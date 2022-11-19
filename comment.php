<?php
include_once "db_connect.php";

$db = $GLOBALS['db'];

if (isset($_POST['submit'])) {

    $comment = $db->addComment($_POST['comment'], $_POST['id']);
    header("Location: post.php?id={$_POST['id']}");
} else {
    header("Location: post.php?id={$_POST['id']}");
}
