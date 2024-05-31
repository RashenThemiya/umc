<?php
// Include the database connection configuration file
require_once "db.php";

// Initialize notification message variable
$notification = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if studentId, studentIndex, and medicalHistory are set and not empty
    if (isset($_POST["studentIdd"]) && isset($_POST["studentIndexx"]) && isset($_POST["medicalHistory"]) && !empty($_POST["studentIdd"]) && !empty($_POST["studentIndexx"]) && !empty($_POST["medicalHistory"])) {
        // Sanitize inputs to prevent SQL injection
        $studentId = mysqli_real_escape_string($conn, $_POST["studentIdd"]);
        $studentIndex = mysqli_real_escape_string($conn, $_POST["studentIndexx"]);
        $medicalHistory = mysqli_real_escape_string($conn, $_POST["medicalHistory"]);

        // Prepare and execute SQL query to insert a new record into student_medical_records table
        $sql_insert = "INSERT INTO student_medical_records (student_id, medical_history, last_updated, student_index) VALUES ('$studentId', '$medicalHistory', current_timestamp(), '$studentIndex')";
        
        if (mysqli_query($conn, $sql_insert)) {
            $notification = "New record inserted successfully.";
        } else {
            $notification = "Failed to insert new record.";
        }
    } else {
        $notification = "Student ID, student index, and medical history must be provided.";
    }
    header("Location: doctor_dashboard.php");
}
?>
