<?php require_once "incl/header.php"; ?>

<div class="col-8">
<?php if (isLoggedIn()): 
	$categories = sqlQuery("SELECT * FROM categories");
	$currentCat = 0;
?>

	<h1>Skriv inlägg</h1>
	<form action="posts/postsend.php" method="POST">
		<label for="category">Kategori:<br></label>
		<select name="category">
			<option value="0"> </option>
			<?php 
				foreach ($categories as $category) {
					$selected = false;
					if (isset($_GET['cat'])) {
						if (in_array($_GET['cat'], $category)) {
							$currentCat = $category;
							$selected = true;
						}
					}
					print "<option value='{$category['id']}'";
					if ($selected) 
						print " selected ";
					print ">{$category['fullName']}</option>";
				}
			?>
		</select><br>
		<label for="title">Titel:<br></label>
		<input type="text" name="title">
		<label for="link">Länk: (glöm inte http://)<br></label>
		<input type="text" name="link">
		<label for="content">Beskrivning:<br></label>
		<textarea name="content" cols="30" rows="10"></textarea>
		<label for="nsfw"><abbr title="Not Safe For Work">NSFW</abbr>: </label>
		<input type="checkbox" name="nsfw"><br>
		<input type="submit" value="Skicka">
	</form>

<?php else: ?>

	<p>Du måste vara inloggad för att skriva inlägg.<br>
		<a href='index.php?p=login'>Logga in</a>
	</p>

<?php 
	endif;

		if (isset($_SESSION['feedback'])) {
			foreach ($_SESSION['feedback'] as $feedback) {
				print $feedback . "<br>";
			}
			unset($_SESSION['feedback']);
		}
?>
</div>