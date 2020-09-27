<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=4){
	header('location: logout.php');
}

$sf=5;

$sql="SELECT `biro-osszesito`.`FID`, `biro-osszesito`.`KID`, `biro-osszesito`.`CSID`, `csapatok`.`CSNEV`
	FROM `biro-osszesito` 
	LEFT JOIN `csapatok` ON `biro-osszesito`.`CSID` = `csapatok`.`CSAZ`
	WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$sf'";
$result = $db->query($sql);
$count = mysqli_num_rows($result);
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
		
		<table class="center">
			<tr>
				<td class="alert">
					<?php echo $lang['after_gen_alert']; ?>
				</td>
			</tr>
		</table>
		
		<br>
		<br>
		
		<table class="center">
			<tr>
				<td class="ok">
					<form action="robot_game_lot_ii.php" method="post">
						<button type="submit"><?php echo $lang['back']; ?></button>
					</form>
				</td>
				<td class="alert">
					<form action="robot_game_sf_ii.php" method="post">
						<?php if($count==0):?>
						<button type="submit"><?php echo $lang['next']; ?></button>
						<?php endif;?>
						<?php if($count>0):?>
						<button type="button"><?php echo $lang['is_gen']; ?></button>
						<?php endif;?>
					</form>
				</td>
			</tr>
		</table>
		
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
		
   </body>
   
</html>