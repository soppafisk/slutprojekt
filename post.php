<?php require_once "incl/header.php";  ?>

<div class="col-8">

<?php

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	
	$result = sqlQuery("SELECT * FROM posts WHERE id='$id'");
	$post = $result[0];

	$comments = sqlQuery("SELECT * FROM comments WHERE post_id='$id'");
}


?>

<h1>POST</h1>
<?php 

print $post['title'];
print "<br>";
print $post['content']; 
?>
<form action="commentsend" method="POST">
	<textarea name="comment" rows="3"></textarea>
	<input type="sumbit" value="skicka">
</form>

<?php 
print "<hr>";

foreach ($comments as $comment) {
	print_r($comment);
} 
?>

</div>