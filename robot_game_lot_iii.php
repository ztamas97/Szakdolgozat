<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=4){
	header('location: logout.php');
}
	
if (isset($_POST['subject_rou'])){
	$round=$_SESSION['ROUND']=$_POST['subject_rou'];
}
	
else{
	$round=$_SESSION['ROUND'];
}
	
if (isset($_POST['subject_rou'])){
	$table_num=$_SESSION['TABLENUMBER']=$_POST['tablenumber'];
}
	
else{
	$table_num=$_SESSION['TABLENUMBER'];
}

$sql="SELECT `biro-osszesito`.*, `csapatok`.`CSNEV`
			FROM `biro-osszesito` 
			LEFT JOIN `csapatok` ON `biro-osszesito`.`CSID` = `csapatok`.`CSAZ`
			WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$round' AND `biro-osszesito`.`ASZTAL` = '$table_num'
			ORDER BY `SSZAM`";
$result = $db->query($sql);

?>
<html>
   
   <head>
      <title><?php echo $lang['ad_random']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
	<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomeadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="check_result_l.php"><?php echo $lang['ad_result']; ?></a>
			<a href="sch_maker.php"><?php echo $lang['schedule']; ?></a>
			<a href="result_send.php"><?php echo $lang['ad_send']; ?></a>
			<a href="addteaminfo.php"><?php echo $lang['ad_reg']; ?></a>
			<a class="active" href="robot_game_lot_i.php"><?php echo $lang['ad_random']; ?></a>
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
	<table style="width:50%">
	<tr>
    <th><?php echo $lang['team_s']; ?></th> 
    <th><?php echo $lang['number_of_t']; ?></th>
	<th><?php echo $lang['delet']; ?></th>
	
	</tr>
	<?php
	while($row = $result->fetch_assoc()) {
		
	?>
			<tr>
			<form action="delete_robot_game_lot.php" method="post">
			<td>
			<?php echo $row['CSNEV'];?><br>
			<?php echo ' ['.$row['CSID'].']';?><br>
			<input type="hidden" name="boaz" value="<?php echo $row['BOAZ']; ?>" />
			</td>
			<td>
			<?php echo $row['SSZAM'];?>
			</td>
			<td width=10%>
			<?php if($row['OSSZPONT']==0): ?>
				<input type="image" id="send" src="images/delete.svg" width=50% alt="ok icon">
			<?php else: ?>
				<?php echo $lang['result_save_n']; ?>
			<?php endif; ?>
			</td>
			</form>
			</tr>	
	<?php
		}
	?>
	</table>
	<br>
	<?php
	$sql_sub="SELECT `csapatok`.`CSAZ`,`csapatok`.`CSNEV`
			FROM `csapatok` 
			LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
			WHERE `csapatok`.`SZID` = '$akt_season_id' AND `csapat-fordulo`.`FORDULOID` = '$user_tourn' AND `CSAZ` NOT IN(SELECT `biro-osszesito`.`CSID`
			FROM `biro-osszesito`
			WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$round')";
	$resultt = $db->query($sql_sub);
	#AND `biro-osszesito`.`ASZTAL` = '$table_num
	?>
	<h2><?php echo $lang['add_team']; ?></h2>
	<form action="robot_game_lot_iv.php" method="post">
	<table>
		<tr>
			<td>
				<p class="form">
					<label for="team"><?php echo $lang['team_s']; ?>: </label>
					<select name="subject_team"required/> 
					<option></option>
					<?php while($subjectDataT = $resultt->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataT['CSAZ'];?>"> <?php echo $subjectDataT['CSNEV'];?></option>
					<?php }?> 
					</select>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<p class="form">
					<label for="num"><?php echo $lang['number_of_t']; ?>:</label>
					<input type="number" name="num" id="num"required/>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<button type = "submit" name="submit"><?php echo $lang['send']; ?></button>
			</td>
		</tr>
	</table>
	</form>
	
	<form action="robot_game_lot_ii.php" method="post">
		<input type="image" src="images/back.svg" width=5% alt="back icon">
	</form>
	
	<br>
	<br>
	<br>
		
	<div class="footer">
		<p>Zelles Tamás SZE 2020</p>
	</div>
	
   </body>
   
</html>