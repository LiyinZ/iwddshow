<?php 

require 'functions/main.php';

$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

// making sure query string is set
if (isset($_GET['order'])) {
	$conn = connect($local_db);
	$projects = get_projects($conn, $_GET['order']);
} else {
	// otherwise default to order by author A-Z
	$conn = connect($local_db);
	$_GET['order'] = 'author_az';
	$projects = get_projects($conn, 'author_az');
}

$title = 'All projects | IWDD Showcase';
require 'partials/header.php';

 ?>

<div class="container" id="viewall">
	<br>
	<div class="section row">
		<div class="col s12 m4 l3">
			<h4><?= get_heading($_GET['order']); ?></h4>
		</div>

		<form class="col s12 m8 l5">
			<div class="row">
				<div class="col s8">
					<select name="order" id="order">
						<option value="author_az">Author A-Z</option>
						<option <?= is_selected($_GET['order'], 'views_most'); ?> value="views_most">Most Viewed</option>
						<option <?= is_selected($_GET['order'], 'name_az'); ?> value="name_az">Project Name A-Z</option>
						<option <?= is_selected($_GET['order'], 'latest'); ?> value="latest">Latest</option>
						<option disabled></option>
						<option <?= is_selected($_GET['order'], 'author_za'); ?> value="author_za">Author Z-A</option>
						<option <?= is_selected($_GET['order'], 'views_least'); ?> value="views_least">Least Viewed</option>
						<option <?= is_selected($_GET['order'], 'name_za'); ?> value="name_za">Project Name Z-A</option>
						<option <?= is_selected($_GET['order'], 'oldest'); ?> value="oldest">Oldest</option>
					</select>
				</div>
				<div class="col s4">
					<button class="btn waves-effect waves-light" type="submit">
						Sort
  					</button>
				</div>
			</div>
		</form>
	</div>
	<main class="section row">
		<?php foreach($projects as $project): ?>
		<div class="col s12 m6 l4">
       	    <div class="card">
       	        <div class="card-image waves-effect waves-block waves-light">
       	            <img class="activator" src="https://api.thumbalizr.com/?url=<?= $project['url']; ?>&width=300">
       	        </div>
       	        <div class="card-content">
       	            <span class="card-title activator grey-text text-darken-4">
   	            		<span class="activator"><?= $project['name']; ?></span>
                        <i class="mdi-navigation-more-vert right"></i>
       	            </span>
       	            <p>By <?php if (empty($project['user_url'])): ?>
							<?= $project['first_name'] . ' ' . $project['last_name']; ?>
       	            <?php else: ?>
       	            	<a class="author" href="<?= $project['user_url']; ?>">
       	            		<?= $project['first_name'] . ' ' . $project['last_name']; ?>
       	            	</a>
       	            <?php endif; ?>
       	        	</p>
       	            <p>
       	            	<a href="/iwddshow/functions/view_count.php?url=<?= $project['url']; ?>">Visit Link</a>
       	            	<i id="<?= $project['project_id'] ?>" onclick="like_add(<?= $project['project_id'] ?>)" class="mdi-action-favorite right"> <?= $project['likes'] ?></i>
       	            	<i class="mdi-image-remove-red-eye right"> <?= $project['view_count']; ?></i>
       	            </p>
       	        </div>
       	        <div class="card-reveal">
       	            <span class="card-title grey-text text-darken-4">
       	            	<?= $project['name']; ?>
       	            	 <i class="mdi-navigation-close right"></i></span>
       	            <p><?= $project['description']; ?></p>
       	        </div>
       	    </div>
       	</div> <!-- end of col -->
       	<?php endforeach; $conn = null; ?>

	</main><!-- end of row -->
</div>
<br>

 <?php require 'partials/footer.php'; ?>