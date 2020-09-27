<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=4){
	header('location: logout.php');
}
	
$sql="SELECT `fordulok`.`FAZ`, `fordulok`.`RGASZTALNUM`
	FROM `fordulok`
	WHERE `fordulok`.`FAZ` = '$user_tourn'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$table_num=$_SESSION['RGASZTALNUM']=$row['RGASZTALNUM'];

if($table_num==0){
?>
<html>
   
   <head>
      <title><?php echo $lang['ad_random']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
   </head>
   
<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomeadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="check_result_l.php"><?php echo $lang['ad_result']; ?></a>
			<a href="sch_maker.php"><?php echo $lang['schedule']; ?></a>
			<a href="result_send.php"><?php echo $lang['ad_send']; ?></a>
			<a href="addteaminfo.php"><?php echo $lang['ad_reg']; ?></a>
			<a class="active" href="robot_game_lot_i.php"><?php echo $lang['ad_random']; ?></a>
			<div class="logout-container">
				<form action="logout.php">
					<button type="submit"><img src="images/logout.svg" alt="logout"></button>
				</form>
			</div>
			<div class="chip">
				<img src="profilepictures/<?php echo $prof_pic; ?>.jpg" alt="Person">
				<?php echo $user_name; ?>
			</div>
		</div>
		<br>
		<form action="" method="post">
			<p class="form">
			<label for="tablenum"><?php echo $lang['table_num']; ?>:</label>
			<input type="number" name="tablenum" id="tablenum" required/>
			</p>
			<button type = "submit" name="submit"><?php echo $lang['send']; ?></button>
		</form>
		<?php
		if(isset($_POST['submit'])){
			$table_num=$_POST['tablenum'];
			$sub_sql="UPDATE `fordulok` SET `RGASZTALNUM` = '$table_num' WHERE `fordulok`.`FAZ` = $user_tourn";
			if(mysqli_query($db, $sub_sql)){
				header('location: robot_game_lot_ii.php');
			}
			else{
				echo 'HIBA!';
			}
		}
		?>
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
</html>
<?php
}
else{
	header("location: robot_game_lot_ii.php");
}