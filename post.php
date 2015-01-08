<?php require_once "incl/header.php"; ?>

<div class="col-8">

<?php

if (isset($_GET['id'])) {
	$id = filter_var($_GET['id'], FILTER_SANITIZE_INT);
	
	$result = sqlQuery("SELECT posts.*, users.username FROM posts JOIN users on posts.user_id = users.id and posts.id='$id'");
	$post = $result[0];

	$comments = sqlQuery("SELECT comments.*, users.username FROM comments JOIN users on comments.user_id = users.id and comments.post_id='$id'");
}


?>

<h1>POST</h1>
<?php 
if ($post['nsfw'] == true) {
	print "NSFW <br>";
}

print "<h4 class='post_title'><a href='" . $post['link'] .  "'>" . $post['title'] . "</a></h4>";
print "Av " . $post['username'] . " den " . $post['post_date'];
print "<p class='single-post content'>"; 
print $post['content']; 
print "</p>";


if (isLoggedIn()) {
	print "(Inloggad som " . $_SESSION['user']['username'] . ")";
	$_SESSION['commentOnPost'] = $post['id'];
?>
	<form action="posts/commentsend.php" method="POST">
		<textarea name="content" rows="3"></textarea>
		<input type="submit" value="Skicka">
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


<?php 
print "<hr>";
print "<pre>";

foreach ($comments as $comment) {
	print $comment['username'];
	print "<br>";
	print $comment['content'];
	print "<hr>";
} 
?>

</div>