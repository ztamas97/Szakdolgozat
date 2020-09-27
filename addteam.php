<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=3){
	header('location: logout.php');
}
	
$sqls = "SELECT * FROM `szezon`";
$results = $db->query($sqls);
?>
<html>
   
   <head>
      <title><?php echo $lang['teams_mad']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomemadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="checktourn.php"><?php echo $lang['tourn_mad']; ?></a>
			<a class="active" href="checkteam.php"><?php echo $lang['teams_mad']; ?></a>
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
		<form action="insertteam.php" method="post">
			<table>
				<tr>
					<td>
						<p class="form">
						<label for="teamname"><?php echo $lang['team_name']; ?>:</label>
						<input type="text" name="teamname" id="teamname" required/>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="pteammem"><?php echo $lang['poss_teammem']; ?>:</label>
						<input type="number" name="pteammem" id="pteammem" min="2" max="10"required/>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="coach">Coach:</label>
						<input type="text" name="coach" id="coach"required/>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="pcn"><?php echo $lang['poss_coachnum']; ?>:</label>
						<input type="number" name="pcn" id="pcn"required/>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="email">E-mail:</label>
						<input type="text" name="email" id="email"required/>
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
						<button type = "submit" name="submit"><?php echo $lang['send']; ?></button>
					</td>
				</tr>
			<table>
		</form>
		<form action="checkteam.php" method="post">
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