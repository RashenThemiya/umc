<?php
session_start(); // Start the session

// Include the database connection file
include 'db.php';

// Check if 'username' is set in the session
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit(); // Stop further execution
}

// Check if student index number is provided in the URL

if (isset($_GET['studentId'])) {
    // Sanitize the input to prevent SQL injection
    $studentId = mysqli_real_escape_string($conn, $_GET['studentId']);

    // Fetch medical records of the student based on their index number
    $query = "SELECT sr.*, 
                     smr.medical_history, 
                     smr.last_updated, 
                     YEAR(CURRENT_DATE()) - YEAR(sr.birth_date) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(sr.birth_date, '%m%d')) AS student_age
              FROM student_record sr 
              LEFT JOIN student_medical_records smr ON sr.student_index = smr.student_index
              WHERE sr.student_index = '$studentId'";
    $result = mysqli_query($conn, $query);

    // Check if any records found
    if (mysqli_num_rows($result) > 0) {
        // Display student information
        $row = mysqli_fetch_assoc($result);
        echo "<div class='section-container'>"; // Parent div for all sections
        
        // Medical record details section
        echo "<div class='section'>";
        echo "<h3>Medical Records for Student ID: $studentId</h3>";
        echo "<p><strong>Name:</strong> " . $row['student_name'] . "</p>";
        echo "<p><strong>Phone Number:</strong> " . $row['student_phone_number'] . "</p>";
        echo "<p><strong>Address:</strong> " . $row['student_address'] . "</p>";
        echo "<p><strong>Blood Type:</strong> " . $row['student_blood_type'] . "</p>";
        echo "<p><strong>Birthdate:</strong> " . $row['birth_date'] . "</p>";
        echo "<p><strong>Age:</strong> " . $row['student_age'] . "</p>";
        echo "<p><strong>Allergies:</strong> " . $row['student_allergies'] . "</p>";
        echo "<p><strong>Height:</strong> " . $row['student_height'] . "</p>";
        echo "<p><strong>Weight:</strong> " . $row['student_weight'] . "</p>";
        echo "<p><strong>Faculty:</strong> " . $row['faculty'] . "</p>";
        echo "<p><strong>Department:</strong> " . $row['department'] . "</p>";
        echo "<p><strong>Student ID:</strong> " . $row['student_id'] . "</p>";
        echo "<p><strong>Student Index:</strong> " . $studentId . "</p>";
        echo "</div>"; // End of medical record details section

        // Update medical history form section
        echo "<div class='section'>";
        echo "<h3>Update Medical History</h3>";
        echo "<form action='update_medical_history.php' method='POST'>";
        echo "<input type='hidden' name='studentIdd' value='" . $row['student_id'] . "'>";
        echo "<input type='hidden' name='studentIndexx' value='" . $studentId . "'>";
        echo "<textarea name='medicalHistory' rows='4' cols='50' placeholder='Enter updated medical history...' required></textarea><br>";
        echo "<button type='submit'>Update Medical History</button>";
        echo "</form>";
        echo "</div>"; // End of update medical history form section
        echo "</div>"; // Closing parent div for both rows
        // Medical history section
        echo "<div class='section'>";
        echo "<h3>Medical History</h3>";

        // Reset the result set pointer to the beginning
        mysqli_data_seek($result, 0);

        // Fetch all medical history records into an array
        $medical_history_records = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Loop through each medical record
        foreach ($medical_history_records as $record) {
            echo "<p><strong>*</strong> " . $record['medical_history'] . " <strong>Updated:</strong> " . $record['last_updated'] . "</p>";
        }

        echo "</div>"; // End of medical history section

       

    } else {
        echo "No medical records found for student ID: $studentId";
    }

    // Close statement and database connection
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>
