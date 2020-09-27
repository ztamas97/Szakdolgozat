<?php
include('session.php');

$round=$_SESSION['rg_round'];
$team_id=$_SESSION['team_id'];

$time=date('Y-m-d H:i:s');  

$sql="UPDATE `biro-osszesito` SET `RIDO` = '$time' WHERE `biro-osszesito`.`CSID` = '$team_id' AND `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$round'";
if(mysqli_query($db, $sql)){
	if($user_permission_id==1){
		header('location: ref_scoring_II.php');
	}
	elseif($user_permission_id==4){
		header('location: modify_res_adm_ii_ref.php');
	}
} else{
	
}
?>