<?php
session_start();
set_time_limit(3600);
require 'config/config_common.php';
$name=$_POST["name"];
$email=$_POST["email"];
$pass=$_POST["password"];
$repass=$_POST["repass"];

$name=trim($name);
$name = strtolower($name);
$email = trim($email);
$pass = trim($pass);
$repass = trim($repass);

$_SESSION['name'] = $name;
$_SESSION['email']=$email;
$_SESSION['password']=$pass;

if(!preg_match ('/^([a-zA-Z]+)$/', $name)){
    echo "<script>alert('Please input alphabet characters only for the Username');</script>";
	header("Refresh: 0; URL=index.php");
	
}else{
require_once('config/recaptchalib.php');
$privatekey = "6LcjCQATAAAAAG4pPiFfY86OMLenXWrjP6pTiioM";
  		$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
		
		 
		 
		
		 
		   if (!$resp->is_valid) {
			   //unlink($temp_file);
			   echo "<script>alert('Captcha Erro');</script>";
			   header("Refresh: 0; URL=index.php");
		   }else{
  
	if($name!="" and $email !="" and $pass!="" and $repass!=""){
		if($pass==$repass){
			$randnum = rand(1000,getrandmax());
			//$cart_query = mysqli_query($con,"SELECT * from `user_main` where `name`='$name' or `email` = '$email'");
			$query = "SELECT * from `user_main` where `name`='$name' or `email` = '$email'";
			//$row222;
			$ret = $dbh->query($query);
				if($row = $ret->fetch(PDO::FETCH_ASSOC)){
					echo "<script>alert('username or email already registered');</script>";
			   		header("Refresh: 0; URL=index.php");
					
				}else{
					
				
			$query = "INSERT INTO `user_main`(`name`, `pass`, `code`, `email`) VALUES ('$name','$pass','$randnum','$email')";
			$ret = $dbh->query($query);
			//mysqli_query($con,"INSERT INTO `user_main`(`name`, `pass`, `code`, `email`) VALUES ('$name','$pass','$randnum','$email')");
			require "mailer/PHPMailerAutoload.php";
			require "config/1.php";
			$mail->Subject = 'Registration';
				//$mail->Body    = "Welcome $name<br><br>Your user name:$username<br>Password:$password<br>";
				$mail->Body    = "Thank you for registering and becoming a part of us,<br><br>click on this link <a href='http://reg.altairsl.us/validate.php?email=$email&code=$randnum'>Click on this</a>";
				echo "<h1 style='font-size:26px;color:red;'>Your information saved</h1>";
				header('Refresh: 5; URL=index.php');
				if(!$mail->send()) {
   					echo 'Message could not be sent.';
  					 echo 'Mailer Error: ' . $mail->ErrorInfo;
   					//exit;
					}
				}
		}else{
			echo "<script>alert('Password missmatch');</script>";
			   header("Refresh: 0; URL=index.php");
			$_SESSION['password']="";	
		}
		
	}else{
		echo "<script>alert('Fill the form properly');</script>";
			   header("Refresh: 0; URL=index.php");
			
	}
		   }
		   }

?>