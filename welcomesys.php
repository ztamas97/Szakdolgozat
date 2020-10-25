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
		<title><?php echo $lang['sys_title']; ?></title>
		<link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
	</head>
   
	<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a class="active" href="welcomesys.php"><?php echo $lang['home_p']; ?></a>
			<a href="checkuser.php"><?php echo $lang['user_sys']; ?></a>
			<a href="addlocation.php"><?php echo $lang['locations_sys']; ?></a>
			<a href="judge_scoresheetmaker.php"><?php echo $lang['jud_sheet_sys']; ?></a>
			<a href="referee_scoresheetmaker.php"><?php echo $lang['ref_sheet_sys']; ?></a>
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
		<div class="info">
		<table>
			<tr>
				<th><?php echo $lang['perm']; ?>:</th>
				<td><?php echo $user_permission; ?></td>
			</tr>
			<tr>
				<th><?php echo $lang['login_t']; ?>:</th>
				<td><?php echo $time; ?> <?php echo $day; ?></td>
			</tr>
		</table>
		</div>
		<div class="documents">
		<table>
			<tr>
				<th><?php echo $lang['rules']; ?>:</th>
				<td><a href="system_files/rg_hu.pdf"><?php echo $lang['open']; ?></a></td>
			</tr>
			<tr>
				<th><?php echo $lang['core_v']; ?>:</th>
				<td><a href="system_files/rg_hu.pdf"><?php echo $lang['open']; ?></a></td>
			</tr>
			<tr>
				<th><?php echo $lang['building_inst']; ?>:</th>
				<td><a href="system_files/rg_hu.pdf"><?php echo $lang['open']; ?></a></td>
			</tr>
		</table>
		</div>
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
   
</html>