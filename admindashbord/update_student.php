<?php
// Include the database connection file
include 'db.php';

// Retrieve search criteria
$search_student_index = $_GET['studentId']; // Updated to use GET instead of POST

// Check if the user has access to the specified student index
$user_index = 123; // Assuming the logged-in user's index is known or retrieved from session

$sql = "SELECT * FROM users WHERE student_index = '$search_student_index' AND role = 'student'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Admin has access to the specified student index, retrieve student record details
    $sql_student = "SELECT * FROM student_record WHERE student_index = '$search_student_index'";
    $result_student = $conn->query($sql_student);

    if ($result_student->num_rows > 0) {
        // Student record found, construct HTML content
        $row = $result_student->fetch_assoc();
        $html = '
        <form action="update_student_details.php" method="post">
                <input type="hidden" id="student_index" name="student_index" value="'.$search_student_index.'">
                <label for="student_name">Student Name:</label><br>
                <input type="text" id="student_name" name="student_name" value="'.$row['student_name'].'"><br>
                <label for="student_phone_number">Student Phone Number:</label><br>
                <input type="text" id="student_phone_number" name="student_phone_number" value="'.$row['student_phone_number'].'"><br>
                <!-- Add other input fields here with their corresponding values -->
                <label for="student_home_number">Student Home Number:</label><br>
                <input type="text" id="student_home_number" name="student_home_number" value="'.$row['student_home_number'].'"><br>
                <label for="student_address">Student Address:</label><br>
                <input type="text" id="student_address" name="student_address" value="'.$row['student_address'].'"><br>
                <label for="student_blood_type">Student Blood Type:</label><br>
                <input type="text" id="student_blood_type" name="student_blood_type" value="'.$row['student_blood_type'].'"><br>
                <label for="birth_date">Birth Date:</label><br>
                <input type="text" id="birth_date" name="birth_date" value="'.$row['birth_date'].'"><br>
                <label for="student_allergies">Student Allergies:</label><br>
                <input type="text" id="student_allergies" name="student_allergies" value="'.$row['student_allergies'].'"><br>
                <label for="student_medical_history">Student Medical History:</label><br>
                <input type="text" id="student_medical_history" name="student_medical_history" value="'.$row['student_medical_history'].'"><br>
                <label for="student_height">Student Height:</label><br>
                <input type="text" id="student_height" name="student_height" value="'.$row['student_height'].'"><br>
                <label for="student_weight">Student Weight:</label><br>
                <input type="text" id="student_weight" name="student_weight" value="'.$row['student_weight'].'"><br>
                <label for="faculty">Faculty:</label><br>
                <input type="text" id="faculty" name="faculty" value="'.$row['faculty'].'"><br>
                <label for="department">Department:</label><br>
                <input type="text" id="department" name="department" value="'.$row['department'].'"><br>

                <input type="submit" value="Update">
                </form>
        ';
        echo $html;
    } else {
        // No student record found
        $html = '
        <form action="update_student_detail.php" method="post">
            <input type="hidden" name="student_index"  value="'.$search_student_index.'" >
            <label for="student_name">Student Name:</label><br>
            <input type="text" id="student_name" name="student_name"><br>
            <label for="student_phone_number">Student Phone Number:</label><br>
            <input type="text" id="student_phone_number" name="student_phone_number"><br>
            <!-- Add other input fields here with their corresponding values -->
            <label for="student_home_number">Student Home Number:</label><br>
            <input type="text" id="student_home_number" name="student_home_number"><br>
            <label for="student_address">Student Address:</label><br>
            <input type="text" id="student_address" name="student_address"><br>
            <label for="student_blood_type">Student Blood Type:</label><br>
            <input type="text" id="student_blood_type" name="student_blood_type"><br>
            <label for="birth_date">Birth Date:</label><br>
            <input type="text" id="birth_date" name="birth_date" ><br>
            <label for="student_allergies">Student Allergies:</label><br>
            <input type="text" id="student_allergies" name="student_allergies" ><br>
            <label for="student_medical_history">Student Medical History:</label><br>
            <input type="text" id="student_medical_history" name="student_medical_history" ><br>
            <label for="student_height">Student Height:</label><br>
            <input type="text" id="student_height" name="student_height"><br>
            <label for="student_weight">Student Weight:</label><br>
            <input type="text" id="student_weight" name="student_weight"><br>
            <label for="faculty">Faculty:</label><br>
            <input type="text" id="faculty" name="faculty" ><br>
            <label for="department">Department:</label><br>
            <input type="text" id="department" name="department" ><br>

            <input type="submit" value="Update">
        </form>
    ';
    echo $html;
    }
} else {
    // Admin does not have access to the specified student index
    echo "You do not have permission to access this student record.";
}

$conn->close();
?>
