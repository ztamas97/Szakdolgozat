<?php
include('session.php');

if(isset($_POST['id']))
{
	$value = $_POST['value'];
	$column = $_POST['column'];
	$table_n = $_POST['table_n'];
	$id_name = $_POST['id_name'];
	$id = $_POST['id'];
	
	$sql="UPDATE `$table_n` 
		SET `$column` = '$value' 
		WHERE `$id_name` = $id ";

	if(mysqli_query($db, $sql)){
		
	} 
	else{

		echo 'HIBA!' . mysqli_error($db);
	}
}
?>