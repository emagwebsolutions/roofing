<?php session_start();
if(isset($_GET['clogout'])){
	unset($_SESSION['xcustomerx']);
	header('location: customer.html');
}




