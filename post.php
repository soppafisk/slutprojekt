<?php require_once "incl/header.php"; ?>
<div class="row">
<?php require "incl/postsmenu.php"; ?>
<div class="col-xs-12 col-md-7">

<?php

if (isset($_GET['id'])) {
	$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
	
	$result = sqlQuery("SELECT posts.*, users.username FROM posts JOIN users on posts.user_id = users.id and posts.id='$id' WHERE deleted=0");
	$post = $result[0];

	$comments = sqlQuery("SELECT comments.*, users.username FROM comments JOIN users on comments.user_id = users.id and comments.post_id='$id'");
}

// If its your post, you 
$adminPost = false;
if (isLoggedIn()) {
	if ($_SESSION['user']['id']==$post['user_id']) {
		$adminPost = true;
		$_SESSION['post']['id'] = $post['id'];
	}
}

if ($post['nsfw'] == true) {
	print "<div class='nsfw'>Not Safe For Work</div>";
}
?>

<?php print "<h1 class='post_title'><a href='" . $post['link'] .  "'>" . $post['title'] . "</a></h1>"; ?>
<p>Av <?php print "<a href='index.php?p=profile&u={$post['username']}'>{$post['username']}</a><br>" . $post['post_date']; ?></p>
<p class='single-post content'> 
<?php print $post['content']; ?> 
</p>
<?php 
if ($adminPost) {
	print "<a href='index.php?p=delete'>Ta bort post</a>";
}

if (isLoggedIn()) {
	$_SESSION['commentOnPost'] = $post['id'];
?>
	<form action="posts/commentsend.php" method="POST">
		<div class="form-group">
			<label for="content">Kommentera: (Inloggad som <?php print $_SESSION['user']['username']; ?>) </label>
			<textarea name="content" class="form-control" rows="3"></textarea>
		</div>
		<input type="submit" class="btn btn-default" value="Skicka">
	</form>

<?php
	if (isset($_SESSION['feedback'])) {
		print $_SESSION['feedback']['message'];
		unset($_SESSION['feedback']);
	}
} else {
	print "<a href='index.php?p=login'>Logga in</a> för att kommentera";
}
?>
<hr>

		<?php
		if (!$comments) {
			print "Inga kommentarer än";
		}

		foreach ($comments as $comment) :
			?>

			<div class="well comment">
				<div class="comment-top">
					<?php print "<a href='index.php?p=profile&u={$comment['username']}'>{$comment['username']}</a>"; ?>
					<?php print "<span class='right'>" . $comment['comment_date'] . "</span>"; ?>
				</div>
				<p><?php print $comment['content']; ?></p>
			</div>

		<?php endforeach;

		?>
</div>
</div>