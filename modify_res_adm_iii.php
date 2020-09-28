<?php
include('session.php');
include('judge_category_numbers.php');
include('functions.php');
require(languageselect($language));
	
$category_r=$_SESSION['cat_id'];
	
if($user_permission_id!=4){
	header('location: logout.php');
}

if($_SESSION['ACTIVE']!=1){
	header('location: check_result_l.php');
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
   
?>
<html>
	<head>
		  <title><?php echo $lang['ad_result']; ?></title>
		  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
	</head>
	   
	<body>
		<div class="welcome">
				<img src="images/fll_main_logo.png" alt="FLL">
				<a href="welcomeadm.php"><?php echo $lang['home_p']; ?></a>
				<a class="active" href="check_result_l.php"><?php echo $lang['ad_result']; ?></a>
				<a href="sch_maker.php"><?php echo $lang['schedule']; ?></a>
				<a href="result_send.php"><?php echo $lang['ad_send']; ?></a>
				<a href="addteaminfo.php"><?php echo $lang['ad_reg']; ?></a>
				<a href="robot_game_lot_i.php"><?php echo $lang['ad_random']; ?></a>
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
			$sql="SELECT `zsuri-szempontok`.*, `zsuri-szempontok`.`ZSURIKATID` 
				FROM `zsuri-szempontok` 
				WHERE `zsuri-szempontok`.`SZEZONID` = '$akt_season_id' AND `zsuri-szempontok`.`ZSURIKATID` = '$category_r'";
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
				<tr id="<?php echo $row['SZEMAZ']?>">
				<form action="modify_res_adm_iv_i.php" method="get">
				<td >
				<?php echo $row['SZEMNEV'];?><br>
				<?php echo $row['KATEGORIA'];?><br>
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
					<?php echo "Rögzített: ".$row_sub["ERTEK"];?>
				<?php else: ?>
					<select name="result_judge" required/>
					<option></option>
					<option value="3">ACCOMPLISHED</option>
					<option value="2">DEVELOPING</option>
					<option value="1">BEGINNING</option>
					</select>
					<?php echo "Rögzített: ".$row_sub["ERTEK"];?>
				<?php endif; ?>
				</td>
				<td width=10%>
				<input type="image" id="send" src="images/modify-judge.svg" width=50% alt="ok icon">
				</td>
				</form>
				</tr>	
				
		<?php
			}
		?>
		</table>
		<?php
		$sql_sub="SELECT `zsuri-osszesito`.`OSSZPONT`,`zsuri-osszesito`.`PLUSSZP`
				FROM `zsuri-osszesito`
				WHERE `zsuri-osszesito`.`CSID` = '$team_id' AND `zsuri-osszesito`.`FID` = '$user_tourn'";
		$result_sub = $db->query($sql_sub);
		$row_sub = $result_sub->fetch_assoc();
		
		?>
		<table>
		
		<form action="modify_res_adm_iv_ii.php" method="post">
		<tr>
			<td>
				<?php echo $lang['bonus_max_5']; ?>
			</td>
			<td>
				<input type="number" name="bonus_p" value=<?php echo $row_sub['PLUSSZP'];?> min="0" max="5">
			</td>
			
		</tr>
		<tr>
			<td>
			<?php echo $lang['sum_score'].": ". $row_sub['OSSZPONT'];?>
			</td>
			<td>
			<button type = "submit" name="submit"><?php echo $lang['send_bonus']; ?></button>
			</td>
			

		</tr>
		</form>
		</table>

		<form action="modify_res_adm_i.php" method="post">
			<input type="image" src="images/back.svg" width=5% alt="back icon">
		</form>
	</body>
</html>