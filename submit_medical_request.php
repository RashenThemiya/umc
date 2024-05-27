<?php
// Include the database connection
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST['student_index']) && isset($_FILES['document']['name']) && isset($_POST['medical_duration']) && isset($_POST['exam_or_lecture_details']) && isset($_POST['faculty']) && isset($_POST['department']) && isset($_POST['approval_status']) && isset($_POST['student_email']) && isset($_POST['faculty_email']) && isset($_POST['lecture_email']) && isset($_POST['department_email'])) {
        
        // Extract data from the POST array
        $student_index = $_POST['student_index'];
        $document_name = $_FILES['document']['name'];
        $document_tmp_name = $_FILES['document']['tmp_name'];
        $medical_duration = $_POST['medical_duration'];
        $exam_or_lecture_details = $_POST['exam_or_lecture_details'];
        $faculty = $_POST['faculty'];
        $department = $_POST['department'];
        $approval_status = $_POST['approval_status'];
        $student_email = $_POST['student_email'];
        $faculty_email = $_POST['faculty_email'];
        $lecture_email = $_POST['lecture_email'];
        $department_email = $_POST['department_email'];
        
        // Check if a document is uploaded
        if (!empty($document_name) && !empty($document_tmp_name)) {
            // Read the contents of the file
            $document_content = file_get_contents($document_tmp_name);
            $document_content = mysqli_real_escape_string($conn, $document_content); // Escape special characters
            
            // Prepare SQL statement to insert data into the database
            $sql = "INSERT INTO requesting_medical (student_index, document, medical_duration, exam_or_lecture_details, faculty, department, approval_status, student_email, faculty_email, lecture_email, department_email, date, time) 
                    VALUES ('$student_index', '$document_content', '$medical_duration', '$exam_or_lecture_details', '$faculty', '$department', '$approval_status', '$student_email', '$faculty_email', '$lecture_email', '$department_email', CURDATE(), CURTIME())";

            // Execute the SQL statement
            if (mysqli_query($conn, $sql)) {
                // Form submission successful, send success response
                $response = array("success" => true);
                echo json_encode($response);
            } else {
                // Form submission failed, send error response
                $response = array("success" => false, "error" => "Error inserting data into the database.");
                echo json_encode($response);
            }
        } else {
            // Missing document, send error response
            $response = array("success" => false, "error" => "Document not uploaded.");
            echo json_encode($response);
        }
    } else {
        // Missing required fields, send error response
        $response = array("success" => false, "error" => "Missing required fields.");
        echo json_encode($response);
    }
} else {
    // Invalid request method, send error response
    $response = array("success" => false, "error" => "Invalid request method.");
    echo json_encode($response);
}
?>
