<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=2){
	header('location: logout.php');
}
 
$sqlc = "SELECT * FROM `zskategoriak`";
$resultc = $db->query($sqlc);
	
$sqls = "SELECT * FROM `szezon`";
$results = $db->query($sqls);

?>
<html>
   
   <head>
      <title><?php echo $lang['jud_sheet_sys']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomesys.php"><?php echo $lang['home_p']; ?></a>
			<a href="checkuser.php"><?php echo $lang['user_sys']; ?></a>
			<a href="addlocation.php"><?php echo $lang['locations_sys']; ?></a>
			<a class="active" href="judge_scoresheetmaker.php"><?php echo $lang['jud_sheet_sys']; ?></a>
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
		
		<table style="width:70%">
			<form action="" method="post">
				<tr>
					<td>
						<p class="form">
							<label for="ses"><?php echo $lang['season']; ?>:</label>
							<select name="subject_ses" required/>
							<option></option>
							<?php while($subjectDataS = $results->fetch_assoc()){ ?>
							<option value="<?php echo $subjectDataS['SZAZ'];?>"> <?php echo $subjectDataS['SZNEV'];?></option>
							<?php }?> 
							</select>
						</p>
					</td>
					<td>
						<p class="form">
							<label for="cat"><?php echo $lang['j_cat_sys']; ?>:</label>
							<select name="subject_cat"required/> 
							<option></option>
							<?php while($subjectDataC = $resultc->fetch_assoc()){ ?>
							<option value="<?php echo $subjectDataC['ZSAZ'];?>"> <?php echo $subjectDataC['ZSKATNEV'];?></option>
							<?php }?> 
							</select>
						</p>
					</td>
					<td>
						<p class="form">
							<button type = "submit" name="submit"><?php echo $lang['search']; ?></button>
						</p>
					</td>
				</tr>
			</form>
		</table>
	<?php
		if(isset($_POST['submit'])):
			$season_r=$_POST['subject_ses'];
			$category_r=$_POST['subject_cat'];
			
			$sql_sub="SELECT * 
			FROM `zskategoriak`
			WHERE `zskategoriak`.`ZSAZ`='$category_r'";
			$result_sub= $db->query($sql_sub);
			$row = $result_sub->fetch_assoc();
			
			$category_name=$row["ZSKATNEV"];
			
			$sql_sub2="SELECT `zsuri-pontok`.* 
			FROM `zsuri-pontok` 
			LEFT JOIN `zsuri-szempontok` ON `zsuri-szempontok`.`SZEMAZ` = `zsuri-pontok`.`SZEMID` 
			WHERE `zsuri-szempontok`.`SZEZONID` = '$season_r' AND `zsuri-szempontok`.`ZSURIKATID` = '$category_r'";
			$result_sub2= $db->query($sql_sub2);
			$count_sub2 = mysqli_num_rows($result_sub2);
			
			$sql="SELECT `zsuri-szempontok`.*
				FROM `zsuri-szempontok`
				WHERE `zsuri-szempontok`.`SZEZONID` = '$season_r' AND `zsuri-szempontok`.`ZSURIKATID` = '$category_r'";
			$result= $db->query($sql);
			$count = mysqli_num_rows($result);
?>
			
			<?php if($count==0): ?>
				<br>
				<?php echo $category_name." kategóriában még nem történt zsűri pontozólapra szempont rögzítés!";?>
				<br>
				
			<?php else: ?>

				<table style="width:100%">
				<tr>
				<th></th>
				<th>exemplary(4)</th> 
				<th>accomplished(3)</th>
				<th>developing(2)</th>
				<th>beginning(1)</th>
				<th><?php echo $lang['operation']; ?></th>
				</tr>
			<?php while($row=$result->fetch_assoc()){
					echo "<tr>";
					echo "<form action='delete_from_jscoresheet.php' method='post'>";
					echo "<td>";
						echo $row["SZEMNEV"]."<br>";
						echo $row["KATEGORIA"]."<br>";
						echo $row["LEIRAS"];
			?>
						<input type="hidden" name="chid" value="<?php echo $row["SZEMAZ"]; ?>" />
			<?php
					echo "</td>";
					echo "<td>";
						echo $row["EXEMPLARY"];
					echo "</td>";
					echo "<td>";
						echo $row["ACCOMPLISHED"];
					echo "</td>";
					echo "<td>";
						echo $row["DEVELOPING"];
					echo "</td>";
					echo "<td>";
						echo $row["BEGINNING"];
					echo "</td>";
					echo "<td width=10%>";
						if($count_sub2==0):
							echo '<input type="image" id="send" src="images/delete.svg" width=50% alt="delete icon">';
						else:
							echo "Nem lehet törölni, már történt eredmény rögzítés!";
						endif;
					echo "</td>";
					echo "</form>";
					echo "</tr>";
				}?>
				
			<?php endif; ?>
			<?php if($count<14): ?>
				</table>
				<br>
				<table style="width:50%">
				<form action='add_to_jscoresheet.php' method='post'>
				<tr>
				<th><?php echo $lang['jscs_name']; ?></th>
				<td>
					<input type="text" name="name" id="name"required/>
					<input type="hidden" name="sid" value="<?php echo $season_r; ?>"/>
					<input type="hidden" name="cid" value="<?php echo $category_r; ?>"/>
				</td>
				</tr>
				<tr>
				<th><?php echo $lang['j_descr']; ?></th>
				<td>
					<textarea name="description" rows="10" cols="50" required/></textarea>
				</td>
				</tr>
				<tr>
				<th><?php echo $lang['j_cat_scs']; ?></th>
				<td>
					<input type="text" name="category" id="category"required/>
				</td>
				</tr>
				<tr>
				<th><?php echo $lang['j_prec']; ?></th>
				<td>
					<input type="number" name="op" min="3" max="4" required/>
				</td>
				</tr>
				<tr>
				<th>Exemplary</th>
				<td>
					<textarea name="exemplary" rows="10" cols="50" ></textarea>
				</td>
				</tr>
				<tr>
				<th>Accomplished</th>
				<td>
					<textarea name="accomplished" rows="10" cols="50" required/></textarea>
				</td>
				</tr>
				<tr>
				<th>Developing</th>
				<td>
					<textarea name="developing" rows="10" cols="50" required/></textarea>
				</td>
				</tr>
				<tr>
				<th>Beginning</th>
				<td>
					<textarea name="beginning" rows="10" cols="50" required/></textarea>
				</td>
				</tr>
				<tr>
				<th><?php echo $lang['send']; ?></th>
				<td width=10%>
					<input class="images" type="image" id="send" src="images/add.svg" width=50% alt="add icon">
				</td>
				</tr>
				</form>
				</table>
				
				<br>
				<br>
				<br>
				<?php else: ?>
				<?php endif; ?>
				

		<?php endif; ?>
		
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
   </body>
   
</html>