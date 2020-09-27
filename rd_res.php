<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=4){
	header('location: logout.php');
}
$cat_id=1;
$sql="SELECT `csapatok`.`CSNEV`, `zsuri-osszesito`.`OSSZPONT`, `zsuri-osszesito`.`FID`, `zsuri-osszesito`.`ZSDM`, `zsuri-osszesito`.`MEGJ`
	FROM `csapatok` 
	LEFT JOIN `zsuri-osszesito` ON `zsuri-osszesito`.`CSID` = `csapatok`.`CSAZ`
	WHERE `zsuri-osszesito`.`FID` = '$user_tourn' AND `zsuri-osszesito`.`ZSKATID` = '$cat_id'
	ORDER BY `OSSZPONT` DESC";
$result = $db->query($sql);
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
	<table style="width:100%">
		<tr>
			<th><?php echo $lang['team_name']; ?></th>
			<th><?php echo $lang['sum_score']; ?></th> 
			<th><?php echo $lang['to_ev']; ?></th>
			<th><?php echo $lang['to_team']; ?></th>
			<th><?php echo $lang['rank']; ?></th>
		</tr>
			<?php
			$rank=1;
			while($row = $result->fetch_assoc()) {	
			?>
				<tr>
					<td>
						<?php echo $row['CSNEV'];?>
					</td>
					<td>
						<?php echo $row['OSSZPONT'];?>
					</td>
					<td>
						<?php echo $row['ZSDM'];?>
					</td>
					<td>
						<?php echo $row['MEGJ'];?>
					</td>
					<td>
						<?php echo $rank;?>
					</td>
				</tr>
		<?php
			$rank+=1;
			}
		?>
	</table>
	<br>
	<br>
	<br>
	<form action="check_result_l.php" method="post">
		<input type="image" src="images/back.svg" width=5% alt="back icon">
	</form>
</body>
</html>