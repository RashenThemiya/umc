<?php
// Include database connection code
include 'db.php';

// Fetch doctor availability data from the database
$query = "SELECT doctor.doctor_name, doctor.doctor_hospital, doctor_availability.day_of_week, doctor_availability.start_time, doctor_availability.end_time, doctor_availability.availability FROM doctor
JOIN doctor_availability ON doctor.doctor_id = doctor_availability.doctor_id";

$result = mysqli_query($conn, $query);

$doctorAvailability = array();

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $doctorAvailability[] = $row;
        }
    }
}

// Close the database connection
mysqli_close($conn);

// Return the doctor availability data as JSON
header('Content-Type: application/json');
echo json_encode($doctorAvailability);
?>
