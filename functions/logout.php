<?php 

require 'main.php';
session_start();

if (isset($_SESSION['first_name'])){
	session_destroy();
	$_SESSION = [];
}

redirect('/iwddshow');

 ?>