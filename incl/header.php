<html lang="sv">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">

	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="style/base.css">
	<link rel="stylesheet" href="style/style.css">

	<link rel="shortcut icon" href="favicon.png">
	
	<title>Trasig</title>
</head>

<body>

<div id="hwrapper">
	<header>
		<a href="index.php"><img src="img/logo.png" alt="logo"></a>
		<nav id="headernav">
			<a href="index.php">Hem</a>
			<a href="index.php?p=writepost">Skriv inlägg</a>
					<?php
		if (isLoggedIn()) {
			print "Inloggad som: " . $_SESSION['user']['username'];
			print " <a href='index.php?p=logout'>Logga ut</a>";
		} else {
			print "<a href='index.php?p=login'>Logga in</a>";
		}
		?>
		</nav>

	</header>
</div>
<div id="wrapper">