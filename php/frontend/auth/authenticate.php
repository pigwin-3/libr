<?php
//må legge til sjekk for om konto er aktivert eller ikke
session_start();
require '../../tools/database.php';
// checks if data exists cus yea i want it to
if ( !isset($_POST['username'], $_POST['password']) ) {
	// need more info (brahhhhh -zombe)
	exit('Please fill both the username and password fields!');
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
    // checks if there is more data than 0 lines
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        if (password_verify($_POST['password'], $password)) {
            // yay!!!!
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: ../home.php');
        } else {
            // Fuck
            echo 'Incorrect username and/or password!';
        }
    } else {
        // FUCK
        echo 'Incorrect username and/or password!';
    }

	$stmt->close();
}
?>