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
	</head>
	<body>


        <?php include '../../tools/navbar.php'; ?>
		<div class="admin-center">
			<div class="admin-settings-container-top">
				<div class="admin-left-card">
					<a href="./"><img src="../assets/back.svg" alt="back buttton" class="admin-icon"></a>
					<h1 class="page-name">Alle brukere</h1>
				</div>
			</div>
			<div class="admin-settings-container">
				<table>
					<thead>
						<tr>
							<th>id</th>
							<th>username</th>
							<th>name</th>
							<th>email</th>
							<th>perm</th>
							<th>created_at</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$stmt = $con->prepare('SELECT `id`, `username`, `name`, `email`, `perm`, `created_at` FROM `accounts` WHERE 1');
							$stmt->execute();
							$stmt->bind_result($id, $username, $name, $email, $perm, $created_at);
							while ($stmt->fetch()) {
								echo "<tr>";
								echo "<td>$id</td>";
								echo "<td>$username</td>";
								echo "<td>$name</td>";
								echo "<td>$email</td>";
								echo "<td>$perm</td>";
								echo "<td>$created_at</td>";
								echo '<td><a href="changeuserpass.php?id='. $id .'">change password</a></td>';
								echo "</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>