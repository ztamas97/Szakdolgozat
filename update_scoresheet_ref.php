<?php
include('session.php');

$boaz=mysqli_real_escape_string($db, $_GET['boaz']);
$res=mysqli_real_escape_string($db, $_GET['res']);
$bp=mysqli_real_escape_string($db, $_GET['backpoint']);
$team_id=$_SESSION['team_id'];
$team_name=$_SESSION['team_name'];
$round=$_SESSION['rg_round'];

$sql="UPDATE `biro-pontok` SET `SZORZO` = '$res' WHERE `biro-pontok`.`BOAZ` = '$boaz'";

if(mysqli_query($db, $sql)){
	$describe='Eredmény frissítve: '.$team_name.' '.$user_tourn.' '.$res;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
    if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	#header("location: ref_scoring_III.php#$bp");
} else{
	$describe='Eredmény frissítése sikertelen: '.$teamname.' '.$user_tourn.' '.$res;
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
	if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
    echo 'HIBA: A hozzáadás nem sikeres! $sql. ' . mysqli_error($db);
}

$sql_sub2="SELECT SUM(`biro-pontok`.`SZORZO`*`biro-r-feladatok`.`ERTEK`) AS SUMPOINT
		FROM `biro-pontok` 
		LEFT JOIN `biro-r-feladatok` ON `biro-pontok`.`BRRFID` = `biro-r-feladatok`.`BRFAZ`
		WHERE `biro-pontok`.`CSID` = '$team_id' AND `biro-pontok`.`FID` = '$user_tourn' AND `biro-pontok`.`BKATID` = '$round'";
$result_sub2 = $db->query($sql_sub2);
$row_sub2 = $result_sub2->fetch_assoc();
$points=$row_sub2['SUMPOINT'];

$plus_p=0;
$sql_sub3="SELECT `biro-feladatok`.`SUBAZ`, `biro-r-feladatok`.`BRFAZ`, `biro-pontok`.`SZORZO`
		FROM `biro-feladatok` 
		LEFT JOIN `biro-r-feladatok` ON `biro-r-feladatok`.`FELID` = `biro-feladatok`.`FELAZ` 
		LEFT JOIN `biro-pontok` ON `biro-pontok`.`BRRFID` = `biro-r-feladatok`.`BRFAZ`
		WHERE `biro-feladatok`.`SUBAZ` = 'M00' AND `biro-pontok`.`SZORZO` = '1' AND `biro-pontok`.`BKATID` = '$round' AND `biro-feladatok`.`SZID` = '$akt_season_id' AND `biro-pontok`.`FID` = '$user_tourn' AND `biro-pontok`.`CSID` = '$team_id'";
$result_sub3 = $db->query($sql_sub3);
$count_sub3 = mysqli_num_rows($result_sub3);

if($count_sub3==1){

	$sql_sub4="SELECT `biro-feladatok`.*
			FROM `biro-feladatok`
			WHERE `biro-feladatok`.`SZID` = '$akt_season_id'";
	$result_sub4 = $db->query($sql_sub4);

	while($row_sub4 = $result_sub4->fetch_assoc()) {
		$obj_id=$row_sub4['FELAZ'];
		$sql_sub5="SELECT `biro-pontok`.*, `biro-feladatok`.`FELAZ`,`biro-feladatok`.`EXTRAPONT`, SUM(`biro-pontok`.`SZORZO`) AS COUNTER
				FROM `biro-pontok` 
				LEFT JOIN `biro-r-feladatok` ON `biro-pontok`.`BRRFID` = `biro-r-feladatok`.`BRFAZ` 
				LEFT JOIN `biro-feladatok` ON `biro-r-feladatok`.`FELID` = `biro-feladatok`.`FELAZ`
				WHERE `biro-feladatok`.`FELAZ` = '$obj_id' AND `biro-pontok`.`BKATID` = '$round' AND `biro-pontok`.`FID` = '$user_tourn' AND `biro-pontok`.`CSID` = '$team_id'";
		$result_sub5 = $db->query($sql_sub5);
		$row_sub5 = $result_sub5->fetch_assoc();
		if($row_sub5['COUNTER']>0){
			$plus_p=$plus_p+$row_sub5['EXTRAPONT'];
		}
	}
	$points=$points+$plus_p;
}
$sql_sub6="UPDATE `biro-osszesito` SET `OSSZPONT` = '$points', `RIDO` = NULL WHERE `biro-osszesito`.`CSID` = '$team_id' AND `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$round'";
if(mysqli_query($db, $sql_sub6)){
	if($user_permission_id==1){
		header('location: ref_scoring_III.php#$bp');
	}
	elseif($user_permission_id==4){
		header('location: modify_res_adm_iii_ref.php#$bp');
	}
} else{
	
}
?>
