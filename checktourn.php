<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=3){
	header('location: logout.php');
}
   
$sqls = "SELECT * FROM `szezon`";
$results = $db->query($sqls);
	
$sqll = "SELECT `helyszinek`.`HAZ`, `helyszinek`.`VAROS` FROM `helyszinek`;";
$resultl = $db->query($sqll);
	
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
		<form action="" method="post">
			<table>
				<tr>
					<td>
					<p class="form">
					<label for="ses"><?php echo $lang['season']; ?>:</label>
					<select name="subject_ses">
					<option></option>
					<?php while($subjectDataS = $results->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataS['SZNEV'];?>"> <?php echo $subjectDataS['SZNEV'];?></option>
					<?php }?> 
					</select>
					</p>
					</td>
					<td>
					<p class="form">
					<label for="loc"><?php echo $lang['loc']; ?>:</label>
					<select name="subject_loc"> 
					<option></option>
					<?php while($subjectDataL = $resultl->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataL['VAROS'];?>"> <?php echo $subjectDataL['VAROS'];?></option>
					<?php }?> 
					</select>
					</p>
					</td>
					<td>
					<p class="form">
					<label for="lev"><?php echo $lang['level']; ?>:</label>
					<select name="subject_lev"> 
					<?php while($subjectDataLev = $resultlev->fetch_assoc()){ ?>
					<option value="<?php echo $subjectDataLev['SZIAZ'];?>"> <?php echo $subjectDataLev['SZINEV'];?></option>
					<?php }?> 
					</select>
					</p>
					</td>
					<td>
					<p class="form">
					<?php echo $lang['show_teams']; ?> <input type="radio" name="radio" value="Igen">
					</p>
					</td>
					<td>
					<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
					</td>
				</tr>
			</table>
		</form>
		<a href="addtourn.php"><img class="images" src="images/add.svg" alt="Add icon"></a>
		<br>
		<?php
			if(isset($_POST['submit'])){
				$seson_r=$_POST['subject_ses'];
				$location_r=$_POST['subject_loc'];
				$level_r=$_POST['subject_lev'];
				
				
				if(($seson_r=="") AND ($location_r=="")){
					#echo "Összes forduló mutatása"."<br>";
					$sql="SELECT `fordulok`.`FAZ`, `helyszinek`.`VAROS`, `szezon`.`SZNEV`, `szint`.`SZINEV`, `fordulok`.`DATE`, `fordulok`.`RESZTVCSMAX`, `fordulok`.`KONTAKT`, `fordulok`.`EMAIL`, `fordulok`.`TEL`,`fordulok`.`AKTIV` 
						FROM `fordulok` 
						LEFT JOIN `helyszinek` ON `fordulok`.`HELYID` = `helyszinek`.`HAZ` 
						LEFT JOIN `szezon` ON `fordulok`.`SZEZONID` = `szezon`.`SZAZ` 
						LEFT JOIN `szint` ON `fordulok`.`SZIID` = `szint`.`SZIAZ` 
						WHERE `fordulok`.`SZIID`='$level_r'";
				}
				else if($seson_r==""){
					#echo "Helyszín szűrés: ".$location_r." minden szeszonban"."<br>";
					$sql="SELECT `fordulok`.`FAZ`, `helyszinek`.`VAROS`, `szezon`.`SZNEV`, `szint`.`SZINEV`, `fordulok`.`DATE`, `fordulok`.`RESZTVCSMAX`, `fordulok`.`KONTAKT`, `fordulok`.`EMAIL`, `fordulok`.`TEL`,`fordulok`.`AKTIV`
						FROM `fordulok` 
						LEFT JOIN `helyszinek` ON `fordulok`.`HELYID` = `helyszinek`.`HAZ` 
						LEFT JOIN `szezon` ON `fordulok`.`SZEZONID` = `szezon`.`SZAZ` 
						LEFT JOIN `szint` ON `fordulok`.`SZIID` = `szint`.`SZIAZ` 
						WHERE `helyszinek`.`VAROS` = '$location_r' AND `fordulok`.`SZIID`='$level_r'";
				}
				else if($location_r==""){
					#echo "Szezon szűrés: ".$seson_r." minden helyszín"."<br>";
					$sql="SELECT `fordulok`.`FAZ`, `helyszinek`.`VAROS`, `szezon`.`SZNEV`, `szint`.`SZINEV`, `fordulok`.`DATE`, `fordulok`.`RESZTVCSMAX`, `fordulok`.`KONTAKT`, `fordulok`.`EMAIL`, `fordulok`.`TEL` ,`fordulok`.`AKTIV`
						FROM `fordulok` 
						LEFT JOIN `helyszinek` ON `fordulok`.`HELYID` = `helyszinek`.`HAZ` 
						LEFT JOIN `szezon` ON `fordulok`.`SZEZONID` = `szezon`.`SZAZ` 
						LEFT JOIN `szint` ON `fordulok`.`SZIID` = `szint`.`SZIAZ` 
						WHERE `szezon`.`SZNEV` = '$seson_r' AND `fordulok`.`SZIID`='$level_r'";
				}
				else{
					#echo "Szezon szűrés: ".$seson_r." Helyszín szűrés: ".$location_r."<br>";
					$sql="SELECT `fordulok`.`FAZ`, `helyszinek`.`VAROS`, `szezon`.`SZNEV`, `szint`.`SZINEV`, `fordulok`.`DATE`, `fordulok`.`RESZTVCSMAX`, `fordulok`.`KONTAKT`, `fordulok`.`EMAIL`, `fordulok`.`TEL`,`fordulok`.`AKTIV`
						FROM `fordulok` 
						LEFT JOIN `helyszinek` ON `fordulok`.`HELYID` = `helyszinek`.`HAZ` 
						LEFT JOIN `szezon` ON `fordulok`.`SZEZONID` = `szezon`.`SZAZ` 
						LEFT JOIN `szint` ON `fordulok`.`SZIID` = `szint`.`SZIAZ` 
						WHERE `helyszinek`.`VAROS` = '$location_r' AND `szezon`.`SZNEV` = '$seson_r' AND `fordulok`.`SZIID`='$level_r'";
				}
				$result = $db->query($sql);
				
				?>
				<?php while($row=$result->fetch_assoc()){?>
					<table style="width:70%">
						<tr>
							<th>
								<?php echo $lang['id']; ?>
							</th>
							<td>
								<?php echo $row['FAZ']; 
								$seged_faz=$row['FAZ'];?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['status']; ?>
							</th>
							<td>
								<?php 
								if($row['AKTIV']==1){
									if($language=='hu'){
										echo 'Aktív';
									}
									else if($language=='eng'){
										echo 'Active';
									}
								}
								else{
									if($language=='hu'){
										echo 'Inaktív';
									}
									else if($language=='eng'){
										echo 'Inactive';
									}
								}?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['loc'];?>
							</th>
							<td>
								<?php echo $row['VAROS'];?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['season'];?>
							</th>
							<td>
								<?php echo $row['SZNEV']; ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['datetime'];?>
							</th>
							<td>
								<?php echo $row['DATE']; ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['max_team'];?>
							</th>
							<td>
								<div contenteditable="true" onBlur="updateValue(this,'RESZTVCSMAX', 'fordulok', 'FAZ','<?php echo $row['FAZ']; ?>')"><?php echo $row['RESZTVCSMAX']; ?></div>
								<?php
								$subsql="SELECT `csapat-fordulo`.`FORDULOID`, `csapat-fordulo`.`CSAPATID`
								FROM `csapat-fordulo`
								WHERE `csapat-fordulo`.`FORDULOID` = '$seged_faz'";
								$sub_result = $db->query($subsql);?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['act_team'];?>
							</th>
							<td>
								<?php echo $sub_result->num_rows; ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['level'];?>
							</th>
							<td>
								<?php echo $row['SZINEV']; ?>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['contact'];?>
							</th>
							<td>
								<div contenteditable="true" onBlur="updateValue(this,'KONTAKT', 'fordulok', 'FAZ','<?php echo $row['FAZ']; ?>')"><?php echo $row['KONTAKT']; ?></div>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['phone_numb'];?>
							</th>
							<td>
								<div contenteditable="true" onBlur="updateValue(this,'TEL', 'fordulok', 'FAZ','<?php echo $row['FAZ']; ?>')"><?php echo $row['TEL']; ?></div>
							</td>
						</tr>
						<tr>
							<th>
								E-mail
							</th>
							<td>
								<div contenteditable="true" onBlur="updateValue(this,'EMAIL', 'fordulok', 'FAZ','<?php echo $row['FAZ']; ?>')"><?php echo $row['EMAIL']; ?></div>
							</td>
						</tr>
						<tr>
							<th>
								<?php echo $lang['teams_mad'];?>
							</th>
							<td>
								<?php if(isset($_POST['radio'])){
									$yes=$_POST['radio'];
									if($yes=='Igen' AND $sub_result->num_rows>0){
										$subsql2="SELECT `csapat-fordulo`.`FORDULOID`, `csapatok`.`CSNEV` 
										FROM `csapat-fordulo` 
										LEFT JOIN `csapatok` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ` 
										WHERE `csapat-fordulo`.`FORDULOID` = '$seged_faz'";
										$sub_result2 = $db->query($subsql2);
										if ($sub_result2->num_rows > 0) {
											while($rows = $sub_result2->fetch_assoc()) {
												echo $rows['CSNEV'].'<br>';
											}
										}
									}
								}?>
							</td>
						</tr>
					</table>
					<br>
				<?php }?>
	<?php } ?>
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