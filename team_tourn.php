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
?>
<html>
   <head>
      <title><?php echo $lang['team-tourn_mad']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomemadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="checktourn.php"><?php echo $lang['tourn_mad']; ?></a>
			<a href="checkteam.php"><?php echo $lang['teams_mad']; ?></a>
			<a class="active" href="team_tourn.php"><?php echo $lang['team-tourn_mad']; ?></a>
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
		<form action="" method="post">
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
						<button type = "submit" name="submit"><?php echo $lang['send']; ?></button>
					</td>
				</tr>
			</table>
		</form>

		<?php
			if(isset($_POST['submit'])){
				$location_r=$_POST['subject_loc'];
				$level_r=$_POST['subject_lev'];
				$team_name=$_POST['teamname'];
				
				$sql="SELECT `fordulok`.`HELYID`, `fordulok`.`SZEZONID`, `fordulok`.`SZIID`, `fordulok`.`RESZTVCSMAX`
				FROM `fordulok`
				WHERE `fordulok`.`FAZ` = '$location_r'";
				$result = $db->query($sql);
				while($row = $result->fetch_assoc()){
					$fordulo_csmax=$row['RESZTVCSMAX'];
				}
				$sql2="SELECT `csapatok`.`CSAZ`, `szezon`.`SZNEV`
				FROM `csapatok` 
				LEFT JOIN `szezon` ON `csapatok`.`SZID` = `szezon`.`SZAZ`
				WHERE `csapatok`.`CSNEV` = '$team_name' AND `csapatok`.`SZID` = '$akt_season_id'";
				$result2 = $db->query($sql2);
				while($row = $result2->fetch_assoc()){
					$csapat_id=$row['CSAZ'];
				}
				$sql3="SELECT `csapat-fordulo`.`FORDULOID`, `csapat-fordulo`.`CSAPATID`
					FROM `csapat-fordulo`
					WHERE `csapat-fordulo`.`FORDULOID` = '$location_r'";
					$result3 = $db->query($sql3);
				if($result3->num_rows<$fordulo_csmax){
					$sql4="INSERT INTO `csapat-fordulo` (`CSAPATID`, `FORDULOID`, `MEGJELENTE`, `CSLSZAM`, `CLSZAM`) VALUES ('$csapat_id', '$location_r', b'0', NULL, NULL)";
					if(mysqli_query($db, $sql4)){
						echo 'Sikeres rögzítés!';
						$describe='Csapat fordulóhoz hozzáadva: '.$team_name;
						$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
						if(mysqli_query($db, $sql_log)){
						} 
						else{
						}				
					} else{
						echo 'HIBA: A rögzítés nem sikeres! $sql.'. mysqli_error($db);
						$describe='Csapat fordulóhoz hozzáadása sikertelen: '.$team_name;
						$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
						if(mysqli_query($db, $sql_log)){
						} 
						else{
						}
					}
				}
				else{
					echo 'A fordulón elérte a lehetséges maximumot('.$fordulo_csmax.') a csapatok szám!';
				}
}
		?>
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
		
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
	</body>
</html>