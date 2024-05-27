<?php
// Include database connection
include 'db.php';

// Check if the student index is provided
if(isset($_GET['student_index'])) {
    // Sanitize the input to prevent SQL injection
    $studentIndex = mysqli_real_escape_string($conn, $_GET['student_index']);
    
    // Query to retrieve medical requests for the specified student index
    $sql_requests = "SELECT * FROM requesting_medical WHERE student_index = '$studentIndex'";
    $result_requests = $conn->query($sql_requests);
    
    // Display the medical requests
    if ($result_requests->num_rows > 0) {

        echo "<table id='medicalRequestTable'>";

        echo "<thead><tr><th>Request ID</th><th>Date</th><th>Student Index</th><th>Document</th><th>Time</th><th>Medical Duration Days</th><th>Exam/Lecture Details</th><th>Faculty</th><th>Department</th><th>Approval Status</th><th>Actions</th></tr></thead><tbody>";
        while($row = $result_requests->fetch_assoc()) {
            // Each row has a unique identifier based on request ID
            echo "<button onclick='goBack()'>Back</button>";

            echo "<tr id='row_" . $row["request_id"] . "'>";
            echo "<td>" . $row["request_id"] . "</td>";
            echo "<td class='editable' data-column='Type' data-id='" . $row["request_id"] . "'>" . $row["date"] . "</td>";
            echo "<td class='editable' data-column='Name' data-id='" . $row["request_id"]. "'>" . $row["student_index"] . "</td>";
            echo "<td>";
            // Display download icon for the document
            echo "<a href='download.php?id=" . $row["request_id"] . "'><i class='fa fa-download'>Click here</i></a>";
            echo "</td>";
            echo "<td class='editable' data-column='Name' data-id='" . $row["request_id"]. "'>" . $row["time"] . "</td>";
            echo "<td class='editable' data-column='Stock' data-id='" . $row["request_id"] . "'>" . $row["medical_duration"] . "</td>";
            echo "<td class='editable' data-column='ExpiryDate' data-id='" . $row["request_id"] . "'>" . $row["exam_or_lecture_details"] . "</td>";
            echo "<td class='editable' data-column='Manufacturer' data-id='" . $row["request_id"] . "'>" . $row["faculty"] . "</td>";
            echo "<td class='editable' data-column='ManufactureDate' data-id='" . $row["request_id"] . "'>" . $row["department"] . "</td>";
            echo "<td class='editable' data-column='Supplier' data-id='" . $row["request_id"] . "'>" . $row["approval_status"] . "</td>";
            echo "<td>";
            echo "<button class='delete-btn' onclick='RequestDelete(" . $row["request_id"] . ")'>Delete</button>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No data available for student index: " . $studentIndex . "</p>";
    }
} else {
    echo "<p>No student index provided</p>";
}
?>
