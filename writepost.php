<?php require_once "incl/header.php"; ?>

<div class="col-8">
	<h1>Skriv inlägg</h1>
	<form action="posts/postsend.php" method="POST">
		<label for="title">Titel:<br></label>
		<input type="text" name="title">
		<label for="link">Länk:<br></label>
		<input type="text" name="link">
		<label for="content">Beskrivning:<br></label>
		<textarea name="content" cols="30" rows="10"></textarea>
		<label for="nsfw">NSFW: </label>
		<input type="checkbox" name="nsfw"><br>
		<input type="submit" value="Skicka">
	</form>
</div>