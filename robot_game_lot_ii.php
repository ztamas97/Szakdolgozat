<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=4){
	header('location: logout.php');
}
	
$sql_tnum="SELECT `fordulok`.`FAZ`, `fordulok`.`RGASZTALNUM`
	FROM `fordulok`
	WHERE `fordulok`.`FAZ` = '$user_tourn'";
$result_tnum = $db->query($sql_tnum);
$row_tnum = $result_tnum->fetch_assoc();
$_SESSION['TABLENUM']=$table_num=$row_tnum['RGASZTALNUM'];
	
$sqlr = "SELECT * FROM `bfordulok`";
$resultr = $db->query($sqlr);

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
		<form action="robot_game_lot_iii.php" method="post">
			<table>
			<tr>
			<td>
			<p class="form">
			<label for="tablenumber"><?php echo $lang['table_num']; ?>:</label>
			<input type="number" name="tablenumber" id="tablenumber" min=1 max=<?php echo $table_num; ?> required/>
			</p>
			</td>
			</tr>
			<tr>
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
			</tr>
			<tr>
			<td>
			<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
			</td>
			</tr>
			</table>
		</form>
		
		<table>
			<tr>
				<td>
					<form action="robot_game_qf_i.php" method="post">
						<button type="submit"><?php echo $lang['qf_gen']; ?></button>
					</form>
				</td>
				<td>
					<form action="robot_game_sf_i.php" method="post">
						<button type="submit"><?php echo $lang['sf_gen']; ?></button>
					</form>
				</td>
				<td>
					<form action="robot_game_f_i.php" method="post">
						<button type="submit"><?php echo $lang['f_gen']; ?></button>
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