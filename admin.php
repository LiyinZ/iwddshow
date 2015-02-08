<?php 

require 'functions/main.php';


// access denied for non admin users
if (!is_admin()) {
  redirect('/iwddshow');
}

// for admin users, connect to database and display available data for both users and projects.
$conn = connect($local_db);

$users_sql = 'SELECT * FROM php_a1_users ORDER BY last_name';
$projects_sql = 'SELECT * FROM php_a1_projects';

$users = $conn->query($users_sql);
$projects = $conn->query($projects_sql);

$title = 'Admin Panel | IWDD Showcase';
require 'partials/header.php';
 ?>

 <div class="container" id="admin">
 	<br><br>
 	<div class="row sub-heading">
        <h4>Users Info</h4>
    </div>
 	<div class="section" id="users">
 		<table class="striped">
        <thead>
          <tr>
          		<th>ID</th>
              <th>Last Name</th>
              <th>First Name</th>
              <th>Student Number</th>
              <th>Personal Link</th>
              <th>Activated</th>
          </tr>
        </thead>

        <tbody>
        	<?php foreach ($users as $user): ?>
          <tr>
          	<td><?= $user['id']; ?></td>
            <td><?= $user['last_name']; ?></td>
            <td><?= $user['first_name']; ?></td>
            <td><?= $user['student_num']; ?></td>
            <td><?= $user['url']; ?></td>
            <td><?= $user['last_logged']=='0000-00-00 00:00:00'? '' : 'Yes'; ?></td>
          </tr>
          	<?php endforeach; ?>
        </tbody>
      </table>
 	</div>
  <hr>
  <br>
 	<div class="section" id="projects">
 		<div class="row sub-heading">
 			<h4>Projects Info</h4>
 		</div>
		<table class="striped">
        <thead>
          <tr>
          		<th>ID</th>
              <th>Project Name</th>
              <th>Description</th>
              <th>User ID</th>
              <th>Project URL</th>
              <th>View Count</th>
              <th>Last Viewed</th>
              <th>Created At</th>
          </tr>
        </thead>

        <tbody>
        	<?php foreach ($projects as $project): ?>
          <tr>
            <td><?= $project['id']; ?></td>
            <td><?= $project['name']; ?></td>
            <td><?= $project['description']; ?></td>
            <td><?= $project['user_id']; ?></td>
            <td><?= $project['url']; ?></td>
            <td><?= $project['view_count']; ?></td>
            <td><?= $project['last_view']; ?></td>
            <td><?= $project['created_at']; ?></td>
          </tr>
          	<?php endforeach; ?>
        </tbody>
      </table>
 	</div>
 </div>


<?php require 'partials/footer.php'; ?>