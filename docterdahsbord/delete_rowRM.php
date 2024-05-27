<?php
// Include database connection
include 'db.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the row id from the request body
    $requestData = json_decode(file_get_contents('php://input'), true);
    $id = $requestData['id'];

    // Perform the deletion operation in the database
    $sql = "DELETE FROM RequiredMedicine WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // If deletion is successful, return a success message
        $response = array("status" => "success", "message" => "success");
        echo json_encode($response);
    } else {
        // If deletion fails, return an error message
        $response = array("status" => "error", "message" => "Error deleting row from the database");
        echo json_encode($response);
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If the request method is not POST, return an error message
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}
?>
