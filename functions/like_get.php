<?php 

require 'main.php';

if ( isset($_POST['project_id'], $_SESSION['ip']) ) {
	$conn = connect($local_db);
	echo ' ' . like_count($_POST['project_id'], $conn);
	$conn = null;
} else {
	redirect('/iwddshow');
}

 ?>