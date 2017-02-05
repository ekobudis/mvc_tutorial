<?php
function Send_Mail($to,$subject,$body){
	require 'class.phpmailer.php';
	$from       = "sa.isimpleerp@gmail.com";
	$mail       = new PHPMailer();
	$mail->IsSMTP(true);            // use SMTP
	$mail->IsHTML(true);
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Host       = "tls://smtp.gmail.com"; // Amazon SES server, note "tls://" protocol
	$mail->Port       =  465;                    // set the SMTP port
	$mail->Username   = "sa.isimpleerp";  // SMTP  username
	$mail->Password   = "masterkey@b";  // SMTP password
	$mail->SetFrom($from, 'System Administrator iSimpleERP');
	$mail->AddReplyTo($from,'System Administrator iSimpleERP');
	$mail->Subject    = $subject;
	$mail->MsgHTML($body);
	$address = $to;
	$mail->AddAddress($address, $to);
	$mail->Send();   
}
?>
