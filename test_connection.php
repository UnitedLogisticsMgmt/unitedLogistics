<?php
$servername = "localhost";
$username = "jondevops";
$password = "Jdj321Jdj321!";
$dbname = "united_logistics_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
