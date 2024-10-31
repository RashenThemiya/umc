<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include database connection
include 'db.php';
require '../vendor/autoload.php';

// Load PHPMailer

// Function to send approval email to multiple recipients
function sendApprovalEmail($emails, $details, $requestData) {
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->Username = 'rashenrashen4@gmail.com'; // Directly assigning email
    $mail->Password = 'rrkvrrnlrjywpduz'; 
    $mail->SMTPSecure = 'ssl';
    $mail->setFrom('rashenrashen4@gmail.com', 'rashen themiya');
    foreach ($emails as $email) {
        $mail->addAddress($email);
    }
    $mail->Subject = 'Medical Request Approval';
    // Construct email body with additional data
    $mail->Body = 'medical request has been approved. Details: ' . $details .
                  "\nStudent Index: " . $requestData['student_index'] .
                  "\nDate: " . $requestData['date'] .
                  "\nTime: " . $requestData['time'] .
                  "\nMedical Duration : " . $requestData['medical_duration'] ." Days".
                  "\nExam/Lecture Details: " . $requestData['exam_or_lecture_details'] .
                  "\nFaculty: " . $requestData['faculty'] .
                  "\nDepartment: " . $requestData['department']; 

                  
    if (!$mail->send()) {
        echo 'error: ' . $mail->ErrorInfo;
        exit();
    }
}

// Fetch request details based on request_id
$requestID = $_POST['requestID'];

// Fetch request details from the database based on $requestID
$sql_fetch_details = "SELECT student_email, faculty_email, lecture_email, department_email, exam_or_lecture_details, student_index, date, time, medical_duration, faculty, department FROM requesting_medical WHERE request_id = $requestID";
$result_fetch_details = $conn->query($sql_fetch_details);
if ($result_fetch_details->num_rows > 0) {
    $row = $result_fetch_details->fetch_assoc();
    $student_email = $row['student_email'];
    $faculty_email = $row['faculty_email'];
    $lecture_email = $row['lecture_email'];
    $department_email = $row['department_email'];
    $approval_details = $row['exam_or_lecture_details'];

    // Send approval email to all recipients
    sendApprovalEmail([$student_email, $faculty_email, $lecture_email, $department_email], $approval_details, [
        'student_index' => $row['student_index'],
        'date' => $row['date'],
        'time' => $row['time'],
        'medical_duration' => $row['medical_duration'],
        'exam_or_lecture_details' => $row['exam_or_lecture_details'],
        'faculty' => $row['faculty'],
        'department' => $row['department']
    ]);

    // Update approval status to 'yes' in the database
    $sql_update = "UPDATE requesting_medical SET approval_status = 'yes' WHERE request_id = $requestID";
    if ($conn->query($sql_update) === TRUE) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    // Handle error if request details are not found
    echo 'error: Request details not found';
}
?>
