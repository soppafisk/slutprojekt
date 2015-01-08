<?php require_once "incl/header.php"; ?>

<div class="col-8">

<?php 

if (isset($_GET['u'])) {
	$u = filter_var($_GET['u'], FILTER_SANITIZE_STRING);

	$result = sqlQuery("SELECT * FROM users WHERE username='$u'");
	$user = $result[0];

	print $user['username'];
	print "<br>";
	print "Medlem sedan: " . $user['account_date'];
	print "<hr>";

	print "<h5>Senaste posterna:</h5>";

	$posts = sqlQuery("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id=users.id and user_id='" . $user['id'] . "'");

	foreach ($posts as $post) {
		include "incl/postbox.php";
	}

} //get ['u']


?>
</div>