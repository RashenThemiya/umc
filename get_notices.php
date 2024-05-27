<?php
include 'db.php';

$sql = "SELECT * FROM notice";
$result = mysqli_query($conn, $sql);

$notices = array();

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $notices[] = $row;
    }
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($notices);
?>
