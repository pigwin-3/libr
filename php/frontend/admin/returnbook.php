<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../');
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
// if perm is 1 or lower exit to main page
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
		<link href="../style/scanner.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        <link href='https://fonts.googleapis.com/css?family=Atkinson Hyperlegible' rel='stylesheet'>
		<h1>husk å lage custum scann greie her!</h1>
		<script defer src="../js/admin/loanbookscanner.js"></script>
		<script defer src="../js/html5-qrcode.js"></script>
	</head>
	<body>
	<button type="button" onclick="openModal()">Open QR Code Scanner</button>
	<div id="modal-container" class="modal">
		<div class="modal-content">
			<button class="close" type="button" onclick="closeModal()">X</button>
			<div id="qr-reader"></div>
			<div id="qr-reader-results"></div>
		</div>
	</div>
    <div id="informer" class="admin-inform">
        <div id="informer-info" class="admin-inform-content">info</div>
    </div>



        <?php include '../../tools/navbar.html'; ?>
		<div class="admin-center">
			<div class="admin-settings-container-top">
				<div class="admin-left-card">
					<a href="./"><img src="../assets/back.svg" alt="back buttton" class="admin-icon"></a>
					<h1 class="page-name">Retuner bok</h1>
				</div>
				<form action="" class="admin-form" method="post">

					<label for="bid">Book ID:</label>
					<input type="text" id="bid" name="bid" class="admin-input" placeholder="1">

					<label for="uid">User id:</label>
					<input type="text" id="uid" name="uid" class="admin-input" placeholder="1" required>

					<input type="submit" value="submit" id="submit-btn" class="admin-input">
				</form>

			</div>
			<div class="admin-settings-container">
			<?php
			if (isset($_POST['bid'])) {
				//INSERT INTO loanlog (usrid, id, loandate, loanend, loanid) SELECT usrid, id, loandate, loanend, loanid FROM loan WHERE id = ?;
				//DELETE FROM loan WHERE id = ?
			}
			?>
			</div>
		</div>
	</body>
</html>