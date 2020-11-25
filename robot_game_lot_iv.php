  <?php
include('session.php');

$team_id=mysqli_real_escape_string($db, $_POST['subject_team']);
$num=mysqli_real_escape_string($db, $_POST['num']);
$round=$_SESSION['ROUND'];
$table_num=$_SESSION['TABLENUMBER'];

$sql_sub="SELECT `biro-osszesito`.`BOAZ`
		FROM `biro-osszesito`
		WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$round' AND `biro-osszesito`.`ASZTAL` = '$table_num' AND `biro-osszesito`.`SSZAM` = '$num'";
$result_sub = $db->query($sql_sub);
$count = mysqli_num_rows($result_sub);

$sql_sub2="SELECT `fordulok`.`RESZTVCSMAX`
		FROM `fordulok`
		WHERE `fordulok`.`FAZ` = '$user_tourn'";
$result_sub2 = $db->query($sql_sub2);
$row_sub2= $result_sub2->fetch_assoc();
$teamax=$row_sub2['RESZTVCSMAX'];

$sql_sub3="SELECT `biro-osszesito`.`BOAZ`
		FROM `biro-osszesito`
		WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$round' AND `biro-osszesito`.`ASZTAL` = '$table_num'";
$result_sub3 = $db->query($sql_sub3);
$count_sub3 = mysqli_num_rows($result_sub3);

if(($teamax/$_SESSION['RGASZTALNUM'])>$count_sub3){

	if($count==0){

		$sql="INSERT INTO `biro-osszesito` (`BOAZ`, `CSID`, `FID`, `KID`, `OSSZPONT`, `ASZTAL`, `SSZAM`, `RIDO`) VALUES (NULL, '$team_id', '$user_tourn', '$round', '0', '$table_num', '$num', NULL);";

		if(mysqli_query($db, $sql)){
			$describe='Csapat rögzítés robot game!';
			$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
			if(mysqli_query($db, $sql_log)){
			} 
			else{
			}
			header('location: robot_game_lot_iii.php');
		} 
		else{
			$describe='Csapat rögzítés robot game sikertelen!';
			$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
			if(mysqli_query($db, $sql_log)){
			} 
			else{
			}
			$_SESSION['akt_lang'] = $language;
			$_SESSION['back_to'] = 'robot_game_lot_iii.php';
			if($language == 'eng'){
				$_SESSION['error_msg'] = 'Problem with robot game round generation!'; 
			}
			else{
				$_SESSION['error_msg'] = 'Probléma a robotmenetkörök sorsolásánál!'; 
			}
			header('location: error_page.php');
		}
	}
	else{
		header('location: robot_game_lot_iii.php');
	}
}
else{
	header('location: robot_game_lot_iii.php');
}
?>