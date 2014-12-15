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