<?php
include('config.php');
include('functions.php');
session_start();
require(languageselect($_SESSION['lang']));

$username = '';
$message='';
if(isset($_POST['username'])){
	$username = $_POST['username'];
	$gen=password_generate(10);
	$password = md5($gen);


	$sql="SELECT `jogosultsagok`.*, `felhasznalok`.`FHNEV`
		FROM `jogosultsagok` 
		LEFT JOIN `felhasznalok` ON `felhasznalok`.`JOGID` = `jogosultsagok`.`JAZ`
		WHERE `felhasznalok`.`FHNEV` = '$username'";
		
	$result = mysqli_query($db,$sql);
	echo $count = mysqli_num_rows($result);
	while($row=$result->fetch_assoc()){
		$permname=$row['JNEV'];
		$perm_id=$row['JAZ'];
	}

	if($perm_id == '2' OR $perm_id == '3'){
		$sql="SELECT `felhasznalok`.*
			FROM `felhasznalok`
			WHERE `felhasznalok`.`JOGID` = '$perm_id' AND `felhasznalok`.`FHNEV` = '$username'";
		
		$result = mysqli_query($db,$sql);
		while($row=$result->fetch_assoc()){
			$id=$row['Azonosito'];
			$email=$row['EMAIL'];
		}

		if($_SESSION['lang']=='eng'){
			$main='
			<h1 style="background-color:powderblue;">Dear user!</h1>
			<p>With your e-mail ('.$email.') was requested a password reset.</p><br>
			<p>Username: '.$username.'</p><br>
			<p style="background-color:red;">Password: '.$gen.'</p><br>
			<h3>Best regards, FLL Team</h3>';
		}
		else{
			$main='
			<h1 style="background-color:powderblue;">Kedves Felhasználó!</h1>
			<p>Az Ön e-mail címével('.$email.') jelszóvisszaállítást igényeltek.</p><br>
			<p>Felhasználónév: '.$username.'</p><br>
			<p style="background-color:red;">Új jelszó: '.$gen.'</p><br>
			<h3>Üdvözlettel: FLL Team</h3>';
		}
	}
	else if ($perm_id == '1' OR $perm_id == '4' OR $perm_id == '5'){
		$sql="SELECT `helyszinek`.`VAROS`,`helyszinek`.`HAZ`, `jogosultsagok`.`JNEV`,`felhasznalok`.`Azonosito` ,`felhasznalok`.`FHNEV`,`szint`.`SZINEV`,`fordulok`.`FAZ`, `fordulok`.`EMAIL`, `fordulok`.`KONTAKT` 
		FROM `felhasznalok` 
		LEFT JOIN `fordulok` ON `fordulok`.`FAZ` = `felhasznalok`.`FORDULOID` 
		LEFT JOIN `helyszinek` ON `helyszinek`.`HAZ`= `fordulok`.`HELYID` 
		LEFT JOIN `jogosultsagok` ON `jogosultsagok`.`JAZ`=`felhasznalok`.`JOGID` 
		LEFT JOIN `szint` ON `szint`.`SZIAZ`=`fordulok`.`SZIID` 
		WHERE `felhasznalok`.`FHNEV` = '$username'";
		
		$result = mysqli_query($db,$sql);
		while($row=$result->fetch_assoc()){
			$loc=$row['VAROS'];
			$id=$row['Azonosito'];
			$email=$row['EMAIL'];
			$kont=$row['KONTAKT'];
			$lev=$row['SZINEV'];
		}
		
		if($_SESSION['lang']=='eng'){
			$main='
			<h1 style="background-color:powderblue;">Dear User!</h1>
			<p>With your e-mail ('.$email.') was requested a password reset.</p><br>
			<p>Username: '.$username.'</p><br>
			<p>Location: '.$loc.'|Level: '.$lev.'|Permission: '.$permname.'</p><br>
			<p style="background-color:red;">Password: '.$gen.'</p><br>
			<h3>Best regards, FLL Team</h3>';
		}
		else{
			$main='
			<h1 style="background-color:powderblue;">Kedves Felhasználó!</h1>
			<p>Az Ön e-mail címével('.$email.') jelszóvisszaállítást igényeltek.</p><br>
			<p>Felhasználónév: '.$username.'</p><br>
			<p>Helyszín: '.$loc.'|Szint: '.$lev.'|Jogosultság: '.$permname.'</p><br>
			<p style="background-color:red;">Új jelszó: '.$gen.'</p><br>
			<h3>Üdvözlettel: FLL Team</h3>';
		}
	}
	if ($count == 0)
	{
		$message = $lang['undefined_user'];
	}
	else{
		emailsender($email,'FLL Scoring System user','FLL Scoring System password re',$main);		
		$sql_up="UPDATE `felhasznalok` SET `JSZO` = '$password' WHERE `felhasznalok`.`Azonosito` = '$id'";
		if(mysqli_query($db, $sql_up)){
			$message = $lang['new_pass'].$email;
		} 	
		else{
			$message= $lang['new_pass_err'];
		}
	}

	$pwd = fopen('passwords.txt', 'a'); 
	fwrite($pwd, $username.' : '.$gen."\n");   
	fclose($pwd); 
	$describe='Jelszó helyreállítás';
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$username', CURRENT_TIMESTAMP, '$describe')";
		if(mysqli_query($db, $sql_log)){
		} 
		else{
		}
}
?>
<html>

	<head>

		<title><?php echo $lang['pswre_title']; ?></title>
		<link rel="stylesheet" type="text/css" href="stylesheet/loginstyle.css">
		
	</head>

	<body>
		<div class="login-page">
		  <img src="images/fll_main_logo.png" alt="LEGO logo" height="50" width="200">
		  <div class="form">
			<form class="login-form" action = "" method = "post">
			  <input type="text" placeholder=<?php echo $lang['username']; ?> name="username"/>
			  <button type = "submit"><?php echo $lang['pswre']; ?> </button>
			  <div class="alert"><?php echo $message; ?></div>
			  <p class="message"><a href="index.php"><?php echo $lang['login_red']; ?></a></p>
			</form>
		  </div>
		</div>
	</body>

</html>