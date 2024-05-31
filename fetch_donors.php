<?php
// Include the database connection details
include 'db.php';

$sql = "SELECT name, email, donate_things FROM pending_donor";
$result = mysqli_query($conn, $sql);

$donors = array();

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $donors[] = $row;
    }
}

mysqli_close($conn);

echo json_encode($donors);
?>
