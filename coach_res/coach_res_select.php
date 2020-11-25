<?php
include('../config.php');
session_start();

$tourn=$_SESSION['tourn_id_result'];
$teamid=$_SESSION['team_id_result'];
$teammem=$_SESSION['team_pmem_result'];
$coach=$_SESSION['team_coach_result'];

$sql="SELECT `bfordulok`.*
	FROM `bfordulok` 
	LEFT JOIN `biro-osszesito` ON `biro-osszesito`.`KID` = `bfordulok`.`FOAZ` 
	LEFT JOIN `csapatok` ON `biro-osszesito`.`CSID` = `csapatok`.`CSAZ`
	WHERE `biro-osszesito`.`CSID` = '$teamid' AND `biro-osszesito`.`FID` = '$tourn' AND `csapatok`.`EMAIL` = '$coach' AND `csapatok`.`VCSLSZAM` = '$teammem'";
$result = $db->query($sql);

$sql2="SELECT `csapatok`.*
	FROM `csapatok`
	WHERE `csapatok`.`CSAZ` = '$teamid'";
$result2 = $db->query($sql2);
$teaminfo = $result2->fetch_assoc();
?>
<html>
	<head>
		<title>Csapat eredmények</title>
		<link rel="stylesheet" type="text/css" href="../stylesheet/scoresheet.css">
	</head>
	
	<body>
		<h3><?php echo 'Csapat ID'; ?>: <?php echo $teamid; ?> | <?php echo 'Csapat név'; ?>: <?php echo $teaminfo['CSNEV']; ?> | <?php echo 'Forduló ID'; ?>: <?php echo $tourn; ?> | E-mail: <?php echo $coach; ?></h3>
		<form action="" method="post">
			 <fieldset>
				<legend>Robot Game eredmény lekérdezés:</legend>
				<label for="subject_rou">Forduló:</label>
				<select name="subject_rou"required/> 
					<option></option>
					<?php while($subjectData = $result->fetch_assoc()){ ?>
						<option value="<?php echo $subjectData['FOAZ'];?>"> <?php echo $subjectData['FONEV'];?></option>
					<?php }?> 
				</select><br><br>
				<button type = "submit" name="submit">Keresés</button>
			 </fieldset>
		</form>
<?php
		if(isset($_POST['submit']))
		{
			$round = $_SESSION['team_round_result'] = $_POST['subject_rou'];
			$season = $_SESSION['team_season_result'] = $teaminfo['SZID'];
			
			$sql3="SELECT `biro-feladatok`.*
			FROM `biro-feladatok`
			WHERE `biro-feladatok`.`SZID` = '$season'
			ORDER BY `biro-feladatok`.`SUBAZ`";
			
			
			$result3 = $db->query($sql3);			
?>
			<table style="width:100%", border="1">
				<tr>
					<th>Azonositó</th>
					<th>Leírás</th>
					<th>Pont</th>
				</tr>
				<?php
					while($row = $result3->fetch_assoc()) {
						$obj_id=$row['FELAZ'];
				?>
						<tr>
							<td>
								<?php echo $row['SUBAZ'];?><br>
							</td>
							<td>
								<div><?php echo $row['NEV'].' ';?></div>
								<?php echo $row['FMEGJ'];?>
							</td>
							<td>
							</td>
						</tr>
<?php
						$sql4 = "SELECT `biro-r-feladatok`.*, `biro-tipus`.`BTIPNEV`
							FROM `biro-r-feladatok` 
							LEFT JOIN `biro-tipus` ON `biro-r-feladatok`.`TIPUSID` = `biro-tipus`.`BTIPAZ`
							WHERE `biro-r-feladatok`.`FELID` = '$obj_id'";
						$result4 = $db->query($sql4);
						while($row4 = $result4->fetch_assoc()) {
							$brf = $row4['BRFAZ'];
							$sql5 = "SELECT `biro-pontok`.*, `biro-r-feladatok`.`ERTEK`
									FROM `biro-pontok` 
									LEFT JOIN `biro-r-feladatok` ON `biro-pontok`.`BRRFID` = `biro-r-feladatok`.`BRFAZ`
									WHERE `biro-pontok`.`CSID` = '$teamid' AND `biro-pontok`.`FID` = '$tourn' AND `biro-pontok`.`BKATID` = '$round' AND `biro-pontok`.`BRRFID` = '$brf'";
							$result5 = $db->query($sql5);
							$row5 = $result5->fetch_assoc();
?>
							<tr>
								<td>
								</td>
								<td>
									<?php echo $row4['LEIRAS']; ?>
								</td>
								<td>
									<?php echo $row5['SZORZO']*$row5['ERTEK']; ?>
								</td>
							</tr>
<?php							
						}
					}
			$sql6 = "SELECT `biro-osszesito`.`OSSZPONT`, `biro-osszesito`.`RIDO`
					FROM `biro-osszesito`
					WHERE `biro-osszesito`.`CSID` = '$teamid' AND `biro-osszesito`.`FID` = '$tourn' AND `biro-osszesito`.`KID` = '$round'";
			$result6 = $db->query($sql6);
			$row6 = $result6->fetch_assoc();
?>
			</table>
			<br>
			<table border="1">
				<tr>
					<th>
						Összpont:
					</th>
					<td>
						<?php echo $row6['OSSZPONT']; ?>
					</td>
				</tr>
				<tr>
					<th>
						Rögzítés:
					</th>
					<td>
						<?php echo $row6['RIDO']; ?>
					</td>
				</tr>
			</table>
			<br>
<?php			
		}
