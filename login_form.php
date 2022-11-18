<?php
include_once "db_connect.php";
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
    <div style="display:flex;width:50%;align-items:center;justify-content:center;margin: 100px auto;flex-direction:column;">
        <form method="POST" action="login.php" class="mb-5 tm-comment-form">
            <h2 class="tm-color-primary tm-post-title mb-4">Sign in</h2>
            <div class="mb-4">
                <label class="col-sm-3 col-form-label  tm-color-primary" style="padding-left:0;max-width:100%;">Username</label>
                <input class="form-control" name="username" type="text" required>
            </div>
            <div class="mb-4">
                <label class="col-sm-3 col-form-label  tm-color-primary" style="padding-left:0;max-width:100%;">Password</label>
                <input class="form-control" name="password" type="password" required>
            </div>
            <?php if (isset($_SESSION['message']) && $_SESSION['message'] === 'Wrong credentials') {
                echo "<p class='col-form-label' style='max-width:100%;margin: 0 auto;color:#ad241a;'>{$_SESSION['message']}</p>";
            } ?>
            <div>
                <input class="tm-btn tm-btn-primary tm-btn-small" type="submit" name="submit" value="Submit">
            </div>
        </form>
        <p class="col-form-label" style="max-width:100%;margin: 0 auto;">Don't have an account yet? <a class="tm-color-primary" href="register_form.php">Register now</a></p>
    </div>
</body>

</html>