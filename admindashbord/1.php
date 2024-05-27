<?php
// Include the database connection file
include 'db.php';

// Retrieve search criteria
$search_student_index = $_POST['search_student_index'];

// Check if the user has access to the specified student index
$user_index = 123; // Assuming the logged-in user's index is known or retrieved from session

$sql = "SELECT * FROM users WHERE student_index = '$search_student_index' AND role = 'student'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Admin has access to the specified student index, retrieve student record details
    $sql_student = "SELECT * FROM student_record WHERE student_index = '$search_student_index'";
    $result_student = $conn->query($sql_student);

    if ($result_student->num_rows > 0) {
        // Student record found, display all details
        $row = $result_student->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Student Record</title>
        </head>
        <body>
            <h2>Update Student Record</h2>
            <form action="update_student_details.php" method="post">
                <input type="hidden" name="student_index" value="<?php echo $search_student_index; ?>">
                <label for="student_name">Student Name:</label><br>
                <input type="text" id="student_name" name="student_name" value="<?php echo $row['student_name']; ?>"><br>
                <label for="student_phone_number">Student Phone Number:</label><br>
                <input type="text" id="student_phone_number" name="student_phone_number" value="<?php echo $row['student_phone_number']; ?>"><br>
                <label for="student_home_number">Student Home Number:</label><br>
                <input type="text" id="student_home_number" name="student_home_number" value="<?php echo $row['student_home_number']; ?>"><br>
                <label for="student_address">Student Address:</label><br>
                <input type="text" id="student_address" name="student_address" value="<?php echo $row['student_address']; ?>"><br>
                <label for="student_blood_type">Student Blood Type:</label><br>
                <input type="text" id="student_blood_type" name="student_blood_type" value="<?php echo $row['student_blood_type']; ?>"><br>
                <label for="birth_date">Birth Date:</label><br>
                <input type="text" id="birth_date" name="birth_date" value="<?php echo $row['birth_date']; ?>"><br>
                <label for="student_allergies">Student Allergies:</label><br>
                <input type="text" id="student_allergies" name="student_allergies" value="<?php echo $row['student_allergies']; ?>"><br>
                <label for="student_medical_history">Student Medical History:</label><br>
                <input type="text" id="student_medical_history" name="student_medical_history" value="<?php echo $row['student_medical_history']; ?>"><br>
                <label for="student_height">Student Height:</label><br>
                <input type="text" id="student_height" name="student_height" value="<?php echo $row['student_height']; ?>"><br>
                <label for="student_weight">Student Weight:</label><br>
                <input type="text" id="student_weight" name="student_weight" value="<?php echo $row['student_weight']; ?>"><br>
                <label for="faculty">Faculty:</label><br>
                <input type="text" id="faculty" name="faculty" value="<?php echo $row['faculty']; ?>"><br>
                <label for="department">Department:</label><br>
                <input type="text" id="department" name="department" value="<?php echo $row['department']; ?>"><br>

                <input type="submit" value="Update">
            </form>
        </body>
        </html>
        <?php
    } else {
        // No student record found, display only the update form
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update Student Record</title>
        </head>
        <body>
            <h2>No Student Record Found</h2>
            <h2>Update Student Record</h2>
            <form action="update_student_details.php" method="post">
                <input type="hidden" name="student_index" value="<?php echo $search_student_index; ?>">
                <label for="student_name">Student Name:</label><br>
                <input type="text" id="student_name" name="student_name"><br>
                <label for="student_phone_number">Student Phone Number:</label><br>
                <input type="text" id="student_phone_number" name="student_phone_number"><br>
                <label for="student_home_number">Student Home Number:</label><br>
                <input type="text" id="student_home_number" name="student_home_number"><br>
                <label for="student_address">Student Address:</label><br>
                <input type="text" id="student_address" name="student_address"><br>
                <label for="student_blood_type">Student Blood Type:</label><br>
                <input type="text" id="student_blood_type" name="student_blood_type"><br>
                <label for="birth_date">Birth Date:</label><br>
                <input type="text" id="birth_date" name="birth_date"><br>
                <label for="student_allergies">Student Allergies:</label><br>
                <input type="text" id="student_allergies" name="student_allergies"><br>
                <label for="student_medical_history">Student Medical History:</label><br>
                <input type="text" id="student_medical_history" name="student_medical_history"><br>
                <label for="student_height">Student Height:</label><br>
                <input type="text" id="student_height" name="student_height"><br>
                <label for="student_weight">Student Weight:</label><br>
                <input type="text" id="student_weight" name="student_weight"><br>
                <label for="faculty">Faculty:</label><br>
                <input type="text" id="faculty" name="faculty"><br>
                <label for="department">Department:</label><br>
                <input type="text" id="department" name="department"><br>

                <input type="submit" value="Update">
            </form>
        </body>
        </html>
        <?php
    }
} else {
    // Admin does not have access to the specified student index
    echo "You do not have permission to access this student record.";
}

$conn->close();
?>
