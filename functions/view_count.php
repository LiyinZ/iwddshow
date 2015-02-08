<?php 

require 'main.php';


if (isset($_GET['url'])) {
	$url = $_GET['url'];
	// connect to database;
	$conn = connect($local_db);
	$sql = 'SELECT * FROM php_a1_projects WHERE url = :url';
	$binding = ['url' => $url];
	$result = query($sql, $binding, $conn);

	if ($result) {
		// new sql
		if (isset($_SESSION['count'][$url])) {
			$sql = 'UPDATE php_a1_projects SET view_count = view_count+1 WHERE url = :url AND (NOW() - INTERVAL 5 MINUTE) > last_view'; // time limit
		} else {
			$sql = 'UPDATE php_a1_projects SET view_count = view_count+1 WHERE url = :url';
			isset($_SESSION['count'])? $_SESSION['count'][$url] = true : $_SESSION['count'] = array($url => true); // keep track of visited links, if first time, create array.
		}
		query($sql, $binding, $conn); // update viewcount

		redirect($url);
	}

	$conn = null;
}

redirect('/iwddshow');
 ?>