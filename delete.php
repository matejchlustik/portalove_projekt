<?php
include_once "db_connect.php";
$db = $GLOBALS['db'];
if (!isset($_SESSION['auth']) || !$_SESSION['auth'] === true) {
    header('Location: login_form.php');
}

if (isset($_GET['id'])) {
    $delete = $db->deletePost($_GET['id']);

    if ($delete) {
        header('Location: profile.php');
    } else {
        echo "error";
    }
} else {
    header('Location: profile.php');
}
