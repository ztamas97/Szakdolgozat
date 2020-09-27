<?php
include('session.php');
   
if($user_permission_id!=2){
	header('location: logout.php');
}

$cid = mysqli_real_escape_string($db, $_POST['chid']);

$sql = "DELETE FROM `zsuri-szempontok` WHERE `zsuri-szempontok`.`SZEMAZ` = '$cid'";

if(mysqli_query($db, $sql)){
    header('location: judge_scoresheetmaker.php');
} else{
    echo 'HIBA: A törlés nem sikeres! $sql.'. mysqli_error($db);
}
?>