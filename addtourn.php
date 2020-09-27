<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=3){
	header("location: logout.php");
}
	
$sqll = "SELECT `helyszinek`.`HAZ`, `helyszinek`.`VAROS` FROM `helyszinek`;";
$resultl = $db->query($sqll);
	
$sqls = "SELECT * FROM `szezon`";
$results = $db->query($sqls);
	
$sqllev = "SELECT * FROM `szint`";
$resultlev = $db->query($sqllev);
?>
<html>
   
   <head>
      <title><?php echo $lang['tourn_mad']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomemadm.php"><?php echo $lang['home_p']; ?></a>
			<a class="active" href="checktourn.php"><?php echo $lang['tourn_mad']; ?></a>
			<a href="checkteam.php"><?php echo $lang['teams_mad']; ?></a>
			<a href="team_tourn.php"><?php echo $lang['team-tourn_mad']; ?></a>
			<a href="modify_res_madm_i.php"><?php echo $lang['res_mod_mad']; ?></a>
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
		
		<form action="inserttourn.php" method="post">
		<table>
			<tr>
				<td>
					<p class="form">
					<label for="loc"><?php echo $lang['loc']; ?>:</label>
					<select name="subject_loc"required/> 
					<option></option>
					<?php while($subjectDataL = $resultl->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataL['HAZ'];?>"> <?php echo $subjectDataL['VAROS'];?></option>
					<?php }?> 
					</select>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="form">
					<label for="ses"><?php echo $lang['season']; ?>:</label>
					<select name="subject_ses"required/> 
					<option></option>
					<?php while($subjectDataS = $results->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataS['SZAZ'];?>"> <?php echo $subjectDataS['SZNEV'];?></option>
					<?php }?> 
					</select>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="form">
					<label for="date"><?php echo $lang['datetime']; ?>:</label>
					<input type="date" name="date" id="date" required/>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="form">
					<label for="maxteam"><?php echo $lang['max_team']; ?>:</label>
					<input type="number" name="maxteam" id="maxteam"required/>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="form">
					<label for="lev"><?php echo $lang['level']; ?>:</label>
					<select name="subject_lev"required/> 
					<option></option>
					<?php while($subjectDataLEV = $resultlev->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataLEV['SZIAZ'];?>"> <?php echo $subjectDataLEV['SZINEV'];?></option>
					<?php }?> 
					</select>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="form">
					<label for="cont"><?php echo $lang['contact']; ?>:</label>
					<input type="text" name="cont" id="cont"required/>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="form">
					<label for="cemail">E-mail:</label>
					<input type="text" name="cemail" id="cemail"required/>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<p class="form">
					<label for="cpn"><?php echo $lang['phone_numb']; ?>:</label>
					<input type="text" name="cpn" id="cpn"required/>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<button type = "submit" name="submit"><?php echo $lang['send']; ?></button>
				</td>
			</tr>
		</table>
		</form>
		<form action="checktourn.php" method="post">
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