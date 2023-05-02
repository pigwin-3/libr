<?php
session_start();
// If the user is not logged in redirect to the login page...

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
		<div class="top">
            <form id="search" method="GET" action="">
                <input id="searchbar" type="text" name="q" placeholder="tittel/forfatter/isbn" value="<?php if (isset($_GET['q'])) { echo $_GET['q']; } ?>">
                <input id="searchexecute" type="submit" value="søk">
            </form>
        </div>
        <div class="cont">
        <?php
        require '../tools/database.php';
        if (isset($_GET['q'])) {
            if ($_GET['q'] != ""){
                $querry = "%" . $_GET['q'] . "%";
                //echo $querry;

                $stockstate = '1';

                $stmt = $con->prepare('SELECT b.bookid, b.isbn, b.name, b.author, b.oclc, COUNT(bc.id) as in_stock_count FROM books b LEFT JOIN bookcopy bc ON b.bookid = bc.bookid AND bc.instock = ? WHERE b.isbn LIKE ? OR b.name LIKE ? OR b.author LIKE ? GROUP BY b.bookid ORDER BY CASE  WHEN b.isbn LIKE ? THEN 1  WHEN b.name LIKE ? THEN 2  WHEN b.author LIKE ? THEN 3  ELSE 4  END');
                $stmt->bind_param('sssssss', $stockstate, $querry, $querry, $querry, $querry, $querry, $querry);

                //var_dump($stmt);

                $stmt->execute();
                $stmt->bind_result( $bookid, $isbn, $name, $author, $oclc, $stock);
                //$stmt->close();
                echo "<div class='bookshelf'>";
                while ($stmt->fetch()) {
                    echo "<div class='book-item'>";
                    echo "<img class='bookimg' src='https://covers.openlibrary.org/b/olid/$oclc-M.jpg' alt=''>";
                    echo "<div class='book-item-title'>$name</div>";
                    echo "<div class='book-item-author'>$author</div>";
                    echo "<div class='book-item-title'>ledige: $stock</div>";
                    echo "<div class='book-item-isbn'>".format_isbn($isbn)."</div>";
                    echo "</div>";
                }
                echo "</div>";
                /*
                echo "<table>";
                echo "<tr><th>Book ID</th><th>ISBN</th><th>Name</th><th>Author</th><th>OCLC</th><th>stock</th></tr>";
                while ($stmt->fetch()) {
                    echo "<tr><td>$bookid</td><td>$isbn</td><td>$name</td><td>$author</td><td>$oclc</td><td>$stock</td></tr>";
                }
                echo "</table>";
                */
            } else {
                echo "skriv noe in i søkefeltet";
            }
            //stuff
        } else {
            echo "vendligst søk på noe";
        }
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