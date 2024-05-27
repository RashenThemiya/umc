<?php
include 'db.php';

$searchName = $_GET['searchName'];

$sql = "SELECT * FROM MedicineAvailability WHERE Name LIKE '%$searchName%'";
$result = $conn->query($sql);
echo "<tr>
<th>Medicine ID</th>
<th>Type</th>
<th>Name</th>
<th>Stock</th>
<th>Expiry Date</th>
<th>Manufacturer</th>
<th>Manufacture Date</th>
<th>Supplier</th>
<th>Update Stock</th>
</tr>
";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
  
        echo "<tr id='row" . $row["MedicineID"] . "'>";
        echo "<td>" . $row["MedicineID"] . "</td>";
        echo "<td>" . $row["Type"] . "</td>";
        echo "<td>" . $row["Name"] . "</td>";
        echo "<td><span id='stock" . $row["MedicineID"] . "'>" . $row["Stock"] . "</span></td>";
        echo "<td>" . $row["ExpiryDate"] . "</td>";
        echo "<td>" . $row["Manufacturer"] . "</td>";
        echo "<td>" . $row["ManufactureDate"] . "</td>";
        echo "<td>" . $row["Supplier"] . "</td>";
        echo "<td><input type='number' id='newStock" . $row["MedicineID"] . "'><button onclick='updateStock(" . $row["MedicineID"] . ")'>Update</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9'>No matching medicines found</td></tr>";
}

$conn->close();
?>
