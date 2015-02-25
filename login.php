<?php


require "incl/header.php";
$username = "";

?>

<div class="row">
	<div class="col-xs-12 col-md-7 col-lg-4">
		<?php
		if (isset($_SESSION['feedback'])) {
			print $_SESSION['feedback']['message'];
			$username = $_SESSION['feedback']['username'];
			unset($_SESSION['feedback']);
		}
		?>
		<h2>Logga in</h2>

		<form id="loginform" action="forms/sendlogin.php" method="POST">
			<div class="form-group">
				<label for="username">Användarnamn: </label>
				<input type="text" class="form-control" name="username" value='<?php print $username; ?>' >
			</div>
			<div class="form-group">
				<label for="password">Lösenord: </label>
				<input type="password" class="form-control" name="password">
			</div>
			<input type="submit" class="btn btn-default" value="Logga in">
		</form>

		<p>Inte medlem? <a href="index.php?p=register">Registrera</a></p>
	</div>
</div>