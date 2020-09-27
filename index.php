<?php
#Konfig. fájl elérése, munkamenet indítása
include('config.php');
session_start();

#Nyelvi beállítások
if($_GET['la']){
	$_SESSION['lang'] = $_GET['la'];
	header('Location:'.$_SERVER['PHP_SELF']);
	exit();
}

switch($_SESSION['lang']){
 	case 'hu':
		require('lang/hu.php');		
	break;
	case 'eng':
		require('lang/eng.php');		
	break;
	default: 
		require('lang/hu.php');		
}
	
#Bejelentkezéshez felhasználónév, hiba üzenet változó deklarálása
$user_name = '';
$error = '';

if(isset($_POST['user_name'])){
	#Felhasználónév érték adás
	$user_name = $_POST['user_name'];
	#Jelzó változó deklarálása
	$password = '';

	if(isset($_POST['password'])){
		#Jelszó érték adás, md5 hash alkalmazása
		$password = md5($_POST['password']);
	
		#Beadott felhasználói adatok alapján lekérdezés
		$login = "SELECT * FROM felhasznalok WHERE FHNEV = '$user_name' and JSZO = '$password'";
		$result = mysqli_query($db,$login);
		$count = mysqli_num_rows($result);
		if($count==1){
			#Felhasználónév tárolása munkamenteben
			$_SESSION['user_name'] = $user_name;
			$_SESSION['profile_pic']=rand(1,10);
			#Jogosultság lekérése
			$permission="SELECT `helyszinek`.`VAROS`,`helyszinek`.`HAZ`, `jogosultsagok`.`JNEV`, `felhasznalok`.`FHNEV`,`felhasznalok`.`AKTIV`,`felhasznalok`.`JOGID`,`szint`.`SZINEV`,`fordulok`.`FAZ`, `zskategoriak`.`ZSKATNEV`,`zskategoriak`.`ZSAZ`
				FROM `felhasznalok` 
				LEFT JOIN `fordulok` ON `fordulok`.`FAZ` = `felhasznalok`.`FORDULOID` 
				LEFT JOIN `helyszinek` ON `helyszinek`.`HAZ`= `fordulok`.`HELYID` 
				LEFT JOIN `jogosultsagok` ON `jogosultsagok`.`JAZ`=`felhasznalok`.`JOGID` 
				LEFT JOIN `szint` ON `szint`.`SZIAZ`=`fordulok`.`SZIID` 
				LEFT JOIN `zskategoriak` ON `zskategoriak`.`ZSAZ`=`felhasznalok`.`ZSKATID` 
				WHERE `felhasznalok`.`FHNEV` = '$user_name'";
			$result = mysqli_query($db,$permission);
			$count = mysqli_num_rows($result);
			#Ha van találat, akkor megfelelő módon tovább irányítás.
			if ($count > 0) {
				while($row = $result->fetch_assoc()) {
					$_SESSION['permission']=$row['JNEV'];
					$_SESSION['permission_id']=$row['JOGID'];
					$_SESSION['login_time']= date('Y/m/d');
					
					if($row['JOGID'] == 1){
						$_SESSION['location']=$row['VAROS'];
						$_SESSION['location_id']=$row['HAZ'];
						$_SESSION['level']=$row['SZINEV'];
						$_SESSION['tourn_id']=$row['FAZ'];
						
						$describe='Sikeres bejelentkezés! | Jog: '.$row['JNEV'];
						$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
						if(mysqli_query($db, $sql_log)){
						} 
						else{
						}
						
						header('location: welcomeref.php');
					}
					else if($row['JOGID']==2){
						$describe='Sikeres bejelentkezés! | Jog: '.$row['JNEV'];
						$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
						if(mysqli_query($db, $sql_log)){
						} 
						else{
						}
						header('location: welcomesys.php');
					}
					else if($row['JOGID']==3){
						$describe='Sikeres bejelentkezés! | Jog: '.$row['JNEV'];
						$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
						if(mysqli_query($db, $sql_log)){
						} 
						else{
						}
						header('location: welcomemadm.php');
					}
					else if($row['JOGID']==4 AND $row['AKTIV']==1){
						$_SESSION['location']=$row['VAROS'];
						$_SESSION['location_id']=$row['HAZ'];
						$_SESSION['level']=$row['SZINEV'];
						$_SESSION['tourn_id']=$row['FAZ'];
						
						$describe='Sikeres bejelentkezés! | Jog: '.$row['JNEV'];
						$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
						if(mysqli_query($db, $sql_log)){
						} 
						else{
						}
						header('location: welcomeadm.php');
					}
					else if($row['JOGID']==5){
						$_SESSION['location']=$row['VAROS'];
						$_SESSION['location_id']=$row['HAZ'];
						$_SESSION['level']=$row['SZINEV'];
						$_SESSION['tourn_id']=$row['FAZ'];
						$_SESSION['category']=$row['ZSKATNEV'];
						$_SESSION['category_id']=$row['ZSAZ'];
						
						$describe='Sikeres bejelentkezés! | Jog: '.$row['JNEV'];
						$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
						if(mysqli_query($db, $sql_log)){
						} 
						else{
						}
						
						header('location: welcomejudge.php');
					}
					else{
						$error = $lang['inactive_user'];
					}
				}
			}
		}
		#sikertelen bejelentkezés esetén hibaüzenet kiírása.
		else{
			$error  = $lang['login_error'];
			$describe = 'Sikertelen bejelentkezés!';
			$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, NULL, CURRENT_TIMESTAMP, '$describe')";
			if(mysqli_query($db, $sql_log)){
			} 
			else{
			}
		}
	}
}
?>
<html>
	<head>
		<title><?php echo $lang['index_title']; ?></title>
		<link rel="stylesheet" type="text/css" href="stylesheet/loginstyle.css">
	</head>
	
	<body>
		<div class="login-page">
			<img src="images/fll_main_logo.png" alt="FLL logo" height="50" width="200">
			<div class="form">
				<form class="login-form" action = "" method = "post">
					<input type="text" placeholder=<?php echo $lang['username']; ?> name="user_name"/>
					<input type="password" placeholder=<?php echo $lang['password']; ?> name="password"/>
					<button type = "submit"><?php echo $lang['login']; ?></button>
					<div class="alert"><?php echo $error; ?></div>
					<p class="message"><a href="password_re.php"><?php echo $lang['forgott_psw']; ?></a></p>
					<table class="langselect">
						<tr>
							<td>
								<a href="index.php?la=hu"><img src="images/flags/hu.png" alt="<?=$lang['lang-hu'];?>" title="<?=$lang['lang-hu'];?>" /></a>
							</td>
							<td>
								<a href="index.php?la=eng"><img src="images/flags/eng.png" alt="<?=$lang['lang-eng'];?>" title="<?=$lang['lang-eng'];?>" /></a>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>