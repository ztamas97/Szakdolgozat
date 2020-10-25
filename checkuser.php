<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=2){
	header('location: logout.php');
}
  
$sqlp = "SELECT * FROM `jogosultsagok`";
$resultp = $db->query($sqlp);

$sqll = "SELECT `helyszinek`.`HAZ`, `helyszinek`.`VAROS` FROM `helyszinek`;";
$resultl = $db->query($sqll);

?>
<html>
   <head>
      <title><?php echo $lang['user_sys']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomesys.php"><?php echo $lang['home_p']; ?></a>
			<a class="active" href="checkuser.php"><?php echo $lang['user_sys']; ?></a>
			<a href="addlocation.php"><?php echo $lang['locations_sys']; ?></a>
			<a href="judge_scoresheetmaker.php"><?php echo $lang['jud_sheet_sys']; ?></a>
			<a href="referee_scoresheetmaker.php"><?php echo $lang['ref_sheet_sys']; ?></a>
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
						<label for="perm"><?php echo $lang['perm']; ?>:</label>
						<select name="subject_perm">
						<option></option>
						<?php while($subjectDataP = $resultp->fetch_assoc()){ ?>
						<option value="<?php echo $subjectDataP['JAZ'];?>"> <?php echo $subjectDataP['JNEV'];?></option><?php }?> 
						</select>
					</td>
					<td>
						<label for="loc"><?php echo $lang['loc']; ?>:</label>
						<select name="subject_loc"> 
						<option></option>
						<?php while($subjectDataL = $resultl->fetch_assoc()){ ?>
						<option value="<?php echo $subjectDataL['HAZ'];?>"> <?php echo $subjectDataL['VAROS'];?></option><?php }?> 
						</select>
					</td>
					<td>
						<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
					</td>
				</tr>
			</table>
		</form>
		<a href="adduser.php"><img class="images" src="images/add.svg" alt="Add icon"></a>
		<br>
