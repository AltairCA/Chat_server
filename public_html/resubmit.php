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
			   header("Refresh: 0; URL=resend.php");
		   }else{
			   if($email !=""){
				   $query = "SELECT * from `user_main` where `email` = '$email' and `code`<>'-1';";
				   //$cart_query = mysqli_query($con,"SELECT * from `user_main` where `email` = '$email' and `code`<>'-1';");
			
			$row222;
				$ret = $dbh->query($query);
				if($row = $ret->fetch(PDO::FETCH_ASSOC)){
					$code = $row["code"];
					$name = $row["name"];
					require "mailer/PHPMailerAutoload.php";
			require "config/1.php";
			$mail->Subject = 'Registration';
				//$mail->Body    = "Welcome $name<br><br>Your user name:$username<br>Password:$password<br>";
				$mail->Body    = "Thank you for registering and becoming a part of us,<br><br>click on this link <a href='http://reg.altairsl.us/validate.php?email=$email&code=$code'>Click on this</a>";
				echo "<h1 style='font-size:26px;color:red;'>Email sent</h1>";
				header('Refresh: 5; URL=resend.php');
				if(!$mail->send()) {
   					echo 'Message could not be sent.';
  					 echo 'Mailer Error: ' . $mail->ErrorInfo;
   					//exit;
					}
					
				}else{
					echo "<script>alert('Your Account Already Validated');</script>";
			   		header("Refresh: 0; URL=resend.php");
				}
			   }else{
					echo "<script>alert('Fill the form properly');</script>";
			   		header("Refresh: 0; URL=resend.php");   
			   }
			   
		   }
		   

?>