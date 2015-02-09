<?php 

require 'main.php';

// check if it's ajax post request and if it comes from a page with ip set
if ( isset($_POST['project_id']) &&  isset($_SESSION['ip']) ) {
	$conn = connect($local_db);
	if ( project_exists($_POST['project_id'], $conn) ) {
		$project_id = $_POST['project_id'];
		$ip = $_SESSION['ip'];
		if ( prev_liked($project_id, $ip, $conn) ) {
			unlike($project_id, $ip, $conn);
			echo 'unliked';
		} else {
			add_like($project_id, $ip, $conn);
			echo 'liked';
		}
	}
	$conn = null;
} else {
	redirect('/iwddshow');
}

 ?>