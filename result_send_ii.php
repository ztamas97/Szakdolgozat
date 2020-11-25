<?php
include('session.php');
include('functions.php');
   
if($user_permission_id!=4){
	header('location: logout.php');
}
$sql_sub="SELECT `fordulok`.*, `helyszinek`.`VAROS`
		FROM `fordulok` 
		LEFT JOIN `helyszinek` ON `fordulok`.`HELYID` = `helyszinek`.`HAZ`
		WHERE `fordulok`.`FAZ` = '$user_tourn'";
$result_sub = $db->query($sql_sub);
$row_sub=$result_sub->fetch_assoc();

$loc=$row_sub['VAROS'];
$email=$row_sub['EMAIL'];

$sql="UPDATE `fordulok` SET `AKTIV` = b'0' WHERE `fordulok`.`FAZ` = '$user_tourn'";

if(mysqli_query($db, $sql)){
	if($language=='hu'){
	$main='
			<h1>Kedves Nemzeti főszervező!</h1>
			<p>A '.$loc.' helyszínen megrendezett forduló helyszíni szervezője lezárta az eseményt!.</p><br>
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
						Kontakt:
					</th>
					<td>
						'.$email.'
					</td>
				</tr>
				<tr style:"width:50%">
					<th>
						Új státusz:
					</th>
					<td>
						Inaktív
					</td>
				</tr>
			</table>
			<br>
			<h3>Üdvözlettel: FLL Team</h3>
			<br>
			<p>Ez az üzenet az FLL Scoring System automatikusan generált üzenete, Kérjük ne válaszoljon rá!</p>';
	}
	else if($language=='eng'){
	$main='
			<h1>Dear National Chief Organizer!</h1>
			<p>At the '.$loc.' the on-site organizer of round closed the event!.</p><br>
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
						Contact:
					</th>
					<td>
						'.$email.'
					</td>
				</tr>
				<tr style:"width:50%">
					<th>
						New status:
					</th>
					<td>
						Inactive
					</td>
				</tr>
			</table>
			<br>
			<h3>Regards, FLL Team</h3>
			<br>
			<p>This message is an automatically generated message from the FLL Scoring System, Please do not reply!</p>';
	}
	emailsender($national_head,'FLL user','FLL Scoring System',$main);
	$describe='Forduló lezárása sikeres!';
	
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
    if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	header('location: welcomeadm.php');
} 
else{
	$describe='Forduló lezárása sikertelen!';
	$sql_log="INSERT INTO `naplo` (`Azonosito`, `Felhasználó`, `Időpont`, `Esemény`) VALUES (NULL, '$user_name', CURRENT_TIMESTAMP, '$describe')";
	if(mysqli_query($db, $sql_log)){
	} 
	else{
	}
	$_SESSION['akt_lang'] = $language;
	$_SESSION['back_to'] = 'welcomeadm.php';
	if($language == 'eng'){
		$_SESSION['error_msg'] = 'Problem with close tourn!'; 
	}
	else{
		$_SESSION['error_msg'] = 'Probléma a forduló lezárásával!'; 
	}
	header('location: error_page.php');
}

?>