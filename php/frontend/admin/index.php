<?php
session_start();
// If the user is not logged in redirect to the login page...

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>index</title>
		<link href="../style/style.css" rel="stylesheet" type="text/css">
        <link href="../style/admin.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href='https://fonts.googleapis.com/css?family=Atkinson Hyperlegible' rel='stylesheet'>
	</head>
	<body>
        <?php include '../../tools/navbar.html'; ?>
        <div class="admin-container">
            <a href="addbook.php">
                <div class="admin-item">
                    legg til bok
                </div>
            </a>
        </div>
	</body>
</html>