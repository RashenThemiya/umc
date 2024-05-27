<?php
// Include database connection
include 'db.php';

// Function to add a notice
if(isset($_POST['notice_heading']) && isset($_POST['notice_details'])) {
    $heading = $_POST['notice_heading'];
    $details = $_POST['notice_details'];
    $createdBy = 1; // Assuming admin's user_id is 1

    $sql = "INSERT INTO notice (notice_heading, notice_details, created_by) VALUES ('$heading', '$details', $createdBy)";
    if ($conn->query($sql) === TRUE) {
        echo "Notice added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
