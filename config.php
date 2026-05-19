<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "student_portal";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
