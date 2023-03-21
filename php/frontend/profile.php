<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
require '../tools/database.php';
// gets user info from db useing id
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>deg</title>
		<link href="style/style.css" rel="stylesheet" type="text/css">
		<link href='https://fonts.googleapis.com/css?family=Atkinson Hyperlegible' rel='stylesheet'>
	</head>
	<body class="loggedin">
        <?php include '../tools/navbar.html'; ?>
		<div class="content">
			<h2>konto detalier</h2>
			<div>
				<p>mye info her:</p>
				<table>
					<tr>
						<td>id:</td>
						<td><?=$_SESSION['id']?></td>
					</tr>
					<tr>
						<td>brukernavn:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>passord hash:</td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>mail:</td>
						<td><?=$email?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>