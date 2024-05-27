<?php
// Include db.php to establish the database connection
require_once 'db.php';

// Query to fetch medical records with pending approval status
$sql = "SELECT * FROM requesting_medical WHERE approval_status = 'pending'";
$result = $db->query($sql);

// Array to store the fetched records
$records = [];

// If there are records, fetch them and add them to the array
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}

// Close the database connection
$db->close();

// Return the records as JSON data
echo json_encode($records);
?>
