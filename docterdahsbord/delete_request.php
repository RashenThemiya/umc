<?php
// Include database connection
include 'db.php';

// Check if the request ID is provided
if(isset($_GET['request_id'])) {
    // Sanitize the input to prevent SQL injection
    $requestId = mysqli_real_escape_string($conn, $_GET['request_id']);
    
    // Query to delete the medical request with the specified request ID
    $sql_delete = "DELETE FROM requesting_medical WHERE request_id = '$requestId'";
    
    // Execute the query
    if ($conn->query($sql_delete) === TRUE) {
        // Return a success response
        echo "success";
    } else {
        // Return an error response
        echo "Error deleting request: " . $conn->error;
    }
} else {
    // Return an error response if request ID is not provided
    echo "No request ID provided";
}
?>
