<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=5){
	header('location: logout.php');
}
   
$schedule='files/Schedule_'.$user_location.'_'.$user_level.'_'.$user_tourn.'.pdf';   
?>
<html>
	<head>
		  <title>Pontozás</title>
		  <link rel="stylesheet" type="text/css" href="form.css">
	</head>
   
	<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomejudge.php"><?php echo $lang['home_p']; ?></a>
			<a href="sum_scores.php"><?php echo $lang['ad_result']; ?></a>
			<a href=<?php echo $schedule; ?> target="_blank"><?php echo $lang['schedule']; ?></a>
			<a class="active" href="judge_scoring.php"><?php echo $lang['ref_scoring']; ?></a>
			<a href="teaminfo_jud_ref.php"><?php echo $lang['jud_team_i']; ?></a>
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
			$sql="SELECT `csapatok`.*,`csapat-fordulo`.`CSLSZAM`
					FROM `csapatok` 
					LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
					WHERE `csapatok`.`SZID` = '$akt_season_id' AND `csapat-fordulo`.`FORDULOID` = '$user_tourn' AND `csapat-fordulo`.`MEGJELENTE`='1'";
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
			$team_id=$row["CSAZ"];
			$sql_sub="SELECT `zsuri-osszesito`.`RIDO`
				FROM `zsuri-osszesito`
				WHERE `zsuri-osszesito`.`CSID` = '$team_id' AND `zsuri-osszesito`.`FID` = '$user_tourn' AND `zsuri-osszesito`.`ZSKATID` = '$user_category_id'";
			$result_sub = $db->query($sql_sub);
			$count_sub = mysqli_num_rows($result_sub);
			$row_sub = $result_sub->fetch_assoc();
		?>
		<?php if($count_sub==0): ?>
				<tr>
					<form action="judge_scoresheet.php" method="post">
						<td >
							<?php echo $row['CSAZ'];?>
							<input type="hidden" name="tid" value="<?php echo $row['CSAZ']; ?>" />
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
						<?php echo $row['CSAZ'];?>
						<input type="hidden" name="tid" value="<?php echo $row['CSAZ']; ?>" />
					</td>
					<td>
						<?php echo $row['CSNEV'];?>
						<input type="hidden" name="tname" value="<?php echo $row['CSNEV']; ?>" />
					</td>
					<td>
						<?php echo $lang['scored'].': '.$row_sub['RIDO'];?>
					</td>
				</tr>
		<?php endif; ?>
		<?php
			}
		?>
		</table>
		
		<br>
		<br>
		<br>
		
		<div class="footer">
				<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
</html>