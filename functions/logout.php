<?php 

require 'main.php';


if (isset($_SESSION['first_name'])){
	session_destroy();
	$_SESSION = [];
}

redirect('/iwddshow');

 ?>