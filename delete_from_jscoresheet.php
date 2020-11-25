<?php
include('session.php');
   
if($user_permission_id!=2){
	header('location: logout.php');
}

$cid = mysqli_real_escape_string($db, $_POST['chid']);

$sql = "DELETE FROM `zsuri-szempontok` WHERE `zsuri-szempontok`.`SZEMAZ` = '$cid'";

if(mysqli_query($db, $sql)){
    header('location: judge_scoresheetmaker.php');
} 
else{
	$_SESSION['akt_lang'] = $language;
	$_SESSION['back_to'] = 'judge_scoresheetmaker.php';
	if($language == 'eng'){
		$_SESSION['error_msg'] = 'Problem with delete one of the judge task from database!'; 
	}
	else{
		$_SESSION['error_msg'] = 'Probléma a zsűri szempont adatbázisból történő törlésénél!'; 
	}
	header('location: error_page.php');
}
?>