<?php 
require "../config.php";
require "../functions/functions.php";

session_start();

$username = addslashes($_POST['username']);
$password = addslashes($_POST['password']);

$query = "SELECT * FROM users WHERE username = '$username'";

$user = dbQuery($query);

if (password_verify($password, $user[0]['password'])) {
	$_SESSION['user'] = $user[0];
	print "va?!";
	header('Location: ../index.php');
	die;
} else {
	$_SESSION['feedback'] = ['color' => 'red', 'message' =>'Användarnamnet eller lösenordet är fel'];
	header('Location: ../index.php?p=login');
	die;
}