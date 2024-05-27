<?php
include 'db.php';

// Function to fetch all ambulance data from the database
function getAllAmbulanceData($conn) {
    // Query to get all ambulance data
    $sql = "SELECT ambulance_id, register_number, contact_number, availability FROM ambulance";

    $result = mysqli_query($conn, $sql);

    $ambulances = array(); // Array to store ambulance data

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch each row and add it to the ambulances array
        while ($row = mysqli_fetch_assoc($result)) {
            $ambulances[] = $row;
        }
        return $ambulances;
    } else {
        return false; // No ambulances found
    }
}

// Fetch all ambulance data
$allAmbulanceData = getAllAmbulanceData($conn);

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($allAmbulanceData);
?>
