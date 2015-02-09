<?php 

// database config
$local_db = array(
	'host' 	   => 'localhost',
	'database' => 'comp1006',
	'username' => 'root',
	'password' => 'root'
);




// use to identify if user is signed in
function is_logged_in() {
	return isset($_SESSION['first_name']);
}
// use to identify if user has admin privilege
function is_admin() {
	return (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 1 || $_SESSION['user_id'] == 2));
}
// determine which order option is selected
function is_selected($order, $option) {
	if ($order == $option) { return 'selected'; }
}

// better redirect than just header()
function redirect($url, $statusCode = 303) {
   header('Location: ' . $url, true, $statusCode);
   die();
}




/* --- DATABASE connect / execute / fetch --- */

// simplified process for connecting to database, returns PDO object or false
function connect($db_config) {
	try {
		$conn = new PDO('mysql:host=' . $db_config['host'] . ';dbname=' . 
										$db_config['database'],
										$db_config['username'],
										$db_config['password']);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	} catch (Exception $e) {
		return false;
	}
}

// reusable and more secure function for queries with bindings, returns query or false
function query($sql, $bindings, $conn) {
	$stmt = $conn->prepare($sql);
	$stmt->execute($bindings);

	return ( $stmt->rowCount() > 0)? $stmt : false;
}




/* --- USER Sign In / Validate / Activate --- */

// validate signin form input, returns user_id or false
function valid_user($first_name, $last_name, $student_num, $config) {
	if (empty($last_name) || empty($student_num)) {
		return false;
	} else {
		return get_user_id($first_name, $last_name, $student_num, $config);
	}
}

// helper function for valid_user(), validate user info against database, returns user_id or false
function get_user_id($first_name, $last_name, $student_num, $config) {
	$conn = connect($config);
	if ($conn) {
		$sql = 'SELECT id, first_name, last_name, student_num FROM php_a1_users WHERE first_name = :first_name';

		$result = query($sql, ['first_name' => $first_name], $conn)->fetchAll();
		if ($result) {
			$user_id = false;
			foreach ($result as $row) {
				if ($last_name == $row['last_name'] && $student_num == $row['student_num']) {
					$user_id = $row['id'];
				}
			}
			return $user_id;
			$conn = null; // disconnect
		}
	}
	return false;
}

// activate and updates user and sends confirmation email
function activate_user($user_id, $url, $config) {
	$conn = connect($config);
	$sql = "SELECT last_logged FROM php_a1_users WHERE id = $user_id";
	$result = $conn->query($sql)->fetch();
	if ($result['last_logged'] === '0000-00-00 00:00:00') {
		// send email
		/*mail($student_num . '@student.georgianc.on.ca', 'Thanks for activating on IWDD Showcase', 'You have now successfully activated your account, feel free to share your awesome work with your classmates!');*/
	}
	// activate user
	$sql = "UPDATE php_a1_users SET last_logged = now() WHERE id = $user_id";
	$conn->query($sql);

	if (!empty($url)) {
		// update url
		$sql = "UPDATE php_a1_users SET url = '$url' WHERE id = $user_id";
		$conn->query($sql);
	}
	$conn = null;
}




/* --- PROJECT submit / display / order --- */

// use for inserting new project to database
function submit_project($name, $url, $description, $user_id, $config) {
	$conn = connect($config);
	$sql = 'INSERT INTO php_a1_projects (name, description, user_id, url, created_at) VALUES (:name, :description, :user_id, :url, now())';
	$bindings = [ 'name'=>$name,
				  'description'=>$description,
				  'user_id'=>$user_id,
				  'url'=>$url ];
	
	query($sql, $bindings, $conn);
	$conn = null;
}

// helper for get_projects(), determine ORDER BY what
function set_query($order, $limit) {
	$order_by = array(
		'author_az' => 'first_name',
		'name_az'   => 'name',
		'oldest'	=> 'php_a1_projects.id',
		'views_least'=>'view_count',
		'author_za' => 'first_name DESC',
		'name_za'   => 'name DESC',
		'latest'	=> 'php_a1_projects.id DESC',
		'views_most'=> 'view_count DESC'
	);
	if (empty($order_by[$order])) {
		$order = 'author_az';
	}
	$sql = "SELECT 
		php_a1_projects.id as project_id,
		name,
		description,
		php_a1_projects.url,
		view_count,
		likes,
		first_name,
		last_name,
		php_a1_users.url as user_url 
		FROM php_a1_projects INNER JOIN php_a1_users ON php_a1_projects.user_id = php_a1_users.id 
		ORDER BY {$order_by[$order]}";
	return $limit? $sql . ' LIMIT ' . $limit : $sql;
}

// for fetching projects to be displayed, nubmer of projects configurable
function get_projects($conn, $order, $limit=null) {
	$sql = set_query($order, $limit);
	$projects = $conn->query($sql);
	return $projects;
}

// use to dynamically dispaly appropriate heading for view all page
function get_heading($order) {
	$headings = array(
		'author_az' => 'Author',
		'name_az'   => 'Projects',
		'oldest'	=> 'Oldest',
		'views_least'=>'Least Viewed',
		'author_za' => 'Author',
		'name_za'   => 'Projects',
		'latest'	=> 'Latest',
		'views_most'=> 'Popular'
	);
	return isset($headings[$order])? $headings[$order] : 'Author';
}




/* --- LIKE / UNLIKE functions --- */

// make sure the project id exists before doing other 'like' functions
function project_exists($project_id, $conn) {
	$bindings = ['project_id'=>$project_id];
	$sql = "SELECT id FROM php_a1_projects WHERE id = :project_id";
	return query($sql, $bindings, $conn);
}

// see if a project is previously liked by a specific ip
function prev_liked($project_id, $ip, $conn) {
	$bindings = ['project_id'=>$project_id, 'ip'=>$ip];
	$sql = "SELECT like_id FROM php_a1_likes WHERE ipv4 = INET_ATON(:ip) AND project_id = :project_id";
	return query($sql, $bindings, $conn);
}

// count how many likes a project has, for displaying on a page
function like_count($project_id, $conn) {
	$bindings = ['project_id'=>$project_id];
	$sql = "SELECT likes FROM php_a1_projects WHERE id = $project_id";
	return query($sql, $bindings, $conn)->fetchColumn();
}

// add 1 like to the project related to an ip, if ip is invalid, nothing happens
function add_like($project_id, $ip, $conn) {
	$bindings = ['project_id'=>$project_id, 'ip'=>$ip];
	$sql = "INSERT INTO php_a1_likes (ipv4, project_id) VALUES (INET_ATON(:ip), :project_id);
			UPDATE php_a1_projects SET likes = likes + 1 WHERE id = :project_id;";
	query($sql, $bindings, $conn);
}

// subtract 1 like if previously liked
function unlike($project_id, $ip, $conn) {
	$bindings = ['project_id'=>$project_id, 'ip'=>$ip];
	$sql = "DELETE FROM php_a1_likes WHERE ipv4 = INET_ATON(:ip) AND project_id = :project_id;
			UPDATE php_a1_projects SET likes = likes - 1 WHERE id = :project_id;";
	query($sql, $bindings, $conn);
}



session_start();
 ?>