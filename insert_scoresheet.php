<?php
include('session.php');

$res=mysqli_real_escape_string($db, $_GET['result_judge']);
$res_id=mysqli_real_escape_string($db, $_GET['chid']);
$team_name=$_SESSION['team_name'];
$team_id=$_SESSION['team_id'];

$sql="INSERT INTO `zsuri-pontok` (`PAZ`, `CSID`, `SZEMID`, `FID`, `ERTEK`, `TIMES`) VALUES (NULL, '$team_id', '$res_id', '$user_tourn', '$res', CURRENT_TIMESTAMP)";

if(mysqli_query($db, $sql)){
	$describe='Eredmény rögzítve: '.$teamname.' '.$user_tourn.' '.$res.' '.$user_category;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
    if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	header('location: judge_scoresheet.php#$res_id');
} 
else{
	$describe='Eredmény rögzítése sikertelen: '.$teamname.' '.$user_tourn.' '.$res.' '.$user_category;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
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