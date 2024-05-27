<?php
// Include the database connection file
include 'db.php';

// Retrieve form data
$student_index = $_POST['student_index'];
$student_name = $_POST['student_name'];
$student_phone_number = $_POST['student_phone_number'];
$student_home_number = $_POST['student_home_number'];
$student_address = $_POST['student_address'];
$student_blood_type = $_POST['student_blood_type'];
$birth_date = $_POST['birth_date'];
$student_allergies = $_POST['student_allergies'];
$student_medical_history = $_POST['student_medical_history'];
$student_height = $_POST['student_height'];
$student_weight = $_POST['student_weight'];
$faculty = $_POST['faculty'];
$department = $_POST['department'];

// Update student record
$sql = "UPDATE student_record SET 
        student_name = '$student_name',
        student_phone_number = '$student_phone_number',
        student_home_number = '$student_home_number',
        student_address = '$student_address',
        student_blood_type = '$student_blood_type',
        birth_date = '$birth_date',
        student_allergies = '$student_allergies',
        student_medical_history = '$student_medical_history',
        student_height = '$student_height',
        student_weight = '$student_weight',
        faculty = '$faculty',
        department = '$department'
        WHERE student_index = '$student_index'";

if ($conn->query($sql) === TRUE) {
    // Alert success message
    echo "<script>alert('Student record updated successfully');</script>";
    // Redirect back to the previous page
    echo "<script>window.location.href = '".$_SERVER['HTTP_REFERER']."';</script>";
    exit;
} else {
    echo "<script>alert('Student record updated UNsuccessfully');</script>";
    echo "<script>window.location.href = '".$_SERVER['HTTP_REFERER']."';</script>";
}

$conn->close();
?>
