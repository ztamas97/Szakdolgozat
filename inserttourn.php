<?php
include('session.php');
include ('functions.php');
   
if($user_permission_id!=3){
	header('location: logout.php');
}

$location = mysqli_real_escape_string($db, $_POST['subject_loc']);
$seson = mysqli_real_escape_string($db, $_POST['subject_ses']);
$tdate = mysqli_real_escape_string($db, $_POST['date']);
$maxteam = mysqli_real_escape_string($db, $_POST['maxteam']);
$level = mysqli_real_escape_string($db, $_POST['subject_lev']);
$contname = mysqli_real_escape_string($db, $_POST['cont']);
$email = mysqli_real_escape_string($db, $_POST['cemail']);
$contpnumber = mysqli_real_escape_string($db, $_POST['cpn']);
 
$sql="INSERT INTO `fordulok` (`FAZ`, `HELYID`, `SZEZONID`, `DATE`, `RESZTVCSMAX`, `SZIID`,`KONTAKT`, `EMAIL`, `TEL`) VALUES (NULL, '$location', '$seson', '$tdate', '$maxteam', '$level','$contname', '$email', '$contpnumber')";

if(mysqli_query($db, $sql)){
	if ($language=='eng'){
		$main='
				<h1>Dear, '.$contname.'!</h1>
				<p>With yout e-mail('.$email.') as a contact person was added a round to the FLL scoring and administration system.</p><br>
				<table style:"width:50% text-align: left">
					<tr style:"width:50%">
						<th>
							Season
						</th>
						<td>
							'.$akt_season.'
						</td>
					</tr>
					<tr style:"width:50%">
						<th>
							Date
						</th>
						<td>
							'.$tdate.'
						</td>
					</tr>
					<tr style:"width:50%">
						<th>
							Maximum team
						</th>
						<td>
							'.$maxteam.'
						</td>
					</tr>
				</table>
				<br>
				<p>More information will be provided by the organizers soon!</p>
				<h3>Regards, FLL Team</h3>
				<br>
				<p>This message is an automatically generated message from the FLL Scoring System, Please do not reply!</p>';
	}
	else{
		$main='
				<h1>Kedves '.$contname.'!</h1>
				<p>Az Ön e-mail címével('.$email.') mint kontakt személy elérhetőség felvettek egy fordulót az FLL pontozó és adminisztrációs felületre .</p><br>
				<table style:"width:50% text-align: left">
					<tr style:"width:50%">
						<th>
							Szezon
						</th>
						<td>
							'.$akt_season.'
						</td>
					</tr>
					<tr style:"width:50%">
						<th>
							Dátum
						</th>
						<td>
							'.$tdate.'
						</td>
					</tr>
					<tr style:"width:50%">
						<th>
							Maximum csapatszám
						</th>
						<td>
							'.$maxteam.'
						</td>
					</tr>
				</table>
				<br>
				<p>Hamarosan a szervezők közlik a további információkat!</p>
				<h3>Üdvözlettel: FLL Team</h3>
				<br>
				<p>Ez az üzenet az FLL Scoring System automatikusan generált üzenete, Kérjük ne válaszoljon rá!</p>';
	}
	emailsender($email,'new FLL user','FLL Scoring System',$main);
	$describe='Forduló hozzáadása sikeres!';
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
	if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
    header('location: addtourn.php');
} else{
	$describe='Forduló hozzáadása sikertelen!';
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
	if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
    echo 'HIBA: A rögzítés nem sikeres! $sql.'. mysqli_error($db);
}
?>