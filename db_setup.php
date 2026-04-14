<?php
// This script should be run manually on a system where you have MySQL access
// It will attempt to create a new user called 'halcon_user' with password 'halcon_password'

$host = '127.0.0.1';
$port = '3306';
$admin_username = 'root';
$admin_password = ''; // Try with empty password first
$new_username = 'halcon_user';
$new_password = 'halcon_password';
$dbname = 'halcon_db';
$output = '';

try {
    // First try with no password
    $output .= "Attempting to connect to MySQL with root (no password)...\n";
    try {
        $conn = new PDO("mysql:host=$host;port=$port", $admin_username, $admin_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $output .= "Connected to MySQL successfully with root (no password)!\n";
    } catch(PDOException $e) {
        $output .= "Failed to connect with no password: " . $e->getMessage() . "\n";
        
        // If that fails, prompt for password
        $output .= "Please edit this file and set the correct root password in the \$admin_password variable.\n";
        throw new Exception("Cannot proceed without MySQL access");
    }
    
    // First check if database exists, create if not
    $result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");
    if($result->rowCount() === 0) {
        $output .= "Database $dbname does not exist. Creating it now...\n";
        $conn->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $output .= "Database $dbname created successfully!\n";
    } else {
        $output .= "Database $dbname already exists.\n";
    }
    
    // Check if user exists already
    $checkUser = $conn->query("SELECT user FROM mysql.user WHERE user = '$new_username'");
    if($checkUser->rowCount() === 0) {
        // Create the user
        $output .= "Creating new user $new_username...\n";
        $conn->exec("CREATE USER '$new_username'@'localhost' IDENTIFIED BY '$new_password'");
        $conn->exec("GRANT ALL PRIVILEGES ON `$dbname`.* TO '$new_username'@'localhost'");
        $conn->exec("FLUSH PRIVILEGES");
        $output .= "User $new_username created successfully with all privileges on $dbname!\n";
    } else {
        $output .= "User $new_username already exists. Updating permissions...\n";
        $conn->exec("GRANT ALL PRIVILEGES ON `$dbname`.* TO '$new_username'@'localhost'");
        $conn->exec("FLUSH PRIVILEGES");
        $output .= "Permissions updated for $new_username.\n";
    }
    
    $output .= "\nConfiguration completed successfully! Update your .env file with:\n";
    $output .= "DB_CONNECTION=mysql\n";
    $output .= "DB_HOST=127.0.0.1\n";
    $output .= "DB_PORT=3306\n";
    $output .= "DB_DATABASE=$dbname\n";
    $output .= "DB_USERNAME=$new_username\n";
    $output .= "DB_PASSWORD=$new_password\n";
    
} catch(Exception $e) {
    $output .= "Error: " . $e->getMessage() . "\n";
}

echo $output;
file_put_contents('db_setup_result.txt', $output);
?>
