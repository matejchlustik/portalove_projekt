<?php
include_once "db_connect.php";

$db = $GLOBALS['db'];

if (isset($_POST['submit'])) {

    $register = $db->register($_POST['username'], $_POST['password'], $_POST['img'],  $_POST['first_name'], $_POST['last_name']);

    if ($register !== "Username already taken") {
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $register;
        unset($_SESSION['message']);
        header('Location: index.php');
    } else {
        $_SESSION['auth'] = false;
        $_SESSION['message'] = $register;
        header('Location: register_form.php');
    }
} else {
    header('Location: register_form.php');
}
