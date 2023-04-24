<!DOCTYPE html>
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
// if perm is 1 or lower exit 
if($perm <= 1) {
    header('Location: ../');
	exit;
}
?>
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
            <div class="admin-left-card">
                <a href="./"><img src="../assets/back.svg" alt="back buttton" class="admin-icon"></a>
                <h1 class="page-name">alle bøker</h1>
            </div>
            <div class="admin-card">
                <form method="GET" action="">
                <select name="filter_by">
                        <option value="name" selected>Filter by book name</option>
                        <option value="author">Filter by author's last name</option>
                    </select>
                    <select name="filter_letter" id="filter_letter">
                        <option value="">All</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                        <option value="I">I</option>
                        <option value="J">J</option>
                        <option value="K">K</option>
                        <option value="L">L</option>
                        <option value="M">M</option>
                        <option value="N">N</option>
                        <option value="O">O</option>
                        <option value="P">P</option>
                        <option value="Q">Q</option>
                        <option value="R">R</option>
                        <option value="S">S</option>
                        <option value="T">T</option>
                        <option value="U">U</option>
                        <option value="V">V</option>
                        <option value="W">W</option>
                        <option value="X">X</option>
                        <option value="Y">Y</option>
                        <option value="Z">Z</option>
                        <option value="Æ">Æ</option>
                        <option value="Ø">Ø</option>
                        <option value="Å">Å</option>
                    </select>
                    <select name="sort">
                        <option value="name" selected>Sort by book name</option>
                        <option value="author">Sort by author's last name</option>
                    </select>
                    <input type="submit" value="Filter">
                </form>
                <script>
                    //document.getElementById('filter_letter').value = 'B';
                </script>
            </div>
            
            <?php

            // results per page
            $results_per_page = 20;

            require '../../tools/database.php';

            // Get the selected letter
            if (isset($_GET['filter_letter'])) {
                $first_letter = $_GET['filter_letter']. "%";
            } else {
                $first_letter = "%";
            }

            // sorting option
            if (isset($_GET['sort'])) {
                $sort = $_GET['sort'];
            } else {
                $sort = 'name';
            }

            // Get filter
            if (isset($_GET['filter_by'])) {
                $filter = $_GET['filter_by'];
            } else {
                $filter = 'name';
            }

            // get total number of results
            if ($filter == 'author') {
                $count_stmt = $con->prepare('SELECT COUNT(*) FROM `books` WHERE SUBSTRING_INDEX(`author`, " ", -1) LIKE ?');
            } else {
                $count_stmt = $con->prepare('SELECT COUNT(*) FROM `books` WHERE `name` LIKE ?');
            }
            $count_stmt->bind_param('s', $first_letter);
            $count_stmt->execute();
            $count_stmt->bind_result($total_results);
            $count_stmt->fetch();
            $count_stmt->close();

            // get total amount of pages
            $total_pages = ceil($total_results / $results_per_page);

            echo "Got ", $total_results, " results";

            // get page number
            if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $total_pages) {
                $current_page = $_GET['page'];
            } else {
                $current_page = 1;
            }

            // get offset
            $offset = ($current_page - 1) * $results_per_page;

            // get books that are on the current page
            if ($filter == 'author') {
                if ($sort == 'author') {
                    $stmt = $con->prepare('SELECT `bookid`, `isbn`, `name`, `author`, `oclc` FROM `books` WHERE SUBSTRING_INDEX(`author`, " ", -1) LIKE ? ORDER BY SUBSTRING_INDEX(`author`, " ", -1) ASC LIMIT ? OFFSET ?');
                } else {
                    $stmt = $con->prepare('SELECT `bookid`, `isbn`, `name`, `author`, `oclc` FROM `books` WHERE SUBSTRING_INDEX(`author`, " ", -1) LIKE ? ORDER BY `name` LIMIT ? OFFSET ?');
                }
            } else {
                if ($sort == 'author') {
                    $stmt = $con->prepare('SELECT `bookid`, `isbn`, `name`, `author`, `oclc` FROM `books` WHERE `name` LIKE ? ORDER BY SUBSTRING_INDEX(`author`, " ", -1) ASC LIMIT ? OFFSET ?');
                } else {
                    $stmt = $con->prepare('SELECT `bookid`, `isbn`, `name`, `author`, `oclc` FROM `books` WHERE `name` LIKE ? ORDER BY `name` LIMIT ? OFFSET ?');
                }
            }
            $stmt->bind_param('sii', $first_letter, $results_per_page, $offset);
            $stmt->execute();
            $stmt->bind_result($bookid, $isbn, $name, $author, $oclc);


            //get the params for in the url (used in page switcher and the edit link)
            $queryParams = $_GET;


            // Start the card container
            echo '<div class="admin-card-container">';

            // Loop through each book and display its information in a row (now card)
            while ($stmt->fetch()) {
                echo '<div class="admin-card">';
                echo '<img src="https://covers.openlibrary.org/b/olid/'.$oclc.'-M.jpg" alt="cover">';
                echo '<div class="admin-card-details">';
                echo '<p class="admin-card-id">'.$bookid.'</p>';
                echo '<h2 class="admin-card-title">'.$name.'</h2>';
                echo '<p class="admin-card-author">'.$author.'</p>';
                echo '<p class="admin-card-isbn">'.format_isbn($isbn).'</p>';
                echo '</div>';
                echo '<a href="'. edit_link($bookid) .'">rediger</a>';
                echo '</div>';
            }

            // End the card container
            echo '</div>';

            $stmt->close();
            $con->close();

            // Function to format an ISBN by adding "-"
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
				$formatted_isbn = 'Invalid ISBN';
				}
				return $formatted_isbn;
			}
            function edit_link($id) {
                $dir = dirname($_SERVER['PHP_SELF']);

                // return to ListBooks.php
                $params = array(
                    'id' => $id,
                    'r' => 'lb',
                    'filter_by' => isset($_GET['filter_by']) ? $_GET['filter_by'] : null,
                    'filter_letter' => isset($_GET['filter_letter']) ? $_GET['filter_letter'] : null,
                    'sort' => isset($_GET['sort']) ? $_GET['sort'] : null,
                    'page' => isset($_GET['page']) ? $_GET['page'] : null
                );
                $params = array_filter($params); // remove any null values
                $params = http_build_query($params);
                $url = "{$dir}/editbook.php?{$params}";
                return $url;
            }
            
            echo '<div class="admin-page-switcher">';
            if ($current_page > 1) {
                $queryParams['page'] = $current_page - 1;
                echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'" class="admin-arrow">&lt;</a>';
            } else {
                echo '<a href="#" class="admin-arrow disabled">&lt;</a>';
            }

            if ($total_pages <= 9) {
                for ($i = 1; $i <= $total_pages; $i++) {
                    //if its the current page then add the class active
                    if ($i == $current_page) {
                        echo '<a href="#" class="active">', $i, '</a>';
                    } else {
                        $queryParams['page'] = $i;
                        echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'">', $i, '</a>';
                    }
                }
            } else {
                //adds the "..." depending on what the current page is set to
                if ($current_page <= 5) {
                    for ($i = 1; $i <= 7; $i++) {
                        if ($i == $current_page) {
                            echo '<a href="#" class="active">', $i, '</a>';
                        } else {
                            $queryParams['page'] = $i;
                            echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'">', $i, '</a>';
                        }
                    }
                    echo '<span class="admin-dots">...</span>';
                    $queryParams['page'] = $total_pages;
                    echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'">', $total_pages, '</a>';
                } elseif ($current_page > $total_pages - 5) {
                    $queryParams['page'] = 1;
                    echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'">1</a>';
                    echo '<span class="admin-dots">...</span>';
                    for ($i = $total_pages - 6; $i <= $total_pages; $i++) {
                        if ($i == $current_page) {
                            echo '<a href="#" class="active">', $i, '</a>';
                        } else {
                            $queryParams['page'] = $i;
                            echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'">', $i, '</a>';
                        }
                    }
                } else {
                    $queryParams['page'] = 1;
                    echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'">1</a>';
                    echo '<span class="admin-dots">...</span>';
                    for ($i = $current_page - 2; $i <= $current_page + 2; $i++) {
                        if ($i == $current_page) {
                            echo '<a href="#" class="active">', $i, '</a>';
                        } else {
                            $queryParams['page'] = $i;
                            echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'">', $i, '</a>';
                        }
                    }
                    echo '<span class="admin-dots">...</span>';
                    $queryParams['page'] = $total_pages;
                    echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'">', $total_pages, '</a>';
                }
            }

            if ($current_page < $total_pages) {
                $queryParams['page'] = $current_page + 1;
                echo '<a href="', $_SERVER['PHP_SELF'] . '?' . http_build_query($queryParams),'" class="admin-arrow">&gt;</a>';
            } else {
                echo '<a href="#" class="admin-arrow disabled">&gt;</a>';
            }
            echo '</div>';
            ?>
			</div>
		</div>
	</body>
</html>