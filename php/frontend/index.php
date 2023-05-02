<?php
session_start();
// If the user is not logged in redirect to the login page...

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>index</title>
		<link href="style/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href='https://fonts.googleapis.com/css?family=Atkinson Hyperlegible' rel='stylesheet'>
	</head>
	<body class="loggedin">
        <?php include '../tools/navbar.php'; ?>
		<div id="hero">
        <form id="hero-search" action="">
            <input id="hero-searchbar" type="text" name="search" placeholder="en kul bok">
            <input id="hero-searchexecute" type="button" value="søk">
        </form>
    </div>
    <div class="cont">
      </div>
	</body>
</html>