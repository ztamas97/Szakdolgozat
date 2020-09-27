<?php
include('session.php');
   
if($user_permission_id!=4){
	header('location: logout.php');
}

$teammem = mysqli_real_escape_string($db, $_POST['teammem']);
$cn = mysqli_real_escape_string($db, $_POST['cn']);
$behere = mysqli_real_escape_string($db, $_POST['radio']);
$tournid = $_SESSION['tourn_id'];
$teamid = mysqli_real_escape_string($db, $_POST['teamid']);
 
#echo $teammem.' '.$cn.' '.$behere.' '.$tournid.' '.$teamid;
 
$sql="UPDATE `csapat-fordulo` SET `MEGJELENTE` = b'$behere', `CSLSZAM` = '$teammem', `CLSZAM` = '$cn' WHERE `csapat-fordulo`.`CSAPATID` = '$teamid' AND `csapat-fordulo`.`FORDULOID` = '$tournid'";

if(mysqli_query($db, $sql)){
    header('location: addteaminfo.php');
} else{
    echo 'HIBA: A rögzítés nem sikeres! $sql. ' . mysqli_error($db);
}

?>