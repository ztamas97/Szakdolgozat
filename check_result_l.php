<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=4){
	header('location: logout.php');
}
   
$sql_ac="SELECT `fordulok`.*
		FROM `fordulok`
		WHERE `fordulok`.`FAZ` = '$user_tourn' AND `fordulok`.`AKTIV` = '1'";
$result_ac= $db->query($sql_ac);
$count = mysqli_num_rows($result_ac);  
$_SESSION['ACTIVE']=0;
?>
<html>
<head>
      <title><?php echo $lang['ad_result']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/check_result.css">
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
	<td>
	<div class="container">
		<form action="summ_res.php" method="post">
		<img src="images/ossz.jpg" alt="ossz" style="width:100%">
		<button type="submit" class="btn"><?php echo $lang['res_sum_ad']; ?></button></form>
	</div>
	</td>
	<td>
	<div class="container">
		<form action="rg_res.php" method="post">
		<img src="images/rg.jpg" alt="robot game" style="width:100%">
		<button type="submit" class="btn">Robot Game</button></form>
	</div>
	</td>
	<td>
	<div class="container">
		<form action="rd_res.php" method="post">
		<img src="images/rd.jpg" alt="robot design" style="width:100%">
		<button type="submit" class="btn">Robot Design</button></form>
	</div>
	</td>
	<td>
	<div class="container">
		<form action="tw_res.php" method="post">
		<img src="images/tw.jpg" alt="team work" style="width:100%">
		<button type="submit" class="btn"><?php echo $lang['team_w_res']; ?></button></form>
	</div>
	</td>
	<td>
	<div class="container">
		<form action="rw_res.php" method="post">
		<img src="images/rw.jpg" alt="research" style="width:100%">
		<button type="submit" class="btn"><?php echo $lang['res_w_res']; ?></button></form>
	</div>
	</td>
	<td>
	<div class="container">
		<form action="projection.php" method="post">
		<img src="images/ossz.jpg" alt="spect" style="width:100%">
		<button type="submit" class="btn"><?php echo $lang['visitors_ad']; ?></button></form>
	</div>
	</td>
	<?php if ($count>0){
		$_SESSION['ACTIVE']=1?>
		<td>
		<div class="container">
			<form action="modify_res_adm_i.php" method="post">
			<img src="images/repair_result.svg" alt="modify" style="width:70%">
			<button type="submit" class="btn"><?php echo $lang['modify']; ?></button></form>
		</div>
		</td>
	<?php } ?>
	</tr>
	</table>
	<br>
	<form action="welcomeadm.php" method="post">
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