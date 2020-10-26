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
			$season_r=$_POST['subject_ses'];				
				
			if($season_r==""){
				$sql="SELECT `csapatok`.*
					FROM `csapatok`";
			}

			else{
				$sql="SELECT `csapatok`.*, `csapatok`.`SZID`
					FROM `csapatok`
					WHERE `csapatok`.`SZID` = '$season_r'";				
			}
			$result = $db->query($sql);
?>				<br>
					<?php while($row=$result->fetch_assoc()){
						$team_id=$row['CSAZ'];
						$sql2="SELECT `helyszinek`.`VAROS`, `szint`.`SZINEV`
							FROM `helyszinek` 
							LEFT JOIN `fordulok` ON `fordulok`.`HELYID` = `helyszinek`.`HAZ` 
							LEFT JOIN `szint` ON `fordulok`.`SZIID` = `szint`.`SZIAZ` 
							LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`FORDULOID` = `fordulok`.`FAZ`
							WHERE `csapat-fordulo`.`CSAPATID` = '$team_id'";
						$result2 = $db->query($sql2);?>
						<table style="width:70%">
							<tr>
								<th>
									<?php echo $lang['id']; ?>:
								</th>
								<td>
									<?php echo $row['CSAZ']; ?>
								</td>
							</tr>
							<tr>
								<th>
									<?php echo $lang['team_name']; ?>:
								</th>
								<td>
									<div contenteditable="true" onBlur="updateValue(this,'CSNEV', 'csapatok', 'CSAZ','<?php echo $row['CSAZ']; ?>')"><?php echo $row['CSNEV']; ?></div>
								</td>
							</tr>
							<tr>
								<th>
									<?php echo $lang['poss_teammem']; ?>:
								</th>
								<td>
									<?php echo $row['VCSLSZAM']; ?>
								</td>
							</tr>
							<tr>
								<th>
									Coach:
								</th>
								<td>
									<div contenteditable="true" onBlur="updateValue(this,'COACH', 'csapatok', 'CSAZ', '<?php echo $row['CSAZ']; ?>')"><?php echo $row['COACH']; ?></div>
								</td>
							</tr>
							<tr>
								<th>
									<?php echo $lang['poss_coachnum']; ?>:
								</th>
								<td>
									<?php echo $row['VCOACHSZAM']; ?>
								</td>
							</tr>	
							<tr>
								<th>
									E-mail:
								</th>
								<td>
									<div contenteditable="true" onBlur="updateValue(this,'EMAIL', 'csapatok', 'CSAZ', '<?php echo $row['CSAZ']; ?>')"><?php echo $row['EMAIL']; ?></div>
								</td>
							</tr>
							<tr>
								<th>
									<?php echo $lang['tourn_mad']; ?>:
								</th>
								<td>
									<?php
										while($row2 = $result2->fetch_assoc())
										{
											echo $row2['VAROS'].' ('.$row2['SZINEV'].')';
											echo '<br>';
										}
									?>
								</td>
							</tr>
						</table>
						<br>
						<br>
					<?php }?>
			<?php }?>
		
		<br> 
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script>
			function updateValue(element, column, table_n, id_name, id)
			{
				var value = element.innerText
					
				$.ajax({
					url:'update_ajax.php',
					type: 'post',
					data:{
						value: value,
						column: column,
						table_n: table_n,
						id_name: id_name,
						id: id
					},
					success:function(php_result)
					{
						console.log(php_result);
					}
				})
			}
		</script>
	</body>
</html>