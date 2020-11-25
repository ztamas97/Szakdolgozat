<?php
session_start();
include('functions.php');
$language = $_SESSION['akt_lang']='hu';
require(languageselect($language));

$error_msg = $_SESSION['error_msg']='igen';
$back_to = $_SESSION['back_to']='igen';
?>
<html>
	<head>
		<title><?php echo $lang['error_title']; ?></title>
		<link rel="stylesheet" type="text/css" href="stylesheet/error_page.css">
	</head>
	<body>
		<table class="table_msg">
			<tr>
				<td>
					<img src="images/error.jpg" alt="error photo">
				</td>
				<td>
					<h1><?php echo $lang['something_wrong']; ?></h1>
					<h4><?php echo $lang['msg_send_or_re']; ?></h4>
					<form action=<?php echo $back_to; ?> method="post">
						<input type="image" src="images/back.svg" width=10% alt="back icon">
					</form>
				</td>
			<tr>
		</table>
	</body>
</html>