<?php
set_time_limit(3600);
require 'config/config_common.php';
$email=$_POST["email"];
$email = trim($email);

require_once('config/recaptchalib.php');
$privatekey = "6LcjCQATAAAAAG4pPiFfY86OMLenXWrjP6pTiioM";
  		$resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
		
		 
		 
		
		 
		   if (!$resp->is_valid) {
			   //unlink($temp_file);
			   echo "<script>alert('Captcha Erro');</script>";
			   header("Refresh: 0; URL=forget_password.php");
		   }else{
			   if($email !=""){
				   
				   $query = "SELECT * from `user_main` where `email` = '$email' and `code`='-1';";
				   //$cart_query = mysqli_query($con,"SELECT * from `user_main` where (`name`='$name' or `email` = '$email') and `code`='-1';");
			
			$row222;
			$books = array();
			$ret = $dbh->query($query);
				if ($row = $ret->fetch(PDO::FETCH_ASSOC))
				
{
    $code =  $row["pass"];
	$username = $row["name"];
	$name = $username;

/*
				if($row222 = mysqli_fetch_array($cart_query)){
					$code = $row222[1];
					$username = $row222[0];
					*/
					require "mailer/PHPMailerAutoload.php";
			require "config/1.php";
			$mail->Subject = 'Registration';
				//$mail->Body    = "Welcome $name<br><br>Your user name:$username<br>Password:$password<br>";
				$mail->Body    = "Thank you for registering and becoming a part of us,<br><br>Your Password is : $code<br> Username :$username";
				echo "<h1 style='font-size:26px;color:red;'>Email sent</h1>";
				header('Refresh: 5; URL=forget_password.php');
				if(!$mail->send()) {
   					echo 'Message could not be sent.';
  					 echo 'Mailer Error: ' . $mail->ErrorInfo;
   					//exit;
					}
					
				}else{
					echo "<script>alert('Your Account is not found or not Validated');</script>";
			   		header("Refresh: 0; URL=forget_password.php");
				}
			   }else{
					echo "<script>alert('Fill the form properly');</script>";
			   		header("Refresh: 0; URL=forget_password.php");   
			   }
			   
		   }
		   

?>