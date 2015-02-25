<div class="postbox row">

	<div class="col-xs-2">

		<?php 
			$hasVoted = "";
			if (isset($post['value']) && ($post['value'] == 1 || $post['value'] == -1))
				$hasVoted = " hasVoted_" . $post['value'];
		?>

		<div class="up arrow <?php print "post_" . $post['id'] . "$hasVoted"; ?>"></div>
		<div class="score"><?php $post['score'] !== null ? print $post['score'] : print "Inga röster";?></div>
		<div class="down arrow <?php print "post_" . $post['id'] . "$hasVoted"; ?>"></div>


	</div>
	<div class="col-xs-10">
		<h4 class='post_title'>
			<?php
				if ($post['nsfw']) {
					print "<span class='nsfw'>NSFW</span>";
				}
			?>
			<a href='<?php print $post['link']; ?>'><?php print $post['title']; ?></a>
		</h4>
		Av: <?php print "<a href='index.php?p=profile&u={$post['username']}'>{$post['username']}</a>"; ?>

		<br>
		<a href='index.php?p=post&id=<?php print $post['id']; ?>'>Kommentarer</a>
	</div>
</div>
<hr>