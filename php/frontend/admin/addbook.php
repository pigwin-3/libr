<?php
session_start();

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



        <?php include '../../tools/navbar.html'; ?>
		<div class="admin-center">
			<div class="admin-settings-container-top">
				<form action="" class="admin-form" method="post">

					<label for="isbn">ISBN:</label>
					<input type="text" id="isbn" name="isbn" class="admin-input" pattern="[0-9]*" inputmode="numeric" placeholder="9780812976564">

					<button class="admin-input" type="button" onclick="getDataFromISBN()">Get data from ISBN</button>

					<label for="title">Title:</label>
					<input type="text" id="title" name="title" class="admin-input" placeholder="Book Title">

					<label for="author">Author:</label>
					<input type="text" id="author" name="author" class="admin-input" placeholder="Ola Norman">

					<label for="olid">Open Library ID:</label>
					<input type="text" id="olid" name="olid" class="admin-input" placeholder="OL8021191M">

					<input type="submit" value="submit" id="submit-btn" class="admin-input">
				</form>

			</div>
			<div class="admin-settings-container">
			<?php
			if( isset($_POST['olid']) )
			{
				echo "<div>book added yay</div>";
				echo '<img src="https://covers.openlibrary.org/b/olid/', $_POST['olid'], '-M.jpg" alt="cover" class="admin-cover">';
				echo "<div>title	:	", $_POST['title'], "</div>";
				echo "<div>author	:	", $_POST['author'], "</div>";

			}
			?>
			</div>
		</div>
	</body>
</html>