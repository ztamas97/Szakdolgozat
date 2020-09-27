<?php
include('session.php');
   
if($user_permission_id!=5){
	header("location: logout.php");
}

$schedule="files/Schedule_".$user_location."_".$user_level."_".$user_tourn.".pdf";
?>
<html>
   
   <head>
      <title>Zsűri</title>
	  <link rel="stylesheet" type="text/css" href="welcome.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a class="active" href="welcomejudge.php">Kezdőlap</a>
			<a href="sum_scores.php">Eredmények</a>
			<a href=<?php echo $schedule; ?> target="_blank">Menetrend</a>
			<a href="judge_scoring.php">Pontozás</a>
			<a href="teaminfo_jud_ref.php">Csapat információk</a>
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
				<th>Jogosultság:</th>
				<td><?php echo $user_permission; ?></td>
			</tr>
			<tr>
				<th>Helyszín:</th>
				<td><?php echo $user_location; ?></td>
			</tr>
			<tr>
				<th>Szint:</th>
				<td><?php echo $user_level; ?></td>
			</tr>
			<tr>
				<th>Kategória:</th>
				<td><?php echo $user_category; ?></td>
			</tr>
			<tr>
				<th>Bejelentkezés:</th>
				<td><?php echo $time; ?> <?php echo $day; ?></td>
			</tr>
		</table>
		</div>
		<div class="documents">
		<table>
			<tr>
				<th>Szabályok:</th>
				<td><a href="rg_hu.pdf">Megnyitás</a></td>
			</tr>
			<tr>
				<th>FLL értékek:</th>
				<td><a href="rg_hu.pdf">Megnyitás</a></td>
			</tr>
			<tr>
				<th>Építési útmutató:</th>
				<td><a href="rg_hu.pdf">Megnyitás</a></td>
			</tr>
		</table>
		</div>
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
 </html> 