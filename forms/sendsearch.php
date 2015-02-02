<?php

require "../config.php";
require "../functions/functions.php";
$search = "";
if (isset($_GET['s'])) {
	$search = $_GET['s'];
}

session_start();
$query = "SELECT DISTINCT posts.*, users.username, score";
if (isLoggedIn()) {
	$query .= ", yourvote.value";
}
$query .=	" FROM posts 
		INNER JOIN users 
		ON posts.user_id = users.id 
		LEFT JOIN (SELECT post_id, SUM(value) as score
			FROM votes GROUP BY post_id) v
		ON posts.id = v.post_id"; 
if (isLoggedIn()) {
	$query .= " LEFT JOIN 
				(SELECT post_id, value FROM votes
				WHERE user_id = '" . $_SESSION['user']['id'] . "') yourvote
				ON posts.id = yourvote.post_id ";
}
$query .= " WHERE (posts.link LIKE '%{$search}%' OR posts.title LIKE '%{$search}%')
		ORDER BY score DESC ";

$posts = sqlQuery($query);

foreach ($posts as $post) {
	include "../incl/postbox.php";
}