<?php
include('session.php');
include('functions.php');
require(languageselect($language));

if($user_permission_id!=3){
	header('location: logout.php');
}

?>
<html>
   
	<head>
		<title><?php echo $lang['mad_title']; ?></title>
		<link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
	</head>
   
	<body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a class="active" href="welcomemadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="checktourn.php"><?php echo $lang['tourn_mad']; ?></a>
			<a href="checkteam.php"><?php echo $lang['teams_mad']; ?></a>
			<a href="team_tourn.php"><?php echo $lang['team-tourn_mad']; ?></a>
			<a href="modify_res_madm_i.php"><?php echo $lang['res_mod_mad']; ?></a>
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