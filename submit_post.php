<?php
include_once "db_connect.php";

$db = $GLOBALS['db'];

if (isset($_POST['submit'])) {
    unset($_POST['submit']);

    $post = $db->addPost($_POST);
    if ($post) {
        header('Location: index.php');
    } else {
        echo "There was an error";
    }
}
