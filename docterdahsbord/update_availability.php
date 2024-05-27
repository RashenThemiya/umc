<?php
// Start the session
session_start();

// Include the database connection file
include 'db.php';

// Check if 'username' is set in the session
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit(); // Stop further execution
}

// Check if form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if availability and doctorId are set and not empty
    if (isset($_POST["availability"]) && isset($_POST["doctorId"]) && !empty($_POST["doctorId"])) {
        // Get the availability value
        $availability = isset($_POST["availability"]) ? $_POST["availability"] : 'Unavailable'; // Default to Unavailable if checkbox is not checked
        $doctorId = $_POST["doctorId"];

        // Prepare and execute SQL query to update the doctor's availability
        $sql_update = "UPDATE doctor_availability SET availability = ? WHERE doctor_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $availability, $doctorId);
        $stmt_update->execute();

        // Check if update was successful
        if ($stmt_update->affected_rows > 0) {
            $notification = "Availability updated successfully.";
        } else {
            $notification = "Failed to update availability.";
        }

        // Close the statement
        $stmt_update->close();
    } else {
        $notification = "Doctor ID must be provided.";
    }
} else {
    // If the form is not submitted via POST method, redirect to doctor_dashboard.php
    header("Location: doctor_dashboard.php");
    exit();
}

// Close database connection
$conn->close();

// Redirect back to doctor_dashboard.php with a notification
header("Location: doctor_dashboard.php?notification=" . urlencode($notification));
exit();
?>
