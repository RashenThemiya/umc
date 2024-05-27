<?php
session_start();
require_once('db.php');

// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to display errors
function display_error($error) {
    echo "<div style='color: red;'>$error</div>";
}

// Appointing Doctors Functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['appoint_doctor'])) {
    // Validate input
    $doctor_id = sanitize_input($_POST['doctor_id']);
    if (empty($doctor_id)) {
        display_error("Please select a doctor.");
    } else {
        // Insert appointment into database
        $student_id = $_SESSION['user_id']; // Assuming user_id is stored in session
        $query = "INSERT INTO appointment (student_id, doctor_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $student_id, $doctor_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<div>Appointment successfully scheduled.</div>";
        } else {
            display_error("Error scheduling appointment.");
        }
        mysqli_stmt_close($stmt);
    }
}

// Applying for Exams/Lectures Functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['apply_exam'])) {
    // Validate input
    $exam_name = sanitize_input($_POST['exam_name']);
    if (empty($exam_name)) {
        display_error("Please enter exam name.");
    } else {
        // Insert exam application into database
        $student_id = $_SESSION['user_id']; // Assuming user_id is stored in session
        $query = "INSERT INTO requesting_medical (student_id, exam_or_lecture_details) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'is', $student_id, $exam_name);
        if (mysqli_stmt_execute($stmt)) {
            echo "<div>Exam application successfully submitted.</div>";
        } else {
            display_error("Error submitting exam application.");
        }
        mysqli_stmt_close($stmt);
    }
}

// Viewing Medical Records Functionality
$student_id = $_SESSION['user_id']; // Assuming user_id is stored in session
$query = "SELECT * FROM student_record WHERE student_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>Date: {$row['date']}</div>";
        echo "<div>Record: {$row['student_medical_history']}</div>";
        echo "<hr>";
    }
} else {
    echo "<div>No medical records found.</div>";
}
mysqli_stmt_close($stmt);

// Updating Profile Functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    // Validate and sanitize input
    $name = sanitize_input($_POST['name']);
    $age = sanitize_input($_POST['age']);
    $blood_type = sanitize_input($_POST['blood_type']);
    // Repeat for other profile fields...

    // Update profile in the database
    $student_id = $_SESSION['user_id']; // Assuming user_id is stored in session
    $query = "UPDATE student_record SET student_name=?, student_age=?, student_blood_type=? WHERE student_id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sisi', $name, $age, $blood_type, $student_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "<div>Profile updated successfully.</div>";
    } else {
        display_error("Error updating profile.");
    }
    mysqli_stmt_close($stmt);
}
?>

<!-- HTML content for student dashboard -->
<div class="container">
    <h2>Welcome to Student Dashboard, <?php echo $_SESSION['username']; ?>!</h2>

    <!-- Appoint Doctors Section -->
    <section>
        <h3>Appoint Doctors</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <!-- Doctor selection dropdown -->
            <label for="doctor_id">Select Doctor:</label>
            <select id="doctor_id" name="doctor_id">
                <option value="">Select</option>
                <?php
                // Fetch and display doctors from database
                $query = "SELECT * FROM doctor";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['doctor_id']}'>{$row['doctor_name']}</option>";
                }
                ?>
            </select>
            <button type="submit" name="appoint_doctor">Schedule Appointment</button>
        </form>
    </section>

    <!-- Apply for Exams/Lectures Section -->
    <section>
        <h3>Apply for Exams/Lectures</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <!-- Exam name input field -->
            <label for="exam_name">Exam Name:</label>
            <input type="text" id="exam_name" name="exam_name">
            <button type="submit" name="apply_exam">Apply</button>
        </form>
    </section>

    <!-- View Medical Records Section -->
    <section>
        <h3>Medical Records</h3>
        <!-- Display medical records here -->
    </section>

    <!-- Update Profile Section -->
    <section>
        <h3>Update Profile</h3>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <!-- Profile update input fields -->
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $_SESSION['username']; ?>">
            <!-- Repeat for other profile fields... -->
            <button type="submit" name="update_profile">Update</button>
        </form>
    </section>
</div>
