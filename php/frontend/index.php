<?php
session_start();
//always needs to be started even if not used here as it is used in navbar
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>index</title>
		<link href="style/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href='https://fonts.googleapis.com/css?family=Atkinson Hyperlegible' rel='stylesheet'>
	</head>
	<body class="loggedin">
        <?php include '../tools/navbar.php'; ?>
		<div id="hero">
        <form id="hero-search" action="search.php" method="get">
            <input id="hero-searchbar" type="text" name="q" placeholder="en kul bok">
            <input id="hero-searchexecute" type="button" value="søk">
        </form>
		</div>
		<div class="cont">
			<?php
			require '../tools/database.php';

			$stmt = $con->prepare('SELECT b.bookid,b.isbn,b.name,b.author,b.oclc,COUNT(bc.id)AS in_stock_count FROM books b LEFT JOIN bookcopy bc ON b.bookid=bc.bookid AND bc.instock=1 GROUP BY b.bookid HAVING in_stock_count>0 ORDER BY RAND()LIMIT 4');

			$stmt->execute();
			$stmt->bind_result( $bookid, $isbn, $name, $author, $oclc, $stock);
			//$stmt->close();
			echo "<div class='bookshelf'>";
			while ($stmt->fetch()) {
				echo "<div class='book-item'>";
				echo "<img class='bookimg' src='https://covers.openlibrary.org/b/olid/$oclc-M.jpg' alt=''>";
				echo "<div class='book-item-title'>$name</div>";
				echo "<div class='book-item-author'>$author</div>";
				echo "<div class='book-item-stock'>ledige: $stock</div>";
				echo "<div class='book-item-isbn'>".format_isbn($isbn)."</div>";
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