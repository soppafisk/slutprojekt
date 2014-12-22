<?php
require "incl/header.php";

if (isset($_SESSION['feedback'])){
	print $_SESSION['feedback']['message'];
	unset($_SESSION['feedback']);
}
?>

<form id="registerform" action="forms/sendregister.php" method="POST">
	<label for="username">Användarnamn:</label>
	<input type="text" name="username">
	<label for="email">Email:</label> 
	<input type="text" name="email">
	<label for="password">Lösenord:</label> 
	<input type="password" name="password">
	<label for="password2">Lösenordet igen:</label> 
	<input type="password" name="password2">
	<input type="submit" value="Registrera!">
</form>