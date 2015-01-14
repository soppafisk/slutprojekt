<?php require "incl/header.php"; ?>

<div class="col-8">
	<h1>Lista/index</h1>
	<?php
		// Pagination
	if (isset($_GET['page']) && ctype_digit($_GET['page'])) {
		$currentPage = $_GET['page'];
	} else {
		$currentPage = 1;
	}
	$postCount = sqlQuery("SELECT COUNT(*) FROM posts")[0]["COUNT(*)"];
	$postsPerPage = 10;
	$pages = ceil($postCount / $postsPerPage);
	$offset = $postsPerPage * ($currentPage-1);

	// The feed
	$result = sqlQuery(
		"SELECT posts.*, users.username 
		FROM `posts` 
		JOIN users on posts.user_id = users.id
		LIMIT $offset , $postsPerPage"
		);

	foreach ($result as $post) {
		include "incl/postbox.php";
	}

	// Pagination links
	print "<div class='row pagination'>";
	print "<div class='col-3'>";
	if ($currentPage <= $pages && $currentPage > 1)
		print "<a href='index.php?page=" . ($currentPage-1) . "' class='leftPag'>Föregående sida</a>";
	
	print "</div>";
	print "<div class='col-6 nrPag'>";
	
	for ($i = 0; $i < $pages; $i++) {
		if ($i+1 == $currentPage) {
			print "<a href='index.php?page=" . ($i+1) . "' class='bold'>" . ($i+1) . "</a>";
		} else {
			print "<a href='index.php?page=" . ($i+1) . "' class=''>" . ($i+1) . "</a>";
		}
	}
	print "</div>";
	print "<div class='col-3'>";
	if ($currentPage < $pages)
		print "<a href='index.php?page=" . ($currentPage+1) . "' class='rightPag'>Nästa sida</a>";
	print "</div>";
	print "</div>";
	?>
</div>