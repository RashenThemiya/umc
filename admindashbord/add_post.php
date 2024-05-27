<?php
include 'db.php';

// Function to add a post
if(isset($_POST['title']) && isset($_POST['description']) && isset($_FILES['image'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = file_get_contents($_FILES['image']['tmp_name']);

    $stmt = $conn->prepare("INSERT INTO healthy_life (title, description, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $image);

    if ($stmt->execute()) {
        echo "Post added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
