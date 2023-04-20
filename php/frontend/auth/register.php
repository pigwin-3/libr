<?php
require '../../tools/database.php';
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form! ');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	// One or more values are empty.
	exit('Please complete the registration form ');
}
// We need to check if the account with that username exists.
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Email is not valid! ');
}
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Username is not valid! ');
}
if ($_POST["password"] != $_POST["password2"]) {
    exit('passwords do not match!');
}
if (strlen($_POST['password']) > 64 || strlen($_POST['password']) < 5) {
	exit('Password must be between 5 and 64 characters long!');
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// checks if username already exists
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} else {
		// the username is not in use and we can create a new account
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
            // makes a hash of the password and executes the the sql statement
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$uniqid = uniqid(true);
            $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
            $stmt->execute();
			echo 'You have successfully registered, you can now login!';
			header('Location: ../index.php');
        } else {
            // fuck
            echo 'Could not prepare statement!';
        }
	}
	$stmt->close();
} else {
	// fuck
	echo 'Could not prepare statement!';
}
$con->close();
?>