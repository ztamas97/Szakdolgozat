<?php
include('../config.php');
session_start();

if($_GET['la']){
	$_SESSION['lang'] = $_GET['la'];
	header('Location:'.$_SERVER['PHP_SELF']);
	exit();
}

switch($_SESSION['lang']){
 	case 'hu':
		require('../lang/hu.php');		
	break;
	case 'eng':
		require('../lang/eng.php');		
	break;
	default: 
		require('../lang/hu.php');		
}
?>
<html>
	<head>
		<title><?php echo $lang['coach_res']; ?></title>
		<link rel="stylesheet" type="text/css" href="../stylesheet/loginstyle.css">
	</head>
	
	<body>
		<div class="login-page">
			<div class="form">
				<h2><?php echo $lang['coach_res']; ?></h2>
				<form class="login-form" action = "" method = "post">
					<input type="password" placeholder=<?php echo $lang['password']; ?> name="password"/>
					<button type = "submit"><?php echo $lang['login']; ?></button>
					<table class="langselect">
						<tr>
							<td>
								<a href="coach_res.php?la=hu"><img src="../images/flags/hu.png" alt="<?=$lang['lang-hu'];?>" title="<?=$lang['lang-hu'];?>" /></a>
							</td>
							<td>
								<a href="coach_res.php?la=eng"><img src="../images/flags/eng.png" alt="<?=$lang['lang-eng'];?>" title="<?=$lang['lang-eng'];?>" /></a>
							</td>
						</tr>
					</table>
				</form>			</div>
		</div>
	</body>
</html>
<?php
if(isset($_POST['password']))
{
	$code = $_POST['password'];
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