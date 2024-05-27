<?php include 'db.php'; ?>

<?php
// Retrieve values from the form
$medicineID = $_POST['medicineID'];
$newStock = $_POST['newStock'];

// Prepare and execute the SQL query
$sql = "UPDATE MedicineAvailability SET Stock = ? WHERE MedicineID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $newStock, $medicineID);

if ($stmt->execute()) {
    echo "Stock updated successfully";
} else {
    echo "Error updating stock: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
