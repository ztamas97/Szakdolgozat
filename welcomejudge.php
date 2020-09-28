<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=5){
	header('location: logout.php');
}

$schedule='files/Schedule_'.$user_location.'_'.$user_level.'_'.$user_tourn.'.pdf';
?>
<html>
   
   <head>
      <title><?php echo $lang['jud_title']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/welcome.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a class="active" href="welcomejudge.php"><?php echo $lang['home_p']; ?></a>
			<a href="sum_scores.php"><?php echo $lang['ad_result']; ?></a>
			<a href=<?php echo $schedule; ?> target="_blank"><?php echo $lang['schedule']; ?></a>
			<a href="judge_scoring.php"><?php echo $lang['ref_scoring']; ?></a>
			<a href="teaminfo_jud_ref.php"><?php echo $lang['jud_team_i']; ?></a>
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
				<th><?php echo $lang['loc']; ?>:</th>
				<td><?php echo $user_location; ?></td>
			</tr>
			<tr>
				<th><?php echo $lang['level']; ?>:</th>
				<td><?php echo $user_level; ?></td>
			</tr>
			<tr>
				<th><?php echo $lang['cat']; ?>:</th>
				<td><?php echo $user_category; ?></td>
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
				<td><a href="images/core_v.jpg"><?php echo $lang['open']; ?></a></td>
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