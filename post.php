<?php require_once "incl/header.php";  

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$result = sqlQuery("SELECT * FROM posts WHERE id='$id'");
	$post = $result[0];
	

}


?>

<h1>POST</h1>
<?php 

print $post['title'];
print "<br>";
print $post['content'];