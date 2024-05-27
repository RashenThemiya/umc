<!-- fetch_ambulances.php -->
<?php
include 'db.php';

// Function to fetch ambulances
function fetchAmbulances($conn) {
    $output = '<table id="ambulanceList">';
    $output .= '<tr><th>Register Number</th><th>Contact Number</th><th>Availability</th><th>Location</th><th>Action</th></tr>';
    $sql = "SELECT * FROM ambulance";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $output .= '<tr id="ambulance_'.$row["ambulance_id"].'">';
            $output .= '<td>'.$row["register_number"].'</td>';
            $output .= '<td>'.$row["contact_number"].'</td>';
            $output .= '<td><select class="availabilitySelect" data-ambulanceid="'.$row["ambulance_id"].'">';
            $output .= '<option value="available"'.($row["availability"]=="available"?" selected":"").'>Available</option>';
            $output .= '<option value="unavailable"'.($row["availability"]=="unavailable"?" selected":"").'>Unavailable</option>';
            $output .= '</select></td>';
            $output .= '<td>'.$row["location"].'</td>';
            $output .= '<td><button class="deleteBtn" data-ambulanceid="'.$row["ambulance_id"].'" style="background-color: #4CAF50;;">Delete</button></td>';            $output .= '</tr>';
        }
    } else {
        $output .= '<tr><td colspan="5">No ambulances found</td></tr>';
    }
    $output .= '</table>';
    echo $output;
}

// Fetch ambulances
fetchAmbulances($conn);

// Add ambulance
if(isset($_POST['register_number']) && isset($_POST['contact_number']) && isset($_POST['location'])) {
    $register_number = $_POST['register_number'];
    $contact_number = $_POST['contact_number'];
    $location = $_POST['location'];
    
    $sql = "INSERT INTO ambulance (register_number, contact_number, availability, location) VALUES ('$register_number', '$contact_number', 'available', '$location')";
    if ($conn->query($sql) === TRUE) {
        $new_id = $conn->insert_id;
        $response = '<tr id="ambulance_'.$new_id.'">';
        $response .= '<td>'.$register_number.'</td>';
        $response .= '<td>'.$contact_number.'</td>';
        $response .= '<td><select class="availabilitySelect" data-ambulanceid="'.$new_id.'">';
        $response .= '<option value="available" selected>Available</option>';
        $response .= '<option value="unavailable">Unavailable</option>';
        $response .= '</select></td>';
        $response .= '<td>'.$location.'</td>';
        $response .= '<td><button class="deleteBtn" data-ambulanceid="'.$new_id.'">Delete</button></td>';
        $response .= '</tr>';
        echo $response;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Delete ambulance
if(isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql = "DELETE FROM ambulance WHERE ambulance_id='$delete_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Ambulance deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Change availability
if(isset($_POST['ambulance_id']) && isset($_POST['availability'])) {
    $ambulance_id = $_POST['ambulance_id'];
    $availability = $_POST['availability'];
    $sql = "UPDATE ambulance SET availability='$availability' WHERE ambulance_id='$ambulance_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Availability updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>
