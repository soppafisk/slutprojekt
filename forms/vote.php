<?php
session_start();

require "../config.php";
require "../functions/functions.php";

$classes = explode(" ", $_POST['classes']);

list($upordown, $arrow, $post_id) = $classes;

if ($upordown == "up") {
	$upordown = 1;
} elseif($upordown == "down") {
	$upordown = -1;
}

$post_id = filter_var(substr($post_id, 5), FILTER_SANITIZE_NUMBER_INT);

$hasVoted = sqlQuery("SELECT * FROM votes WHERE post_id='$post_id' AND user_id='" . $_SESSION['user']['id'] . "'");

if (!$hasVoted) {
	$query = "INSERT INTO votes (user_id, post_id, value) VALUES ('" . $_SESSION['user']['id'] . "', '" . $post_id . "', '" . $upordown . "')";

	$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if ($mysqli->connect_errno) {
	    print "Kunde inte ansluta till databasen (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	if ($result = $mysqli->query($query)) {
		print "success";
	} else {
		print $query;
	}

	$mysqli->close();
} // !hasVoted