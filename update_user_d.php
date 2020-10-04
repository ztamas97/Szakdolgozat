<?php
include('session.php');

if(isset($_POST['id']))
{
	$value = $_POST['value'];
	$column = $_POST['column'];
	$id = $_POST['id'];
	
	$sql="UPDATE `felhasznalok` 
		SET `$column` = '$value' 
		WHERE `Azonosito` = $id ";

	if(mysqli_query($db, $sql)){
		
	} 
	else{

		echo 'HIBA!' . mysqli_error($db);
	}
}
?>