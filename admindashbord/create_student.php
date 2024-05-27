<?php
// Include the database connection file
include 'db.php';

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];
$student_index = $_POST['student_index'];

// Insert data into users table
$sql = "INSERT INTO users (username, password, role, student_index) VALUES ('$username', '$password', 'student', '$student_index')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Student ACCOUNT CREATED');</script>";
    // Redirect back to the previous page
    echo "<script>window.location.href = '".$_SERVER['HTTP_REFERER']."';</script>";
} else {
    echo "<script>alert('Student ACCOUNT DIDNT CREATED');</script>";
    // Redirect back to the previous page
    echo "<script>window.location.href = '".$_SERVER['HTTP_REFERER']."';</script>";
}

$conn->close();
?>
