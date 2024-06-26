<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../test');
	exit;
}

require '../../tools/database.php';
// gets user info from db useing id
$stmt = $con->prepare('SELECT `perm` FROM `accounts` WHERE `id` = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($perm);
$stmt->fetch();
$stmt->close();
// if perm is 1 or lower exit 
if($perm <= 1) {
    header('Location: ../');
	exit;
}
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
        <?php include '../../tools/navbar.php'; ?>
        <div class="admin-container">
            <a href="addbook.php">
                <div class="admin-item">
                    Legg til bok
                </div>
            </a>
            <a href="listbooks.php">
                <div class="admin-item">
                    Se alle bøker
                </div>
            </a>
            <a href="editbook.php">
                <div class="admin-item">
                    Rediger bok inføring
                </div>
            </a>
            <a href="loanbook.php">
                <div class="admin-item">
                    Låne ut bok
                </div>
            </a>
            <a href="returnbook.php">
                <div class="admin-item">
                    Returner ut bok
                </div>
            </a>
            <a href="listloans.php">
                <div class="admin-item">
                    Se alle utlån
                </div>
            </a>
            <a href="listusers.php">
                <div class="admin-item">
                    Se alle brukere
                </div>
            </a>
        </div>
	</body>
</html>