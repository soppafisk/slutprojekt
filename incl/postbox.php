<div class="postbox row">

	<div class="col-2">

		<?php 
			$hasVoted = "";
			if ($post['value'] == 1 || $post['value'] == -1)
				$hasVoted = "hasVoted";
			?>
		<div class="up arrow <?php print $hasVoted . " post_" . $post['id']; ?>"></div>
		<div class="score"><?php $post['score'] !== null ? print $post['score'] : print "Inga röster";?></div>
		<div class="down arrow <?php print $hasVoted . " post_" . $post['id']; ?>"></div>
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