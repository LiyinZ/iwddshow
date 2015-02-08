<?php 

require 'functions/main.php';


// make sure it's post request before preparing database queries
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['first_name'])) {
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$student_num = $_POST['student_num'];
		$url = $_POST['url'];

		if (!empty($url) && !filter_var($url, FILTER_VALIDATE_URL)) {
			$url_status = 'Your url is invalid. (e.g. include http://)';
		} else {
			$user_id = valid_user($first_name, $last_name, $student_num, $local_db);
			if ($user_id) { // if valid user credentials, set user as logged in;
				activate_user($user_id, $url, $local_db); // sends success email, update info
				$_SESSION['first_name'] = $first_name;
				$_SESSION['user_id'] = $user_id;
				$status = 'successful';
				redirect('/iwddshow');
			} else {
				$creds_status = 'You entered incorrect credentials.';
			}
		}
	} else {
		$name_status = 'Please select your first name'; 
	}
}

$title = 'Sign In | IWDD Showcase';
require 'partials/header.php';

$conn = connect($local_db);
$sql = 'SELECT DISTINCT first_name, url FROM php_a1_users ORDER BY first_name';
$users = $conn->query($sql);

?>

<div class="container" id="signin">
	<br>
	<br>
	<br>
	<div class="row sub-heading">
		<h4>Sign In</h4>
		<h5>/ Activate Your Account</h5>
	</div>
	<div class="row">
		<div class="col s12">
		    <div class="card blue-grey darken-1">
		        <div class="card-content white-text">
		            <span class="card-title">Note</span>
		            <p>Projects can be browsed by anyone. Submitting project requires Sign In and is curretly only available to students who gave me their student number. You can request an invite by contacting me if interested.</p>
		        </div>
		        <div class="card-action">
		            <a href="#contact" onclick="toast('See contact info in footer.', 4000)">Contact</a>
		        </div>
		    </div>
		</div>
	</div>
	<br>
	<div class="row">
	    <form action="" method="post" class="col s12">
	        <div class="row">
	            <div class="col s12 m6">
	            	<label>Choose Your First Name</label>
	            	
					<select name="first_name" id="first_name" class="browser-default">
					    <option <?= empty($_POST)? 'selected' : '' ?> disabled>First Name *</option>

						<?php foreach($users as $user): ?>
						<option <?= (isset($_POST['first_name']) && $_POST['first_name'] == $user['first_name'])? 'selected' : '' ?> value="<?= $user['first_name'] ?>">
							<?= $user['first_name'] ?>
						</option>
						<?php endforeach; ?>
					</select>
					<?php if (isset($name_status)): ?>
        	        	<p class="red-text text-lighten-1"><?= $name_status; ?></p>
        	    	<?php endif; ?>
	            </div>
	            <div class="input-field col s12 m6">
	                <input name="last_name" id="last_name" type="text" class="validate" value="<?= isset($_POST['last_name'])? $_POST['last_name'] : '' ?>" required>
	                <label for="last_name">Last Name *</label>
	            </div>
	        </div>
	        <div class="row">
	            <div class="input-field col s12">
	                <input name="student_num" id="student_num" type="password" class="validate" required>
	                <label for="student_num">Your Student Number *</label>
	            </div>
	        </div>
	        <div class="row">
	            <div class="input-field col s12">
	            	<input name="url" id="url" type="text" value="<?= isset($_POST['url'])? $_POST['url'] : '' ?>" class="validate">
	            	<label for="url">Personal Link (e.g. twitter) optional</label>
	            	<?php if (isset($url_status)): ?>
        	        	<p class="red-text text-lighten-1"><?= $url_status; ?></p>
        	    	<?php endif; ?>
	            </div>
	        </div>
			<?php if (isset($creds_status)): ?>
        		<p class="red-text text-lighten-1"><?= $creds_status; ?></p>
        	<?php endif; ?>
	        <button type="submit" class="waves-effect waves-light btn-large">
				<i class="mdi-action-done left"></i>Sign In
			</button>
			
			<!-- send email confirmation upon successful activation (plz check your student mail) -->
	    </form>
	    <?php if (isset($status)): ?>
			<h4><?= $status ?></h4>
		<?php endif; ?>
	</div>
</div>

<br>
<br>



<?php require 'partials/footer.php' ?>