<?php require "incl/header.php"; ?>

<div class="col-8">
	<h1>Lista/index</h1>

	<?php

	$result = sqlQuery("SELECT posts.*, users.username FROM `posts` JOIN users on posts.user_id = users.id");

	foreach ($result as $post) {
		if ($post['nsfw']) {
			print " ";
			print "NSFW";
		}
		print "<h4 class='post_title'>" . $post['title'] . "</h4>";
		print "<br>";
		print $post['username'];

		print "<br>";
		print "<a href='index.php?p=post&id={$post['id']}'>Kommentarer</a>";
		print "<hr>";
	}
	?>

</div>