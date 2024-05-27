<?php
// Include database connection
include 'db.php';

// Function to delete a notice
if(isset($_POST['notice_id'])) {
    $noticeId = $_POST['notice_id'];
    $sql = "DELETE FROM notice WHERE notice_id=$noticeId";
    if ($conn->query($sql) === TRUE) {
        echo "Notice deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
