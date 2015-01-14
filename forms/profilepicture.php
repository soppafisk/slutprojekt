<?php
session_start();
require "../functions/functions.php";
require "../config.php";

$location = "Location: ../index.php?p=profile&u=" . $_SESSION['user']['username'];

if (!empty($_FILES['uploadedPicture'])) {
		$picture = $_FILES['uploadedPicture'];
		$name = $picture['name'];
		$tmp  = $picture['tmp_name'];
		$size = $picture['size'];
		$target_dir = "../img/profiles/";
		$imageFileType = pathinfo($name, PATHINFO_EXTENSION);

		if ($picture['error'] == 0) {
			$check = getimagesize($tmp);

			if ($check == false) {
				$_SESSION['feedback'] = [
				'color' => 'red', 
				'message' => 'Filen måste vara en bild.'
				];
				header($location);
				die;
			}

			if ($size > 5000000) {
				$_SESSION['feedback'] = [
					'color' => 'red', 
					'message' => 'Bilden får vara högst 5MB'
				];
				header($location);
				die;
			} else {
				$newName = newNameForProfilePicture($imageFileType);
			
				if (move_uploaded_file($tmp, $target_dir . $newName)) {
						$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
						$query = "UPDATE users SET profilePicture='$newName' WHERE id='{$_SESSION['user']['id']}'";

						if ($mysqli->connect_errno) {
						    print "Kunde inte ansluta till databasen (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
						}

						if ($result = $mysqli->query($query)) {
								$_SESSION['feedback'] = [
									'color' => 'green', 
									'message' => 'Filuppladdningen lyckades!'
								];
						}

						$mysqli->close();
					
				} else {
					$_SESSION['feedback'] = [
						'color' => 'red', 
						'message' => 'Någonting gick fel. Försök igen.'
					];
				}
			}
		} else if ($picture['error'] > 0) {
			$_SESSION['feedback'] = [
				'color' => 'red', 
				'message' => 'Något gick fel. Försök igen.'
			];
		}

} // if !empty($_FILES)
else {
	$_SESSION['feedback'] = [
	'color' => 'red', 
	'message' => 'Något gick fel vid filuppladdningen. Kom ihåg att bilden får vara max 5MB stor'
	];
}

print $_SESSION['feedback']['message'];
header($location);
die;