<?php
		if(isset($_POST['submit'])){
			$permission_r=$_POST['subject_perm'];
			$location_r=$_POST['subject_loc'];
				
				
			if(($permission_r=="") AND ($location_r=="")){
				$sql="SELECT `helyszinek`.`VAROS`,`helyszinek`.`HAZ`, `jogosultsagok`.`JNEV`, `felhasznalok`.`FHNEV`,`felhasznalok`.`Azonosito`,`felhasznalok`.`AKTIV`,`felhasznalok`.`EMAIL`,`szint`.`SZINEV`,`fordulok`.`FAZ` 
				FROM `felhasznalok` 
				LEFT JOIN `fordulok` ON `fordulok`.`FAZ` = `felhasznalok`.`FORDULOID` 
				LEFT JOIN `helyszinek` ON `helyszinek`.`HAZ`= `fordulok`.`HELYID` 
				LEFT JOIN `jogosultsagok` ON `jogosultsagok`.`JAZ`=`felhasznalok`.`JOGID` 
				LEFT JOIN `szint` ON `szint`.`SZIAZ`=`fordulok`.`SZIID`
				ORDER BY `jogosultsagok`.`JNEV`";
			}
			
			else if($permission_r==""){
				$sql="SELECT `helyszinek`.`VAROS`,`helyszinek`.`HAZ`, `jogosultsagok`.`JNEV`, `felhasznalok`.`FHNEV`,`felhasznalok`.`Azonosito`,`felhasznalok`.`AKTIV`,`felhasznalok`.`EMAIL`,`szint`.`SZINEV`,`fordulok`.`FAZ` 
				FROM `felhasznalok` 
				LEFT JOIN `fordulok` ON `fordulok`.`FAZ` = `felhasznalok`.`FORDULOID` 
				LEFT JOIN `helyszinek` ON `helyszinek`.`HAZ`= `fordulok`.`HELYID` 
				LEFT JOIN `jogosultsagok` ON `jogosultsagok`.`JAZ`=`felhasznalok`.`JOGID` 
				LEFT JOIN `szint` ON `szint`.`SZIAZ`=`fordulok`.`SZIID`
				WHERE `fordulok`.`HELYID` = '$location_r'";
			}

			else if($location_r==""){
				$sql="SELECT `helyszinek`.`VAROS`,`helyszinek`.`HAZ`, `jogosultsagok`.`JNEV`, `felhasznalok`.`FHNEV`,`felhasznalok`.`Azonosito`,`felhasznalok`.`AKTIV`,`felhasznalok`.`EMAIL`,`szint`.`SZINEV`,`fordulok`.`FAZ` 
				FROM `felhasznalok` 
				LEFT JOIN `fordulok` ON `fordulok`.`FAZ` = `felhasznalok`.`FORDULOID` 
				LEFT JOIN `helyszinek` ON `helyszinek`.`HAZ`= `fordulok`.`HELYID` 
				LEFT JOIN `jogosultsagok` ON `jogosultsagok`.`JAZ`=`felhasznalok`.`JOGID` 
				LEFT JOIN `szint` ON `szint`.`SZIAZ`=`fordulok`.`SZIID`
				WHERE `felhasznalok`.`JOGID` = '$permission_r'";
			}

			else{
				$sql="SELECT `helyszinek`.`VAROS`,`helyszinek`.`HAZ`, `jogosultsagok`.`JNEV`, `felhasznalok`.`FHNEV`,`felhasznalok`.`Azonosito`,`felhasznalok`.`AKTIV`,`felhasznalok`.`EMAIL`,`szint`.`SZINEV`,`fordulok`.`FAZ` 
				FROM `felhasznalok` 
				LEFT JOIN `fordulok` ON `fordulok`.`FAZ` = `felhasznalok`.`FORDULOID` 
				LEFT JOIN `helyszinek` ON `helyszinek`.`HAZ`= `fordulok`.`HELYID` 
				LEFT JOIN `jogosultsagok` ON `jogosultsagok`.`JAZ`=`felhasznalok`.`JOGID` 
				LEFT JOIN `szint` ON `szint`.`SZIAZ`=`fordulok`.`SZIID`
				WHERE `felhasznalok`.`JOGID` = '$permission_r' AND `fordulok`.`HELYID` = '$location_r'";				
			}
			$result = $db->query($sql);
?>				<br>
				<table style="width:100%">
						<tr>
							<th><?php echo $lang['id']; ?></th>
							<th><?php echo $lang['username_sys']; ?></th>
							<th><?php echo $lang['perm']; ?></th>
							<th><?php echo $lang['other']; ?></th>
							<th><?php echo $lang['active']; ?></th>
						</tr>
					<?php while($row=$result->fetch_assoc()){?>
						<form action="usera.php" method="post">
						<tr>
							<td>
								<?php echo $row['Azonosito']; ?>
								<input type="hidden" name="uid" value="<?php echo $row['Azonosito']; ?>" />
							</td>
							<td>
								<div contenteditable="true" onBlur="updateValue(this,'FHNEV', 'felhasznalok', 'Azonosito','<?php echo $row['Azonosito']; ?>')"><?php echo $row['FHNEV']; ?></div>
							</td>
							<td>
								<?php echo $row['JNEV']; ?>
							</td>
							<td>
								<?php if($row['VAROS']){
									echo $row['VAROS'].'<br>';
								}?>
								<?php if($row['SZINEV']){
									echo $row['SZINEV'];
								}?>
								<div contenteditable="true" onBlur="updateValue(this,'EMAIL', 'felhasznalok', 'Azonosito', '<?php echo $row['Azonosito']; ?>')"><?php echo $row['EMAIL']; ?></div>
							</td>
							<td width=20%>
								<?php if($row['AKTIV']==1){
									echo "<input type='image' id='send' src='images/active.svg' width=15% alt='active icon'>";
									echo"<input type='hidden' name='avalue' value=".$row["AKTIV"]."/>";
								}?>
								<?php if($row['AKTIV']==0){
									echo "<input type='image' id='send' src='images/inactive.svg' width=15% alt='inactive icon'>";
									echo"<input type='hidden' name='avalue' value=".$row["AKTIV"]."/>";
								}?>
							</td>
						</tr>
						</form>
					<?php }?>
			</table>
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