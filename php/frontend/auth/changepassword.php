<html>
<body>

<!--
new: <?php echo $_POST["password"]; ?><br>
new2: <?php echo $_POST["password2"]; ?><br>
-->
<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
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
// prechecks
if ($_POST["password"] != $_POST["password2"]) {
    exit("Passwords do not match!");
}
if (strlen($_POST['password']) > 64 || strlen($_POST['password']) < 5) {
    exit('Password must be between 5 and 64 characters long!');
}

if ($stmt = $con->prepare('UPDATE accounts SET password=? WHERE id=?')) {
    // INSERTS NEW PASSWORD!!!
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt->bind_param('si', $password, $_POST['id']);
    if ($stmt->execute()) {
        echo 'Du har endret passordet til brukeren!';
    } else {
        // Error while updating password
        echo 'Could not update password!';
    }
    $stmt->close();
} else {
    // Error while preparing statement
    echo 'Could not prepare statement!';
}
?>

</body>
</html>
