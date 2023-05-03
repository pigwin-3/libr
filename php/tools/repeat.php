suff: <?php 
require 'database.php';

$table_name = 'accounts';

$stmt = $con->prepare("SHOW TABLES LIKE '$table_name'");

$stmt->execute();

$stmt->bind_result($table);

$table_exists = false;
while ($stmt->fetch()) {
    $table_exists = true;
    break;
}

// check if the table exists or not
if ($table_exists) {
    echo "Table $table_name exists!";
} else {
    echo "Table $table_name does not exist.";
}

// close the prepared statement
$stmt->close();

// close the con connection
$con->close();
?><br>