<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=1){
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

$schedule='files/Schedule_'.$user_location.'_'.$user_level.'_'.$user_tourn.'.pdf';

?>
<html>
   
   <head>
      <title><?php echo $lang['ref_scoring']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomeref.php"><?php echo $lang['home_p']; ?></a>
			<a href="ref_result.php"><?php echo $lang['ad_result']; ?></a>
			<a href=<?php echo $schedule; ?> target="_blank"><?php echo $lang['schedule']; ?></a>
			<a class="active" href="ref_scoring_I.php"><?php echo $lang['ref_scoring']; ?></a>
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
		<table>
			<form action="ref_scoring_II.php" method="post">
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
							<label for="rou"><?php echo $lang['table_num']; ?>:</label>
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
			</form>
		</table>
		<br>
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
   </body>
   
</html>