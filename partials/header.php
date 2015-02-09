<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
    <title><?= $title; ?></title>
    <link rel="shortcut icon" href="/iwddshow/favicon.ico" />
    <!-- CSS  -->
    <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
</head>

<body>
    <div class="navbar-fixed">
        <ul id="logout" class="dropdown-content">
            <li><a href="/iwddshow/functions/logout.php">Log Out</a>
            </li>
        </ul>
        <nav class="light-blue lighten-1" role="navigation">
            <div class="container">
                <div class="nav-wrapper"><a id="logo-container" href="/iwddshow" class="brand-logo">IWDD <i class="mdi-action-polymer"></i></a>
                    <ul id="nav-mobile" class="right side-nav">
                        <li><?= is_admin()? '<a href="/iwddshow/admin.php">Admin</a>' : ''; ?></li>
                        <li><a href="/iwddshow/submit.php"><i class="mdi-content-add-circle"></i></a></li>
                        <li><a href="#about" onclick="toast('See About info in footer.', 4000)">About</a>
                        </li>
                        <li>
                            <?php if (is_logged_in()): ?>
                                <li><a class="dropdown-button" href="#!" data-activates="logout">Hi, <?= $_SESSION['first_name']; ?>!<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
                            <?php else: ?>
                                <a href="/iwddshow/signin.php">Sign In</a>
                            <?php endif; ?>
                            
                        </li>
                    </ul><a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
                </div>
            </div>
        </nav>
    </div>
    <!-- End of Nav bar -->