<?php
include('session.php');

$team_name=$_SESSION['team_name'];
$team_id=$_SESSION['team_id'];
if(isset($_POST['bonus_p'])){
	$bonus=mysqli_real_escape_string($db, $_POST['bonus_p']);
}
else{
	$bonus=0;
}
if(isset($_POST['message_to_team'])){
	$team_message=mysqli_real_escape_string($db, $_POST['message_to_team']);
}
else{
	$team_message='';
}
if(isset($_POST['message'])){
	$judge_message=mysqli_real_escape_string($db, $_POST['message']);
}
else{
	$judge_message='';
}

$sql_sub="SELECT SUM(`zsuri-pontok`.`ERTEK`) AS SUMPOINT
	FROM `zsuri-pontok` 
	LEFT JOIN `zsuri-szempontok` ON `zsuri-szempontok`.`SZEMAZ`= `zsuri-pontok`.`SZEMID` 
	LEFT JOIN `zskategoriak` ON `zskategoriak`.`ZSAZ`=`zsuri-szempontok`.`ZSURIKATID` 
	WHERE `zsuri-pontok`.`CSID` = '$team_id' AND `zskategoriak`.`ZSAZ` = '$user_category_id' AND `zsuri-pontok`.`FID` = '$user_tourn'";
$result_sub = $db->query($sql_sub);
$row_sub = $result_sub->fetch_assoc();

$sumofpoint = $row_sub['SUMPOINT']+$bonus;
echo $sumofpoint;
$sql="INSERT INTO `zsuri-osszesito` (`OAZ`, `CSID`, `OSSZPONT`, `PLUSSZP`, `ZSDM`, `MEGJ`, `RIDO`, `FID`, `ZSKATID`) VALUES (NULL, '$team_id', '$sumofpoint', '$bonus', '$judge_message', '$team_message', CURRENT_TIMESTAMP, '$user_tourn', '$user_category_id')";

if(mysqli_query($db, $sql)){
	$describe='Eredmény véglegesítve: '.$team_name.' '.$user_tourn.' '.$user_category;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name, CURRENT_TIMESTAMP, '$describe')";
    if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	header('location: judge_scoring.php');
} else{
	$describe='Eredmény véglegesítése sikertelen: '.$team_name.' '.$user_tourn.' '.$user_category;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
	if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
    echo 'HIBA: A hozzáadás nem sikeres! $sql. ' . mysqli_error($db);
}

?>