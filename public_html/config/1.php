<?php
$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->Host = '';
				$mail->SMTPAuth = true;
				$mail->Username = '';
				$mail->Password ='';
				$mail->Timeout = 3600;
				$mail->Port = 25;
				$mail->setFrom('', 'Admin');
				$mail->addAddress($email, $name);
				$mail->isHTML(true);
?>