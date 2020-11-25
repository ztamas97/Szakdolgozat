<?php
include('session.php');
   
if($user_permission_id!=2){
	header('location: logout.php');
}

$name = mysqli_real_escape_string($db, $_POST['name']);
$season = mysqli_real_escape_string($db, $_POST['sid']);
$category = mysqli_real_escape_string($db, $_POST['cid']);
$desc = mysqli_real_escape_string($db, $_POST['description']);
$cat = mysqli_real_escape_string($db, $_POST['category']);
$option = mysqli_real_escape_string($db, $_POST['op']);
if(isset($_POST['exemplary'])){
$exp = mysqli_real_escape_string($db, $_POST['exemplary']);
}
else{
$exp='';
}
$acc = mysqli_real_escape_string($db, $_POST['accomplished']);
$dev = mysqli_real_escape_string($db, $_POST['developing']);
$beg = mysqli_real_escape_string($db, $_POST['beginning']);

 

$sql = "INSERT INTO `zsuri-szempontok` (`SZEMAZ`, `SZEMNEV`, `LEIRAS`, `KATEGORIA`, `FOK`, `SZEZONID`, `ZSURIKATID`, `EXEMPLARY`, `ACCOMPLISHED`, `DEVELOPING`, `BEGINNING`) VALUES (NULL, '$name', '$desc', '$cat', '$option', '$season', '$category', '$exp', '$acc', '$dev', '$beg')";

if(mysqli_query($db, $sql)){
    header('location: judge_scoresheetmaker.php');
} 
else{
	$_SESSION['akt_lang'] = $language;
	$_SESSION['back_to'] = 'judge_scoresheetmaker.php';
	if($language == 'eng'){
		$_SESSION['error_msg'] = 'Problem with add a new judge task to database!'; 
	}
	else{
		$_SESSION['error_msg'] = 'Probléma a zsűri szempont rögzítésénél!'; 
	}
	header('location: error_page.php');
}
?>