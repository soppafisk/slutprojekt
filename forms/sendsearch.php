<?php
require "../config.php";
require "../functions/functions.php";
$search = "";
if (isset($_GET['s'])) {
	$search = $_GET['s'];
}

$posts = sqlQuery("SELECT DISTINCT posts.*, users.username FROM posts INNER JOIN users ON posts.user_id = users.id WHERE (posts.link LIKE '%{$search}%' OR posts.title LIKE '%{$search}%')");

foreach ($posts as $post) {
	include "../incl/postbox.php";
}