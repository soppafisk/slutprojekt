<?php require_once "incl/header.php"; ?>

<div class="col-xs-8">
<?php if (isLoggedIn()): 
	$categories = sqlQuery("SELECT * FROM categories");
	$currentCat = 0;
?>

	<h1>Skriv inlägg</h1>
	<form action="posts/postsend.php" method="POST">
		<div class="formgroup">
		<label for="category">Kategori:<br></label>

			<select name="category" class="form-control">
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
			</select>
		</div>
		<div class="formgroup">
			<label for="title">Titel:</label>
			<input type="text" class="form-control" name="title">
		</div>
		<div class="formgroup">
			<label for="link">Länk: (glöm inte http://)</label>
			<input type="text" class="form-control" name="link">
		</div>
		<div class="formgroup">
			<label for="content">Beskrivning:</label>
			<textarea name="content" cols="30" rows="10" class="form-control"></textarea>
		</div>
		<div class="checkbox">
			<label><input type="checkbox" name="nsfw"><abbr title="Not Safe For Work">NSFW</abbr></label>
		</div>
		<input type="submit" class="btn btn-default" value="Skicka">
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