<div class="row">
	<div class="col-md-12">
		<!--- Category Menu -->
		<nav id='catNav'>		
		<?php
		$params = array_merge($_GET, ["cat" => "all"]);
		unset($params['page']);
		unset($params['order']);
		$new_query_string = http_build_query($params);
		
		$categories = sqlQuery("SELECT * FROM categories");
		$currentCat = $categories[0];

		$activeClass = " active";
		foreach ($categories as $category) {
			if (isset($_GET['cat'])) {
				if (in_array($_GET['cat'], $category)) {
					$currentCat = $category;
					$activeClass = " active";
				} else {
					$activeClass = "";
				}
			} 

			$params = array_merge($_GET, ["cat" => $category['name']]);
			unset($params['page']);
			unset($params['order']);
			$new_query_string = http_build_query($params);
			print "<a class='btn btn-default $activeClass' role='button' href='index.php?" . $new_query_string . "'>" . $category['fullName'] . "</a>";
			$activeClass = "";
		}
		?>
		</nav>
		<!--- Order By-Menu -->
		<?php 
		// Sort by
		$sortings = [
			1 => ["name" => "Högsta poäng", "query" => " ORDER BY score DESC "],
			2 => ["name" => "Heta", "query" => " AND post_date > now() - INTERVAL 48 HOUR ORDER BY score DESC ", "countQuery" => " AND post_date > now() - INTERVAL 24 HOUR "],
			3 => ["name" => "Nya", "query" => " ORDER BY post_date DESC "],
			];
		?>

		<nav id="orderNav">
			<?php
			$activeOrder = "active";
			foreach ($sortings as $sorting => $values) {
							
				if (isset($_GET['order'])) {
					if ($_GET['order'] == $sorting) {
						$activeOrder = "active";
					} else {
						$activeOrder = "";
					}
				}
					
				
				$params = array_merge($_GET, ["cat" => $currentCat['name'], "order" => $sorting]);
				unset($params['page']);
				$new_query_string = http_build_query($params);
				print "<a class='btn btn-default $activeOrder' href='index.php?" . $new_query_string . "'>" . $values['name'] . "</a>";
				$activeOrder = "";
			}
			?>
		</nav>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
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
			FROM posts JOIN users ON posts.user_id = users.id" . $catQuery . $singleUserQuery;
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

			$query .= $catQuery . $singleUserQuery;
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
		} // if $postCount != 0
		?>
	</div>
</div> 