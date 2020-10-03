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
      <title><?php echo $lang['jud_team_i']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
</head>
   
	<body>
			<div class="welcome">
				<img src="images/fll_main_logo.png" alt="FLL">
				<a href="welcomejudge.php"><?php echo $lang['home_p']; ?></a>
				<a href="sum_scores.php"><?php echo $lang['ad_result']; ?></a>
				<a href=<?php echo $schedule; ?> target="_blank"><?php echo $lang['schedule']; ?></a>
				<a href="judge_scoring.php"><?php echo $lang['ref_scoring']; ?></a>
				<a class="active" href="teaminfo_jud_ref.php"><?php echo $lang['jud_team_i']; ?></a>
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
			
		<table style="width:70%">
			<form action="" method="post">
				<tr>
					<td>
						<p class="form">
						<label for="ses"><?php echo $lang['option_to_src']; ?>:</label>
						<select name="subject_ob">
						<option value="1"><?php echo $lang['all_team']; ?></option> 
						<option value="2"><?php echo $lang['scored_teams']; ?></option> 
						</select>
						</p>
					</td>
					<td>
						<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
					</td>
				</tr>
			</form>
		</table>
		<?php
			if(isset($_POST['submit'])){
				$object=$_POST['subject_ob'];
				
				
				if($object==1){			
				$sql="SELECT `csapatok`.*,`csapat-fordulo`.`CSLSZAM`
					FROM `csapatok` 
					LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
					WHERE `csapatok`.`SZID` = '$akt_season_id' AND `csapat-fordulo`.`FORDULOID` = '$user_tourn' AND `csapat-fordulo`.`MEGJELENTE`='1'";
				}
				if($object==2){			
				$sql="SELECT `csapatok`.* ,`csapat-fordulo`.`CSLSZAM`
					FROM `csapatok` 
					LEFT JOIN `zsuri-osszesito` ON `zsuri-osszesito`.`CSID`= `csapatok`.`CSAZ` 
					LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
					WHERE `zsuri-osszesito`.`ZSKATID` = '$user_category_id' AND `csapat-fordulo`.`FORDULOID` = '$user_tourn'";
				}

				$result = $db->query($sql);
			?>
			<br>
			
			<table style="width:100%">
						<tr>
							<th><?php echo $lang['team_id']; ?></th>
							<th><?php echo $lang['team_name']; ?></th>
							<th><?php echo $lang['teammem']; ?></th>
							<th>Coach</th>
						</tr>
					<?php while($row=$result->fetch_assoc()){?>
						<tr>
							<td>
								<?php echo $row['CSAZ']; ?>
							</td>
							<td>
								<?php echo $row['CSNEV']; ?>
							</td>
							<td>
								<?php echo $row['CSLSZAM']; ?>
							</td>
							<td>
								<?php echo $row['COACH']; ?>
							</td>
						</tr>
					<?php }?>
			</table>
			<?php }?>
		
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
</html>