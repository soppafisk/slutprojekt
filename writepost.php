<?php require_once "incl/header.php"; 

var_dump($_SESSION);

?>

<h1>Skriv inlägg</h1>
<form action="posts/postsend.php" method="POST">
	<label for="title">Titel:<br> </label><input type="text" name="title"> <br>
	<label for="link">Länk:<br> </label><input type="text" name="link"><br>
	<label for="content">Beskrivning:<br> </label><textarea name="content" cols="30" rows="10"></textarea><br>
	<label for="nsfw">NSFW: </label><input type="checkbox" name="nsfw"><br>
	<input type="submit" value="Skicka">
</form>