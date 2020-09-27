<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";

$mail->SMTPDebug  = 1;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "fllscoringsystem@gmail.com";
$mail->Password   = "Domper0818.";

$mail->IsHTML(true);
$mail->AddAddress("zelles.tamas@gmail.com", "recipient-name");
$mail->SetFrom("fllscoringsystem@gmail.com", "from-name");
//$mail->AddReplyTo("reply-to-email@domain", "reply-to-name");
//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
$mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
$content = "
<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h1>Ez itt az e-mail címe</h1>
		<p>Ez itt a gyökere</p>
		<h3>Aláírás</h3>
	</body>
</html>";

$mail->MsgHTML($content); 
if(!$mail->Send()) {
  echo "Error while sending Email.";
  var_dump($mail);
} else {
  echo "Email sent successfully";
}
?>