<?php
session_start();
set_time_limit(3600);
require 'config/config_common.php';
$name=$_POST["name"];
$oldpassword=$_POST["oldpassword"];
$pass=$_POST["password"];
$repass=$_POST["repass"];

$name=trim($name);
$name = strtolower($name);
$oldpassword = trim($oldpassword);
$pass = trim($pass);
$repass = trim($repass);

if(!preg_match ('/^([a-zA-Z]+)$/', $name)){
    echo "<script>alert('Please input alphabet characters only for the Username');</script>";
	header("Refresh: 0; URL=passreset.php");
	
}else{

require_once('config/recaptchalib.php');
$privatekey = "6LcjCQATAAAAAG4pPiFfY86OMLenXWrjP6pTiioM";
  		$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
		
		 
		 
		
		 
		   if (!$resp->is_valid) {
			   //unlink($temp_file);
			   echo "<script>alert('Captcha Erro');</script>";
			   header("Refresh: 0; URL=passreset.php");
		   }else{
  
	if($name!="" and $oldpassword !="" and $pass!="" and $repass!=""){
		if($pass==$repass){
			$query = "SELECT * from `user_main` where `name`='$name' and `pass` = '$oldpassword'";
			//$cart_query = mysqli_query($con,"SELECT * from `user_main` where `name`='$name' and `pass` = '$oldpassword'");
			
			//$row222;
				$ret = $dbh->query($query);
				if(!($row = $ret->fetch(PDO::FETCH_ASSOC))){
					echo "<script>alert('username or password incorrect');</script>";
			   		header("Refresh: 0; URL=passreset.php");
					
				}else{
					
				$query = "UPDATE `user_main` SET `pass`='$pass' WHERE `name`='$name'";
			
			//mysqli_query($con,"UPDATE `user_main` SET `pass`='$pass' WHERE `name`='$name'");
				$ret = $dbh->query($query);
			
			
				//$mail->Body    = "Welcome $name<br><br>Your user name:$username<br>Password:$password<br>";
				
				echo "<h1 style='font-size:26px;color:red;'>Your Password Reset Successful</h1>";
				header('Refresh: 5; URL=passreset.php');
				
				}
		}else{
			echo "<script>alert('Password missmatch');</script>";
			   header("Refresh: 0; URL=passreset.php");
			$_SESSION['password']="";	
		}
		
	}else{
		echo "<script>alert('Fill the form properly');</script>";
			   header("Refresh: 0; URL=passreset.php");
			
	}
		   }
		   }

?>