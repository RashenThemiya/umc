<?php
$servername = "db";  // Use the service name defined in the Docker Compose file
$username = "user";   // Use the same username defined in your Docker Compose
$password = "1234";   // Use the password defined in your Docker Compose
$dbname = "umc1";     // Database name

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
