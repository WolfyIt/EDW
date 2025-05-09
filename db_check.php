<?php
$host = '127.0.0.1';
$port = '3306';
$username = 'root';
$password = 'edwdb'; // Added a password for testing
$dbname = 'halcon_db';
$output = '';

try {
    $output .= "Attempting to connect to MySQL...\n";
    $conn = new PDO("mysql:host=$host;port=$port", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if database exists
    $result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");
    if($result->rowCount() === 0) {
        $output .= "Database $dbname does not exist. Creating it now...\n";
        $conn->exec("CREATE DATABASE `$dbname`");
        $output .= "Database $dbname created successfully!\n";
    } else {
        $output .= "Database $dbname already exists.\n";
    }
    
    $output .= "MySQL connection successful!\n";
} catch(PDOException $e) {
    $output .= "Connection failed: " . $e->getMessage() . "\n";
}

echo $output;
file_put_contents('db_result.txt', $output);
?>
