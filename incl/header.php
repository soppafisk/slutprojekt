<html lang="sv">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">

	<link rel="shortcut icon" href="favicon.png">
	
	<title>Trasig</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

	<script src="js/bootstrap.min.js"></script>

	<script src="scripts/scripts.js"></script>
</head>

<body>
<div class="container-fluid">
	<div id="hwrapper" class="row">
		<header class="col-md-10 col-md-offset-1 col-xs-12">
			<div class="row">
			<div class="col-xs-4">
				<a href="index.php"><img src="img/logo.png" alt="logo" id="logo"></a>
			</div>
			<div class="col-xs-8">
				<nav id="headernav" class="right">
					<a href="index.php">Hem</a>
					<a href='index.php?p=search'>Sök</a>
					<?php
					if (isLoggedIn()) {
						print "<a href='index.php?p=writepost'>Skriv inlägg</a> ";
						print "<a id='yourProfile' href='index.php?p=profile&u=" . $_SESSION['user']['username'] . "'>" . $_SESSION['user']['username'] . "</a>";
						print " <a href='index.php?p=logout'>Logga ut</a>";
					} else {
						print "<a href='index.php?p=login'>Logga in</a>";
					}
					?>

				</nav>
			</div>
			</div>
		</header>
	</div>
	<div id="wrapper" class="row">
		<div class="col-lg-10 col-lg-offset-1 col-xs-12">