<?php
include('session.php');
include('functions.php');
require(languageselect($language));
	
if($user_permission_id!=1){
	header('location: logout.php');
}

$pr1=1;
$pr2=2;
$pr3=3;
$qf=4;
$sf=5;
$f1=6;
$f2=7;

$sql="SELECT `csapat-fordulo`.`FORDULOID`, `csapatok`.*
	FROM `csapat-fordulo` 
	LEFT JOIN `csapatok` ON `csapat-fordulo`.`CSAPATID` = `csapatok`.`CSAZ`
	WHERE `csapat-fordulo`.`FORDULOID` = '$user_tourn'";

$result = $db->query($sql);

$schedule='files/Schedule_'.$user_location.'_'.$user_level.'_'.$user_tourn.'.pdf';
?>
<html>
<head>
      <title><?php echo $lang['ad_result']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
</head>
   
	<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomeref.php"><?php echo $lang['home_p']; ?></a>
			<a class="active" href="ref_result.php"><?php echo $lang['ad_result']; ?></a>
			<a href=<?php echo $schedule; ?> target="_blank"><?php echo $lang['schedule']; ?></a>
			<a href="ref_scoring_I.php"><?php echo $lang['ref_scoring']; ?></a>
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
		
		<table style="width:100%" id="result">
		<tr>
		<th><?php echo $lang['team_name']; ?></th>
		<th>PR I</th> 
		<th>PR II</th>
		<th>PR III</th>
		<th>Best PR </th>
		<th>QF</th> 
		<th>SF</th> 
		<th>F I</th> 
		<th>F II</th> 
		</tr>
		<?php
		while($row = $result->fetch_assoc()) {
			$team_id = $row['CSAZ'];
		?>
		<tr>
		<td>
			<?php echo $row['CSNEV'].' ['.$row['CSAZ'].']';?>
		</td>
		<td>
			<?php 
			$sql_res="SELECT `biro-osszesito`.`OSSZPONT`
					FROM `biro-osszesito`
					WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$pr1' AND `biro-osszesito`.`CSID` = '$team_id'";
			$points=$db->query($sql_res);
			$point = $points->fetch_assoc();
			if ($point['OSSZPONT']==''){
				$p=0;
			}
			else{
				$p=$point['OSSZPONT'];
			}
			echo $p ;?>
		</td>
		<td>
			<?php 
			$sql_res="SELECT `biro-osszesito`.`OSSZPONT`
					FROM `biro-osszesito`
					WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$pr2' AND `biro-osszesito`.`CSID` = '$team_id'";
			$points=$db->query($sql_res);
			$point = $points->fetch_assoc();
			if ($point['OSSZPONT']==''){
				$p=0;
			}
			else{
				$p=$point['OSSZPONT'];
			}
			echo $p ;?>
		</td>
		<td>
			<?php 
			$sql_res="SELECT `biro-osszesito`.`OSSZPONT`
					FROM `biro-osszesito`
					WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$pr3' AND `biro-osszesito`.`CSID` = '$team_id'";
			$points=$db->query($sql_res);
			$point = $points->fetch_assoc();
			if ($point['OSSZPONT']==''){
				$p=0;
			}
			else{
				$p=$point['OSSZPONT'];
			}
			echo $p ;?>
		</td>
		<td>
			<?php 
			$sql_res="SELECT MAX(`biro-osszesito`.`OSSZPONT`) AS MAXIMUM
				FROM	`biro-osszesito`
				WHERE	`biro-osszesito`.`FID`='$user_tourn' AND (`biro-osszesito`.`KID`='$pr1' OR `biro-osszesito`.`KID`='$pr2' OR `biro-osszesito`.`KID`='$pr3') AND `biro-osszesito`.`CSID`='$team_id'";
			$points=$db->query($sql_res);
			$point = $points->fetch_assoc();
			
			echo $point['MAXIMUM'] ;?>
		</td>
		<td>
			<?php 
			$sql_res="SELECT `biro-osszesito`.`OSSZPONT`
					FROM `biro-osszesito`
					WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$qf' AND `biro-osszesito`.`CSID` = '$team_id'";
			$points=$db->query($sql_res);
			$point = $points->fetch_assoc();
			if ($point['OSSZPONT']==''){
				$p=0;
			}
			else{
				$p=$point['OSSZPONT'];
			}
			echo $p ;?>
		</td>
		<td>
			<?php 
			$sql_res="SELECT `biro-osszesito`.`OSSZPONT`
					FROM `biro-osszesito`
					WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$sf' AND `biro-osszesito`.`CSID` = '$team_id'";
			$points=$db->query($sql_res);
			$point = $points->fetch_assoc();
			if ($point['OSSZPONT']==''){
				$p=0;
			}
			else{
				$p=$point['OSSZPONT'];
			}
			echo $p ;?>
		</td>
		<td>
			<?php 
			$sql_res="SELECT `biro-osszesito`.`OSSZPONT`
					FROM `biro-osszesito`
					WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$f1' AND `biro-osszesito`.`CSID` = '$team_id'";
			$points=$db->query($sql_res);
			$point = $points->fetch_assoc();
			if ($point['OSSZPONT']==''){
				$p=0;
			}
			else{
				$p=$point['OSSZPONT'];
			}
			echo $p ;?>
		</td>
		<td>
			<?php 
			$sql_res="SELECT `biro-osszesito`.`OSSZPONT`
					FROM `biro-osszesito`
					WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$f2' AND `biro-osszesito`.`CSID` = '$team_id'";
			$points=$db->query($sql_res);
			$point = $points->fetch_assoc();
			if ($point['OSSZPONT']==''){
				$p=0;
			}
			else{
				$p=$point['OSSZPONT'];
			}
			echo $p ;?>
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