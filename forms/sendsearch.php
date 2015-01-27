<?php
require "../config.php";
require "../functions/functions.php";
$search = "";
if (isset($_GET['s'])) {
	$search = $_GET['s'];
}

$posts = sqlQuery("SELECT DISTINCT posts.*, users.username, score
		FROM posts 
		INNER JOIN users 
		ON posts.user_id = users.id 
		LEFT JOIN (SELECT post_id, SUM(value) as score
			FROM votes GROUP BY post_id) v
		ON posts.id = v.post_id 
		WHERE (posts.link LIKE '%{$search}%' OR posts.title LIKE '%{$search}%')
		ORDER BY score DESC ");

foreach ($posts as $post) {
	include "../incl/postbox.php";
}