<?php
include("session.php");
	
if($user_permission_id!=5){
	header("location: logout.php");
}
   
$schedule="files/Schedule_".$user_location."_".$user_level."_".$user_tourn.".pdf";  
?>
<html>
<head>
      <title>Összesített pontozás</title>
	  <link rel="stylesheet" type="text/css" href="form.css">
</head>
   
<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomejudge.php">Kezdőlap</a>
			<a class="active" href="sum_scores.php">Eredmények</a>
			<a href=<?php echo $schedule; ?>>Menetrend</a>
			<a href="judge_scoring.php">Pontozás</a>
			<a href="teaminfo_jud_ref.php">Csapat információk</a>
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
	<?php
		$sql="SELECT `zsuri-szempontok`.*, `zsuri-szempontok`.`ZSURIKATID` 
			FROM `zsuri-szempontok` 
			WHERE `zsuri-szempontok`.`SZEZONID` = '$akt_season_id' AND `zsuri-szempontok`.`ZSURIKATID` = '$user_category_id'";
		$result = $db->query($sql);
		
		$sql_team="SELECT `csapatok`.*
			FROM `csapatok` 
			LEFT JOIN `csapat-fordulo` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
			WHERE `csapatok`.`SZID` = '$akt_season_id' AND `csapat-fordulo`.`FORDULOID` = '$user_tourn' AND `csapat-fordulo`.`MEGJELENTE`='1'";
		$result_team = $db->query($sql_team);
	?>
	<table style="width:20%">
	<tr>
	<th>Csapat ID</th>
	<th>Csapat név</th>
	</tr>
	<?php
	while($row_team = $result_team->fetch_assoc()) { ?>
	<tr>
			<td>
			<?php echo $row_team["CSAZ"];?><br>
			</td>
			<td>
			<?php echo $row_team["CSNEV"];?><br>
			</td>
	</tr>
	<?php }?>
	</table>
	<br>
	<table style="width:100%">
	<tr>
    <th></th>
    <th>exemplary(4)</th> 
    <th>accomplished(3)</th>
	<th>developing(2)</th>
	<th>beginning(1)</th>
	</tr>
	<?php
		while($row = $result->fetch_assoc()) {
		$obj_id=$row['SZEMAZ'];
		$sql_sub="SELECT `zsuri-pontok`.*
			FROM `zsuri-pontok`
			WHERE `zsuri-pontok`.`SZEMID` = '$obj_id' AND`zsuri-pontok`.`FID` = '$user_tourn'";
		$result_sub = $db->query($sql_sub);
		$count = mysqli_num_rows($result_sub);
		$exemplary=$accomplished=$developing=$beginning="";
		while($row_sub = $result_sub->fetch_assoc()){
			if($row_sub["ERTEK"]==4){
				$exemplary=$exemplary."|".$row_sub["CSID"];
			}
			else if($row_sub["ERTEK"]==3){
				$accomplished=$accomplished."|".$row_sub["CSID"];
			}
			else if($row_sub["ERTEK"]==2){
				$developing=$developing."|".$row_sub["CSID"];
			}
			else{
				$beginning=$beginning."|".$row_sub["CSID"];
			}
			
		}
		
	?>
			<tr>
			<td>
			<?php echo $row["SZEMNEV"];?><br>
			<?php echo $row["KATEGORIA"];?><br>
			</td>
			<td>
			<?php echo $exemplary;?>
			</td>
			<td>
			<?php echo $accomplished;?>
			</td>
			<td>
			<?php echo $developing;?>
			</td>
			<td>
			<?php echo $beginning;?>
			</td>
			</tr>
			
			
	<?php
		}
	?>
	</table>
	
	<br>
	<br>
	<br>
	
	<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
</body>
</html>