<?php 

require 'functions/main.php';
session_start();

// only logged in users are able to submit, otherwise, redirect to homepage
if (is_logged_in()) {
	$user_id = $_SESSION['user_id'];
} else {
	redirect('/iwddshow/signin.php');
}

// get $_POST data only if it's a post request
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$name = htmlspecialchars($_POST['name']);
	$url = htmlspecialchars($_POST['url']);
	$description = htmlspecialchars($_POST['description']);
    // validate URL and make sure project name is filled before entering database
	if (empty($name) || !filter_var($url, FILTER_VALIDATE_URL)) {
		$url_status = 'Please enter valid URL (e.g. with http://)';
	} else {
		submit_project($name, $url, $description, $user_id, $local_db);
		redirect('/iwddshow');
	}
}

$title = 'Submit | IWDD Showcase';
require 'partials/header.php';

 ?>

<div class="container" id="submit">
	<br>
	<br>
	<div class="row sub-heading">
		<h4>Submit Project</h4>
		<h5>Thumbnail of your site will be automatically generated.</h5>
	</div>
	<div class="row">
      <div class="col s12 m8 l5">
        <div class="card-panel blue-grey darken-1">
          <span class="white-text">Inappropriate content will be removed :)</span>
        </div>
      </div>
    </div>
	<div class="row">
		<form action="" method="post" class="col s12 l10">
			<div class="row">
        	    <div class="input-field col s12">
        	        <input name="name" id="name" type="text" class="validate" value="<?= isset($_POST['name'])? $_POST['name'] : '' ?>" required>
        	        <label for="name">Project Name *</label>
        	    </div>
        	</div>
        	<div class="row">
        	    <div class="input-field col s12">
        	        <input name="url" id="url" type="text" class="validate" value="<?= isset($_POST['url'])? $_POST['url'] : '' ?>" required>
        	        <label for="url">Project URL (include http://) *</label>
        	        <?php if (isset($url_status)): ?>
        	        	<p class="red-text text-lighten-1"><?= $url_status; ?></p>
        	    	<?php endif; ?>
        	    </div>
        	</div>
        	<div class="row">
        	    <div class="input-field col s12">
        	        <textarea name="description" id="description" class="materialize-textarea"><?= isset($_POST['description'])? $_POST['description'] : '' ?></textarea>
        	        <label for="description">Project Description</label>
        	    </div>
        	</div>

        	<button class="btn waves-effect waves-light" type="submit" name="action">Submit
    			<i class="mdi-content-send right"></i>
  			</button>
		</form>
	</div>
</div>

<?php require 'partials/footer.php'; ?>