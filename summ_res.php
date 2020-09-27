<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=4){
	header('location: logout.php');
}
$pr1=1;
$pr2=2;
$pr3=3;
$qf=4;
$sf=5;
$f1=6;
$f2=7;

$rd=1;
$rw=2;
$tw=3;

$maximum_jd= 50;

$sql="SELECT `csapat-fordulo`.`FORDULOID`, `csapatok`.*
	FROM `csapat-fordulo` 
	LEFT JOIN `csapatok` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
	WHERE `csapat-fordulo`.`FORDULOID` = '$user_tourn'";

$result = $db->query($sql);

$sql_max_rg = "SELECT MAX(`biro-osszesito`.`OSSZPONT`) AS MAX
				FROM	`biro-osszesito`
				WHERE	`biro-osszesito`.`FID`='$user_tourn' AND (`biro-osszesito`.`KID`='$pr1' OR `biro-osszesito`.`KID`='$pr2' OR `biro-osszesito`.`KID`='$pr3')";
$result_max_rg = $db->query($sql_max_rg);
$row_max_rg = $result_max_rg->fetch_assoc();
$max_rg= $row_max_rg['MAX'];

$sql_max_rd = "SELECT MAX(`zsuri-osszesito`.`OSSZPONT`) AS MAX
			FROM `zsuri-osszesito`
			WHERE `zsuri-osszesito`.`FID` = '$user_tourn' AND `zsuri-osszesito`.`ZSKATID` = '$rd'";
$result_max_rd = $db->query($sql_max_rd);
$row_max_rd = $result_max_rd->fetch_assoc();
$max_rd= $row_max_rd['MAX'];

$sql_max_rw = "SELECT MAX(`zsuri-osszesito`.`OSSZPONT`) AS MAX
			FROM `zsuri-osszesito`
			WHERE `zsuri-osszesito`.`FID` = '$user_tourn' AND `zsuri-osszesito`.`ZSKATID` = '$rw'";
$result_max_rw = $db->query($sql_max_rw);
$row_max_rw = $result_max_rw->fetch_assoc();
$max_rw= $row_max_rw['MAX'];

$sql_max_tw = "SELECT MAX(`zsuri-osszesito`.`OSSZPONT`) AS MAX
			FROM `zsuri-osszesito`
			WHERE `zsuri-osszesito`.`FID` = '$user_tourn' AND `zsuri-osszesito`.`ZSKATID` = '$tw'";
$result_max_tw = $db->query($sql_max_tw);
$row_max_tw = $result_max_tw->fetch_assoc();
$max_tw= $row_max_tw['MAX'];
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
		<th>Robot Design</th> 
		<th><?php echo $lang['team_w_res']; ?></th>
		<th><?php echo $lang['res_w_res']; ?></th>
		<th>Robot Game</th>
		<th><?php echo $lang['sum_score']; ?></th> 
		</tr>
		<?php
		while($row = $result->fetch_assoc()) {
			$team_id = $row['CSAZ'];
		?>
		<tr>
		<td>
			<?php echo $row['CSNEV'].' ['.$row['CSAZ'].']';?>
		</td>
		<td>
			<?php 
			$sql_res_rd="SELECT `zsuri-osszesito`.`OSSZPONT` AS P
					FROM `zsuri-osszesito`
					WHERE `zsuri-osszesito`.`CSID` = '$team_id' AND `zsuri-osszesito`.`FID` = '$user_tourn' AND `zsuri-osszesito`.`ZSKATID` = '$rd'";
			$res_rd=$db->query($sql_res_rd);
			$rd_points = $res_rd->fetch_assoc();
			$rd_res = $rd_points['P'];
			$rd_to_table=result_div($rd_res,$max_rd,$maximum_jd);
			echo $rd_to_table;
			?>
		</td>
		<td>
			<?php 
			$sql_res_rw="SELECT `zsuri-osszesito`.`OSSZPONT` AS P
					FROM `zsuri-osszesito`
					WHERE `zsuri-osszesito`.`CSID` = '$team_id' AND `zsuri-osszesito`.`FID` = '$user_tourn' AND `zsuri-osszesito`.`ZSKATID` = '$rw'";
			$res_rw=$db->query($sql_res_rw);
			$rw_points = $res_rw->fetch_assoc();
			$rw_res = $rw_points['P'];
			$rw_to_table=result_div($rw_res,$max_rw,$maximum_jd);
			echo $rw_to_table;?>
		</td>
		<td>
			<?php 
			$sql_res_tw="SELECT `zsuri-osszesito`.`OSSZPONT` AS P
					FROM `zsuri-osszesito`
					WHERE `zsuri-osszesito`.`CSID` = '$team_id' AND `zsuri-osszesito`.`FID` = '$user_tourn' AND `zsuri-osszesito`.`ZSKATID` = '$tw'";
			$res_tw=$db->query($sql_res_tw);
			$tw_points = $res_tw->fetch_assoc();
			$tw_res = $tw_points['P'];
			$tw_to_table=result_div($tw_res,$max_tw,$maximum_jd);
			echo $tw_to_table;?>
		</td>
		<td>
			<?php 
			$sql_res_rg="SELECT MAX(`biro-osszesito`.`OSSZPONT`) AS P
				FROM	`biro-osszesito`
				WHERE	`biro-osszesito`.`FID`='$user_tourn' AND (`biro-osszesito`.`KID`='$pr1' OR `biro-osszesito`.`KID`='$pr2' OR `biro-osszesito`.`KID`='$pr3') AND `biro-osszesito`.`CSID`='$team_id'";
			$res_rg=$db->query($sql_res_rg);
			$rg_points = $res_rg->fetch_assoc();
			$rg_res = $rg_points['P'];
			$rg_to_table=result_div($rg_res,$max_rg,$maximum_jd);
			echo $rg_to_table;?>
		</td>
		<td>
			<?php 
			$final_res = $rd_to_table + $rw_to_table + $tw_to_table + $rg_to_table;
			echo $final_res;?>
		</td>
		</tr>
		<?php
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