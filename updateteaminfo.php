<?php
include('session.php');
include ('functions.php');
   
if($user_permission_id!=4){
	header('location: logout.php');
}

$teammem = mysqli_real_escape_string($db, $_POST['teammem']);
$cn = mysqli_real_escape_string($db, $_POST['cn']);
$behere = mysqli_real_escape_string($db, $_POST['radio']);
$tournid = $_SESSION['tourn_id'];
$teamid = mysqli_real_escape_string($db, $_POST['teamid']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$possteammem = mysqli_real_escape_string($db, $_POST['poss_teammem']);
 
$sql="UPDATE `csapat-fordulo` SET `MEGJELENTE` = b'$behere', `CSLSZAM` = '$teammem', `CLSZAM` = '$cn' WHERE `csapat-fordulo`.`CSAPATID` = '$teamid' AND `csapat-fordulo`.`FORDULOID` = '$tournid'";

if(mysqli_query($db, $sql)){
	if($language == 'eng'){
		$main='
				<h1>Dear Coach!</h1>
				<p>You can view the robot game results per turn using the code below.</p><br>
				<p>Results <a href="http://fll.zeta-it.hu/coach_res/coach_res.php">here!</a></p><br>
				<table style:"width:50% text-align: left">>
					<tr style:"width:50%">
						<th>
							Result access code:
						</th>
						<td>
							'.$tournid.'-'.$teamid.'-'.$possteammem.'-'.$email.'
						</td>
					</tr>
				</table>
				<br>
				<p>Judge scorecards will be available after the event closes!</p>
				<h3>Regards, FLL Team</h3>
				<br>
				<p>This message is an automatically generated message from the FLL Scoring System, Please do not reply!</p>';
		}
	else{
		$main='
				<h1>Kedves Coach!</h1>
				<p>A robot game pontozólapokat körönként a lenti kód segítségével tudja elérni.</p><br>
				<p>Eredmények <a href="http://fll.zeta-it.hu/coach_res/coach_res.php">itt!</a></p><br>
				<table style:"width:50% text-align: left">>
					<tr style:"width:50%">
						<th>
							Eredmény elérési kód:
						</th>
						<td>
							'.$tournid.'-'.$teamid.'-'.$possteammem.'-'.$email.'
						</td>
					</tr>
				</table>
				<br>
				<p>A zsúri pontozólapokat az esemény lezárása után lesznek elérhetőek!</p>
				<h3>Üdvözlettel: FLL Team</h3>
				<br>
				<p>Ez az üzenet az FLL Scoring System automatikusan generált üzenete, Kérjük ne válaszoljon rá!</p>';
	}
	emailsender($email,'FLL user','FLL Scoring System',$main);
    header('location: addteaminfo.php');
} 
else{
	$_SESSION['akt_lang'] = $language;
	$_SESSION['back_to'] = 'addteaminfo.php';
	if($language == 'eng'){
		$_SESSION['error_msg'] = 'Problem with update team informations!'; 
	}
	else{
		$_SESSION['error_msg'] = 'Probléma a csapatadatok frissítésénél!'; 
	}
	header('location: error_page.php');
}

?>