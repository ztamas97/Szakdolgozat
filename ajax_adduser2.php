<?php
include('session.php');
if($_POST['id']){
$id=$_POST['id'];
if($id==5){
	$sql = "SELECT `zskategoriak`.*
		FROM `zskategoriak`";
$result = $db->query($sql);
 while($row = $result->fetch_assoc()){
 echo '<option value="'.$row['ZSAZ'].'">'.$row['ZSKATNEV'].'</option>';
 }
}
else{
 echo "<option></option>";
 }
}
?>