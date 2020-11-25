<?php
include('session.php');
   
if($user_permission_id!=2){
	header('location: logout.php');
}

$varos = mysqli_real_escape_string($db, $_POST['city']);
$irsz = mysqli_real_escape_string($db, $_POST['postcode']);
$utca = mysqli_real_escape_string($db, $_POST['street']);
$hsz = mysqli_real_escape_string($db, $_POST['number']);
 

$sql = "INSERT INTO `helyszinek` (`HAZ`, `VAROS`, `IRSZ`, `UTCA`, `HSZ`) VALUES (NULL, '$varos', '$irsz', '$utca', '$hsz')";

if(mysqli_query($db, $sql)){
    header('location: addlocation.php');
} 
else{
	$_SESSION['akt_lang'] = $language;
	$_SESSION['back_to'] = 'addlocation.php';
	if($language == 'eng'){
		$_SESSION['error_msg'] = 'Problem with recording the new location to database!'; 
	}
	else{
		$_SESSION['error_msg'] = 'Probléma az új helyszín adatbázisba történő rögzítésnél!'; 
	}
	header('location: error_page.php');
}
?>