<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=3){
	header('location: logout.php');
}
	
$sqls = "SELECT * FROM `szezon`";
$results = $db->query($sqls);
	
$sqllev = "SELECT * FROM `szint`";
$resultlev = $db->query($sqllev);
$resultlev2 = $db->query($sqllev);
	
$sqlcat = "SELECT * FROM `zskategoriak`";
$resultcat = $db->query($sqlcat);

$sqlr = "SELECT * FROM `bfordulok`";
$resultr = $db->query($sqlr);

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
		<form action="modify_res_madm_ii.php" method="post">
			<table>
				<tr>
					<td>
						<p class="form">
							<label for="lev"><?php echo $lang['level']; ?>:</label>
							<select name="subject_lev" class="level"required/> 
							<option></option>
							<?php while($subjectDataLev = $resultlev->fetch_assoc()){ ?>
								<option value="<?php echo $subjectDataLev['SZIAZ'];?>"> <?php echo $subjectDataLev['SZINEV'];?></option>
							<?php }?> 
							</select>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="loc"><?php echo $lang['loc']; ?>:</label>
							<select name="subject_loc" class="city"required/> 
							<option></option> 
							</select>
						</p>
					</td>
				</tr>
				<tr>
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
				</tr>
				<tr>
					<td>
						<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
					</td>
				</tr>
			</table>
		</form>
		<form action="modify_res_madm_ii_ref.php" method="post">
			<table>
				<tr>
					<td>
						<p class="form">
							<label for="lev"><?php echo $lang['level']; ?>:</label>
							<select name="subject_lev" class="level2"required/> 
							<option></option>
							<?php while($subjectDataLev2 = $resultlev2->fetch_assoc()){ ?>
								<option value="<?php echo $subjectDataLev2['SZIAZ'];?>"> <?php echo $subjectDataLev2['SZINEV'];?></option>
							<?php }?> 
							</select>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="loc"><?php echo $lang['loc']; ?>:</label>
							<select name="subject_loc" class="city2"required/> 
							<option></option> 
							</select>
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
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function()
		{
		$(".level").change(function()
		{
		var level_id=$(this).val();
		var post_id = 'id='+ level_id;
 
		$.ajax
		({
		type: "POST",
		url: "ajax_teamtourn.php",
		data: post_id,
		cache: false,
		success: function(cities)
		{
		$(".city").html(cities);
		} 
		});
 
		});
		});
		</script>
		<script type="text/javascript">
		$(document).ready(function()
		{
		$(".level2").change(function()
		{
		var level_id=$(this).val();
		var post_id = 'id='+ level_id;
 
		$.ajax
		({
		type: "POST",
		url: "ajax_teamtourn.php",
		data: post_id,
		cache: false,
		success: function(cities)
		{
		$(".city2").html(cities);
		} 
		});
 
		});
		});
		</script>
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
   </body>
   
</html>