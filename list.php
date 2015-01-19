<?php require "incl/header.php"; ?>
<div class="row">
	<div class="col-8">
		<?php 
		$currentCat = ["id" => "%", "name" => "all", "fullName" => "Allt"];
		$categories = sqlQuery("SELECT * FROM categories");

		// Category Menu
		print "<nav id='catNav'>";
		print "<a href='index.php?cat=all'>Allt</a>";
		foreach ($categories as $category) {
			if (isset($_GET['cat'])) {
				if (in_array($_GET['cat'], $category)) {
					$currentCat = $category;
				} 
			}
			print "<a href='index.php?cat=" . $category['name'] . "'>" . $category['fullName'] . "</a>";
		}
		print "</nav>";

		?>

	</div>
</div>
<div class="row">
	<div class="col-8">
		<h1>Lista/index</h1>
		<?php
			// Pagination
		if (isset($_GET['page']) && ctype_digit($_GET['page'])) {
			$currentPage = $_GET['page'];
		} else {
			$currentPage = 1;
		}
		$catQuery = "";
		if ($currentCat['name'] != "all")
			$catQuery = " WHERE cat_id='" . $currentCat['id'] . "'";

		$postCount = sqlQuery("SELECT COUNT(*) FROM posts" . $catQuery)[0]["COUNT(*)"];
		$postsPerPage = 5;
		$pages = ceil($postCount / $postsPerPage);
		$offset = $postsPerPage * ($currentPage-1);

		// The feed
		$catQuery = "";
		if ($currentCat['name'] != "all")
			$catQuery = "AND cat_id='" . $currentCat['id'] . "'";

		$result = sqlQuery(
			"SELECT posts.*, users.username 
			FROM `posts` 
			JOIN users on posts.user_id = users.id
			$catQuery
			LIMIT $offset , $postsPerPage"
		);

		foreach ($result as $post) {
			include "incl/postbox.php";
		}

		// Pagination links
		print "<div class='row pagination'>";
		print "<div class='col-3'>";
		if ($currentPage <= $pages && $currentPage > 1) {
			$params = array_merge($_GET, array("page" => $currentPage-1));
			$new_query_string = http_build_query($params);
			print "<a href='index.php?page=" . $new_query_string . "' class='leftPag'>Föregående sida</a>";
		}
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
		if ($currentPage < $pages) {
			$params = array_merge($_GET, array("page" => $currentPage+1));
			$new_query_string = http_build_query($params);
			print "<a href='index.php?" . $new_query_string . "' class='rightPag'>Nästa sida</a>";
		}
		print "</div>";
		print "</div>";
		?>
	</div>
</div> 