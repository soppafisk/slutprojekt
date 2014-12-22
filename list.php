<?php require "incl/header.php"; ?>

<div class="col-8">
	<h1>Lista/index</h1>

	<?php

	$result = sqlQuery("SELECT posts.*, users.username FROM `posts` JOIN users on posts.user_id = users.id");

	foreach ($result as $post) {
		print $post['title'];
		print $post['username'];
		if ($post['nsfw'])
			print "NSFW";
		print "<br>";
		print "<a href='index.php?p=post&id={$post['id']}'>Kommentarer</a>";
		print "<hr>";
	}
	?>

</div>