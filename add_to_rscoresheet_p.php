 <?php
include('session.php');
   
if($user_permission_id!=2){
	header('location: logout.php');
}

$sub_id = mysqli_real_escape_string($db, $_POST['subid']);
$season = mysqli_real_escape_string($db, $_POST['sid']);
$name = mysqli_real_escape_string($db, $_POST['name']);
if(isset($_POST['comm'])){
	$comment = mysqli_real_escape_string($db, $_POST['comm']);
}
else{
	$comment=NULL;
}
$value_max = mysqli_real_escape_string($db, $_POST['value_max']);
if(isset($_POST['extrapoint'])){
	$epoint = mysqli_real_escape_string($db, $_POST['extrapoint']);
}
else{
	$epoint=NULL;
}

$sql = "INSERT INTO `biro-feladatok` (`FELAZ`, `SUBAZ`, `NEV`, `FMEGJ`, `MAXPONT`, `EXTRAPONT`, `SZID`) VALUES (NULL, '$sub_id', '$name', '$comment', '$value_max', '$epoint', '$season')";

if(mysqli_query($db, $sql)){
    header('location: referee_scoresheetmaker_II.php');
} else{
    echo 'HIBA: A hozzáadás nem sikeres! $sql.'. mysqli_error($db);
}
?>