<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=2){
	header("location: logout.php");
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
			
			$sql="SELECT `biro-feladatok`.*
				FROM `biro-feladatok`
				WHERE `biro-feladatok`.`SZID` = '$season_r'
				ORDER BY `biro-feladatok`.`SUBAZ`";
			$result= $db->query($sql);
			$count = mysqli_num_rows($result);
?>
			
			<?php if($count==0): ?>
				<?php echo $lang['not_have_task'];?>
				
			<?php else: ?>

				<table style="width:100%">
				<tr>
				<th><?php echo $lang['id'];?></th> 
				<th><?php echo $lang['task_name'];?></th>
				<th><?php echo $lang['extra'];?></th>
				</tr>
			<?php while($row=$result->fetch_assoc()){?>
				<tr>
					<td>
						<?php echo $row["FELAZ"].")"; ?>
						<?php echo $row["SUBAZ"]; ?>
					</td>
					<td>
						<?php echo $row["NEV"]; ?>
					</td>
					<td>
						<?php echo $row["EXTRAPONT"]; ?>
					</td>
				</tr>
			<?php }endif; ?>
				</table>
				<br>
				<table style="width:50%">
					<form action='add_to_rscoresheet.php' method='post'>
						<tr>
							<th><?php echo $lang['id'];?>(M01):</th>
							<td>
								<input type="text" name="subid" id="subid"required/>
								<input type="hidden" name="sid" value="<?php echo $season_r; ?>"/>
							</td>
						</tr>
						<tr>
							<th><?php echo $lang['task_name'];?>:</th>
							<td>
								<input type="text" name="name" id="name"required/>
							</td>
						</tr>
						<tr>
							<th><?php echo $lang['comment'];?>:</th>
							<td>
								<input type="text" name="comm" id="comm">
							</td>
						</tr>
						<tr>
							<th>Maximum:</th>
							<td>
								<input type="number" name="value_max" min="0" max="100" required/>
							</td>
						</tr>
						<tr>
							<th><?php echo $lang['extra'];?>:</th>
							<td>
								<input type="number" name="extrapoint" min="0" max="15">
							</td>
						</tr>
						<tr>
							<th><?php echo $lang['send'];?>:</th>
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