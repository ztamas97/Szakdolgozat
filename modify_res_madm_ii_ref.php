<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=3){
	header('location: logout.php');
}

if(isset($_POST['subject_rou'])){
	$round=$_SESSION['rg_round']=mysqli_real_escape_string($db, $_POST['subject_rou']);
}

else{
	$round=$_SESSION['rg_round'];
}

$location_r=$_SESSION['loc_id']=$_POST['subject_loc'];
$level_r=$_SESSION['lev_id']=$_POST['subject_lev'];

$sql_h="SELECT `fordulok`.`FAZ`, `helyszinek`.`VAROS`, `szint`.`SZINEV`
FROM `fordulok` 
LEFT JOIN `helyszinek` ON `fordulok`.`HELYID` = `helyszinek`.`HAZ` 
LEFT JOIN `szint` ON `fordulok`.`SZIID` = `szint`.`SZIAZ`
WHERE `fordulok`.`HELYID` = '$location_r' AND`fordulok`.`SZEZONID` = '$akt_season_id' AND `fordulok`.`SZIID` = '$level_r'";
$result_h = $db->query($sql_h);
$row_h = $result_h->fetch_assoc();
$loc=$_SESSION['city']=$row_h['VAROS'];
$lev=$_SESSION['level']=$row_h['SZINEV'];
$rid=$_SESSION['round']=$row_h['FAZ']; 

?>
<html>
	<head>
      <title><?php echo $lang['res_mod_mad']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
	</head>
   
	<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomemadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="checktourn.php"><?php echo $lang['tourn_mad']; ?></a>
			<a href="checkteam.php"><?php echo $lang['teams_mad']; ?></a>
			<a href="team_tourn.php"><?php echo $lang['team-tourn_mad']; ?></a>
			<a class="active" href="modify_res_madm_i.php"><?php echo $lang['res_mod_mad']; ?></a>
			<div class="logout-container">
				<form action="logout.php">
					<button type="submit"><img src="images/logout.svg" alt="logout"></button>
				</form>
			</div>
			<div class="chip">
				<img src="profilepictures/<?php echo $prof_pic; ?>.jpg" alt="Person">
				<?php echo $user_name; ?>
			</div>
		</div>
		
		<br>
		
		<?php
			$sql="SELECT `csapatok`.`CSNEV`, `biro-osszesito`.`CSID`, `biro-osszesito`.`FID`, `biro-osszesito`.`KID`, `biro-osszesito`.`ASZTAL`, `biro-osszesito`.`SSZAM`
			FROM `csapatok` 
			LEFT JOIN `biro-osszesito` ON `biro-osszesito`.`CSID` = `csapatok`.`CSAZ`
			WHERE `biro-osszesito`.`FID` = '$rid' AND `biro-osszesito`.`KID` = '$round'
			ORDER BY `biro-osszesito`.`KID`";
			$result = $db->query($sql);
		?>
		<table style="width:100%">
			<tr>
				<th><?php echo $lang['team_id']; ?></th>
				<th><?php echo $lang['team_s']; ?></th> 
				<th><?php echo $lang['scoring']; ?></th>
			</tr>
		<?php
			while($row = $result->fetch_assoc()) {
			$team_id=$row['CSID'];
			$sql_sub="SELECT `biro-osszesito`.`OSSZPONT`, `biro-osszesito`.`RIDO`, `biro-osszesito`.`CSID`, `biro-osszesito`.`FID`, `biro-osszesito`.`KID`
			FROM `biro-osszesito`
			WHERE `biro-osszesito`.`CSID` = '$team_id' AND `biro-osszesito`.`FID` = '$rid' AND `biro-osszesito`.`KID` = '$round' AND `biro-osszesito`.`RIDO` IS NOT NULL";
			$result_sub = $db->query($sql_sub);
			$count_sub = mysqli_num_rows($result_sub);
			$row_sub = $result_sub->fetch_assoc();
		?>
			<tr>
				<form action="modify_res_madm_iii_ref.php" method="post">
				<td>
					<?php echo $row['CSID'];?>
					<input type="hidden" name="tid" value="<?php echo $row['CSID']; ?>" />
				</td>
				<td>
					<?php echo $row['CSNEV'];?>
					<input type="hidden" name="tname" value="<?php echo $row['CSNEV']; ?>" />
				</td>
				<td>
					<button type="submit"><?php echo $lang['modify'];?></button>
				</td>
				</form>
			</tr>
		<?php
			}
		?>
		</table>
		
		<form action="modify_res_madm_i.php" method="post">
			<input type="image" src="images/back.svg" width=5% alt="back icon">
		</form>
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
</html>