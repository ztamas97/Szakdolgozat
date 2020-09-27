<?php
include('session.php');

$team_id=$_SESSION['team_id'];
$rid=$_SESSION['round'];
$bonus=$_POST['bonus_p'];
$category_r=$_SESSION['cat_id'];

$sql_sub="SELECT `zsuri-osszesito`.`PLUSSZP`,`zsuri-osszesito`.`OSSZPONT`,`zsuri-osszesito`.`OAZ`
		FROM `zsuri-osszesito`
		WHERE `zsuri-osszesito`.`CSID` = '$team_id' AND `zsuri-osszesito`.`FID` = '$rid'";
$result_sub = $db->query($sql_sub);
$row_sub = $result_sub->fetch_assoc();
$sumid=$row_sub['OAZ'];
$sump=$row_sub['OSSZPONT'];

echo $bonus.' '.$sumid;
$sql="UPDATE `zsuri-osszesito` SET `PLUSSZP` = '$bonus' WHERE `zsuri-osszesito`.`OAZ` = '$sumid'";

if(mysqli_query($db, $sql)){

} else{
	
}
$sql_sub2="SELECT SUM(`zsuri-pontok`.`ERTEK`) AS SUMPOINT
	FROM `zsuri-pontok` 
	LEFT JOIN `zsuri-szempontok` ON `zsuri-szempontok`.`SZEMAZ`= `zsuri-pontok`.`SZEMID` 
	LEFT JOIN `zskategoriak` ON `zskategoriak`.`ZSAZ`=`zsuri-szempontok`.`ZSURIKATID` 
	WHERE `zsuri-pontok`.`CSID` = '$team_id' AND `zskategoriak`.`ZSAZ` = '$category_r' AND `zsuri-pontok`.`FID` = '$rid'";
$result_sub2 = $db->query($sql_sub2);
$row_sub2 = $result_sub2->fetch_assoc();

$sumofpoint = $row_sub2['SUMPOINT']+$bonus;

$sql2="UPDATE `zsuri-osszesito` SET `OSSZPONT` = '$sumofpoint' WHERE `zsuri-osszesito`.`OAZ` = '$sumid'";
if(mysqli_query($db, $sql2)){
	header('location: modify_res_madm_iii.php');
} else{
	
}
?>