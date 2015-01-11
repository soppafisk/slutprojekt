<div class="postbox row">

	<div class="col-2">
		<div class="uparrow"></div>
		<div class="downarrow"></div>
		<?php
			if ($post['nsfw']) {
				print "NSFW";
			}
		?>
	</div>
	<div class="col-10">
		<h4 class='post_title'><a href='<?php print $post['link']; ?>'><?php print $post['title']; ?></a></h4>
		Av: <?php print "<a href='index.php?p=profile&u={$post['username']}'>{$post['username']}</a>"; ?>

		<br>
		<a href='index.php?p=post&id=<?php print $post['id']; ?>'>Kommentarer</a>
	</div>
</div>
<hr>