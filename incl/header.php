<html lang="sv">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<<<<<<< HEAD
	<link rel="stylesheet" href="style/base.css">
	<link rel="stylesheet" href="style/style.css">
=======

	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
>>>>>>> cbb20e9e3c106823f9a69ee9acacf3bd879fb19b

	<link rel="shortcut icon" href="favicon.png">
	
	<title>Trasig</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<<<<<<< HEAD
=======
	<script src="js/bootstrap.min.js"></script>
>>>>>>> cbb20e9e3c106823f9a69ee9acacf3bd879fb19b
	<script src="scripts/scripts.js"></script>
</head>

<body>
<div class="container">
	<div id="hwrapper" class="row">
		<header>
			<div class="col-xs-4">
				<a href="index.php"><img src="img/logo.png" alt="logo" id="logo"></a>
			</div>
			<nav id="headernav" class="col-xs-4 col-xs-offset-4">
				<a href="index.php">Hem</a>
				<a href='index.php?p=search'>Sök</a>
				<?php
				if (isLoggedIn()) {
					print "<a href='index.php?p=writepost'>Skriv inlägg</a> ";
					print "Inloggad som: <a href='index.php?p=profile&u=" . $_SESSION['user']['username'] . "'>" . $_SESSION['user']['username'] . "</a>";
					print " <a href='index.php?p=logout'>Logga ut</a>";
				} else {
					print "<a href='index.php?p=login'>Logga in</a>";
				}
				?>
			</nav>
		</header>
	</div>
	<div id="wrapper">
