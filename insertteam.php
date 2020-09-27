<?php
include('session.php');
include ('functions.php');
   
if($user_permission_id!=3){
	header('location: logout.php');
}

$teamname = mysqli_real_escape_string($db, $_POST['teamname']);
$pteammem = mysqli_real_escape_string($db, $_POST['pteammem']);
$coach = mysqli_real_escape_string($db, $_POST['coach']);
$pcn = mysqli_real_escape_string($db, $_POST['pcn']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$season_id = mysqli_real_escape_string($db, $_POST['subject_ses']);
 
$sql="INSERT INTO `csapatok` (`CSAZ`, `CSNEV`, `VCSLSZAM`, `COACH`, `VCOACHSZAM`, `EMAIL`, `SZID`) VALUES (NULL, '$teamname', '$pteammem', '$coach', '$pcn', '$email','$season_id');";

if(mysqli_query($db, $sql)){
	if($language == 'eng'){
		$main='
				<h1>Dear '.$coach.'!</h1>
				<p>With your e-mail('.$email.') have been registered in the FLL scoring and administration system as a'.$teamname.' (csapat) Coach.</p><br>
				<table style:"width:50% text-align: left">
					<tr style:"width:50%">
						<th>
							Season:
						</th>
						<td>
							'.$akt_season.'
						</td>
					</tr>
					<tr style:"width:50%">
						<th>
							Possible team size:
						</th>
						<td>
							'.$pteammem.'
						</td>
					</tr>
					<tr style:"width:50%">
						<th>
							Possible coach number:
						</th>
						<td>
							'.$pcn.'
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
				<h1>Kedves '.$coach.'!</h1>
				<p>Az Ön e-mail címét('.$email.') regisztrálták az FLL pontozó és adminisztrációs rendszerébe, mint a '.$teamname.' (csapat) Coachja.</p><br>
				<table style:"width:50% text-align: left">
					<tr style:"width:50%">
						<th>
							Szezon:
						</th>
						<td>
							'.$akt_season.'
						</td>
					</tr>
					<tr style:"width:50%">
						<th>
							Várható csapatlétszám:
						</th>
						<td>
							'.$pteammem.'
						</td>
					</tr>
					<tr style:"width:50%">
						<th>
							Várható Coach szám:
						</th>
						<td>
							'.$pcn.'
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
    header('location: addteam.php');
} else{
    echo 'HIBA: A rögzítés nem sikeres! $sql. ' . mysqli_error($db);
}
?>