<?php
include('session.php');

$boaz=mysqli_real_escape_string($db, $_POST['boaz']);


$sql="DELETE FROM `biro-osszesito` WHERE `biro-osszesito`.`BOAZ` = '$boaz'";

if(mysqli_query($db, $sql)){
	$describe='Csapat törlés robot game!';
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
    if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	header('location: robot_game_lot_iii.php');
} 
else{
	$describe='Csapat törlés robot game sikertelen!';
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
	if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	
	$_SESSION['akt_lang'] = $language;
	$_SESSION['back_to'] = 'robot_game_lot_iii.php';
	if($language == 'eng'){
		$_SESSION['error_msg'] = 'Problem with delete team from robot game round!'; 
	}
	else{
		$_SESSION['error_msg'] = 'Probléma a csapat sorsolásból történő törlésénél!'; 
	}
	header('location: error_page.php');
}

?>