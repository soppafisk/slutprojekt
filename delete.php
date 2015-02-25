<?php require_once "incl/header.php"; ?>
<div class="row">
<?php require "incl/postsmenu.php"; ?>
<div class="col-xs-12 col-md-7">

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	sqlQuery("UPDATE posts SET deleted=1 WHERE id =". $_SESSION['post']['id'], "DELETE");
	print "Posten är borttagen";

} else {
	if (isLoggedIn()) {
		$query = "SELECT id, title FROM `posts` WHERE user_id=" . $_SESSION['user']['id'] . " AND id=" . $_SESSION['post']['id'];

		$result = sqlQuery($query)[0];

		if (!$result) {
			print "Du försöker ta bort en post som inte är din.";
		} else {
			?>
			<form action="#" method="POST">
			<p>Om du vill ta bort <?php print $result['title']; ?>, tryck på knappen</p>

			<input type="submit" class="btn btn-default" value="Ta bort">
			</form>
			<?php
		}
	} // if logged in
} // if !post
?>
</div>
</div>