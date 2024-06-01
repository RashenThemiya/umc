<?php
// Include the database connection details
include 'db.php';

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare and execute the SQL query
$sql = "SELECT name, email, donate_thing FROM pending_donor WHERE status = 'completed'";
$result = mysqli_query($conn, $sql);

$donors = array();

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $donors[] = $row;
        }
    }
    // Free result set
    mysqli_free_result($result);
} else {
    // Log SQL error if the query fails
    error_log("SQL error: " . mysqli_error($conn));
}

// Close the database connection
mysqli_close($conn);

// Set the content type to JSON
header('Content-Type: application/json');

// Output the JSON encoded array
echo json_encode($donors);
?>
