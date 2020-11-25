<?php
include('session.php');
   
if($user_permission_id!=2){
		header('location: logout.php');
}

echo $userid = mysqli_real_escape_string($db, $_POST['uid']);
echo $activity = mysqli_real_escape_string($db, $_POST['avalue']);


if($activity==1){
	$sql="UPDATE `felhasznalok` SET `AKTIV` = b'0' WHERE `felhasznalok`.`Azonosito` = '$userid'";
}
else{
	$sql="UPDATE `felhasznalok` SET `AKTIV` = b'1' WHERE `felhasznalok`.`Azonosito` = '$userid'";
}

if(mysqli_query($db, $sql)){
	header('location: checkuser.php');
} 
else{
	$_SESSION['akt_lang'] = $language;
	$_SESSION['back_to'] = 'checkuser.php';
	if($language == 'eng'){
		$_SESSION['error_msg'] = 'Problem with update status of user!'; 
	}
	else{
		$_SESSION['error_msg'] = 'Probléma a felhasználó státuszának frissítésénél!'; 
	}
	header('location: error_page.php');
}

?>