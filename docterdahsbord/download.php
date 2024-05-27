<?php
// Include database connection
include 'db.php';

if (isset($_GET['id'])) {
    // Retrieve the request ID from the URL parameter
    $request_id = $_GET['id'];

    // Prepare and execute query to retrieve document data from the database
    $sql = "SELECT document FROM requesting_medical WHERE request_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $stmt->store_result();

    // Check if document data exists
    if ($stmt->num_rows == 1) {
        // Bind the result to a variable
        $stmt->bind_result($document_data);
        $stmt->fetch();

        // Set headers for file download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="document.pdf"'); // Change the filename if needed
        header('Content-Length: ' . strlen($document_data));

        // Output the document data
        echo $document_data;
    } else {
        // Document not found
        echo "Document not found.";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Request ID not provided
    echo "Request ID not provided.";
}
?>
