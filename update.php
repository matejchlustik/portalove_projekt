<?php
include_once "db_connect.php";
$db = $GLOBALS['db'];
if (!isset($_SESSION['auth']) || !$_SESSION['auth'] === true) {
    header('Location: login_form.php');
}

if (isset($_POST['submit'])) {
    $update = $db->updatePost($_POST, $_GET['id']);

    if ($update) {
        header('Location: profile.php');
    } else {
        echo "FATAL ERROR!!";
    }
} else {
    header('Location: profile.php');
}
