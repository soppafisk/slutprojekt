<?php
session_start();
require_once "../config.php";
require_once "../functions/functions.php";
require_once "../incl/header.php";


$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
if ($mysqli->connect_errno) {
    print "Kunde inte ansluta till databasen (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$stmt = $mysqli->prepare("INSERT INTO posts (title, link, content, nsfw, user_id, cat_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssssii', $title, $link, $content, $nsfw, $user_id, $cat_id);

$title 	= $mysqli->real_escape_string($_POST['title']);

if (filter_var($_POST['link'], FILTER_VALIDATE_URL)) {
	$link 	= $_POST['link'];
}

$content= $mysqli->real_escape_string($_POST['content']);

if (isset($_POST['nsfw'])) {
	$nsfw = true;
} else {
	$nsfw = false;
}

$user_id = $_SESSION['user']['id'];
$cat_id = 1;

if (!$stmt->execute()) {
	print $mysqli->error;
	die;
}
$stmt->close();

$mysqli->close();



var_dump($_SESSION);

var_dump($_POST);