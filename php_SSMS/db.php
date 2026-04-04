<?php
// Database Connection File - db.php
// Connects to MySQL database via XAMPP

$host     = "localhost";
$user     = "root";
$password = "";         // default XAMPP has no password
$database = "ssms_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
// Connection successful - $conn is now available in any file that includes this
?>
