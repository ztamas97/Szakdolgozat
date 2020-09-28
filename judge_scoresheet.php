<?php
include('session.php');
include('judge_category_numbers.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=5){
	header('location: logout.php');
}

if(isset($_POST['tname']) OR isset($_POST['tid'])){
	$team_name=$_SESSION['team_name']=mysqli_real_escape_string($db, $_POST['tname']);
	$team_id=$_SESSION['team_id']=mysqli_real_escape_string($db, $_POST['tid']);
}
	
else{
	$team_name=$_SESSION['team_name'];
	$team_id=$_SESSION['team_id'];
}
   
$sql="SELECT `csapatok`.`COACH`, `csapat-fordulo`.`CSLSZAM`
	FROM `csapatok` 
	LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
	WHERE `csapatok`.`CSAZ` = '$team_id' AND `csapat-fordulo`.`FORDULOID` = '$user_tourn'";
	
$result = $db->query($sql);
$row = $result->fetch_assoc();
$team_mem_num=$row['CSLSZAM'];
$coach=$row['COACH'];

$schedule='files/Schedule_'.$user_location.'_'.$user_level.'_'.$user_tourn.'.pdf';
?>
<html>
	<head>
		  <title><?php echo $lang['ref_scoring']; ?></title>
		  <link rel="stylesheet" type="text/css" href="stylesheet/scoresheet.css">
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
		<h3><?php echo $lang['team_name'].': '.$team_name; ?> | <?php echo $lang['team_id'].': '.$team_id; ?>| <?php echo $lang['teammem'].': '.$team_mem_num; ?> | Coach: <?php echo $coach; ?></h3>
		<br>
		<?php
			$sql="SELECT `zsuri-szempontok`.*, `zsuri-szempontok`.`ZSURIKATID` 
				FROM `zsuri-szempontok` 
				WHERE `zsuri-szempontok`.`SZEZONID` = '$akt_season_id' AND `zsuri-szempontok`.`ZSURIKATID` = '$user_category_id'";
			$result = $db->query($sql);
		?>
		<table style="width:100%">
			<tr>
				<th></th>
				<th>exemplary(4)</th> 
				<th>accomplished(3)</th>
				<th>developing(2)</th>
				<th>beginning(1)</th>
				<th><?php echo $lang['scoring']; ?></th>
				<th><?php echo $lang['send']; ?></th>
			</tr>
		<?php
			while($row = $result->fetch_assoc()) {
			$obj_id=$row['SZEMAZ'];
			$sql_sub="SELECT `zsuri-pontok`.`PAZ`, `zsuri-pontok`.`ERTEK`
				FROM `zsuri-pontok`
				WHERE `zsuri-pontok`.`SZEMID` = '$obj_id' AND `zsuri-pontok`.`CSID` = '$team_id' AND`zsuri-pontok`.`FID` = '$user_tourn'";
			$result_sub = $db->query($sql_sub);
			$count = mysqli_num_rows($result_sub);
			$row_sub = $result_sub->fetch_assoc();
			
		?>
				<?php if($count==0): ?>
					<tr id="<?php echo $row['SZEMAZ']?>">
						<form action="insert_scoresheet.php" method="get">
							<td>
								<div class="name"><?php echo $row['SZEMNEV'];?></div><br>
								<div class="cat"><?php echo $row['KATEGORIA'];?></div><br>
								<?php echo $row['LEIRAS'];?>
								<input type="hidden" name="chid" value="<?php echo $row['SZEMAZ']; ?>" />
							</td>
							<td>
								<?php echo $row['EXEMPLARY'];?>
							</td>
							<td>
								<?php echo $row['ACCOMPLISHED'];?>
							</td>
							<td>
								<?php echo $row['DEVELOPING'];?>
							</td>
							<td>
								<?php echo $row['BEGINNING'];?>
							</td>
							<td>
							<?php if($row['FOK']==4): ?>
								<select name="result_judge" required/>
									<option></option>
									<option value="4">EXEMPLARY</option>
									<option value="3">ACCOMPLISHED</option>
									<option value="2">DEVELOPING</option>
									<option value="1">BEGINNING</option>
								</select>
							<?php else: ?>
									<select name="result_judge" required/>
									<option></option>
									<option value="3">ACCOMPLISHED</option>
									<option value="2">DEVELOPING</option>
									<option value="1">BEGINNING</option>
								</select>
							<?php endif; ?>
							</td>
							<td width=10%>
								<input type="image" id="send" src="images/ok.svg" width=50% alt="ok icon">
							</td>
						</form>
					</tr>
				<?php else: ?>
					<tr id="<?php echo $row['SZEMAZ']?>">
						<form action="update_scoresheet.php" method="get">
							<td >
								<div class="name"><?php echo $row['SZEMNEV'];?></div><br>
								<div class="cat"><?php echo $row['KATEGORIA'];?></div><br>
								<?php echo $row['LEIRAS'];?>
								<input type="hidden" name="chid" value="<?php echo $row['SZEMAZ']; ?>" />
								<input type="hidden" name="oid" value="<?php echo $row_sub['PAZ']; ?>" />
							</td>
							<td>
								<?php echo $row['EXEMPLARY'];?>
							</td>
							<td>
								<?php echo $row['ACCOMPLISHED'];?>
							</td>
							<td>
								<?php echo $row['DEVELOPING'];?>
							</td>
							<td>
								<?php echo $row['BEGINNING'];?>
							</td>
							<td>
							<?php if($row['FOK']==4): ?>
								<select name="result_judge" required/>
									<option></option>
									<option value="4">EXEMPLARY</option>
									<option value="3">ACCOMPLISHED</option>
									<option value="2">DEVELOPING</option>
									<option value="1">BEGINNING</option>
								</select>
								<?php echo $lang['scored'].': '.$row_sub['ERTEK'];?>
							<?php else: ?>
								<select name="result_judge" required/>
									<option></option>
									<option value="3">ACCOMPLISHED</option>
									<option value="2">DEVELOPING</option>
									<option value="1">BEGINNING</option>
								</select>
								<?php echo $lang['scored'].': '.$row_sub['ERTEK'];?>
							<?php endif; ?>
							</td>
							<td width=10%>
								<input type="image" id="send" src="images/modify-judge.svg" width=50% alt="ok icon">
							</td>
						</form>
					</tr>	
				<?php endif; ?>
				
		<?php
			}
		?>
		</table>
		<?php
		$sql_sub="SELECT `zsuri-pontok`.`PAZ`
		FROM `zsuri-pontok` 
		LEFT JOIN `zsuri-szempontok` ON `zsuri-szempontok`.`SZEMAZ`= `zsuri-pontok`.`SZEMID` 
		LEFT JOIN `zskategoriak` ON `zskategoriak`.`ZSAZ`=`zsuri-szempontok`.`ZSURIKATID` 
		WHERE `zsuri-pontok`.`CSID` = '$team_id' AND `zskategoriak`.`ZSAZ` = '$user_category_id' AND `zsuri-pontok`.`FID` = '$user_tourn'";
		$result_sub = $db->query($sql_sub);
		$count = mysqli_num_rows($result_sub);
		?>
		<table>
			<form action="end_of_judge_scoring.php" method="post">
				<tr>
					<td>
						<?php echo $lang['bonus_max_5'];?>
					</td>
					<td>
						<input type="number" name="bonus_p" min="0" max="5">
					</td>
					
				</tr>
				<tr>
					<td>
						<?php echo $lang['comm_to_team'].': ';?>
					</td>
					<td>
						<textarea name="message_to_team" rows="10" cols="50"></textarea>
					</td>
					
				</tr>
				<tr>
					<td>
						<?php echo $lang['comm_to_jc'].': ';?>
					</td>
					<td>
						<textarea name="message" rows="10" cols="50"></textarea>
					</td>
					
				</tr>
				<tr>
					<?php if($count==$robot_design_num): ?>
						<td>
							<?php echo $user_category.' '. $lang['judge_team'].': ';?>
							<input type="checkbox" name="judge_check" required/>
						</td>
						<td>
							<button type = "submit" name="submit"><?php echo $lang['scoring'];?></button>
						</td>
					<?php else: ?>
						<td>
							<?php echo $user_category.' '. $lang['judge_team'].': ';?>
							<input type="checkbox" name="judge_check" readonly>
						</td>
						<td>
							<button type = "button" name="submit"><?php echo $lang['not_poss_score'];?></button>
						</td>
						<?php endif; ?>

				</tr>
			</form>
		</table>

		<form action="judge_scoring.php" method="post">
			<input type="image" src="images/back.svg" width=5% alt="back icon">
		</form>
		
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
</html>