<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=1){
	header('location: logout.php');
}

if(isset($_POST['tablenumber']) OR isset($_POST['subject_rou'])){
	$table=$_SESSION["tablenumber_rg"]=mysqli_real_escape_string($db, $_POST['tablenumber']);
	$round=$_SESSION["rg_round"]=mysqli_real_escape_string($db, $_POST['subject_rou']);
}

else{
	$table=$_SESSION['tablenumber_rg'];
	$round=$_SESSION['rg_round'];
}

$schedule='files/Schedule_'.$user_location.'_'.$user_level.'_'.$user_tourn.'.pdf';
   
?>
<html>
	<head>
		  <title><?php echo $lang['ref_scoring']; ?></title>
		  <link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
	</head>
   
	<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomeref.php"><?php echo $lang['home_p']; ?></a>
			<a href="ref_result.php"><?php echo $lang['ad_result']; ?></a>
			<a href=<?php echo $schedule; ?> target="_blank"><?php echo $lang['schedule']; ?></a>
			<a class="active" href="ref_scoring_I.php"><?php echo $lang['ref_scoring']; ?></a>
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
			WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$round' AND `biro-osszesito`.`ASZTAL` = '$table'
			ORDER BY `biro-osszesito`.`SSZAM`";
			$result = $db->query($sql);
		?>
		<table style="width:100%">
			<tr>
				<th><?php echo $lang['team_id']; ?></th>
				<th><?php echo $lang['team_name']; ?></th> 
				<th><?php echo $lang['ref_scoring']; ?></th>
			</tr>
		<?php
			while($row = $result->fetch_assoc()) {
			$team_id=$row["CSID"];
			$sql_sub="SELECT `biro-osszesito`.`OSSZPONT`, `biro-osszesito`.`RIDO`, `biro-osszesito`.`CSID`, `biro-osszesito`.`FID`, `biro-osszesito`.`KID`
			FROM `biro-osszesito`
			WHERE `biro-osszesito`.`CSID` = '$team_id' AND `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$round' AND `biro-osszesito`.`RIDO` IS NOT NULL";
			$result_sub = $db->query($sql_sub);
			$count_sub = mysqli_num_rows($result_sub);
			$row_sub = $result_sub->fetch_assoc();
		?>
		<?php if($count_sub==0): ?>
				<tr>
					<form action="ref_scoring_III.php" method="post">
						<td >
							<?php echo $row['CSID'];?>
							<input type="hidden" name="tid" value="<?php echo $row['CSID']; ?>" />
						</td>
						<td>
							<?php echo $row['CSNEV'];?>
							<input type="hidden" name="tname" value="<?php echo $row['CSNEV']; ?>" />
						</td>
						<td>
							<button type="submit"><?php echo $lang['ref_scoring']; ?></button>
						</td>
					</form>
				</tr>
		<?php else: ?>
				<tr>
					<td >
						<?php echo $row['CSID'];?>
						<input type="hidden" name="tid" value="<?php echo $row['CSID']; ?>" />
					</td>
					<td>
						<?php echo $row['CSNEV'];?>
						<input type="hidden" name="tname" value="<?php echo $row['CSNEV']; ?>" />
					</td>
					<td>
						<?php echo $lang['ref_scored'];?>
					</td>
				</tr>
		<?php endif; ?>
		<?php
			}
		?>
		<table>
		<form action="ref_scoring_I.php" method="post">
			<input type="image" src="images/back.svg" width=5% alt="back icon">
		</form>
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
</html>