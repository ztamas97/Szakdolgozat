<?php
include('session.php');

$res=mysqli_real_escape_string($db, $_GET['result_judge']);
$res_id=mysqli_real_escape_string($db, $_GET['chid']);
$obj_id=mysqli_real_escape_string($db, $_GET['oid']);
$team_name=$_SESSION['team_name'];
$team_id=$_SESSION['team_id'];
$rid=$_SESSION['round'];
$category_r=$_SESSION['cat_id'];

$sql="UPDATE `zsuri-pontok` SET `ERTEK` = '$res',`TIMES` = CURRENT_TIMESTAMP WHERE `zsuri-pontok`.`PAZ` = '$obj_id'";

if(mysqli_query($db, $sql)){
	$describe='Eredmény frissítve: '.$team_name.' '.$res;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
    if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
} else{
	$describe='Eredmény frissítése sikertelen: '.$team_name.' '.$res;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
	if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
    echo 'HIBA: A hozzáadás nem sikeres!';
}
$sql_sub="SELECT `zsuri-osszesito`.`PLUSSZP`,`zsuri-osszesito`.`OAZ`
		FROM `zsuri-osszesito`
		WHERE `zsuri-osszesito`.`CSID` = '$team_id' AND `zsuri-osszesito`.`FID` = '$rid'";
$result_sub = $db->query($sql_sub);
$row_sub = $result_sub->fetch_assoc();
$bonus=$row_sub['PLUSSZP'];
$sumid=$row_sub['OAZ'];

$sql_sub2="SELECT SUM(`zsuri-pontok`.`ERTEK`) AS SUMPOINT
	FROM `zsuri-pontok` 
	LEFT JOIN `zsuri-szempontok` ON `zsuri-szempontok`.`SZEMAZ`= `zsuri-pontok`.`SZEMID` 
	LEFT JOIN `zskategoriak` ON `zskategoriak`.`ZSAZ`=`zsuri-szempontok`.`ZSURIKATID` 
	WHERE `zsuri-pontok`.`CSID` = '$team_id' AND `zskategoriak`.`ZSAZ` = '$category_r' AND `zsuri-pontok`.`FID` = '$rid'";
$result_sub2 = $db->query($sql_sub2);
$row_sub2 = $result_sub2->fetch_assoc();

$sumofpoint = $row_sub2['SUMPOINT']+$bonus;

$sql_sub3="UPDATE `zsuri-osszesito` SET `OSSZPONT` = '$sumofpoint' WHERE `zsuri-osszesito`.`OAZ` = '$sumid'";
if(mysqli_query($db, $sql_sub3)){
	header('location: modify_res_madm_iii.php#$res_id');
} else{
    echo 'HIBA: A hozzáadás nem sikeres!';
}
?>