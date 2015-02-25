<div class="col-md-2 col-xs-12" id="postsMenu">
	<!--- Category Menu -->
	<ul id='catNav'>	
		<?php
		$categories = sqlQuery("SELECT * FROM categories");
		$currentCat = $categories[0];

		$activeClass = " active";
		foreach ($categories as $category) {
			if (isset($_GET['cat'])) {
				if (in_array($_GET['cat'], $category)) {
					$currentCat = $category;
					$activeClass = "active";
				} else {
					$activeClass = "";
				}
			} 

			$new_query_string = http_build_query(["cat" => $category['name']]);
			if (isset($_GET['p']) && $_GET['p'] == 'profile') {
				$params = array_merge($_GET, ["cat" => $category['name']]);
				unset($params['page']);
				unset($params['order']);
				$new_query_string = http_build_query($params);
			}

			print "<li><a class='$activeClass' href='index.php?" . $new_query_string . "'>" . $category['fullName'] . "</a></li>";
			
			if ($activeClass != "") :
			?>
			<!--- Order By-Menu -->
			<ul id="orderNav">
				<?php
						// Sort by
				$sortings = [
					1 => ["name" => "Högsta poäng", "query" => " ORDER BY score DESC "],
					2 => ["name" => "Heta", "query" => " AND post_date > now() - INTERVAL 48 HOUR ORDER BY score DESC ", "countQuery" => " AND post_date > now() - INTERVAL 24 HOUR "],
					3 => ["name" => "Nya", "query" => " ORDER BY post_date DESC "],
					];

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
					print "<li><a class='$activeOrder' href='index.php?" . $new_query_string . "'>" . $values['name'] . "</a></li>";
					$activeOrder = "";
				}
				?>
			</ul>
		<?php
			endif;
			$activeClass = "";
		} // end foreach category
		?>
	</ul>
</div>