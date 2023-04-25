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
        <link href='https://fonts.googleapis.com/css?family=Atkinson Hyperlegible' rel='stylesheet'>
	</head>
	<body>



        <?php include '../../tools/navbar.html'; ?>
		<div class="admin-center">
			<div class="admin-settings-container-top">
				<div class="admin-left-card">
					<a href="
                    <?php
                    $dir = dirname($_SERVER['PHP_SELF']);
                    if (isset($_GET['r'])){
                        if ($_GET['r'] == "lb"){
                            // return to ListBooks.php
                            $params = array(
                                'filter_by' => isset($_GET['filter_by']) ? $_GET['filter_by'] : null,
                                'filter_letter' => isset($_GET['filter_letter']) ? $_GET['filter_letter'] : null,
                                'sort' => isset($_GET['sort']) ? $_GET['sort'] : null,
                                'page' => isset($_GET['page']) ? $_GET['page'] : null
                            );
                            $params = array_filter($params); // remove any null values
                            $params = http_build_query($params);
                            $url = "{$dir}/listbooks.php?{$params}";
                            echo $url;
                        } else {
                            echo "./";
                        }    
                    } else {
                        echo "./";
                    }
                    ?>
                    "><img src="../assets/back.svg" alt="back buttton" class="admin-icon"></a>
					<h1 class="page-name">rediger en bok</h1>
				</div>
                <?php 
                require '../../tools/database.php';
                if( isset($_POST['title']) ){
                    $stmt = $con->prepare('UPDATE `books` SET `isbn`=?,`name`=?,`author`=?,`oclc`=? WHERE `bookid`=?');
                    $stmt->bind_param('sssss', $_POST['isbn'], $_POST['title'], $_POST['author'], $_POST['olid'], $_POST['id']);
                    $stmt->execute();
                    if (isset($_GET['r'])) {
                        $dir = dirname($_SERVER['PHP_SELF']);
                        if ($_GET['r'] == "lb"){
                            // return to ListBooks.php
                            $params = array(
                                'filter_by' => isset($_GET['filter_by']) ? $_GET['filter_by'] : null,
                                'filter_letter' => isset($_GET['filter_letter']) ? $_GET['filter_letter'] : null,
                                'sort' => isset($_GET['sort']) ? $_GET['sort'] : null,
                                'page' => isset($_GET['page']) ? $_GET['page'] : null
                            );
                            $params = array_filter($params); // remove any null values
                            $params = http_build_query($params);
                            $url = "{$dir}/listbooks.php?{$params}";
                            echo $url;
                            header('Location: '. $url);
                            echo "<br>";
                            echo "return to list books";
                        } else {
                            echo "ERROR: failed to redirect back";
                            echo "<div>book updated!</div>";
                            echo "<div>edit another book:</div>";
                            echo "<form method='GET' action=''>";
                            echo "<label for='id'>Book id:</label><input type='text' id='id' name='id' class='admin-input' placeholder='1'>";
                            echo "<input type='submit' value='submit' id='submit-btn' class='admin-input'>";
                            echo "</form>";
                        }
                    }
                    else{
                        echo "<div>book updated!</div>";
                        echo "<div>edit another book:</div>";
                        echo "<form method='GET' action=''>";
                        echo "<label for='id'>Book id:</label><input type='text' id='id' name='id' class='admin-input' placeholder='1'>";
                        echo "<input type='submit' value='submit' id='submit-btn' class='admin-input'>";
                        echo "</form>";
                    }
                }else{
                    if (isset($_GET['id'])) {
                        $boid = $_GET['id'];
                        echo "<form action='' class='admin-form' method='post'>";
                        echo "<label for='id'>Book id:</label><input type='text' id='id' name='id' class='admin-input' placeholder='1' value='", $boid,"'>";
                        $stmt = $con->prepare('SELECT `isbn`, `name`, `author`, `oclc` FROM `books` WHERE `bookid` = ?;');
                        $stmt->bind_param('i', $boid);
                        $stmt->execute();
                        $stmt->bind_result($isbn, $name, $author, $oclc);
                        $stmt->fetch();
                        echo "<label for='isbn'>ISBN:</label><input type='text' id='isbn' name='isbn' class='admin-input' pattern='^[0-9 \-]*$' placeholder='978-0-8129-7656-4' value='", $isbn,"'>";
                        echo "<label for='title'>Title:</label><input type='text' id='title' name='title' class='admin-input' placeholder='Book Title' value='", $name,"' required>";
                        echo "<label for='author'>Author:</label><input type='text' id='author' name='author' class='admin-input' placeholder='Ola Norman' value='", $author,"'>";
                        echo "<label for='olid'>Open Library ID:</label><input type='text' id='olid' name='olid' class='admin-input' placeholder='OL8021191M' value='", $oclc,"'>";
                        echo "<input type='submit' value='submit' id='submit-btn' class='admin-input'>";
                        echo "</form>";
                    }
                    else {
                        echo "<form method='GET' action=''>";
                        echo "<label for='id'>Book id:</label><input type='text' id='id' name='id' class='admin-input' placeholder='1'>";
                        echo "<input type='submit' value='submit' id='submit-btn' class='admin-input'>";
                        echo "</form>";
                    }
                }
                ?>
			</div>
		</div>
	</body>
</html>