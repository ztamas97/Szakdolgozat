<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=4){
	header('location: logout.php');
}

$pr1=1;
$pr2=2;
$pr3=3;
$qf=4;
$sf=5;

$limit=4;

$sql_h ="SELECT `biro-osszesito`.`FID`, `biro-osszesito`.`KID`, `biro-osszesito`.`CSID`, `csapatok`.`CSNEV`
	FROM `biro-osszesito` 
	LEFT JOIN `csapatok` ON `biro-osszesito`.`CSID` = `csapatok`.`CSAZ`
	WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$qf'";
$result_h = $db->query($sql_h);
$count_h = mysqli_num_rows($result_h);

if($count_h==0){
$sql="SELECT `csapatok`.*, MAX(`biro-osszesito`.`OSSZPONT`) AS MAXIMUM
	FROM `csapatok`
		LEFT JOIN `biro-osszesito` ON `biro-osszesito`.`CSID` = `csapatok`.`CSAZ`
	WHERE `biro-osszesito`.`FID`='$user_tourn' AND (`biro-osszesito`.`KID`='$pr1' OR `biro-osszesito`.`KID`='$pr2' OR `biro-osszesito`.`KID`='$pr3')
	GROUP BY `biro-osszesito`.`CSID`
	ORDER BY MAXIMUM DESC
	LIMIT $limit";
$result = $db->query($sql);
}
else{
$sql="SELECT `biro-osszesito`.`OSSZPONT` AS MAXIMUM, `csapatok`.*
	FROM `biro-osszesito` 
	LEFT JOIN `csapatok` ON `biro-osszesito`.`CSID` = `csapatok`.`CSAZ`
	WHERE `biro-osszesito`.`FID` = '$user_tourn' AND `biro-osszesito`.`KID` = '$qf'
	ORDER BY MAXIMUM DESC
	LIMIT $limit";
$result = $db->query($sql);
}

$sql_sub="SELECT `fordulok`.`RGASZTALNUM`
		FROM `fordulok`
		WHERE `fordulok`.`FAZ` = '$user_tourn'";
$result_sub = $db->query($sql_sub);
$row_sub=$result_sub->fetch_assoc();
$table_num=$row_sub['RGASZTALNUM'];

?>
<html>
   
   <head>
      <title><?php echo $lang['ad_random']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomeadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="check_result_l.php"><?php echo $lang['ad_result']; ?></a>
			<a href="sch_maker.php"><?php echo $lang['schedule']; ?></a>
			<a href="result_send.php"><?php echo $lang['ad_send']; ?></a>
			<a href="addteaminfo.php"><?php echo $lang['ad_reg']; ?></a>
			<a class="active" href="robot_game_lot_i.php"><?php echo $lang['ad_random']; ?></a>
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
	<tr>
		<th><?php echo $lang['num_of_teams']; ?>: </th>
		<td><?php echo $limit;?></td>
	</tr>
	<tr>
		<th><?php echo $lang['table_num']; ?>: </th>
		<td><?php echo $table_num;?></td>
	</tr>
</table>

<br>
	
<table style="width:50%">
	<tr>
    <th><?php echo $lang['team_name']; ?></th>
	<th>Best </th>
	</tr>
	<?php
	$teams = array();
	while($row = $result->fetch_assoc()) {
		$teams[]=$row['CSAZ'];
	?>
	<tr>
	<td>
		<?php echo $row['CSNEV'].' ['.$row['CSAZ'].']';?>
	</td>
	<td>
		<?php echo $row['MAXIMUM'] ;?>
	</td>
	</tr>
	<?php
		}
	?>
	</table>
	<?php 
		shuffle($teams);
		print_r($teams);
	?>
	<table>
		<form action="" method="post">
			<tr>
				<th>
				<?php echo $lang['table_num']; ?>:
				</th>
				<td>
					<input type="number" name="tablenum" id="tablenum" min= 2 max=<?php echo $table_num ;?> required/>
				</td>
			</tr>
			<tr>
				<th>
				
				</th>
				<td>
					<button type = "submit" name="submit"><?php echo $lang['gen']; ?></button>
				</td>
			</tr>
		</form>
	</table>
	
	<?php
	if(isset($_POST['submit'])){
		$tablenum=$_POST['tablenum'];
		$max_per_table=$limit/2;
		$act=0;
		for($table=1; $table<=$tablenum; $table++){
			$num=1;
			for($act; $act<count($teams); $act++){
				if($num<=$max_per_table){
					$team_id=$teams[$act];
					$sql_sub_i="INSERT INTO `biro-osszesito` (`BOAZ`, `CSID`, `FID`, `KID`, `OSSZPONT`, `ASZTAL`, `SSZAM`, `RIDO`) VALUES (NULL, '$team_id', '$user_tourn', '$sf', '0', '$table', '$num', NULL)";
					if(mysqli_query($db, $sql_sub_i)){
						echo 'SIKERES GENERÁLÁS!';
					}
					else{
						echo 'HIBA!';
					}
					$num++;
				}
				else{
					break;
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