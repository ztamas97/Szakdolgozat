<?php
include('../config.php');
session_start();
?>
<html>
	<head>
		<title>Csapat eredmények</title>
	</head>
	
	<body>
		<form action="" method="post">
			 <fieldset>
				<legend>Eredmény lekérdezés:</legend>
				<label for="rid">Eredmény azonosító:</label>
				<input type="text" id="rid" name="rid"><br>
				<button type = "submit" name="submit">Keresés</button>
			 </fieldset>
		</form>
	</body>
</html>
<?php
if(isset($_POST['submit']))
{
	$code = $_POST['rid'];
	$token = strtok($code, '-');
	$a_of_token = array();
 
	while ($token !== false)
	{
		array_push($a_of_token, $token);
		$token = strtok('-');
	}
	$tourn = $_SESSION['tourn_id_result'] = $a_of_token[0];
	$teamid = $_SESSION['team_id_result'] = $a_of_token[1];
	$teammem = $_SESSION['team_pmem_result'] = $a_of_token[2];
	$coach = $_SESSION['team_coach_result'] = $a_of_token[3];
	
	$sql="SELECT `bfordulok`.*
	FROM `bfordulok` 
	LEFT JOIN `biro-osszesito` ON `biro-osszesito`.`KID` = `bfordulok`.`FOAZ` 
	LEFT JOIN `csapatok` ON `biro-osszesito`.`CSID` = `csapatok`.`CSAZ`
	WHERE `biro-osszesito`.`CSID` = '$teamid' AND `biro-osszesito`.`FID` = '$tourn' AND `csapatok`.`EMAIL` = '$coach' AND `csapatok`.`VCSLSZAM` = '$teammem'";
	$result = $db->query($sql);
	$count = mysqli_num_rows($result);
	if($count>0)
	{
		header('location: coach_res_select.php');
	}
	else
	{
		echo 'Hibás azonosító!';
	}
}
?>