?>

<?php	
		$sql7="SELECT * 
			FROM `zskategoriak`";
		$result7 = $db->query($sql7);

		$sql8="SELECT `fordulok`.*
			FROM `fordulok`
			WHERE `fordulok`.`FAZ` = '$tourn' AND `fordulok`.`AKTIV` = '0'";
		$result8 = $db->query($sql8);
		$count8= mysqli_num_rows($result8);
		
		if($count8 == 1){ 
?>
		<form action="" method="post">
			 <fieldset>
				<legend>Zsűri eredmény lekérdezés:</legend>
				<label for="subject_cat">Kategória:</label>
				<select name="subject_cat"required/> 
					<o ption></option>
					<?php while($subjectDataC = $result7->fetch_assoc()){ ?>
						<option value="<?php echo $subjectDataC['ZSAZ'];?>"> <?php echo $subjectDataC['ZSKATNEV'];?></option>
					<?php }?> 
				</select><br><br>
				<button type = "submit" name="submit2">Keresés</button>
			 </fieldset>
		</form>
<?php
		if(isset($_POST['submit2']))
		{
			$user_category_id = $_SESSION['team_category_result'] = $_POST['subject_cat'];
			$season = $_SESSION['team_season_result'] = $teaminfo['SZID'];
			
			$sql9="SELECT `zsuri-szempontok`.*, `zsuri-pontok`.`ERTEK`, `zsuri-pontok`.`CSID`, `zsuri-pontok`.`FID`
					FROM `zsuri-szempontok` 
					LEFT JOIN `zsuri-pontok` ON `zsuri-pontok`.`SZEMID` = `zsuri-szempontok`.`SZEMAZ`
					WHERE `zsuri-szempontok`.`SZEZONID` = '$season' AND `zsuri-szempontok`.`ZSURIKATID` = '$user_category_id' AND `zsuri-pontok`.`CSID` = '$teamid' AND `zsuri-pontok`.`FID` = '$tourn'";
			$result9 = $db->query($sql9);
			
			$sql10="SELECT `zsuri-osszesito`.*
					FROM `zsuri-osszesito`
					WHERE `zsuri-osszesito`.`CSID` = '$teamid' AND `zsuri-osszesito`.`FID` = '$tourn' AND `zsuri-osszesito`.`ZSKATID` = '$user_category_id'";
			$result10 = $db->query($sql10);
			$row10 = $result10->fetch_assoc();
?>
			<table style="width:100%", border="1">
			<tr>
				<th></th>
				<th>exemplary(4)</th> 
				<th>accomplished(3)</th>
				<th>developing(2)</th>
				<th>beginning(1)</th>
				<th>Eredmény</th>
			</tr>
<?php	
			while($row9 = $result9->fetch_assoc()) {
?>				<tr>
					<th>
						<?php echo $row9['SZEMNEV'];?><br>
						<?php echo $row9['KATEGORIA'];?><br>
						<?php echo $row9['LEIRAS'];?>
					</th>
					<th><?php echo $row9['EXEMPLARY'];?></th> 
					<th><?php echo $row9['ACCOMPLISHED'];?></th>
					<th><?php echo $row9['DEVELOPING'];?></th>
					<th><?php echo $row9['BEGINNING'];?></th>
					<th><?php echo $row9['ERTEK'];?></th>
				</tr>
<?php      }
?>
			</table>
			<br>
			<table style="width:40%", border="1">
				<tr>
					<th>
						Bónusz pont:
					</th>
					<td>
						<?php echo $row10['PLUSSZP']; ?>
					</td>
				</tr>
				<tr>
					<th>
						Megjegyzés:
					</th>
					<td>
						<?php echo $row10['MEGJ']; ?>
					</td>
				</tr>
				<tr>
					<th>
						Rögzítés:
					</th>
					<td>
						<?php echo $row10['RIDO']; ?>
					</td>
				</tr>
			</table>
<?php	}
	}
?>
		<br>
		
		<form action="coach_res.php" method="post">
			<input type="image" src="../images/back.svg" width=5% alt="back icon">
		</form>
		
	</body>
</html>
