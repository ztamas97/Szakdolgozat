<?php
include('session.php');
include('functions.php');
require(languageselect($language));
   
if($user_permission_id!=2){
	header('location: logout.php');
}

$sql="SELECT `helyszinek`.*
	FROM `helyszinek`;";
	
$result=$db->query($sql);
	
?>
<html>
   
   <head>
      <title><?php echo $lang['locations_sys']; ?></title>
	  <link rel="stylesheet" type="text/css" href="stylesheet/form.css">
   </head>
   
   <body>
		<div class="welcome">
			<img src="images/fll_main_logo.png" alt="FLL">
			<a href="welcomesys.php"><?php echo $lang['home_p']; ?></a>
			<a href="checkuser.php"><?php echo $lang['user_sys']; ?></a>
			<a class="active" href="addlocation.php"><?php echo $lang['locations_sys']; ?></a>
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
		<table style="width:100%">
				<tr>
					<th><?php echo $lang['id']; ?></th>
					<th><?php echo $lang['city']; ?></th>
					<th><?php echo $lang['address']; ?></th>
				</tr>
				<?php while($row=$result->fetch_assoc()){?>
					<tr>
						<td>
							<?php echo $row['HAZ']; ?>
						</td>
						<td>
							<div contenteditable="true" onBlur="updateValue(this,'IRSZ', 'helyszinek', 'HAZ','<?php echo $row['HAZ']; ?>')"><?php echo $row['IRSZ']; ?></div>
							<div contenteditable="true" onBlur="updateValue(this,'VAROS', 'helyszinek', 'HAZ','<?php echo $row['HAZ']; ?>')"><?php echo $row['VAROS']; ?></div>
						</td>
						<td>
							<div contenteditable="true" onBlur="updateValue(this,'UTCA', 'helyszinek', 'HAZ','<?php echo $row['HAZ']; ?>')"><?php echo $row['UTCA']; ?></div>
							<div contenteditable="true" onBlur="updateValue(this,'HSZ', 'helyszinek', 'HAZ','<?php echo $row['HAZ']; ?>')"><?php echo $row['HSZ']; ?></div>							
						</td>
					</tr>
				<?php }?>
		</table>
		
		<br>
		
		<table>
			<form action="insertlocation.php" method="post">
				<tr>
					<td>
					<p class="form">
					<label for="city"><?php echo $lang['city']; ?>:</label>
					<input type="text" name="city" id="city" required/>
					</p>
					</td>
				</tr>
				<tr>
					<td>
					<p class="form">
					<label for="postcode"><?php echo $lang['pc']; ?>:</label>
					<input type="text" name="postcode" id="postcode"required/>
					</p>
					</td>
				</tr>
				<tr>
					<td>
					<p class="form">
					<label for="street"><?php echo $lang['street']; ?>:</label>
					<input type="text" name="street" id="street"required/>
					</p>
					</td>
				</tr>
				<tr>
					<td>
					<p class="form">
					<label for="number"><?php echo $lang['hn']; ?>:</label>
					<input type="text" name="number" id="number"required/>
					</p>
					</td>
				</tr>
				<tr>
					<td>
					<button type = "submit"><?php echo $lang['add_loc']; ?></button>
					</td>
				</tr>
			</form>
		</table>
		
		<br>
		<br>
		<br>
		
		<div class="footer">
			<p>Zelles Tamás SZE 2020</p>
		</div>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script>
		function updateValue(element, column, table_n, id_name, id)
			{
				var value = element.innerText
					
				$.ajax({
					url:'update_ajax.php',
					type: 'post',
					data:{
						value: value,
						column: column,
						table_n: table_n,
						id_name: id_name,
						id: id
					},
					success:function(php_result)
					{
						console.log(php_result);
					}
				})
			}
		</script>
   </body>
   
</html>