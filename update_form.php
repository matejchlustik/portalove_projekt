<?php
include_once "db_connect.php";
if (isset($_SESSION['auth']) && $_SESSION['auth'] !== true) {
    header('Location: index.php');
}
$db = $GLOBALS['db'];

if (!isset($_GET['id'])) {
    header('Location: profile.php');
}


$categories = $db->getCategories();
$post = $db->getPost($_GET['id']);


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

    <div style="display:flex;align-items:center;justify-content:center;margin: 100px auto;flex-direction:column;width:65%">
        <form method="POST" action="update.php?id=<?php echo $_GET['id'] ?>" class="mb-5" style="width:40%;margin:0 auto;">
            <h2 class="tm-color-primary tm-post-title mb-4">Add Post</h2>
            <div class="mb-4">
                <label class="col-sm-3 col-form-label  tm-color-primary" style="padding-left:0;max-width:100%;">Title</label>
                <input class="form-control" name="title" type="text" value="<?php echo $post['title'] ?>" required>
            </div>
            <div class="mb-4">
                <label class="col-sm-3 col-form-label  tm-color-primary" style="padding-left:0;max-width:100%;">Image</label>
                <input class="form-control" name="img" type="text" value="<?php echo $post['img'] ?>" required>
            </div>
            <div class="mb-4">
                <label class="col-sm-3 col-form-label  tm-color-primary" style="padding-left:0;max-width:100%;">Content</label>
                <textarea class="form-control" name="content" rows="6" required><?php echo $post['content'] ?></textarea>
            </div>
            <div class="mb-4">
                <h5 class="tm-color-primary mb-4">Categories</h5>
                <?php foreach ($categories as $categoryName => $categoryId) : ?>
                    <div class="mb-4" style="display:flex;justify-content:space-between;">
                        <label class="col-form-label  tm-color-primary" style="padding-left:0;max-width:100%;"><?php echo $categoryName ?></label>
                        <input class="tm-btn tm-btn-primary tm-btn-small" type="checkbox" name="<?php echo "{$categoryId}" ?>" style="margin-right:20px;" <?php foreach ($post['categories'] as $postCategory) {
                                                                                                                                                                if ($postCategory === $categoryName) echo "checked";
                                                                                                                                                            } ?>>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-right">
                <input class="tm-btn tm-btn-primary tm-btn-small" type="submit" name="submit" value="Submit">
            </div>
        </form>
    </div>

</body>

</html>