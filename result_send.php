<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=4){
	header('location: logout.php');
}

?>
<html>
   
   <head>
      <title><?php echo $lang['ad_send']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomeadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="check_result_l.php"><?php echo $lang['ad_result']; ?></a>
			<a href="sch_maker.php"><?php echo $lang['schedule']; ?></a>
			<a class="active" href="result_send.php"><?php echo $lang['ad_send']; ?></a>
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
		
		<table class="center">
			<tr>
				<td class="alert">
					<?php echo $lang['res_send_attention'];?>
				</td>
			</tr>
		</table>
		
		<br>
		<br>
		
		<table class="center">
			<tr>
				<td class="ok">
					<form action="welcomeadm.php" method="post">
						<button type="submit"><?php echo $lang['back']; ?></button>
					</form>
				</td>
				<td class="alert">
					<form action="result_send_ii.php" method="post">
						<button type="submit"><?php echo $lang['write']; ?></button>
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