<?php
include('session.php');
include('functions.php');
require(languageselect($language));

if($user_permission_id!=2){
	header('location: logout.php');
}

$sqlj = "SELECT * FROM `jogosultsagok`";
$resultj = $db->query($sqlj);

$sqllev = "SELECT * FROM `szint`";
$resultlev = $db->query($sqllev);

?>
<html>
   
   <head>
      <title><?php echo $lang['user_sys']; ?> </title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomesys.php"><?php echo $lang['home_p']; ?></a>
			<a class="active" href="checkuser.php"><?php echo $lang['user_sys']; ?></a>
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
		<table>
			<form action="insertuser.php" method="post">
				<tr>
					<td>
						<p class="form">
						<label for="uname"><?php echo $lang['username_sys']; ?>:</label>
						<input type="text" name="uname" id="uname"required/>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="perm"><?php echo $lang['perm']; ?>:</label>
						<select name="subject_perm" class="permission"required/>
						<option></option>
						<?php while($subjectDataP = $resultj->fetch_assoc()){ ?>
						<option value="<?php echo $subjectDataP['JAZ'];?>"> <?php echo $subjectDataP['JNEV'];?></option>
						<?php }?> 
						</select>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="loc"><?php echo $lang['level']; ?>:</label>
						<select name="subject_lev" class="level"> 
						<option></option>
						<?php while($subjectDataLev = $resultlev->fetch_assoc()){ ?>
						<option value="<?php echo $subjectDataLev['SZIAZ'];?>"> <?php echo $subjectDataLev['SZINEV'];?></option>
						<?php }?> 
						</select>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="loc"><?php echo $lang['loc']; ?>:</label>
						<select name="subject_loc" class="city"> 
						<option></option> 
						</select>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="loc"><?php echo $lang['j_cat_sys']; ?>:</label>
						<select name="subject_category" class="category"> 
						<option></option> 
						</select>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<p class="form">
						<label for="email"><?php echo $lang['email_sys']; ?>:</label>
						<input type="text" name="email" id="email">
						</p>
					</td>
				</tr>
				<tr>
					<td>	
						<button type = "submit" name="submit"><?php echo $lang['add_user']; ?></button>
					</td>
				</tr>
			</form>
		</table>
		<form action="checkuser.php" method="post">
			<input type="image" src="images/back.svg" width=5% alt="back icon">
		</form>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function()
		{
		$(".level").change(function()
		{
		var level_id=$(this).val();
		var post_id = 'id='+ level_id;
 
		$.ajax
		({
		type: "POST",
		url: "ajax_adduser.php",
		data: post_id,
		cache: false,
		success: function(cities)
		{
		$(".city").html(cities);
		} 
		});
 
		});
		});
		</script>
		<script type="text/javascript">
		$(document).ready(function()
		{
		$(".permission").change(function()
		{
		var permission_id=$(this).val();
		var post_id2 = 'id='+ permission_id;
 
		$.ajax
		({
		type: "POST",
		url: "ajax_adduser2.php",
		data: post_id2,
		cache: false,
		success: function(categorys)
		{
		$(".category").html(categorys);
		} 
		});
 
		});
		});
		</script>
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
   </body>
   
</html>