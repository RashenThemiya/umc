<?php
// Include the database connection
include 'db.php';

// Query to fetch data from the RequiredMedicine table
$sql = "SELECT TypeName,Name,Quantity FROM RequiredMedicine";

// Perform the query
$result = mysqli_query($conn, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Initialize an empty array to store the data
    $medicineData = array();

    // Fetch data from each row and store it in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $medicineData[] = $row;
    }

    // Close the connection
    mysqli_close($conn);

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($medicineData);
} else {
    // If no data found, return an empty array
    echo json_encode(array());
}
?>
