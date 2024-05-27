<?php
// get_tips.php
include 'db.php';

$sql = "SELECT * FROM healthy_life";
$result = mysqli_query($conn, $sql);

$tips = array();

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $tips[] = array(
            'title' => $row['title'],
            'description' => $row['description'],
            'image' => base64_encode($row['image'])
        );
    }
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($tips);
?>
