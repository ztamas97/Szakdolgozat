<?php
include('session.php');
include('judge_category_numbers.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=3){
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
$rid=$_SESSION['round'];
   
$sql="SELECT `csapatok`.`COACH`, `csapat-fordulo`.`CSLSZAM`
	FROM `csapatok` 
	LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
	WHERE `csapatok`.`CSAZ` = '$team_id' AND `csapat-fordulo`.`FORDULOID` = '$rid'";
	
$result = $db->query($sql);
$row = $result->fetch_assoc();
$team_mem_num=$row['CSLSZAM'];
$coach=$row['COACH'];
$round=$_SESSION['rg_round'];
   
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
		
		<h3><?php echo $lang['team_name']; ?>: <?php echo $team_name; ?> | <?php echo $lang['id']; ?>: <?php echo $team_id; ?>| <?php echo $lang['teammem']; ?>: <?php echo $team_mem_num; ?> | <?php echo $lang['coach']; ?>: <?php echo $coach; ?></h3>
		
		<br>
		<?php
			$sql="SELECT `biro-feladatok`.*
				FROM `biro-feladatok`
				WHERE `biro-feladatok`.`SZID` = '$akt_season_id'
				ORDER BY `biro-feladatok`.`SUBAZ`";
			$result = $db->query($sql);
		?>
		<table style="width:100%">
		<tr>
			<th><?php echo $lang['id']; ?></th> 
			<th><?php echo $lang['descr']; ?></th>
			<th><?php echo $lang['scoring']; ?></th>
			<th><?php echo $lang['send']; ?></th>
		</tr>
		<?php
			while($row = $result->fetch_assoc()) {
				$obj_id=$row['FELAZ'];
		?>
			<tr>
				<td class="id">
					<?php echo $row['SUBAZ'];?><br>
					<img src="<?php echo 'images/'.$row['SUBAZ'].'.png';?>" alt="gaz">
				</td>
				<td>
					<div class="name"><?php echo $row['NEV'].' ';?></div>
					<?php echo $row['FMEGJ'];?>
				</td>
				<td>
				</td>
				<td>
				</td>
			</tr>
		<?php	
			$sql_sub="SELECT `biro-r-feladatok`.*, `biro-tipus`.`BTIPNEV`
				FROM `biro-r-feladatok` 
				LEFT JOIN `biro-tipus` ON `biro-r-feladatok`.`TIPUSID` = `biro-tipus`.`BTIPAZ`
				WHERE `biro-r-feladatok`.`FELID` = '$obj_id'";
			$result_sub = $db->query($sql_sub);
			while($row_sub = $result_sub->fetch_assoc()) {
				$min=$row_sub['MINERTEK'];
				$max=$row_sub['MAXERTEK'];
				$brfaz=$row_sub['FUGGID'];
				$brf=$row_sub['BRFAZ'];
				$sql_check="SELECT `biro-pontok`.`BOAZ`, `biro-pontok`.`CSID`, `biro-pontok`.`FID`, `biro-pontok`.`BKATID`, `biro-pontok`.`BRRFID`, `biro-pontok`.`SZORZO`
					FROM `biro-pontok`
					WHERE `biro-pontok`.`CSID` = '$team_id' AND `biro-pontok`.`FID` = '$rid' AND `biro-pontok`.`BKATID` = '$round' AND `biro-pontok`.`BRRFID` = '$brf'";
				$result_check = $db->query($sql_check);
				$count_check = mysqli_num_rows($result_check);
				$row_check = $result_check->fetch_assoc();
		?>
				<?php if($count_check==0): ?>
					<?php if($row_sub['FUGGID']==NULL): ?>
						<tr id="<?php echo $row['FELAZ']?>">
							<form action="insert_scoresheet_ref.php" method="get">
								<td>
									<input type="hidden" name="chid" value="<?php echo $row_sub['BRFAZ']; ?>" />
									<input type="hidden" name="backpoint" value="<?php echo $row['FELAZ']; ?>" />
								</td>
								<td>
									<?php echo $row_sub['LEIRAS']; ?>
								</td>
								<td>
									<?php if($row_sub['BTIPNEV']=='YN'): ?>
										<input type="radio" id="radio_yes" name="res" value="1">   
										<label for="radio_yes">Yes</label>
										<br>
										<input type="radio" id="radio_no" name="res" value="0">   
										<label for="radio_no">No</label>
									<?php elseif($row_sub['BTIPNEV']=='NUMB'): ?>
										<input type="number" id="number" name="res" min="<?php echo $min; ?>" max="<?php echo $max; ?>"/>
									<?php elseif($row_sub['BTIPNEV']=='RBUTTON3(034)'): ?>
										<input type="radio" id="one" name="res" value="0">
										<label for="one">1</label><br>
										<input type="radio" id="two" name="res" value="3">
										<label for="two">2</label><br>
										<input type="radio" id="three" name="res" value="4">
										<label for="three">3</label>
									<?php endif; ?>
								</td>
								<td width=10%>
									<input type="image" id="send" src="images/ok.svg" width=50% alt="ok icon">
								</td>
							</form>
						</tr>
				
				<?php else: 
				$sql_sub2="SELECT `biro-pontok`.`BOAZ`, `biro-pontok`.`CSID`, `biro-pontok`.`FID`, `biro-pontok`.`BKATID`, `biro-pontok`.`BRRFID`, `biro-pontok`.`SZORZO`
				FROM `biro-pontok`
				WHERE `biro-pontok`.`CSID` = '$team_id' AND `biro-pontok`.`FID` = '$rid' AND `biro-pontok`.`BKATID` = '$round' AND `biro-pontok`.`BRRFID` = '$brfaz' AND `biro-pontok`.`SZORZO` > '0'";
				$result_sub2 = $db->query($sql_sub2);
				$count_sub2 = mysqli_num_rows($result_sub2);
				?>
					<?php if($count_sub2>0): ?>
						<tr id="<?php echo $row['FELAZ']?>">
							<form action="insert_scoresheet_ref.php" method="get">
								<td>
									<input type="hidden" name="chid" value="<?php echo $row_sub['BRFAZ']; ?>" />
								</td>
								<td>
									<?php echo $row_sub['LEIRAS']; ?>
								</td>
								<td>
									<?php if($row_sub['BTIPNEV']=='YN'): ?>
										<input type="radio" id="radio_yes" name="res" value="1">   
										<label for="radio_yes">Yes</label>
										<br>
										<input type="radio" id="radio_no" name="res" value="0">   
										<label for="radio_no">No</label>
									<?php elseif($row_sub['BTIPNEV']=='NUMB'): ?>
										<input type="number" id="number" name="res" min="<?php echo $min; ?>" max="<?php echo $max; ?>"/>
									<?php elseif($row_sub['BTIPNEV']=='RBUTTON3(034)'): ?>
										<input type="radio" id="one" name="res" value="0">
										<label for="one">1</label><br>
										<input type="radio" id="two" name="res" value="3">
										<label for="two">2</label><br>
										<input type="radio" id="three" name="res" value="4">
										<label for="three">3</label>
									<?php endif; ?>
								</td>
								<td width=10%>
									<input type="image" id="send" src="images/ok.svg" width=50% alt="ok icon">
								</td>
							</form>
						</tr>
					<?php else: ?>
						<tr id="<?php echo $row['FELAZ']?>">
							<form action="insert_scoresheet_ref.php" method="get">
								<td>
									<input type="hidden" name="chid" value="<?php echo $row_sub['BRFAZ']; ?>" />
								</td>
								<td>
									<?php echo $row_sub['LEIRAS']; ?>
								</td>
								<td>
									<button type="button" onclick="alert('Függés miatt nem rögzíthető')"><?php echo $lang['error']; ?>!</button>
								</td>
								<td>
								</td>
							</form>
						</tr>
					<?php endif; ?>
				<?php endif; ?>
				<?php else: 
						$value= $row_check['SZORZO']?>
						<tr id="<?php echo $row['FELAZ']?>">
							<form action="update_scoresheet_ref.php" method="get">
								<td>
									<input type="hidden" name="boaz" value="<?php echo $row_check['BOAZ']; ?>" />
								</td>
								<td>
									<?php echo $row_sub['LEIRAS']; ?>
								</td>
								<td>
								<?php if($row_sub['BTIPNEV']=='YN' AND $value==1): ?>
									<input type="radio" id="radio_yes" name="res" value="1" checked>   
									<label for="radio_yes">Yes</label>
									<br>
									<input type="radio" id="radio_no" name="res" value="0">   
									<label for="radio_no">No</label>
								<?php elseif($row_sub['BTIPNEV']=='YN' AND $value==0): ?>
									<input type="radio" id="radio_yes" name="res" value="1">   
									<label for="radio_yes">Yes</label>
									<br>
									<input type="radio" id="radio_no" name="res" value="0" checked>   
									<label for="radio_no">No</label>	
								<?php elseif($row_sub['BTIPNEV']=='NUMB'): ?>
									<input type="number" id="number" name="res" value="<?php echo $value; ?>" min="<?php echo $min; ?>" max="<?php echo $max; ?>"/>
								<?php elseif($row_sub['BTIPNEV']=='RBUTTON3(034)' AND $value==0): ?>
									<input type="radio" id="one" name="res" value="0" checked>
									<label for="one">1</label><br>
									<input type="radio" id="two" name="res" value="3">
									<label for="two">2</label><br>
									<input type="radio" id="three" name="res" value="4">
									<label for="three">3</label>
								<?php elseif($row_sub['BTIPNEV']=='RBUTTON3(034)' AND $value==3): ?>
									<input type="radio" id="one" name="res" value="0">
									<label for="one">1</label><br>
									<input type="radio" id="two" name="res" value="3" checked>
									<label for="two">2</label><br>
									<input type="radio" id="three" name="res" value="4">
									<label for="three">3</label>
									<?php elseif($row_sub['BTIPNEV']=='RBUTTON3(034)' AND $value==4): ?>
									<input type="radio" id="one" name="res" value="0">
									<label for="one">1</label><br>
									<input type="radio" id="two" name="res" value="3">
									<label for="two">2</label><br>
									<input type="radio" id="three" name="res" value="4" checked>
									<label for="three">3</label>
								<?php endif; ?>
								</td>
								<td width=10%>
									<input type="image" id="send" src="images/modify-judge.svg" width=50% alt="modify icon">
								</td>
							</form>
						</tr>
				<?php endif; ?>
				
		<?php
			}
			}
			$sql_sub3="SELECT `biro-osszesito`.`OSSZPONT`
			FROM `biro-osszesito`
			WHERE `biro-osszesito`.`CSID` = '$team_id' AND `biro-osszesito`.`FID` = '$rid' AND `biro-osszesito`.`KID` = '$round'";
			$result_sub3 = $db->query($sql_sub3);
			$row_sub3 = $result_sub3->fetch_assoc();
		?>
		</table>

		<table style="width:20%">
			<tr>
				<td>
					<?php echo $lang['sum_score'].': '.$row_sub3['OSSZPONT']; ?>
				</td>
			</tr>
		</table>
		
		<br>
		
		<form action="modify_res_madm_ii_ref.php" method="post">
			<input type="image" src="images/back.svg" width=5% alt="back icon">
		</form>
		
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
</html>