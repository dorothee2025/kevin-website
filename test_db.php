<?php
// test_db.php - Simple database connection test

require_once 'api/config.php';

$conn = get_db();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Database connected successfully!";

// Test a simple query
$result = $conn->query("SHOW TABLES");
if ($result) {
    echo "<br>Tables in database:<br>";
    while ($row = $result->fetch_array()) {
        echo "- " . $row[0] . "<br>";
    }
} else {
    echo "<br>Failed to query tables: " . $conn->error;
}

$conn->close();
?>