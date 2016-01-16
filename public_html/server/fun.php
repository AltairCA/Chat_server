
<?php

set_time_limit(3600);

include 'config/config_common1.php';

error_reporting(0);
$options = $_POST['option'];
$username = $_POST['username'];
$password = $_POST['pass'];
$to = $_POST['to'];
$msg = $_POST['msg'];
$timess = $_POST['time'];
$search_word = $_POST['word'];
$search_word = trim($search_word);
$login = false;

 $sql =<<<EOF
      select * from `user_main` where `name`='$username' and `pass`='$password' and `code`='-1';
EOF;

   $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      $login = true;
   }
   
   if($login==true){
	   	if(strval($options) == "1"){
			$dat = strval(date("Y-m-d"));
			$tim = strval(date("h:i:sa"));
			$sql =<<<EOF
			 INSERT INTO `msg_store`(`date`, `time`, `from_name`, `to_name`, `msg`,`deliverd`,`seen`) VALUES ( '$dat','$tim','$username','$to','$msg','0','0');
EOF;
			
   			$ret = $db->exec($sql);
			if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "recevied";
   }
   			
			
		}else if(strval($options) == "2"){
			$sql =<<<EOF
			 SELECT * FROM `msg_store` WHERE `to_name`='$username' and `deliverd`='0' order by `date`, `time`;
EOF;

   			$ret = $db->query($sql);
			$xo = 0;
   			while($row = $ret->fetchArray(SQLITE3_ASSOC) and $xo <20){
      			echo $row['msg'].$splitstring.$row['from_name'].$splitstring.$row['time'].$splitstring;
				$xo++;
				
				
   			}
		}else if(strval($options) == "3"){
			 $sql =<<<EOF
			 SELECT * FROM `friend_table` WHERE (`f_name`='$username' or `name`='$username') and `name_accept`='1';
EOF;

   			$ret = $db->query($sql);
   			while($row = $ret->fetchArray(SQLITE3_ASSOC)){
      			echo $row['f_name'].$splitstring.$row['name'].$splitstring;
   			}
		}else if(strval($options) == "4"){
			 $sql =<<<EOF
			 SELECT `name` FROM `user_main` WHERE `name` LIKE '%$search_word%' and `name` <> '$username' and (`name` not in (SELECT `name` FROM `friend_table` WHERE `f_name`='$username')  and `name` not in  (SELECT `f_name` FROM `friend_table` WHERE `name`='$username'));
EOF;
			$count=0;
   			$ret = $db->query($sql);
   			while($row = $ret->fetchArray(SQLITE3_ASSOC) and $count<20){
      			echo $row['name'].$splitstring;
				$count++;
   			}
		}else if(strval($options) == "5"){
			$f_count;
			$sql =<<<EOF
			 SELECT count(*) as 'noOf' FROM `friend_table` WHERE (`f_name`='$username' and `name`='$to') or (`f_name`='$to' and `name`='$username');
EOF;
			
   			$ret = $db->query($sql);
   			while($row = $ret->fetchArray(SQLITE3_ASSOC)){
      			$f_count = strval($row['noOf']);
				break;
   			}
			if($f_count=="0" and $to != $username){
				$f_count = "0";
				
				$sql =<<<EOF
			SELECT count(*) as 'noOf' FROM `user_main` WHERE `name` ='$to';
EOF;
			
   				$ret = $db->query($sql);
   				while($row = $ret->fetchArray(SQLITE3_ASSOC)){
      				$f_count = strval($row['noOf']);
					break;
   				}
				
				if($f_count!="0"){
					$sql =<<<EOF
			INSERT INTO `friend_table`(`f_name`, `name`, `name_accept`) VALUES ('$to','$username','0');
EOF;
			
   				$ret = $db->exec($sql);
				
				if(!$ret){
     				 echo $db->lastErrorMsg();
  			 } else {
      			echo "friend added";
   			}
					
				}
			}
			
			
			
		}else if(strval($options) == "6"){
			
			$sql =<<<EOF
			 SELECT `name` FROM `friend_table` WHERE (`f_name`='$username') and `name_accept`='0';
EOF;
			
   			$ret = $db->query($sql);
   			while($row = $ret->fetchArray(SQLITE3_ASSOC)){
      			echo $row['name'].$splitstring;
   			}
			
			
		}else if(strval($options) == "7"){
			
			$sql =<<<EOF
      UPDATE `friend_table` SET `name_accept`='1' WHERE `f_name`='$username' and `name` = '$to' and `name_accept` = '0';
EOF;
   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "accpeted";
   }
			
		}else if(strval($options) == "8"){
			
			$sql =<<<EOF
      DELETE FROM `friend_table` WHERE (`f_name`='$to' and `name` = '$username') or (`f_name`='$username' and `name` = '$to');
EOF;
   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "unfriend";
   }
			
		}else if(strval($options) == '9'){
			$sql =<<<EOF
			 SELECT `name` FROM `online_user` WHERE `name` in (SELECT `f_name` FROM `friend_table` WHERE (`f_name`='$username' or `name`='$username') and `name_accept`='1') or `name` in (SELECT `name` FROM `friend_table` WHERE (`f_name`='$username' or `name`='$username') and `name_accept`='1');
EOF;
			
   			$ret = $db->query($sql);
   			while($row = $ret->fetchArray(SQLITE3_ASSOC)){
      			echo $row['name'].$splitstring;
   			}
			
		}else if(strval($options) == '10'){
			/*$sql =<<<EOF
      UPDATE `msg_store` SET `deliverd`='1' WHERE `time` = '$timess' and `to_name`='$username' and `msg`='$msg';
EOF;
*/

/*
$sql =<<<EOF
      DELETE FROM `msg_store` WHERE `time` = '$timess' and `to_name`='$username' and `msg`='$msg';
EOF;
*/
$sql =<<<EOF
      DELETE FROM `msg_store` WHERE `time` = '$timess' and `to_name`='$username';
EOF;
   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Updated Deliverd";
   }
			
		}
   
   $db->close();
		
   }

//deliverd`,`seen`

?>