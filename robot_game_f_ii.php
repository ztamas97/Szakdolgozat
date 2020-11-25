<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=4){
	header("location: logout.php");
}

$f1=6;
$f2=7;

$limit=2;

$sql="SELECT `csapatok`.*, MAX(`biro-osszesito`.`OSSZPONT`) AS MAXIMUM
	FROM `csapatok`
		LEFT JOIN `biro-osszesito` ON `biro-osszesito`.`CSID` = `csapatok`.`CSAZ`
	WHERE `biro-osszesito`.`FID`='$user_tourn' AND (`biro-osszesito`.`KID`='$f1' OR `biro-osszesito`.`KID`='$f2')
	GROUP BY `biro-osszesito`.`CSID`
	ORDER BY MAXIMUM DESC
	LIMIT $limit";
$result = $db->query($sql);

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
	<th>Best SF </th>
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
	?>
	
	<br>
	
	<table>
		<form action="" method="post">
			<tr>
				<th>
				<?php echo $lang['table_num']; ?>:
				</th>
				<td>
					2
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
		$team1=$teams[0];
		$team2=$teams[1];
		$sql_sub_i="INSERT INTO `biro-osszesito` (`BOAZ`, `CSID`, `FID`, `KID`, `OSSZPONT`, `ASZTAL`, `SSZAM`, `RIDO`) VALUES (NULL, '$team1', '$user_tourn', '$f1', '0', '1', '1', NULL)";
					if(mysqli_query($db, $sql_sub_i)){
						echo 'SIKERES GENERÁLÁS!';
					}
					else{
						$_SESSION['akt_lang'] = $language;
						$_SESSION['back_to'] = 'robot_game_lot_ii.php';
						if($language == 'eng'){
							$_SESSION['error_msg'] = 'Problem with automatic robot game round generation (F)!'; 
						}
						else{
							$_SESSION['error_msg'] = 'Probléma az sorsolás generálásnál (F)!'; 
						}
						header('location: error_page.php');
					}
		$sql_sub_ii="INSERT INTO `biro-osszesito` (`BOAZ`, `CSID`, `FID`, `KID`, `OSSZPONT`, `ASZTAL`, `SSZAM`, `RIDO`) VALUES (NULL, '$team2', '$user_tourn', '$f1', '0', '2', '1', NULL)";
					if(mysqli_query($db, $sql_sub_ii)){
						echo 'SIKERES GENERÁLÁS!';
					}
					else{
						$_SESSION['akt_lang'] = $language;
						$_SESSION['back_to'] = 'robot_game_lot_ii.php';
						if($language == 'eng'){
							$_SESSION['error_msg'] = 'Problem with automatic robot game round generation (F)!'; 
						}
						else{
							$_SESSION['error_msg'] = 'Probléma az sorsolás generálásnál (F)!'; 
						}
						header('location: error_page.php');
					}
		$sql_sub_iii="INSERT INTO `biro-osszesito` (`BOAZ`, `CSID`, `FID`, `KID`, `OSSZPONT`, `ASZTAL`, `SSZAM`, `RIDO`) VALUES (NULL, '$team1', '$user_tourn', '$f2', '0', '2', '1', NULL)";
					if(mysqli_query($db, $sql_sub_iii)){
						echo 'SIKERES GENERÁLÁS!';
					}
					else{
						$_SESSION['akt_lang'] = $language;
						$_SESSION['back_to'] = 'robot_game_lot_ii.php';
						if($language == 'eng'){
							$_SESSION['error_msg'] = 'Problem with automatic robot game round generation (F)!'; 
						}
						else{
							$_SESSION['error_msg'] = 'Probléma az sorsolás generálásnál (F)!'; 
						}
						header('location: error_page.php');
					}
		$sql_sub_iv="INSERT INTO `biro-osszesito` (`BOAZ`, `CSID`, `FID`, `KID`, `OSSZPONT`, `ASZTAL`, `SSZAM`, `RIDO`) VALUES (NULL, '$team2', '$user_tourn', '$f2', '0', '1', '1', NULL)";
					if(mysqli_query($db, $sql_sub_iv)){
						echo 'SIKERES GENERÁLÁS!';
					}
					else{
						$_SESSION['akt_lang'] = $language;
						$_SESSION['back_to'] = 'robot_game_lot_ii.php';
						if($language == 'eng'){
							$_SESSION['error_msg'] = 'Problem with automatic robot game round generation (F)!'; 
						}
						else{
							$_SESSION['error_msg'] = 'Probléma az sorsolás generálásnál (F)!'; 
						}
						header('location: error_page.php');
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