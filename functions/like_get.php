<?php 

require 'main.php';

// ajax for displaying updated number of like on requested project
if ( isset($_POST['project_id'], $_SESSION['ip']) ) {
	$conn = connect($local_db);
	echo ' ' . like_count($_POST['project_id'], $conn);
	$conn = null;
} else {
	redirect('/iwddshow');
}

 ?>