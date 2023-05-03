<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ./login.html');
	exit;
}
require '../tools/database.php';
// gets user info from db useing id
$stmt = $con->prepare('SELECT email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($email);
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
        <?php include '../tools/navbar.php'; ?>
		<div class="cont">
			<div>
				<h2>din bibloteksprofil</h2>
				<div>
					<div>navn: <?=$_SESSION['name']?></div>
					<div>epost: <?=$email?></div>
				</div>
				<h3>nåværende utlån</h3>
			</div>
		</div>
		<div class="cont">
		<?php
		$stmt = $con->prepare('SELECT books.name, books.isbn, books.author, books.oclc, loan.loandate, loan.loanend FROM loan JOIN bookcopy ON loan.id = bookcopy.id JOIN books ON bookcopy.bookid = books.bookid JOIN accounts ON loan.usrid = accounts.id WHERE loan.usrid = ?');
		$stmt->bind_param('i', $_SESSION['id']);

		//var_dump($stmt);

		$stmt->execute();
		$stmt->bind_result( $name, $isbn, $author, $oclc, $loandate, $loanend);
		//$stmt->close();
		echo "<div class='bookshelf'>";
		while ($stmt->fetch()) {
			echo "<div class='book-item'>";
			echo "<img class='bookimg' src='https://covers.openlibrary.org/b/olid/$oclc-M.jpg' alt=''>";
			echo "<div class='book-item-title'>$name</div>";
			echo "<div class='book-item-author'>$author</div>";
			echo "<div class='book-item-isbn'>".format_isbn($isbn)."</div>";
			echo "<div class='book-item-loanstart-label'>Loan started:</div>";
			echo "<div class='book-item-loanstart'>".date("Y-m-d", strtotime($loandate))."</div>";
			echo "<div class='book-item-loanstart-label'>Return by:</div>";
			echo "<div class='book-item-loanend'>".date("Y-m-d", strtotime($loanend))."</div>";
			echo "</div>";
		}
		echo "</div>";
		echo "</div><div class='cont'>";
		echo "<h3>tiligere utlån</h3>";
		echo "</div><div class='cont'>";
		$stmt2 = $con->prepare('SELECT books.name, books.isbn, books.author, books.oclc, loanlog.loanreturn FROM loanlog JOIN bookcopy ON loanlog.id = bookcopy.id JOIN books ON bookcopy.bookid = books.bookid JOIN accounts ON loanlog.usrid = accounts.id WHERE loanlog.usrid = ? ORDER BY loanlog.loanreturn DESC');
		$stmt2->bind_param('i', $_SESSION['id']);

		//var_dump($stmt);

		$stmt2->execute();
		$stmt2->bind_result( $name, $isbn, $author, $oclc, $loanreturn);
		echo "<div class='bookshelf'>";
		while ($stmt2->fetch()) {
			echo "<div class='book-item'>";
			echo "<img class='bookimg' src='https://covers.openlibrary.org/b/olid/$oclc-M.jpg' alt=''>";
			echo "<div class='book-item-title'>$name</div>";
			echo "<div class='book-item-author'>$author</div>";
			echo "<div class='book-item-isbn'>".format_isbn($isbn)."</div>";
			echo "<div class='book-item-loanstart-label'>Ble retunert:</div>";
			echo "<div class='book-item-loanstart'>".date("Y-m-d", strtotime($loanreturn))."</div>";
			echo "</div>";
		}
		echo "</div>";
		function format_isbn($isbn) {
            $formatted_isbn = '';
            if (strlen($isbn) == 10) {
            // ISBN-10 = n-nnnn-nnn-c
            $formatted_isbn = substr($isbn, 0, 1) . '-' . substr($isbn, 1, 4) . '-' . substr($isbn, 5, 3) . '-' . substr($isbn, 8, 1);
            } else if (strlen($isbn) == 13) {
            // ISBN-13: = n-nnnn-nnnn-n-c
            $formatted_isbn = substr($isbn, 0, 3) . '-' . substr($isbn, 3, 4) . '-' . substr($isbn, 7, 5) . '-' . substr($isbn, 12, 1);
            } else {
            // wrong length
            $formatted_isbn = 'No ISBN';
            }
            return $formatted_isbn;
        }
		?>
		</div>
	</body>
</html>