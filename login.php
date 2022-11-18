<?php
include_once "db_connect.php";

$db = $GLOBALS['db'];

if (isset($_POST['submit'])) {

    $login = $db->login($_POST['username'], $_POST['password']);
    if ($login !== "Wrong credentials") {
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $login;
        unset($_SESSION['message']);
        header('Location: index.php');
    } else {
        $_SESSION['auth'] = false;
        $_SESSION['message'] = $login;
        header('Location: login_form.php');
    }
} else {
    header('Location: login_form.php');
}
