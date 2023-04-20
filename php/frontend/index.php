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
        <?php include '../tools/navbar.html'; ?>
		<div id="hero">
        <form id="hero-search" action="">
            <input id="hero-searchbar" type="text" name="search" placeholder="en kul bok">
            <input id="hero-searchexecute" type="button" value="søk">
        </form>
    </div>
    <div class="section">ambefalte bøker</div>
    <div class="book-container">
        <div class="book-item">
            <img class="bookimg-1" src="http://books.google.com/books/content?id=MElAnSMPPYoC&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api" alt="">
            <div>The Gospel of the Flying Spaghetti Monster</div>
        </div>
        <div class="book-item">
            <img class="bookimg-1" src="http://books.google.com/books/content?id=X8KCBgAAQBAJ&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api" alt="">
            <div>Spaghetti Issues</div>
        </div>
        <div class="book-item">
            <img class="bookimg-1" src="http://books.google.com/books/content?id=aFEfDAAAQBAJ&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api" alt="">
            <div>Invented Religions</div>
        </div>  
        <div class="book-item">
            <img class="bookimg-1" src="http://books.google.com/books/content?id=HLZMAgAAQBAJ&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api" alt="">
            <div>The Bloomsbury Companion to New Religious Movements</div>
        </div>
        <div class="book-item">
            <img class="bookimg-1" src="http://books.google.com/books/content?id=Fk1nDwAAQBAJ&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api" alt="">
            <div>Humorists vs. Religion</div>
        </div>
        <div class="book-item">
            <img class="bookimg-1" src="http://books.google.com/books/content?id=I9gcDgAAQBAJ&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api" alt="">
            <div>Picturing Quantum Processes</div>
        </div>  
      </div>
	</body>
</html>