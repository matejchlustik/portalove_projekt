<?php
include_once "db_connect.php";
$db = $GLOBALS['db'];
if (!isset($_SESSION['auth']) || !$_SESSION['auth'] === true) {
    header('Location: login_form.php');
}

$posts = $db->getPostsByUser($_SESSION['user_id']);

//TODO: pridavanie, mazanie editovanie postov
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xtra Blog</title>
    <link rel="stylesheet" href="fontawesome/css/all.min.css"> <!-- https://fontawesome.com/ -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet"> <!-- https://fonts.google.com/ -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/templatemo-xtra-blog.css" rel="stylesheet">
</head>

<body>
    <header class="tm-header" id="tm-header">
        <div class="tm-header-wrapper">
            <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="tm-site-header">
                <div class="mb-3 mx-auto tm-site-logo"><i class="fas fa-times fa-2x"></i></div>
                <h1 class="text-center">Xtra Blog</h1>
            </div>
            <nav class="tm-nav" id="tm-nav">
                <ul>
                    <?php include_once('nav_bar.php'); ?>
                </ul>
            </nav>
            <div class="tm-mb-65">
                <a rel="nofollow" href="https://fb.com/templatemo" class="tm-social-link">
                    <i class="fab fa-facebook tm-social-icon"></i>
                </a>
                <a href="https://twitter.com" class="tm-social-link">
                    <i class="fab fa-twitter tm-social-icon"></i>
                </a>
                <a href="https://instagram.com" class="tm-social-link">
                    <i class="fab fa-instagram tm-social-icon"></i>
                </a>
                <a href="https://linkedin.com" class="tm-social-link">
                    <i class="fab fa-linkedin tm-social-icon"></i>
                </a>
            </div>
            <p class="tm-mb-80 pr-5 text-white">
                Xtra Blog is a multi-purpose HTML template from TemplateMo website. Left side is a sticky menu bar. Right side content will scroll up and down.
            </p>
        </div>
    </header>
    <div class="container-fluid">
        <main class="tm-main">
            <a class="tm-btn tm-btn-primary tm-btn-small" href="post_form.php">Add Post</a>
            <div style="margin-top: 15px;">
                <?php foreach ($posts as $post) : ?>
                    <div style="display:flex;flex-direction:row;width:75%;margin-right:auto;margin-bottom:8px;">
                        <div style="margin-right:30px;width:25%;"><a class="tm-post-link" href="post.php?id=<?php echo $post['id'] ?>"><?php echo $post['id'] ?></a></div>
                        <div style="margin-right:30px;width:25%;"><?php echo $post['title'] ?></div>
                        <div style="margin-right:30px;width:25%;">
                            <?php $phpdate = strtotime($post['created_at']);
                            echo date("F j, Y", $phpdate);
                            ?>
                        </div>
                        <a href="delete.php?id=<?php echo $post['id'] ?>" style="text-decoration:none;color:white;">
                            <div class="tm-btn tm-btn-primary tm-btn-small" style="margin-right:10px;">
                                Delete
                            </div>
                        </a>
                        <a href="update_form.php?id=<?php echo $post['id'] ?>" style="text-decoration:none;color:white;">
                            <div class="tm-btn tm-btn-primary tm-btn-small" style="margin-right:10px;">
                                Update
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

</body>

</html>