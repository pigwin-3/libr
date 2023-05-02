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
					<h1 class="page-name">legg til bok</h1>
				</div>
				<form action="" class="admin-form" method="post">

					<label for="isbn">ISBN:</label>
					<input type="text" id="isbn" name="isbn" class="admin-input" pattern="^[0-9 \-]*$" placeholder="978-0-8129-7656-4">

					<button class="admin-input" type="button" onclick="getDataFromISBN()">Get data from ISBN</button>

					<label for="title">Title:</label>
					<input type="text" id="title" name="title" class="admin-input" placeholder="Book Title" required>

					<label for="author">Author:</label>
					<input type="text" id="author" name="author" class="admin-input" placeholder="Ola Norman">

					<label for="olid">Open Library ID:</label>
					<input type="text" id="olid" name="olid" class="admin-input" placeholder="OL8021191M">

					<input type="submit" value="submit" id="submit-btn" class="admin-input">
				</form>

			</div>
			<div class="admin-settings-container">
			<?php
			if( isset($_POST['title']) )
			{
				require '../../tools/database.php';

				$stmt1 = $con->prepare("INSERT INTO books (isbn, name, author, oclc) SELECT isbn, name, author, oclc FROM (SELECT ? AS isbn, ? AS name, ? AS author, ? AS oclc) AS tmp WHERE NOT EXISTS ( SELECT * FROM books WHERE isbn = ? AND name = ? AND author = ? AND oclc = ? ) LIMIT 1");
				// Bind the values to the placeholders
				if (validate_isbn($_POST['isbn']) == 2) {
					//echo 'Valid ISBN';
					$isbn = unformat_isbn($_POST['isbn']);
				} elseif (validate_isbn($_POST['isbn']) == 0) {
					//echo 'No ISBN or ISBN wrong length';
					$isbn = '0';
				} else {
					//echo 'Invalid ISBN';
					$isbn = '0';
				}

				$name = $_POST['title'];
				$author = $_POST['author'];
				if( $_POST['olid'] != '' ) {
					$oclc = $_POST['olid'];
				} else {
					$oclc = '0';
				}
                $stmt1->bind_param('ssssssss', $isbn, $name, $author, $oclc, $isbn, $name, $author, $oclc);
				echo "test";
				$stmt1->execute();

				$stmt2 = $con->prepare("INSERT INTO bookcopy (bookid, `instock`) VALUES ((SELECT bookid FROM books WHERE isbn = ? AND name = ? AND author = ? AND oclc = ?), 1)");
				$stmt2->bind_param('ssss', $isbn, $name, $author, $oclc);
				$stmt2->execute();


				$stmt = $con->prepare('SELECT * FROM `books` WHERE `isbn` = ? AND `name`= ? AND `author` = ? AND `oclc` = ?');
				$stmt->bind_param('ssss', $isbn, $name, $author, $oclc);
				$stmt->execute();
				$stmt->bind_result($bookid, $isbn, $name, $author, $oclc);

				echo "<div>bookids: ";
				while ($stmt->fetch()) {
					echo $bookid, ", ";
				}
				echo "</div>";



				echo "<div>book added yay</div>";
				echo '<img src="https://covers.openlibrary.org/b/olid/', $oclc, '-M.jpg" alt="cover" class="admin-cover">';
				echo "<div>title	:	", $name, "</div>";
				echo "<div>author	:	", $author, "</div>";
				echo "<div>isbn	:	", unformat_isbn($isbn), "</div>";

			}

			// make storage ready
			function unformat_isbn($isbn) {
				$isbn = str_replace(array('-', ' '), '', $isbn); // remove all bad formating stuff
				return $isbn;
			}

			// Function to format an ISBN by adding -
			function format_isbn($isbn) {
				$isbn = str_replace(array('-', ' '), '', $isbn); // remove all bad formating stuff
				$formatted_isbn = '';
				if (strlen($isbn) == 10) {
				// ISBN-10 = n-nnnn-nnn-c
				$formatted_isbn = substr($isbn, 0, 1) . '-' . substr($isbn, 1, 4) . '-' . substr($isbn, 5, 3) . '-' . substr($isbn, 8, 1);
				} else if (strlen($isbn) == 13) {
				// ISBN-13: = n-nnnn-nnnn-n-c
				$formatted_isbn = substr($isbn, 0, 3) . '-' . substr($isbn, 3, 4) . '-' . substr($isbn, 7, 5) . '-' . substr($isbn, 12, 1);
				} else {
				// wrong length
				$formatted_isbn = 'Invalid ISBN';
				}
				return $formatted_isbn;
			}
			
			// Function to validate an ISBN using a regular expression
			function validate_isbn($isbn) {
				$isbn = str_replace(array('-', ' '), '', $isbn); // Remove existing hyphens and spaces
				if (strlen($isbn) == 10 || strlen($isbn) == 13) {
				if (preg_match('/^(97(8|9))?\d{9}(\d|X)$/', $isbn)) {
					return 2; // Valid ISBN (:
				} else {
					return 1; // Invalid ISBN ):
				}
				} else {
				return 0; // Invalid length (id say its average ;) )
				}
			}  
			  
			?>
			</div>
		</div>
	</body>
</html>