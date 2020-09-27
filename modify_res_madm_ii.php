<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=3){
	header('location: logout.php');
}

$location_r=$_SESSION['loc_id']=$_POST['subject_loc'];
$level_r=$_SESSION['lev_id']=$_POST['subject_lev'];
$category_r=$_SESSION['cat_id']=$_POST['subject_cat'];
	
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
		$sql="SELECT `csapatok`.*,`csapat-fordulo`.`CSLSZAM`
				FROM `csapatok` 
				LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
				WHERE `csapatok`.`SZID` = '$akt_season_id' AND `csapat-fordulo`.`FORDULOID` = '$rid' AND `csapat-fordulo`.`MEGJELENTE`='1'";
		$result = $db->query($sql);
	?>
	<table style="width:100%">
	<tr>
    <th><?php echo $lang['team_id']; ?></th>
    <th><?php echo $lang['team_name']; ?></th> 
    <th><?php echo $lang['modify']; ?></th>
  </tr>
	<?php
		while($row = $result->fetch_assoc()) {
			$team_id=$row["CSAZ"];
			$sql_sub="SELECT `zsuri-osszesito`.`RIDO`
				FROM `zsuri-osszesito`
				WHERE `zsuri-osszesito`.`CSID` = '$team_id' AND `zsuri-osszesito`.`FID` = '$rid' AND `zsuri-osszesito`.`ZSKATID` = '$category_r'";
			$result_sub = $db->query($sql_sub);
			$count_sub = mysqli_num_rows($result_sub);
			$row_sub = $result_sub->fetch_assoc();
	?>
	<?php if($count_sub==0): ?>
			<tr>
			<td >
			<?php echo $row['CSAZ'];?>
			<input type="hidden" name="tid" value="<?php echo $row["CSAZ"]; ?>" />
			</td>
			<td>
			<?php echo $row['CSNEV'];?>
			<input type="hidden" name="tname" value="<?php echo $row["CSNEV"]; ?>" />
			</td>
			<td>
			<?php echo $lang['not_scoring']; ?>
			</td>
			</tr>
	<?php else: ?>
			<tr>
			<form action="modify_res_madm_iii.php" method="post">
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
	</table>
	<form action="modify_res_madm_i.php" method="post">
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