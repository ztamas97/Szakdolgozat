 <?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=4){
	header('location: logout.php');
}

defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
defined("SITE_ROOT") ? null : define("SITE_ROOT", "C:".DS."wamp64".DS."www".DS."fll-scs");

$file_name_def='Schedule_'.$user_location.'_'.$user_level.'_'.$user_tourn.'.pdf';

?>
<html>
   
   <head>
      <title><?php echo $lang['schedule']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomeadm.php"><?php echo $lang['home_p']; ?></a>
			<a href="check_result_l.php"><?php echo $lang['ad_result']; ?></a>
			<a class="active" href="sch_maker.php"><?php echo $lang['schedule']; ?></a>
			<a href="result_send.php"><?php echo $lang['ad_send']; ?></a>
			<a href="addteaminfo.php"><?php echo $lang['ad_reg']; ?></a>
			<a href="robot_game_lot_i.php"><?php echo $lang['ad_random']; ?></a>
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
			<form action = "" method = "POST" enctype = "multipart/form-data">
				<tr>
					<td>
						<input type = "file" name = "file" />
					</td>
					<td>
						<input type = "submit"/>
					</td>
				</tr>
			</form>
		</table>
		<?php
		if(isset($_FILES['file'])){
			$errors= array();
			$file_name = $_FILES['file']['name'];
			$file_size = $_FILES['file']['size'];
			$file_tmp = $_FILES['file']['tmp_name'];
			$file_type = $_FILES['file']['type'];
			$file_upload_to=SITE_ROOT . DS . "files";
			$file_ext=strtolower(end(explode('.',$_FILES['file']['name'])));
		  
			$extensions= array('pdf');
		  
			if(in_array($file_ext,$extensions)=== false){
				if($language=='hu'){
					$errors[]='nem megfelelő a kiterjesztés, kérem  PDF fájlt töltsön fel.';
				}
				else if($language=='eng'){
					$errors[]='the extension is not correct, please upload a PDF file.';
				}
			}
		  
			if($file_size > 5097152) {
				if($language=='hu'){
					$errors[]='Fájl méret maximum 5 MB';
				}
				else if($language=='eng'){
					$errors[]='File size up to 5 MB.';
				}
			}
		  
			if($file_name != $file_name_def) {
				if($language=='hu'){
					$errors[]='A megadott fájlnév nem megfelelő! Követelmény: '.$file_name_def;
				}
				else if($language=='eng'){
					$errors[]='The file name you entered is incorrect! Requirement: '.$file_name_def;
				}
			}
		  
			if(empty($errors)==true) {
				move_uploaded_file($file_tmp, $file_upload_to . DS . $file_name);
				if($language=='hu'){
					echo 'Sikeres';
				}
				else if($language=='eng'){
					echo 'Complet';
				}
			}
			else{
				print_r($errors);
				if($language=='hu'){
					echo 'Sikertelen feltöltés!';
				}
				else if($language=='eng'){
					echo 'Upload failed!';
				}
			}
		}
		?>
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
	</body>
</html>