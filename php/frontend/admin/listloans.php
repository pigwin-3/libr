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
		<script defer src="../js/admin/addbook.js"></script>
		<script defer src="../js/admin/addbookscanner.js"></script>
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



        <?php include '../../tools/navbar.php'; ?>
		<div class="admin-center">
			<div class="admin-settings-container-top">
				<div class="admin-left-card">
					<a href="./"><img src="../assets/back.svg" alt="back buttton" class="admin-icon"></a>
					<h1 class="page-name">Alle utlån</h1>
				</div>
			</div>
			<div class="admin-settings-container">
			<form form method="GET" action="">
			<label for="l">Only show expired loans:</label><br>
			<input type="checkbox" id="l" name="l" value="1" <?php if (isset($_GET['l'])){ echo " checked";}?>>
			<input type="submit" value="Filter">
			</form>
				<table>
				<thead>
					<tr>
						<th>loanid</th>
						<th>id</th>
						<th>name</th>
						<th>usrid</th>
						<th>username</th>
						<th>loandate</th>
						<th>loanend</th>
					</tr>
				</thead>
				<tbody>
                <?php
				if (isset($_GET['l'])){
					if ($_GET['l'] == "1"){
						$stmt = $con->prepare('SELECT loan.loanid, loan.id, books.name, loan.usrid, accounts.username, loan.loandate, loan.loanend FROM loan JOIN bookcopy ON loan.id = bookcopy.id JOIN books ON bookcopy.bookid = books.bookid JOIN accounts ON loan.usrid = accounts.id WHERE loan.loanend < NOW()');
					}else{
						$stmt = $con->prepare('SELECT loan.loanid, loan.id, books.name, loan.usrid, accounts.username, loan.loandate, loan.loanend FROM loan JOIN bookcopy ON loan.id = bookcopy.id JOIN books ON bookcopy.bookid = books.bookid JOIN accounts ON loan.usrid = accounts.id');
					}
				}else{
					//get all
					$stmt = $con->prepare('SELECT loan.loanid, loan.id, books.name, loan.usrid, accounts.username, loan.loandate, loan.loanend FROM loan JOIN bookcopy ON loan.id = bookcopy.id JOIN books ON bookcopy.bookid = books.bookid JOIN accounts ON loan.usrid = accounts.id');
				}
				$stmt->execute();
				$stmt->bind_result($lid, $bid, $bname, $uid, $uname, $ld, $le);
				while ($stmt->fetch()) {
					echo "<tr>";
					echo "<td>$lid</td>";
					echo "<td>$bid</td>";
					echo "<td>$bname</td>";
					echo "<td>$uid</td>";
					echo "<td>$uname</td>";
					echo "<td>$ld</td>";
					echo "<td>$le</td>";
					echo "</tr>";
				}
                ?>
				</tbody></table>
			</div>
		</div>
	</body>
</html>