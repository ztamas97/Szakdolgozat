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
      <title><?php echo $lang['ad_reg']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
  <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomeadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="check_result_l.php"><?php echo $lang['ad_result']; ?></a>
			<a href="sch_maker.php"><?php echo $lang['schedule']; ?></a>
			<a href="result_send.php"><?php echo $lang['ad_send']; ?></a>
			<a class="active" href="addteaminfo.php"><?php echo $lang['ad_reg']; ?></a>
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
				
			$sql="SELECT `csapatok`.*, `csapat-fordulo`.`MEGJELENTE`, `csapat-fordulo`.`CSLSZAM`, `csapat-fordulo`.`CLSZAM`
			FROM `csapatok` 
			LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
			WHERE `csapatok`.`SZID` = '$akt_season_id' AND `csapat-fordulo`.`FORDULOID` = '$user_tourn'";
				
			$result = $db->query($sql);
		?>
		
		<?php while($row=$result->fetch_assoc()){?>
					<table style="width:70%">
						<tr>
							<th>
								<?php echo $lang['id']; ?>:
							</th>
							<td>
								<?php echo $row['CSAZ'];?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['team_name']; ?>:
							</th>
							<td>
								<?php echo $row['CSNEV'];?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['poss_teammem']; ?>:
							</th>
							<td>
								<?php echo $row['VCSLSZAM']; ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['poss_coachnum']; ?>:
							</th>
							<td>
								<?php echo $row['VCOACHSZAM']; ?>
							</td>
						</tr>
						<tr>
							<th>
								E-mail:
							</th>
							<td>
								<?php echo $row['EMAIL']; ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['check_res_code']; ?>:
							</th>
							<td>
								<?php echo $user_tourn.'-'.$row['CSAZ'].'-'.$row['VCSLSZAM'].'-'.$row['EMAIL']; ?>
							</td>
						</tr>
						<?php if($row['MEGJELENTE']==1):?>
						<tr>
							<th style="background-color: lime">
								<?php echo $lang['is_here']; ?>
							</th>
							<td>
								<?php echo $lang['teammem'].': ' . $row['CSLSZAM'].'<br>';
									  echo $lang['coach_num'].': ' . $row['CLSZAM'].'<br>';?>
							</td>
						</tr>
						<?php endif;?>
						<?php if($row['MEGJELENTE']==0):?>
						<tr style="background-color: coral">
							<th>
								<?php echo $lang['wait_to_reg']; ?>
							</th>
						</tr>
						<tr>
							<form action="updateteaminfo.php" method="post">
							<tr>
								<td>
									<p class="form">
									<label for="teammem"><?php echo $lang['teammem']; ?>:</label>
									<input type="number" name="teammem" id="teammem" min=2 max=10>
									<input type='hidden' name='teamid' value="<?php echo $row['CSAZ']; ?>">
									<input type='hidden' name='email' value="<?php echo $row['EMAIL']; ?>">
									<input type='hidden' name='poss_teammem' value="<?php echo $row['VCSLSZAM']; ?>">
									</p>
								</td>
							</tr>
							<tr>
								<td>
									<p class="form">
									<label for="cn"><?php echo $lang['coach_num']; ?>:</label>
									<input type="number" name="cn" id="cn" min=1 max=5>
									</p>
								</td>
							</tr>
							<tr>
								<td>
									<p class="form">
									<?php echo $lang['is_here']; ?> <input type="radio" name="radio" value="1">
									</p>
								</td>
							</tr>
							<tr>
								<td>
									<button type = "submit"><?php echo $lang['send']; ?></button>
								</td>
							</tr>
							</form>
						</tr>
						<?php endif;?>
					</table>
					<br>
		<?php }?>
		
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
   </body>
</html>