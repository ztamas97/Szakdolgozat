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
		<form action="" method="post">
		<table>
			<tr>
				<td>
					<p class="form">
					<label for="ses"><?php echo $lang['season']; ?>:</label>
					<select name="subject_ses">
					<option></option>
					<?php while($subjectDataS = $results->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataS['SZAZ'];?>"> <?php echo $subjectDataS['SZNEV'];?></option>
					<?php }?> 
					</select>
					</p>
					<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
				</td>
			</tr>
		</table>
		</form>
		<a href="addteam.php"><img class="images" src="images/add.svg" alt="Add icon"></a>
		<br>
		<?php
			if(isset($_POST['submit'])){
				$seson_r=$_POST['subject_ses'];
				
				$sql="SELECT * FROM `csapatok`";
				$result = $db->query($sql);
				if ($result->num_rows > 0) {?>
				
				<?php while($row = $result->fetch_assoc()) {
						if($seson_r==''){
							echo '<table>';
								echo '<tr>';
									echo '<th>';
										echo $lang['id'];
									echo '</th>';
									echo '<td>';
										echo $row['CSAZ'];
									echo '</td>';
									echo '<th>';
										echo $lang['team_name'];
									echo '</th>';
									echo '<td>';
										echo $row['CSNEV'];
									echo '</td>';
									echo '<th>';
										echo $lang['poss_teammem'];
									echo '</th>';
									echo '<td>';
										echo $row['VCSLSZAM'];
									echo '</td>';
									echo '<th>';
										echo 'Coach';
									echo '</th>';
									echo '<td>';
										echo $row['COACH'];
									echo '</td>';									
									echo '<th>';
										echo $lang['poss_coachnum'];
									echo '</th>';
									echo '<td>';
										echo $row['VCOACHSZAM'];
									echo '</td>';
									echo '<th>';
										echo 'E-mail';
									echo '</th>';
									echo '<td>';
										echo $row['EMAIL'];
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						}
						else if($row['SZID']==$seson_r){
							echo $lang['id'].': '. $row['CSAZ'].'<br>';
							echo $lang['team_name'].': '. $row['CSNEV'].'<br>';
							echo $lang['poss_teammem'].': '. $row['VCSLSZAM'].'<br>';
							echo 'Coach: ' . $row['COACH'].'<br>';
							echo $lang['poss_coachnum'].': '. $row['VCOACHSZAM'].'<br>';
							echo 'Email: ' . $row['EMAIL'].'<br>';
							echo '<hr>'.'<br>';
					}
				}
				}
			}
		?>
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
</html>