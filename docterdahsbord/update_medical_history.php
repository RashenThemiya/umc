<?php
// Include the database connection configuration file
require_once "db.php";

// Initialize notification message variable
$notification = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if studentId, studentIndex, and medicalHistory are set and not empty
    if (isset($_POST["studentId"]) && isset($_POST["studentIndex"]) && isset($_POST["medicalHistory"]) && !empty($_POST["studentId"]) && !empty($_POST["studentIndex"]) && !empty($_POST["medicalHistory"])) {
        // Sanitize inputs to prevent SQL injection
        $studentId = $_POST["studentId"];
        $studentIndex = $_POST["studentIndex"];
        $medicalHistory = $_POST["medicalHistory"];

        // Prepare and execute SQL query to insert a new record into student_medical_records table
        $sql_insert = "INSERT INTO student_medical_records (student_id, medical_history, last_updated, student_index) VALUES (?, ?, current_timestamp(), ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "isi", $studentId, $medicalHistory, $studentIndex);
        mysqli_stmt_execute($stmt_insert);

        // Check if insert was successful
        if (mysqli_stmt_affected_rows($stmt_insert) > 0) {
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