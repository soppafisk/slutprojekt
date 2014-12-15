<?php


require "incl/header.php";

if (isset($_SESSION['feedback'])) {
	print $_SESSION['feedback']['message'];
	unset($_SESSION['feedback']);
}
?>


<form id="loginform" action="forms/sendlogin.php" method="POST">
	<label for="username">Användarnamn: </label><input type="text" name="username">
	<label for="password">Lösenord: </label><input type="password" name="password">
	<input type="submit" value="Logga in">
</form>