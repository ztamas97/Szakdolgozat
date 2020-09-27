<?php
include('session.php');
if($_POST['id']){
$id=$_POST['id'];
if($id==0){
 echo "<option></option>";
}else{
 $sql = "SELECT `fordulok`.`FAZ`, `helyszinek`.`VAROS`
		FROM `fordulok` 
		LEFT JOIN `helyszinek` ON `fordulok`.`HELYID` = `helyszinek`.`HAZ`
		LEFT JOIN `szezon` ON `fordulok`.`SZEZONID` = `szezon`.`SZAZ`
		WHERE `fordulok`.`SZIID` = '$id' AND `fordulok`.`SZEZONID`='$akt_season_id'";
$result = $db->query($sql);
 while($row = $result->fetch_assoc()){
 echo '<option value="'.$row['FAZ'].'">'.$row['VAROS'].'</option>';
 }
 }
}
?>