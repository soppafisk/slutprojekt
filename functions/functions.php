<?php

////////////////////////////////////////////////////////////////////
/// Send query to db, return data[]
function dbQuery($query) {

	$db = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if (mysqli_connect_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Det gick inte att ansluta till databasen'];
		header('Location: ../index.php');
		die;
	}

	$result = mysqli_query($db, $query);

	if (mysqli_errno($db)) {
		$_SESSION['feedback'] = ['color'=>'red', 'message'=>'Något gick fel'];
		header('Location: ../index.php');
		die;
	}

	if (mysqli_num_rows($result)>0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
	}
	mysqli_free_result($result);
	mysqli_close($db);

	return $data;
}

////////////////////////////////////////////////////////////////////
/// Send query to db, return data[]
function sqlQuery($query) {
	$mysqli = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

	if ($mysqli->connect_errno) {
	    print "Kunde inte ansluta till databasen (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$data = [];
	if ($result = $mysqli->query($query)) {
		while($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		$result->close();
	}

	$mysqli->close();
	return $data;
}

////////////////////////////////////////////////////////////////////
/// Check if user in session/logged in, return bool
function isLoggedIn() {
	if (isset($_SESSION['user']))
		return true;
	else 
		return false;
}