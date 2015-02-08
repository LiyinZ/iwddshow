<?php 

require 'functions/main.php';

$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

// $_SESSION['ip'] = "173.224.120.84"; // test

$conn = connect($local_db);

// fetch projects and order by most views and most recent
$popular = get_projects($conn, 'views_most', 3);
$latest = get_projects($conn, 'latest', 3);

$title = 'IWDD Showcase | Share & Learn';

require 'partials/header.php';
include 'partials/intro.php';
?>

<div class="container">
    <div class="section" id="popular">
    	<div class="row sub-heading">
    		<a href="/iwddshow/all.php?order=latest">View All</a>
    		<h4>Latest</h4>
    	</div>

        <div class="row">
		<?php foreach($latest as $project): ?>
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
                            <i onclick="like_add(<?= $project['project_id'] ?>)" class="mdi-action-favorite right <?= 'project-' . $project['project_id'] ?>"> <?= $project['likes'] ?></i>
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
        <?php endforeach; ?>

        </div> <!-- end of row -->
    </div> <!-- end of section -->
    <br>
    <hr>
    <br>
    <div class="section" id="latest">
    	<div class="row sub-heading">
    		<a href="/iwddshow/all.php?order=views_most">View All</a>
    		<h4>Popular</h4>
    	</div>

		<div class="row">	
		<?php foreach($popular as $project): ?>
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
                            <i onclick="like_add(<?= $project['project_id'] ?>)" class="mdi-action-favorite right <?= 'project-' . $project['project_id'] ?>"> <?= $project['likes'] ?></i>
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

        </div> <!-- end of row -->
    </div> <!-- end of section -->
    </div>

<?php require 'partials/footer.php' ?>