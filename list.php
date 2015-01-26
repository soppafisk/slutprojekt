<?php require "incl/header.php"; ?>
<div class="row">
	<div class="col-8">
		<!--- Category Menu -->
		<nav id='catNav'>
		<a href='index.php?cat=all'>Allt</a>
		<?php
		$currentCat = ["id" => "%", "name" => "all", "fullName" => "Allt"];
		$categories = sqlQuery("SELECT * FROM categories");
		foreach ($categories as $category) {
			if (isset($_GET['cat'])) {
				if (in_array($_GET['cat'], $category)) {
					$currentCat = $category;
				} 
			}
			print "<a href='index.php?cat=" . $category['name'] . "'>" . $category['fullName'] . "</a>";
		}
		?>
		</nav>
		<!--- Order By Menu -->
		<?php 
		// Sort by
		$sortings = [
			1 => ["name" => "Heta", "query" => " ORDER BY score DESC "],
			2 => ["name" => "Nya", "query" => " ORDER BY post_date DESC "]
			];
		?>
		<div class="orderNav">
			<?php
			foreach ($sortings as $sorting => $values) {
				$new_query_string = http_build_query(["cat" => $currentCat['name'], "order" => $sorting]);
				print "<a href='index.php?" . $new_query_string . "'>" . $values['name'] . "</a>";
			}
			?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-8">
		<h1>Lista/index</h1>
		<?php
		// Selected category into query
		$catQuery = "";
		if ($currentCat['name'] != "all")
			$catQuery = " WHERE cat_id='" . $currentCat['id'] . "'";

		// Pagination
		if (isset($_GET['page']) && ctype_digit($_GET['page'])) {
			$currentPage = $_GET['page'];
		} else {
			$currentPage = 1;
		}

		$postCount = sqlQuery("SELECT COUNT(*) as counter FROM posts" . $catQuery)[0]["counter"];
		$postsPerPage = 5;
		$pages = ceil($postCount / $postsPerPage);
		$offset = $postsPerPage * ($currentPage-1);

		// The feed

		// Building the query
		$query = "SELECT posts.*, users.username, score ";
		if (isLoggedIn())
			$query .= ", yourvote.value ";
		$query .= "FROM `posts`";
		
		$query .= "INNER JOIN users 
			ON posts.user_id = users.id 
			LEFT JOIN 
				(SELECT post_id, (SUM(coalesce(value,0))) as score 
				FROM votes GROUP BY post_id) v 
			ON posts.id = v.post_id ";
		if (isLoggedIn())
			$query .= "LEFT JOIN 
				(SELECT post_id, value FROM votes
				WHERE user_id = '" . $_SESSION['user']['id'] . "') yourvote
				ON posts.id = yourvote.post_id ";

		$singleUserQuery = "WHERE user_id = 4 "; 
		$query .= $catQuery . $singleUserQuery;
		if (isset($_GET['order']) && array_key_exists($_GET['order'], $sortings)) {
			$query .= $sortings[$_GET['order']]['query'];
		} else {
			$query .= $sortings['1']['query'];
		}
		$query .= "LIMIT $offset, $postsPerPage";

		print $query;

		$result = sqlQuery($query);

		foreach ($result as $post) {
			include "incl/postbox.php";
		}

		// Pagination links
		print "<div class='row pagination'>";
		print "<div class='col-3'>";
		if ($currentPage <= $pages && $currentPage > 1) {
			$params = array_merge($_GET, array("page" => $currentPage-1));
			$new_query_string = http_build_query($params);
			print "<a href='index.php?" . $new_query_string . "' class='leftPag'>Föregående sida</a>";
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
			$params = array_merge($_GET, ["page" => $currentPage+1]);
			$new_query_string = http_build_query($params);
			print "<a href='index.php?" . $new_query_string . "' class='rightPag'>Nästa sida</a>";
		}
		print "</div>";
		print "</div>";
		?>
	</div>
</div> 