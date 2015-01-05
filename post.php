<?php require_once "incl/header.php";  ?>

<div class="col-8">

<?php

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	
	$result = sqlQuery("SELECT posts.*, users.username FROM posts JOIN users on posts.user_id = users.id and posts.id='$id'");
	$post = $result[0];

	$comments = sqlQuery("SELECT * FROM comments WHERE post_id='$id'");
}


?>

<h1>POST</h1>
<pre>
<?php 
print_r($post);
if ($post['nsfw'] == true) {
	print "NSFW <br>";
}

print "<h4>" . $post['title'] . "</h4>";
print "Av " . $post['username'] . " den " . $post['post_date'];
print "<p class='single-post content'>"; 
print $post['content']; 
print "</p>";
?>
<form action="commentsend" method="POST">
	<textarea name="comment" rows="3"></textarea>
	<input type="submit" value="skicka">
</form>

<?php 
print "<hr>";

foreach ($comments as $comment) {
	print_r($comment);
} 
?>

</div>