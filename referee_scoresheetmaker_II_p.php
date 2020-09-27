<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=2){
	header('location: logout.php');
}  
	
$sqls = "SELECT * FROM `szezon`";
$results = $db->query($sqls);
?>
<html>
   
   <head>
      <title><?php echo $lang['ref_sheet_sys']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomesys.php"><?php echo $lang['home_p']; ?></a>
			<a href="checkuser.php"><?php echo $lang['user_sys']; ?></a>
			<a href="addlocation.php"><?php echo $lang['locations_sys']; ?></a>
			<a href="judge_scoresheetmaker.php"><?php echo $lang['jud_sheet_sys']; ?></a>
			<a class="active" href="referee_scoresheetmaker.php"><?php echo $lang['ref_sheet_sys']; ?></a>
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
			<th>
				<form action="" method="post">
					<p class="form">
					<label for="ses"><?php echo $lang['season']; ?>:</label>
					<select name="subject_ses" required/>
					<option></option>
					<?php while($subjectDataS = $results->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataS['SZAZ'];?>"> <?php echo $subjectDataS['SZNEV'];?></option>
					<?php }?> 
					</select>
					</p>
					<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
				</form>
			</th>
		</table>
		<br>
	<?php
		if(isset($_POST['submit'])):
			$season_r=$_POST['subject_ses'];
			
			$sql="SELECT `biro-r-feladatok`.*, `biro-feladatok`.`SUBAZ`, `biro-tipus`.`BTIPNEV`
				FROM `biro-r-feladatok` 
				LEFT JOIN `biro-feladatok` ON `biro-r-feladatok`.`FELID` = `biro-feladatok`.`FELAZ` 
				LEFT JOIN `biro-tipus` ON `biro-r-feladatok`.`TIPUSID` = `biro-tipus`.`BTIPAZ`
				WHERE `biro-feladatok`.`SZID` = '$season_r'
				ORDER BY `biro-feladatok`.`SUBAZ`";
			$result= $db->query($sql);
			$count = mysqli_num_rows($result);
			
			$sql_sub="SELECT `biro-feladatok`.*
				FROM `biro-feladatok`
				WHERE `biro-feladatok`.`SZID` = '$season_r'
				ORDER BY `biro-feladatok`.`SUBAZ`";
			$result_sub= $db->query($sql_sub);
			
			$sql_sub2="SELECT `biro-tipus`.*
					FROM `biro-tipus`";
			$result_sub2= $db->query($sql_sub2);
			
			$sql_sub3="SELECT `biro-r-feladatok`.*, `biro-feladatok`.`SZID`
					FROM `biro-r-feladatok` 
					LEFT JOIN `biro-feladatok` ON `biro-r-feladatok`.`FELID` = `biro-feladatok`.`FELAZ`
					WHERE `biro-feladatok`.`SZID` = '$season_r'";
			$result_sub3= $db->query($sql_sub3);
?>
			
			<?php if($count==0): ?>
				<?php echo $lang['not_have_a_part_task'];?>
				
			<?php else: ?>

				<table style="width:100%">
				<tr>
				<th><?php echo $lang['id']; ?></th> 
				<th><?php echo $lang['task']; ?></th>
				<th><?php echo $lang['descr']; ?></th>
				<th><?php echo $lang['need']; ?></th>
				<th><?php echo $lang['default']; ?></th>
				<th><?php echo $lang['type_n']; ?></th>
				<th>Minimum</th>
				<th>Maximum</th>
				</tr>
			<?php while($row=$result->fetch_assoc()){?>
				<tr>
					<td>
						<?php echo $row["BRFAZ"]; ?>
					</td>
					<td>
						<?php echo $row["SUBAZ"]; ?>
					</td>
					<td>
						<?php echo $row["LEIRAS"]; ?>
					</td>
					<td>
						<?php echo $row["FUGGID"]; ?>
					</td>
					<td>
						<?php echo $row["ERTEK"]; ?>
					</td>
					<td>
						<?php echo $row["BTIPNEV"]; ?>
					</td>
					<td>
						<?php echo $row["MINERTEK"]; ?>
					</td>
					<td>
						<?php echo $row["MAXERTEK"]; ?>
					</td>
				</tr>
			<?php }endif; ?>
				</table>
				<br>
				<table style="width:50%">
				<form action='add_to_rscoresheet_p.php' method='post'>
				<tr>
				<th><?php echo $lang['task']; ?>:</th>
				<td>
					<select name="subject_obj" required/>
					<option></option>
					<?php while($subjectData = $result_sub->fetch_assoc()){ ?>
					<option value="<?php echo $subjectData['FELAZ'];?>"> <?php echo $subjectData['SUBAZ'];?></option>
					<?php }?> 
					</select>
					<input type="hidden" name="sid" value="<?php echo $season_r; ?>"/>
				</td>
				</tr>
				<tr>
				<th><?php echo $lang['descr']; ?>:</th>
				<td>
					<textarea name="describe" rows="10" cols="50" required/></textarea>
				</td>
				</tr>
				<tr>
				<th><?php echo $lang['value']; ?>:</th>
				<td>
					<input type="number" name="value" min="0" max="100" required/>
				</td>
				</tr>
				<tr>
				<tr>
				<th><?php echo $lang['need']; ?>:</th>
				<td>
					<select name="subject_pobj">
					<option></option>
					<?php while($subjectDataP = $result_sub3->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataP['BRFAZ'];?>"> <?php echo $subjectDataP['LEIRAS'];?></option>
					<?php }?> 
					</select>
				</td>
				</tr>
				<tr>
				<th><?php echo $lang['type_n']; ?>:</th>
				<td>
					<select name="subject_typ" required/>
					<option></option>
					<?php while($subjectDataT = $result_sub2->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataT['BTIPAZ'];?>"> <?php echo $subjectDataT['BTIPNEV'];?></option>
					<?php }?> 
					</select>
				</td>
				</tr>
				<tr>
				<th>Minimum:</th>
				<td>
					<input type="number" name="value_min" min="0" max="100">
				</td>
				</tr>
				<tr>
				<th>Maximum:</th>
				<td>
					<input type="number" name="value_max" min="0" max="100">
				</td>
				</tr>
				<tr>
				<th><?php echo $lang['send']; ?>:</th>
				<td width=10%>
					<input type="image" id="send" src="images/add.svg" width=15% alt="add icon">
				</td>
				</tr>
				</form>
				</table>

		<?php endif; ?>
		
		<br>
		
		<form action="referee_scoresheetmaker.php" method="post">
			<input type="image" src="images/back.svg" width=5% alt="back icon">
		</form>
		
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
   </body>
   
</html>