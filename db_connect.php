<?php
include_once "db.php";

use portalove\DB;

$db = new DB("localhost", "portalove_projekt", "root", "", 3306);

global $db;

session_start();
