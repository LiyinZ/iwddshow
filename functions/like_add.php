<?php 

require 'main.php';

if ( isset($_POST['project_id']) &&  isset($_SESSION['ip']) ) {
	$conn = connect($local_db);
	if ( project_exists($_POST['project_id'], $conn) ) {
		$project_id = $_POST['project_id'];
		$ip = $_SESSION['ip'];
		if ( prev_liked($project_id, $ip, $conn) ) {
			unlike($project_id, $ip, $conn);
		} else {
			add_like($project_id, $ip, $conn);
		}
	}
	$conn = null;
} else {
	redirect('/iwddshow');
}

 ?>