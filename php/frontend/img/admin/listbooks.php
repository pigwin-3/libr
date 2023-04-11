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

		<div class="admin-center">
			<div class="admin-settings-container-top">
            <div class="admin-card">
                <a href="./"><img src="../assets/back.svg" alt="back buttton" class="admin-icon"></a>

            </div>
            <?php
            session_start();
            // If the user is not logged in redirect to the login page...
            if (!isset($_SESSION['loggedin'])) {
                header('Location: ../');
                exit;
            }
            // also add that admin thingi

            require '../../tools/database.php';

            // Get books from the database
            $stmt = $con->prepare('SELECT `bookid`, `isbn`, `name`, `author`, `oclc` FROM `books` WHERE 1');
            $stmt->execute();
            $stmt->bind_result($bookid, $isbn, $name, $author, $oclc);

            // Start the table HTML
            echo '<div class="admin-card-container">';

            // Loop through each book and display its information in a row (now card)
            while ($stmt->fetch()) {
                echo '<div class="admin-card">';
                echo '<img src="https://covers.openlibrary.org/b/olid/'.$oclc.'-M.jpg" alt="cover">';
                echo '<div class="admin-card-details">';
                echo '<p class="admin-card-id">'.$bookid.'</p>';
                echo '<h2 class="admin-card-title">'.$name.'</h2>';
                echo '<p class="admin-card-author">'.$author.'</p>';
                echo '<p class="admin-card-isbn">'.$isbn.'</p>';
                echo '</div>';
                echo '</div>';
            }

            // End the table HTML
            echo '</div>';

            $stmt->close();
            $con->close();
            ?>
			</div>
		</div>
	</body>
</html>