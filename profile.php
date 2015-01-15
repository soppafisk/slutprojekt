<?php require_once "incl/header.php"; ?>

<div class="col-8">

<?php 

if (isset($_GET['u'])) {
	$u = filter_var($_GET['u'], FILTER_SANITIZE_STRING);

	$result = sqlQuery("SELECT * FROM users WHERE username='$u'");

	if ($result == false) {
		print "Användaren finns inte.";
	} else {
		$user = $result[0];

		$ownProfile = false;
		if (isLoggedIn()) {
			if ($_SESSION['user']['id']==$user['id']) {
				$ownProfile = true;
			}
		}

		if ($ownProfile) : ?>
			<form enctype='multipart/form-data' action='forms/profilepicture.php' method='post'>
				<input name='uploadedPicture' type='file'><br>
				<input type='submit' value='Byt profilbild'> (Bilden får vara max 5MB)
			</form>
		
		<?php
			if (isset($_SESSION['feedback'])) {
				print $_SESSION['feedback']['message'] . "<br>";
				unset($_SESSION['feedback']);
			}
		endif;

		print $user['username'];
		print "<br>";
		print "<img src='img/profiles/" . $user['profilePicture'] . "' class='profilePicture' alt='profilbild'>";
		print "Medlem sedan: " . substr($user['account_date'], 0, 10);
		print "<hr>";

		print "<h5>Senaste posterna:</h5>";

		$postCount = sqlQuery("SELECT COUNT(*) FROM posts WHERE user_id='" . $user['id'] . "'");
		print($postCount[0]["COUNT(*)"]);

		$posts = sqlQuery("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id=users.id and user_id='" . $user['id'] . "'");

		foreach ($posts as $post) {
			include "incl/postbox.php";
		}
	}
} //get ['u']


?>
</div>