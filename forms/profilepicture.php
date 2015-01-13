<?php
session_start();

if (!empty($_FILES['uploadedPicture'])) {
		print "<pre>";
		var_dump($_FILES);
		$picture = $_FILES['uploadedPicture'];

		if ($picture['error'] > 0) {
			$_SESSION['feedback'] = [
				'color' => 'red', 
				'message' => 'Något gick fel. Försök igen.'
				];
			header("Location: ../index.php?p=profile&u=" . $_SESSION['user']['username']);
			die;
		}
		print $_SESSION['user']['id'];


	} // if POST