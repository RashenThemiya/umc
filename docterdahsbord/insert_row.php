<?php
// Include database connection
include 'db.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $json_data = file_get_contents("php://input");

    // Check if JSON data was received
    if ($json_data !== false) {
        // Decode the JSON data into an associative array
        $data = json_decode($json_data, true);

        // Check if all required fields are set in the decoded JSON data
        if (
            isset($data['newMedicineID']) &&
            isset($data['newType']) &&
            isset($data['newName']) &&
            isset($data['newStock']) &&
            isset($data['newExpiryDate']) &&
            isset($data['newManufacturer']) &&
            isset($data['newManufactureDate']) &&
            isset($data['newSupplier'])
        ) {
            // Extract data from the decoded JSON data
            $newMedicineID = $data['newMedicineID'];
            $newType = $data['newType'];
            $newName = $data['newName'];
            $newStock = $data['newStock'];
            $newExpiryDate = $data['newExpiryDate'];
            $newManufacturer = $data['newManufacturer'];
            $newManufactureDate = $data['newManufactureDate'];
            $newSupplier = $data['newSupplier'];

            // Prepare and execute the SQL statement using a prepared statement
            $stmt = $conn->prepare("INSERT INTO MedicineAvailability (MedicineID, Type, Name, Stock, ExpiryDate, Manufacturer, ManufactureDate, Supplier) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssssss", $newMedicineID, $newType, $newName, $newStock, $newExpiryDate, $newManufacturer, $newManufactureDate, $newSupplier);

            if ($stmt->execute()) {
                // If insertion is successful, return a success message
                $response = array("status" => "success", "message" => "New row inserted successfully");
                echo json_encode($response);
            } else {
                // If insertion fails, return an error message
                $response = array("status" => "error", "message" => "Error inserting new row into the database: " . $stmt->error);
                echo json_encode($response);
            }
        } else {
            // If any required field is missing, return an error message
            $response = array("status" => "error", "message" => "All fields are required");
            echo json_encode($response);
        }
    } else {
        // If no JSON data was received, return an error message
        $response = array("status" => "error", "message" => "No data received");
        echo json_encode($response);
    }
} else {
    // If the request method is not POST, return an error message
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}

// Close database connection
$conn->close();
?>
