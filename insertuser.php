<?php
include('session.php');
include ('functions.php');
   
if($user_permission_id!=2){
	header('location: logout.php');
}

$username = mysqli_real_escape_string($db, $_POST['uname']);
$gen=password_generate(10);
$password = md5($gen);
$permission = mysqli_real_escape_string($db, $_POST['subject_perm']);
$location = mysqli_real_escape_string($db, $_POST['subject_loc']);
$category = mysqli_real_escape_string($db, $_POST['subject_category']);
$email=mysqli_real_escape_string($db, $_POST['email']);

if($location==''){
	$sql = "INSERT INTO `felhasznalok` (`Azonosito`, `FHNEV`, `JSZO`, `JOGID`, `FORDULOID`,`ZSKATID`,`EMAIL`) VALUES (NULL, '$username', '$password', '$permission', NULL, NULL,'$email')";
}

else{
	if($category==''){
	$sql = "INSERT INTO `felhasznalok` (`Azonosito`, `FHNEV`, `JSZO`, `JOGID`, `FORDULOID`,`ZSKATID`,`EMAIL`) VALUES (NULL, '$username', '$password', '$permission', '$location', NULL, NULL)";
	}
	else{
	$sql = "INSERT INTO `felhasznalok` (`Azonosito`, `FHNEV`, `JSZO`, `JOGID`, `FORDULOID`,`ZSKATID`,`EMAIL`) VALUES (NULL, '$username', '$password', '$permission', '$location', '$category', NULL)";	
	}
}

if(mysqli_query($db, $sql)){
	if($language == 'eng'){
		$main='
		<h1>Dear User!</h1>
		<p>With your e-mail('.$email.') a user account has been registered.</p><br>
		<p>Username: '.$username.'</p><br>
		<p>Password: '.$gen.'</p><br>
		<h3>Reagreds, FLL Team</h3>';
	}
	else {
		$main='
		<h1>Kedves Felhasználó!</h1>
		<p>Az Ön e-mail címével('.$email.') regisztráltak egy felhasználói fiókot.</p><br>
		<p>Felhasználónév: '.$username.'</p><br>
		<p>Jelszó: '.$gen.'</p><br>
		<h3>Üdvözlettel: FLL Team</h3>';
	}
	emailsender($email,'new FLL user','FLL Scoring System',$main);
	$describe='Felhasználó hozzáadva: '.$username;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
    if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	header('location: adduser.php');
} 
else{
	$describe='Sikertelen felhasználó hozzáadás: '.$username;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
	if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	$_SESSION['akt_lang'] = $language;
	$_SESSION['back_to'] = 'adduser.php';
	if($language == 'eng'){
		$_SESSION['error_msg'] = 'Problem with recording the new user to database!'; 
	}
	else{
		$_SESSION['error_msg'] = 'Probléma a felhasználó adatbázisba történő rögzítésnél!'; 
	}
	header('location: error_page.php');
}
//ideiglenesen, ellenőrzés miatt
$pwd = fopen('passwords.txt', 'a'); 
fwrite($pwd, $user_name.' : '.$gen."\n");   
fclose($pwd); 
?>