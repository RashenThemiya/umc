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
if(isset($_GET['studentId'])) {
    $studentId = $_GET['studentId'];

    // Fetch medical records of the student based on their index number
    $query = "SELECT sr.*, smr.medical_history, smr.last_updated, YEAR(CURRENT_DATE()) - YEAR(sr.birth_date) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(sr.birth_date, '%m%d')) AS student_age
              FROM student_record sr 
              LEFT JOIN student_medical_records smr ON sr.student_index = smr.student_index
              WHERE sr.student_index = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $studentId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any records found
    if ($result->num_rows > 0) {
        // Display student information
        $row = $result->fetch_assoc();
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
        echo "</div>"; // End of medical record details section


        // Update medical history form section
     
        // Assuming you have already fetched $row from the database query
        
        // Fetching student ID and student index from $row
        $studentId = $row['student_id'];
        $studentIndex = $row['student_index'];
        
        echo "<div class='section'>";
        echo "<h3>Update Medical History</h3>";
        echo "<form action='update_medical_history.php' method='POST'>";
        echo "<input type='hidden' name='studentId' value='" . $studentId . "'>";
        echo "<input type='hidden' name='studentIndex' value='" . $studentIndex . "'>";
        echo "<textarea name='medicalHistory' rows='4' cols='50' placeholder='Enter updated medical history...' required></textarea><br>";
        echo "<button type='submit'>Update Medical History</button>";
        echo "</form>";
        echo "</div>"; // End of update medical history form section
        
        echo "</div>"; // Closing parent div for both rows
       
         // Closing parent div for both rows


        // Medical history section
        echo "<div class='section'>";
        echo "<h3>Medical History</h3>";

        // Reset the result set pointer to the beginning
        mysqli_data_seek($result, 0);

        // Fetch all medical history records into an array
        $medical_history_records = $result->fetch_all(MYSQLI_ASSOC);

        // Loop through each medical record
        foreach ($medical_history_records as $record) {
            echo "<p><strong>Medical History:</strong> " . $record['medical_history'] ."<strong> Updated:</strong> " . $record['last_updated'] . "</p>";
        }

        echo "</div>"; // End of medical history section
    } else {
        echo "No medical records found for student ID: $studentId";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
