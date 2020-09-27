<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=2){
	header('location: logout.php');
}

?>
<html>
	<head>
		<title><?php echo $lang['ref_sheet_sys']; ?></title>
		<link rel="stylesheet" type="text/css" href="stylesheet/form.css">
	</head>
   
	<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomesys.php"><?php echo $lang['home_p']; ?></a>
			<a href="checkuser.php"><?php echo $lang['user_sys']; ?></a>
			<a href="addlocation.php"><?php echo $lang['locations_sys']; ?></a>
			<a href="judge_scoresheetmaker.php"><?php echo $lang['jud_sheet_sys']; ?></a>
			<a class="active" href="referee_scoresheetmaker.php"><?php echo $lang['ref_sheet_sys']; ?></a>
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
		<table>
			<tr>
				<td>
					<form action="referee_scoresheetmaker_II.php" method="post">
						<button type="submit"><?php echo $lang['tasks']; ?></button>
					</form>
				</td>
				<td>
					<form action="referee_scoresheetmaker_II_p.php" method="post">
						<button type="submit"><?php echo $lang['part_tasks']; ?></button>
					</form>
				</td>
			</tr>
		</table>
		
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
		
   </body>
   
</html>