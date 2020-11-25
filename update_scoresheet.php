<?php
include('session.php');

$res=mysqli_real_escape_string($db, $_GET['result_judge']);
$res_id=mysqli_real_escape_string($db, $_GET['chid']);
$obj_id=mysqli_real_escape_string($db, $_GET['oid']);
$team_name=$_SESSION['team_name'];
$team_id=$_SESSION['team_id'];

$sql="UPDATE `zsuri-pontok` SET `ERTEK` = '$res',`TIMES` = CURRENT_TIMESTAMP WHERE `zsuri-pontok`.`PAZ` = '$obj_id'";

if(mysqli_query($db, $sql)){
	$describe='Eredmény frissítve: '.$team_name.' '.$user_tourn.' '.$res;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$login_session', CURRENT_TIMESTAMP, '$describe')";
    if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	header('location: judge_scoresheet.php#$res_id');
} else{
	$describe='Eredmény frissítése sikertelen: '.$team_name.' '.$user_tourn.' '.$res;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$login_session', CURRENT_TIMESTAMP, '$describe')";
	if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	$_SESSION['akt_lang'] = $language;
	$_SESSION['back_to'] = 'judge_scoresheet.php.php';
	if($language == 'eng'){
		$_SESSION['error_msg'] = 'Problem with recording the new judge result to database!'; 
	}
	else{
		$_SESSION['error_msg'] = 'Probléma az új zsűri értékelés rögzítésnél!'; 
	}
	header('location: error_page.php');
}
?>