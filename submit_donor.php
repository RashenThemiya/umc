<?php
// Include the database connection file
require 'db.php';

// Capture form data and sanitize it
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
$donate_thing = mysqli_real_escape_string($conn, $_POST['donate_thing']);
$message = mysqli_real_escape_string($conn, $_POST['message']);
$amount = 0.00; // Set a default value or capture this from the form if needed
$status = 'pending'; // Set the default status to 'pending'

// Construct the SQL query
$sql = "INSERT INTO pending_donor (name, email, mobile, donate_thing, message, amount, status) 
        VALUES ('$name', '$email', '$mobile', '$donate_thing', '$message', $amount, '$status')";

// Execute the query
if (mysqli_query($conn, $sql)) {
    // Success: Show alert and redirect to the previous page
    echo "<script>
            alert('New pending donor record created successfully');
            window.history.go(-1);
          </script>";
} else {
    // Error: Show alert and redirect to the previous page
    echo "<script>
            alert('Error: " . mysqli_error($conn) . "');
            window.history.go(-1);
          </script>";
}

// Close the connection
mysqli_close($conn);
?>
