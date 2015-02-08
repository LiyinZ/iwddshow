<?php 

require 'functions/main.php';

$_SESSION['ip'] = "173.224.120.84";

// $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
$ip = $_SESSION['ip'];

var_dump($ip);

$conn = connect($local_db);

$projects = get_projects($conn, 'oldest');

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Like button</title>
</head>
<body>

<a onclick="alert('working')" href="#">Alert</a>

<?php foreach ($projects as $project): ?>

<ul>
	<li><?= $project['name'] ?></li>
	<li><?= $project['url'] ?></li>
	<li><button id="like"><a href="#" onclick="like_add(<?= $project['project_id'] ?>)">Like</a></button></li>
	<li id="<?= $project['project_id'] ?>"><?= $project['likes'] ?></li>
</ul>

<?php endforeach; $conn = null; ?>
	
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/init.js"></script>
</body>
</html>

