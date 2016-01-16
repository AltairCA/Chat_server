<?php
require 'config/config_common.php';
$code = $_GET["code"];
$email = $_GET["email"];

$query = "SELECT * from `user_main` where `code`='$code' and `email` = '$email'";
//$cart_query = mysqli_query($con,"SELECT * from `user_main` where `code`='$code' and `email` = '$email'");
			
			$row222;
			$ret = $dbh->query($query);
				if($row = $ret->fetch(PDO::FETCH_ASSOC)){
					
					//$cart_query = mysqli_query($con,"UPDATE `user_main` SET `code`='-1' WHERE `code`='$code' and `email`='$email'");
					$query = "UPDATE `user_main` SET `code`='-1' WHERE `code`='$code' and `email`='$email'";
					$ret = $dbh->query($query);
					echo "<script>alert('validation completed');</script>";
			   		header("Refresh: 0; URL=index.php");
					
}else{
	echo "<script>alert('validation erro');</script>";
			   		header("Refresh: 0; URL=index.php");	
}
?>