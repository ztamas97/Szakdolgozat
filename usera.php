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
} else{
    echo 'HIBA: A hozzáadás nem sikeres! $sql. ' . mysqli_error($db);
}

?>