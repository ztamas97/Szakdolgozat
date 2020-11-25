<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function password_generate($chars) 
{
  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($data), 0, $chars);
}

function emailsender($to,$to_name,$subject,$main)
{
	require 'PHPMailer-master/src/Exception.php';
	require 'PHPMailer-master/src/PHPMailer.php';
	require 'PHPMailer-master/src/SMTP.php';

	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Mailer = "smtp";

	$mail->SMTPDebug  = 0;  
	$mail->SMTPAuth   = TRUE;
	$mail->SMTPSecure = "tls";
	$mail->CharSet	  =	"UTF-8";
	$mail->Port       = 587;
	$mail->Host       = "smtp.gmail.com";
	$mail->Username   = "fllscoringsystem@gmail.com";
	$mail->Password   = "Domper0818.";

	$mail->IsHTML(true);
	$mail->AddAddress($to,$to_name);
	$mail->SetFrom("fllscoringsystem@gmail.com", "FLL Scoring System");
	$mail->Subject = $subject;
	$content = $main;

	$mail->MsgHTML($content); 
	if(!$mail->Send()) {
	} else {
	}
}

function languageselect($selected_lang)
{
	switch($selected_lang){
 	case 'hu':
		return 'lang/hu.php';		
	break;
	case 'eng':
		return 'lang/eng.php';		
	break;
	default: 
		return 'lang/hu.php';		
	}
}

function result_div($team_res, $cat_max, $div)
{
	if($team_res==0)
	{
		return 0;
	}
	else
	{
	return round(($team_res/$cat_max)*$div);
	}
}

function error_handling($lang, $backpoint, $error_msg)
{
	$_SESSION['akt_lang'] = $lang;
	$_SESSION['back_to'] = $backpoint;
	$_SESSION['error_msg'] = $error_msg;
	header('location: error_page.php');
}
?>