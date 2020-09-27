<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=4){
	header('location: logout.php');
}

if($_SESSION['ACTIVE']!=1){
	header('location: check_result_l.php');
}

$category_r=$_SESSION['cat_id']=$_POST['subject_cat'];
	
?>
<html>
<head>
      <title><?php echo $lang['ad_result']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
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
		$sql="SELECT `csapatok`.*,`csapat-fordulo`.`CSLSZAM`
				FROM `csapatok` 
				LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
				WHERE `csapatok`.`SZID` = '$akt_season_id' AND `csapat-fordulo`.`FORDULOID` = '$user_tourn' AND `csapat-fordulo`.`MEGJELENTE`='1'";
		$result = $db->query($sql);
	?>
	<table style="width:100%">
		<tr>
		<th><?php echo $lang['id']; ?></th>
		<th><?php echo $lang['team_name']; ?></th> 
		<th><?php echo $lang['modify']; ?></th>
		</tr>
	<?php
		while($row = $result->fetch_assoc()) {
		$team_id=$row['CSAZ'];
		$sql_sub="SELECT `zsuri-osszesito`.`RIDO`
			FROM `zsuri-osszesito`
			WHERE `zsuri-osszesito`.`CSID` = '$team_id' AND `zsuri-osszesito`.`FID` = '$user_tourn' AND `zsuri-osszesito`.`ZSKATID` = '$category_r'";
		$result_sub = $db->query($sql_sub);
		$count_sub = mysqli_num_rows($result_sub);
		$row_sub = $result_sub->fetch_assoc();
	?>
	<?php if($count_sub==0): ?>
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
			<?php echo $lang['not_scoring']; ?>
			</td>
			</tr>
	<?php else: ?>
			<tr>
			<form action="modify_res_adm_iii.php" method="post">
			<td >
			<?php echo $row['CSAZ'];?>
			<input type="hidden" name="tid" value="<?php echo $row['CSAZ']; ?>" />
			</td>
			<td>
			<?php echo $row['CSNEV'];?>
			<input type="hidden" name="tname" value="<?php echo $row['CSNEV']; ?>" />
			</td>
			<td>
			<button type="submit"><?php echo $lang['modify']; ?></button>
			</td>
			</tr>
			</form>
			</tr>
	<?php endif; ?>
	<?php
		}
	?>
	<table>
	<form action="modify_res_adm_i.php" method="post">
		<input type="image" src="images/back.svg" width=5% alt="back icon">
	</form>
	<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
	</div>
</body>
</html>