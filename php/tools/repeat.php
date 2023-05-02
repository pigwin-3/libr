suff: <?php 
require 'database.php';

// create a prepared statement
$stmt = $con->prepare("SHOW TABLES LIKE ?");

// bind the parameter
$table_name = 'accounts';
$stmt->bind_param("s", $table_name);

// execute the prepared statement
$stmt->execute();

// bind the result variable
$stmt->bind_result($table);

// fetch the results
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