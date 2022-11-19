<?php
include_once "db.php";

use portalove\DB;

$db = new DB("localhost", "portalove_projekt", "root", "", 3306);

global $db;
//TODO: ADD REDIRECT TO AUTH ROUTES IF $_SESSION['auth'] IS NOT SET
session_start();
