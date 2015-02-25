<?php

$username = "";
$email = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$location = 'Location: index.php?p=register';

	$db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Det gick inte att ansluta till databasen'];
		header($location);
		die;
	}

	$username 	= mysqli_real_escape_string($db, $_POST['username']);
	$password 	= mysqli_real_escape_string($db, $_POST['password']);
	$password2 	= mysqli_real_escape_string($db, $_POST['password2']);
	$email 		= mysqli_real_escape_string($db, $_POST['email']);
	
	if (strlen($username) < 3) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Användarnamnet måste vara minst 3 tecken'];
		header($location);
		die;
	}

	//check if user exists
	$query = sprintf("SELECT username FROM users where username='%s'", $username);

	$result = mysqli_query($db, $query);
	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Registreringen misslyckades.'];
		header($location);
		die;
	} else {
		if (mysqli_num_rows($result)>0) {
			$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Användarnamet är upptaget'];
			header($location);
			die;
		}
	}

	// Password check
	if (strlen($password) < 6) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Lösenorden måste vara minst 6 tecken långt'];
		header($location);
		die;
	}

	if ($password != $password2) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Lösenorden måste vara likadana'];
		header($location);
		die;
	}

	$password = password_hash($password, PASSWORD_DEFAULT);

	// then insert
	$query = sprintf("INSERT INTO users (username, password, email) VALUES ('%s', '%s', '%s')", $username, $password, $email);
	$result = mysqli_query($db, $query);

	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Registreringen misslyckades '];
		header($location);
		die;
	} else {
		$_SESSION['feedback'] = ['color'=>'green', 'message'=>'Registreringen lyckades'];
		header('Location: index.php?p=login');
		die;
	}
} // if post
?>

<?php require "incl/header.php"; ?>
<div class="row">
	<div class="col-xs-12 col-md-7 col-lg-4">

		<?php
		if (isset($_SESSION['feedback'])){
			print $_SESSION['feedback']['message'];
			unset($_SESSION['feedback']);
		}
		?>

		<form id="registerform" action="index.php?p=register" method="POST">
			<div class="form-group">
				<label for="username">Användarnamn:</label>
				<input type="text" name="username" class="form-control" value="<?php print $username; ?>">
			</div>
			<div class="form-group">
				<label for="email">Email:</label> 
				<input type="text" name="email" class="form-control" value="<?php print $email; ?>">
			</div>
			<div class="form-group">
				<label for="password">Lösenord:</label> 
				<input type="password" name="password" class="form-control">
			</div>
			<div class="form-group">
				<label for="password2">Lösenordet igen:</label> 
				<input type="password" name="password2" class="form-control">
			</div>
			<div id="feedback"></div>
			<input type="submit" class="btn btn-default" value="Registrera!">
		</form>
	</div>
</div>