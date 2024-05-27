<?php
// Include database connection
include 'db.php';

// Function to fetch notices
function fetchNotices($conn) {
    $output = '';
    $sql = "SELECT * FROM notice";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $output .= '<table border="1">';
        $output .= '<tr><th>ID</th><th>Heading</th><th>Details</th><th>Created At</th><th>Action</th></tr>';
        while($row = $result->fetch_assoc()) {
            $output .= "<tr>";
            $output .= "<td>".$row["notice_id"]."</td>";
            $output .= "<td>".$row["notice_heading"]."</td>";
            $output .= "<td>".$row["notice_details"]."</td>";
          //  $output .= "<td>".$row["created_by"]."</td>";
            $output .= "<td>".$row["created_at"]."</td>";
            $output .= "<td><button class='deleteBtn' data-noticeid='".$row["notice_id"]."'>Delete</button></td>";
            $output .= "</tr>";
        }
        $output .= "</table>";
    } else {
        $output .= "<p>No notices found</p>";
    }
    echo $output;
}

// Fetch notices
fetchNotices($conn);
?>
