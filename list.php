<?php require "incl/header.php"; ?>

<div class="col-8">
	<h1>Lista/index</h1>

	<?php
	$postCount = sqlQuery("SELECT COUNT(*) FROM posts")[0]["COUNT(*)"];
	$postsPerPage = 3;
	$pages = ceil($postCount / $postsPerPage);
	
	print $pages;
	$result = sqlQuery("SELECT posts.*, users.username FROM `posts` JOIN users on posts.user_id = users.id");

	foreach ($result as $post) {
		include "incl/postbox.php";
	}
	?>
</div>