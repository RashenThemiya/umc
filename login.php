<?php
session_start();
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        switch ($row['role']) {
            case 'student':
                header('Location: student_dashboard.php');
                break;
            case 'doctor':
                header('Location: docterdahsbord/doctor_dashboard.php');
                break;
            case 'admin':
                header('Location: admindashbord/admin_dashboard.php');
                break;
            case 'staff':
                header('Location: staff_dashboard.php');
                break;
            default:
                // Handle other roles or errors
                break;
        }
    } else {
        echo "Invalid username or password";
    }
}
?>
