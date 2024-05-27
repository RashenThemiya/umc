<?php
// Include database connection
include 'db.php';

// Function to fetch notices
echo fetchNotices($conn);

// Function to add a notice
if(isset($_POST['add_notice'])) {
    $heading = $_POST['notice_heading'];
    $details = $_POST['notice_details'];
    $createdBy = $_POST['created_by'];

    $sql = "INSERT INTO notice (notice_heading, notice_details, created_by) VALUES ('$heading', '$details', $createdBy)";
    if ($conn->query($sql) === TRUE) {
        echo fetchNotices($conn);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to delete a notice
if(isset($_POST['delete_notice'])) {
    $noticeId = $_POST['notice_id'];
    $sql = "DELETE FROM notice WHERE notice_id=$noticeId";
    if ($conn->query($sql) === TRUE) {
        echo fetchNotices($conn);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to fetch notices
function fetchNotices($conn) {
    $output = '';
    $sql = "SELECT * FROM notice";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $output .= '<table border="1">';
        $output .= '<tr><th>ID</th><th>Heading</th><th>Details</th><th>Created By</th><th>Created At</th><th>Action</th></tr>';
        while($row = $result->fetch_assoc()) {
            $output .= "<tr>";
            $output .= "<td>".$row["notice_id"]."</td>";
            $output .= "<td>".$row["notice_heading"]."</td>";
            $output .= "<td>".$row["notice_details"]."</td>";
            $output .= "<td>".$row["created_by"]."</td>";
            $output .= "<td>".$row["created_at"]."</td>";
            $output .= "<td><button class='deleteBtn' data-noticeid='".$row["notice_id"]."'>Delete</button></td>";
            $output .= "</tr>";
        }
        $output .= "</table>";
    } else {
        $output .= "<p>No notices found</p>";
    }
    return $output;
}
?>
