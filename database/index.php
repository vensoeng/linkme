<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "linkme";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    echo "can't connect to database";
    die("Connection failed: " . mysqli_connect_error());
}
$conn->set_charset("utf8mb4");
