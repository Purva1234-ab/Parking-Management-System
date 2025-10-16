<?php
// dbconnect.php
$servername = "localhost";
$username = "Project";
$password = "root";
$dbname = "Parking_System";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
