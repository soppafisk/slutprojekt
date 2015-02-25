<?php require "incl/postsmenu.php"; ?>
<div class="col-md-7 col-xs-12">
	<?php
	// Selected category into query
	$catQuery = " WHERE cat_id LIKE '%'";
	if ($currentCat['name'] != "all")
		$catQuery = " WHERE cat_id='" . $currentCat['id'] . "'";

	if (isset($_GET['order']) && array_key_exists($_GET['order'], $sortings)) {
		$orderQuery = $sortings[$_GET['order']]['query'];
	} else {
		$orderQuery = $sortings['1']['query'];
	}

	// Pagination
	if (isset($_GET['page']) && ctype_digit($_GET['page'])) {
		$currentPage = $_GET['page'];
	} else {
		$currentPage = 1;
	}

	// query for counting posts
	$countQuery = "SELECT username, COUNT(*) as counter 
		FROM posts JOIN users ON posts.user_id = users.id" . $catQuery . "AND deleted=0" . $singleUserQuery;
	// best lazy fix ever
	if ($orderQuery == $sortings['2']['query']) {
		$countQuery .= $sortings['2']['countQuery'];
	}
	
	$postCount = sqlQuery($countQuery)[0]["counter"];

	if ($postCount == 0) {
		print "Här var det tomt";
	} else {
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
				(SELECT post_id, SUM(value) as score 
				FROM votes GROUP BY post_id) v 
			ON posts.id = v.post_id ";
		if (isLoggedIn())
			$query .= "LEFT JOIN 
				(SELECT post_id, value FROM votes
				WHERE user_id = '" . $_SESSION['user']['id'] . "') yourvote
				ON posts.id = yourvote.post_id ";

		$query .= $catQuery . "AND deleted=0" . $singleUserQuery;
		$query .= $orderQuery;

		$query .= "LIMIT $offset, $postsPerPage";

		// Run query
		$result = sqlQuery($query);

		foreach ($result as $post) {
			$ownPost = false;
			if (isLoggedIn()) {
				if ($_SESSION['user']['username'] == $post['username']){
					$ownPost = true;
				}
			}
			include "incl/postbox.php";
		}

		// Pagination links
		print "<div class='row'>";
		print "<div class='col-xs-12'>";
		print "<nav>";
		print "<ul class='pagination'>";
		$params = array_merge($_GET, array("page" => $currentPage-1));
		$new_query_string = http_build_query($params);
		$disabled = "class='disabled'";
		if ($currentPage <= $pages && $currentPage > 1) {
			$disabled = "";
		}
		print "<li $disabled ><a disabled href='index.php?" . $new_query_string . "' class='leftPag'>Föregående sida</a></li>";
		
		for ($i = 0; $i < $pages; $i++) {
			if ($i+1 == $currentPage) {
				print "<li class='active'><a href='index.php?page=" . ($i+1) . "' >" . ($i+1) . "</a></li>";
			} else {
				print "<li><a href='index.php?page=" . ($i+1) . "' class=''>" . ($i+1) . "</a></li>";
			}
		}

		$params = array_merge($_GET, ["page" => $currentPage+1]);
		$new_query_string = http_build_query($params);	
		$disabled = "class='disabled'";	
		if ($currentPage < $pages) {
			$disabled = "";
		}
		print "<li $disabled ><a href='index.php?" . $new_query_string . "' class='rightPag'>Nästa sida</a></li>";

		print "</ul>";
		print "</nav>";
		print "</div>";
		print "</div>";
	} // if $postCount != 0
	?>
</div>