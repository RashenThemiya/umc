<?php
include 'db.php';

// Function to delete a post
if(isset($_POST['post_id'])) {
    $postId = $_POST['post_id'];
    $sql = "DELETE FROM healthy_life WHERE tip_id=$postId";
    if ($conn->query($sql) === TRUE) {
        echo "Post deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
