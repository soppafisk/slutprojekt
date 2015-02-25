<?php require_once "incl/header.php"; ?>


<div id="profile" class="row">
	<?php 

	if (isset($_GET['u'])) :
		$u = filter_var($_GET['u'], FILTER_SANITIZE_STRING);

		$singleUserQuery = " AND username = '$u'";
		$header = "profil";

		$result = sqlQuery("SELECT * FROM users WHERE username='$u'");

		if ($result == false) {
			print "<div class='col-xs-12'>Användaren finns inte.</div>";
		} else {
			$user = $result[0];

			// check if it's you own profile
			$ownProfile = false;
			if (isLoggedIn()) {
				if ($_SESSION['user']['id']==$user['id']) {
					$ownProfile = true;
				}
			}
		} // result != false 
		?>

		<?php if ($user) : ?>
		<div class="col-xs-2">
			<img src='img/profiles/<?php print $user['profilePicture'];?>' class='profilePicture img-thumbnail' alt='profilbild'>

		</div>
		<div class="col-xs-7">
			<h2 class="profileName"><?php print $user['username']; ?></h2>
			
			<p>Medlem sedan: <?php print substr($user['account_date'], 0, 10); ?><br>

			Antal poster: <?php print sqlQuery(
				"SELECT COUNT(*) as count FROM `posts` WHERE user_id=" . $user['id']
				)[0]["count"];
			?>
			</p>
			<?php
			// profile pic upload
			if ($ownProfile) : ?>
				<form enctype='multipart/form-data' action='forms/profilepicture.php' method='post'>
					<input name='uploadedPicture' type='file'><br>
					<input type='submit' class="btn btn-default" value='Byt profilbild'> <br>(Bilden får vara max 5MB)
				</form>
			
				<?php
				if (isset($_SESSION['feedback'])) {
					print $_SESSION['feedback']['message'] . "<br>";
					unset($_SESSION['feedback']);
				}
			endif; ?>
		</div>
		<?php endif; // if user  ?>


	<?php endif; //get ['u'] ?>
</div>
<div class="row">
	<?php
	if ($user) {
		print "<div id='latestPosts' class='col-xs-12 text-center'><h4>" . $user['username'] . "s poster</h4></div>";
		require "incl/feed.php";
	}
	?>
	<?php require "incl/topusers.php"; ?>

</div>