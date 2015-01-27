<?php


require "incl/header.php";
$username = "";
if (isset($_SESSION['feedback'])) {
	print $_SESSION['feedback']['message'];
	unset($_SESSION['feedback']);
}
?>

<div class="col-8">
	<h2>Logga in</h2>

	<form id="loginform" action="forms/sendlogin.php" method="POST">
		<label for="username">Användarnamn: </label>
		<input type="text" name="username" value='<?php print $username; ?>' >
		<label for="password">Lösenord: </label>
		<input type="password" name="password">
		<input type="submit" value="Logga in">
	</form>

	<p>Inte medlem? <a href="index.php?p=register">Registrera</a></p>
</div>