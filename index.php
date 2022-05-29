<?php session_start();
date_default_timezone_set('Africa/Accra');
error_reporting(E_ALL);
ini_set("display_errors", 1); 
if(!file_exists(dirname(__FILE__).'/model/constants.php')){
	include 'install.html';
    exit;
}
include dirname(__FILE__).'/model/utils.php'; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title id="app_name"></title>
        <link rel="stylesheet" href="assets/css/styles.css">
</head>

<?php

//Get page 
if(isset($_GET['page'])){
	$curr_page = strtolower($_GET['page']);
}
else{
	$curr_page = 'dashboard';
}

if(isset($_GET['logout'])){
	unset($_SESSION['edfghl']);
}
 
if(isset($_SESSION['edfghl'])){
	?>
	<body style="background-color: #e9ecef;">
	<div class="nav-menu"></div>
	<div class="content"></div>
	
	<?php
	include 'view/'.strtolower($curr_page).'.html';
	?>

	<footer>
		<small>&copy; copyright 2015 - <?php echo date("Y"); ?>  <span id="appname"></span> by <a href="http://www.emagwebsolutions.com">Emagweb Solutions</a></small>
	</footer>

	<script type="module" src="assets/components/navbar/Navmenu.js"></script>
	<script type="module" src="assets/components/global.js"></script>
	<br><br><br>
	</body>
</html>
<?php
	}
	else{
		include 'login.html';
	}
?>