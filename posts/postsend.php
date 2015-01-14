<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	require_once "../config.php";
	require_once "../functions/functions.php";
	$error = false;

	$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
	if ($mysqli->connect_errno) {
	    print "Kunde inte ansluta till databasen (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$stmt = $mysqli->prepare("INSERT INTO posts (title, link, content, nsfw, user_id, cat_id) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('ssssii', $title, $link, $content, $nsfw, $user_id, $cat_id);

	// VALIDATION
	if (strlen($_POST['title']) > 2) {
		$title 	= $mysqli->real_escape_string($_POST['title']);
	} else {
		$error = true;
		$_SESSION['feedback']['title'] = "Titeln måste vara minst 3 tecken lång";
	}

	if (filter_var($_POST['link'], FILTER_VALIDATE_URL)) {
		$doesExist = sqlQuery("SELECT * FROM posts WHERE link='{$_POST['link']}'");
		if ($doesExist == true) {
			$error = true;
			$_SESSION['feedback']['link'] = "Länken är redan postad. Hitta en ny!";
		}
		$link = $_POST['link'];
	} else {
		$error = true;
		$_SESSION['feedback']['link'] = "Du måste ange en riktig länk. Glöm inte http:// och sånt";
	}

	if (strlen($_POST['content']) <= 2000 && strlen($_POST['content']) > 3) {
		$content= $mysqli->real_escape_string($_POST['content']);
	} else {
		$error = true;
		$_SESSION['feedback']['content'] = "Beskrivningen måste vara mellan 3 och 2000 tecken";
	}

	if (isset($_POST['nsfw'])) 
		$nsfw = true;
	else 
		$nsfw = false;

	$user_id = $_SESSION['user']['id'];
	$cat_id = 1;

	if (!$error) {
		if (!$stmt->execute()) {
			print $mysqli->error;
			die;
		}
	} else {
		header("Location: ../index.php?p=writepost");
		die;
	}
	$stmt->close();

	$mysqli->close();

} // if post

header("Location: ../index.php");
die;