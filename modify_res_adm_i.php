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
	
$sqlcat = "SELECT * FROM `zskategoriak`";
$resultcat = $db->query($sqlcat);
	
$sqlr = "SELECT * FROM `bfordulok`";
$resultr = $db->query($sqlr);

?>
<html>
   
   <head>
      <title><?php echo $lang['ad_result']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
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
		
		<form action="modify_res_adm_ii.php" method="post">
			<table>
				<tr>
					<td>
					<?php echo $lang['jud']; ?>
					</td>
					<td>
						<p class="form">
						<label for="cat"><?php echo $lang['cat']; ?>:</label>
						<select name="subject_cat"required/> 
						<option></option>
						<?php while($subjectDataCat = $resultcat->fetch_assoc()){ ?>
						<option value="<?php echo $subjectDataCat['ZSAZ'];?>"> <?php echo $subjectDataCat['ZSKATNEV'];?></option>
						<?php }?> 
						</select>
						</p>
					</td>
					<td>
						<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
					</td>
				</tr>
			<table>
		</form>
		
		<br>
		<br>
		
		<form action="modify_res_adm_ii_ref.php" method="post">
			<table>
				<tr>
					<td>
					<?php echo $lang['ref']; ?>
					</td>
					<td>
						<p class="form">
						<label for="rou"><?php echo $lang['round_ad']; ?>:</label>
						<select name="subject_rou"required/> 
						<option></option>
						<?php while($subjectDataR = $resultr->fetch_assoc()){ ?>
						<option value="<?php echo $subjectDataR['FOAZ'];?>"> <?php echo $subjectDataR['FONEV'];?></option>
						<?php }?> 
						</select>
						</p>
					</td>
					<td>
						<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
					</td>
				</tr>
			</table>
		</form>
		
		<form action="welcomeadm.php" method="post">
			<input type="image" src="images/back.svg" width=5% alt="back icon">
		</form>
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
   </body>
   
</html>