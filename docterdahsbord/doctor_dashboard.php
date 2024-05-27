<?php
// Start the session
session_start();

// Include the database connection file
include 'db.php';

// Check if 'username' is set in the session
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit(); // Stop further execution
}

$username = $_SESSION['username']; // Retrieve username from session

// Function to fetch doctor's profile details from the database
function fetchDoctorDetails($conn, $userId) {
    $query = "SELECT d.doctor_id, d.doctor_name, d.doctor_hospital, da.start_time, da.end_time, da.availability
              FROM doctor d
              LEFT JOIN doctor_availability da ON d.doctor_id = da.doctor_id
              WHERE d.user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $doctorId, $doctorName, $hospital, $startTime, $endTime, $availability);
    
    // Fetch the result
    mysqli_stmt_fetch($stmt);
    
    // Close the statement
    mysqli_stmt_close($stmt);
    
    // Return the fetched details as an associative array
    return [
        'doctor_id' => $doctorId,
        'doctor_name' => $doctorName,
        'doctor_hospital' => $hospital,
        'start_time' => $startTime,
        'end_time' => $endTime,
        'availability' => $availability
    ];
}

// Assuming you have a function to fetch doctor's profile details from the database
$doctorDetails = fetchDoctorDetails($conn, $_SESSION['user_id']); 

// Display notification if provided
if (isset($_GET['notification'])) {
    $notification = htmlspecialchars($_GET['notification']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="stylesdoctor.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
        
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<div class="site-wrap">

  <nav class="site-nav">

    <div class="name">
    <h1>Welcome, <?php echo  $doctorDetails['doctor_name']; ?></h1>
     
    </div>



    <div class="functions ">
        <ul>
        <li><a href="#" onclick="showProfile()">Set Profile</a></li>
        <li><a href="#" onclick="showAppointments()">View Appointments</a></li>
        <li><a href="#" onclick="showMedicalRequests()">Approve Medical Requests</a></li>
        <li><a href="#" onclick="showMedicalRecords()">View Medical Records</a></li>
        <li><a href="#" onclick="showMedicineManagement()">Manage Medicines</a></li>
        <li><a href="../logout.php">Logout</a></li>
        </div>
        </ul>

    <div class="note">
      <h3>Welcome to the  platform</h3>
      <p>Devloped by Software Engineering Deprement Student 20/21 Batch Team number 10</p>
    </div>

  </nav>

  <div class="container">
    <div id="welcomeMessage" class="">
       <h1> Welcome to the University Management System!</h1>
        <p>We're delighted to have you join our digital campus community. Our management system is designed to streamline your academic journey, making it easier for you to navigate through your courses, access resources, and connect with fellow students and faculty.</p>
        <p>With this system, you'll have the tools at your fingertips to manage your schedule, submit assignments, track your progress, and stay updated on important announcements and events happening across the university.</p>
        <p>We're committed to providing you with a seamless experience that enhances your learning and empowers you to succeed. If you have any questions or need assistance, don't hesitate to reach out to our support team.</p>
        <p>Once again, welcome aboard, and we wish you a fulfilling and enriching academic experience here at our university!</p>
    </div>
    <div id="profile" class="hidden">
      <div class="section">
        <h2>Doctor Information</h2>
        <p>
            <strong>Name:</strong> <?php echo htmlspecialchars($doctorDetails['doctor_name']); ?><br>
            <strong>Hospital:</strong> <?php echo htmlspecialchars($doctorDetails['doctor_hospital']); ?><br>
            <strong>Availability:</strong> <?php echo $doctorDetails['availability']  ?>
        </p>
      </div>

      <div class="section">
        <h2>Update Availability</h2>
        <form id="availabilityForm" method="post" action="update_availability.php">
    <label for="availability">Availability:</label>
    <div class="toggle-switch">
        <input type="checkbox" id="availabilityCheckbox" name="availability_checkbox" <?php if ($doctorDetails['availability'] == 'Available') echo 'checked'; ?> onchange="updateAvailability()">
        <label for="availabilityCheckbox"></label>
    </div>
    <br><br>
    <!-- Hidden input field to submit availability -->
    <input type="hidden" id="availabilityHidden" name="availability" value="<?php echo ($doctorDetails['availability'] == 'Available') ? 'Available' : 'Unavailable'; ?>">
    
    <!-- Hidden input field to submit doctor ID -->
    <input type="hidden" name="doctorId" value="<?php echo $doctorDetails['doctor_id']; ?>">
    
    <button type="submit">Update Availability</button>
</form>


      </div>

      <div class="section">
    <h2>Update Password</h2>
    <form id="credentialForm" method="post" action="update_credentials.php">
        <label for="oldPassword">Old Password: </label>
        <input type="password" id="oldPassword" name="oldPassword" required><br><br>
        <label for="newPassword">New Password:</label>
        <input type="password" id="newPassword" name="newPassword" required><br><br>
        <button type="submit">Update Password</button>
    </form>
</div>

    </div>







        
<div id="appointments" class="hidden">
<h1>Currently Under Devoloping</h1>        </div>






<div id="medicalRequests" class="hidden">
<div id="medicallist">
    <label for="studentIndex">Enter Student Index Number:</label>
    <input type="text" id="studentIndex" name="studentIndex" required>
    <button onclick="Searche()">Search</button>
</div>


       <div id="pendinglist">  </div>  <!-- Medical request approval functionality goes here -->
          <div id="pending"> <?php
    // Include database connection
    include 'db.php';
    echo "<h2> Pending Medical Requests</h2>";
    // Function to display table rows with approval_status pending
    function displayPendingMedicalRequestRows($conn) {
        // Retrieve data from MedicineAvailability table
        $sql_requests = "SELECT * FROM requesting_medical WHERE approval_status = 'pending'";
        $result_requests = $conn->query($sql_requests);

        if ($result_requests->num_rows > 0) {
            echo "<table id='medicalRequestTable'>";
            echo "<thead><tr><th>Request ID</th><th>Date</th><th>Student Index</th><th>Document</th><th>Time</th><th>Medical Duration Days</th><th>Exam/Lecture Details</th><th>Faculty</th><th>Department</th><th>Approval Status</th><th>Actions</th></tr></thead><tbody>";
            while($row = $result_requests->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["request_id"] . "</td>";
                echo "<td class='editable' data-column='Type' data-id='" . $row["request_id"] . "'>" . $row["date"] . "</td>";
                echo "<td class='editable' data-column='Name' data-id='" . $row["request_id"]. "'>" . $row["student_index"] . "</td>";
                echo "<td>";
                // Display download icon for the document
                echo "<a href='download.php?id=" . $row["request_id"] . "'><i class='fa fa-download'>Click here</i></a>";
                echo "</td>";
                echo "<td class='editable' data-column='Name' data-id='" . $row["request_id"]. "'>" . $row["time"] . "</td>";
                echo "<td class='editable' data-column='Stock' data-id='" . $row["request_id"] . "'>" . $row["medical_duration"] . "</td>";
                echo "<td class='editable' data-column='ExpiryDate' data-id='" . $row["request_id"] . "'>" . $row["exam_or_lecture_details"] . "</td>";
                echo "<td class='editable' data-column='Manufacturer' data-id='" . $row["request_id"] . "'>" . $row["faculty"] . "</td>";
                echo "<td class='editable' data-column='ManufactureDate' data-id='" . $row["request_id"] . "'>" . $row["department"] . "</td>";
                echo "<td class='editable' data-column='Supplier' data-id='" . $row["request_id"] . "'>" . $row["approval_status"] . "</td>";
                echo "<td>";
               echo "<button class='approve-btn' onclick='approveRecord(" . $row["request_id"] . ")'>Approve</button>";
                echo "<button class='not-approve-btn' onclick='notApproveRecord(" . $row["request_id"] . ")'>Not Approve</button>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No data available</p>";
        }
    }
    // Call the function to display rows with approval_status pending
    displayPendingMedicalRequestRows($conn);
?>


        
</div> 

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        </div>




































<div id="medicalRecords" class="hidden">
<h2>View Medical Records</h2>
<!-- Search form -->
<div id="searchFormContainer">
    <label for="studentId">Enter Student Index Number:</label>
    <input type="text" id="studentId" name="studentId" required>
    <button onclick="submitSearch()">Search</button>
</div>
<!-- Medical records display area -->
<div id="medicalRecordsDisplay"></div>



</div>


















        <div id="medicineManagement" class="hidden">
        <label for="toggleAvailableMedicine">Show Available Medicine</label>
<input type="checkbox" id="toggleAvailableMedicine" class="toggle-checkbox" checked onchange="toggleAvailableMedicineList()">

<label for="toggleRequiredMedicine">Show Required Medicine</label>
<input type="checkbox" id="toggleRequiredMedicine" class="toggle-checkbox" checked onchange="toggleRequiredMedicineList()">
<div class="MedicineLists">
    <div class="AvailableMedicineList MedicineList" id="availableMedicineList">  <h2>Available Medicine List</h2>
<?php
    // Include database connection
    include 'db.php';

    // Function to display table rows
    function displayMedicineRows($conn) {
        // Retrieve data from MedicineAvailability table
        $sql_availability = "SELECT * FROM MedicineAvailability";
        $result_availability = $conn->query($sql_availability);

        if ($result_availability->num_rows > 0) {
            echo "<table id='medicineTable'>";
            echo "<thead><tr><th>Medicine ID</th><th>Type</th><th>Name</th><th>Stock</th><th>Expiry Date</th><th>Manufacturer</th><th>Manufacture Date</th><th>Supplier</th><th>Actions</th></tr></thead><tbody>";
            while($row = $result_availability->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["MedicineID"] . "</td>";
                echo "<td class='editable' data-column='Type' data-id='" . $row["MedicineID"] . "'>" . $row["Type"] . "</td>";
                echo "<td class='editable' data-column='Name' data-id='" . $row["MedicineID"] . "'>" . $row["Name"] . "</td>";
                echo "<td class='editable' data-column='Stock' data-id='" . $row["MedicineID"] . "'>" . $row["Stock"] . "</td>";
                echo "<td class='editable' data-column='ExpiryDate' data-id='" . $row["MedicineID"] . "'>" . $row["ExpiryDate"] . "</td>";
                echo "<td class='editable' data-column='Manufacturer' data-id='" . $row["MedicineID"] . "'>" . $row["Manufacturer"] . "</td>";
                echo "<td class='editable' data-column='ManufactureDate' data-id='" . $row["MedicineID"] . "'>" . $row["ManufactureDate"] . "</td>";
                echo "<td class='editable' data-column='Supplier' data-id='" . $row["MedicineID"] . "'>" . $row["Supplier"] . "</td>";
                // echo "<td><img src='data:image/jpeg;base64," . base64_encode($row['Image']) . "'/></td>";
                echo "<td>";
               // echo "<button class='edit-btn' onclick='editRow(" . $row["MedicineID"] . ")'>Edit</button>";
                echo "<button class='delete-btn' onclick='deleteRow(" . $row["MedicineID"] . ")'>Delete</button>";
                //echo "<button class='save-btn' onclick='saveRow(" . $row["MedicineID"] . ")' style='display: none;'>Save</button>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No data available</p>";
        }
    }

    // Call the function to display rows
    displayMedicineRows($conn);
    ?>

    <!-- Row for inserting new data -->
    <table id="newData">
        <tr>
            <td><input type="text" id="newMedicineID" placeholder="Medicine ID" class="editable"></td>
            <td><input type="text" id="newType" placeholder="Type" class="editable"></td>
            <td><input type="text" id="newName" placeholder="Name" class="editable"></td>
            <td><input type="number" id="newStock" placeholder="Stock" class="editable"></td>
            <td><input type="date" id="newExpiryDate" placeholder="Expiry Date" class="editable"></td>
            <td><input type="text" id="newManufacturer" placeholder="Manufacturer" class="editable"></td>
            <td><input type="date" id="newManufactureDate" placeholder="Manufacture Date" class="editable"></td>
            <td><input type="text" id="newSupplier" placeholder="Supplier" class="editable"></td>
         <!--  <td><input type="file" id="newImage" accept="image/*"></td> -->
            <td><button id="insert-btn" onclick="insertRow()">Insert</button></td>
        </tr>
    </table>
    </div> 

<!-- Required Medicine management functionality goes here -->
<div class="RequiredMedicineList MedicineList" id="requiredMedicineList">
    <h2>Required Medicine List</h2>
    <?php
    // Include database connection
    include 'db.php';

    // Function to display table rows
    function displayRequiredMedicineRows($conn)
    {
        // Retrieve data from RequiredMedicine table
        $sql_required = "SELECT * FROM RequiredMedicine";
        $result_required = $conn->query($sql_required);

        if ($result_required->num_rows > 0) {
            echo "<table id='requiredMedicineTable'>";
            echo "<thead><tr><th>ID</th><th>Type</th><th>Name</th><th>Quantity</th><th>Actions</th></tr></thead><tbody>";
            while ($row = $result_required->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td class='editable' data-column='Type' data-id='" . $row["ID"] . "'>" . $row["TypeName"] . "</td>";
                echo "<td class='editable' data-column='Name' data-id='" . $row["ID"] . "'>" . $row["Name"] . "</td>";
                echo "<td class='editable' data-column='Stock' data-id='" . $row["ID"] . "'>" . $row["Quantity"] . "</td>";

                echo "<td>";
                echo "<button class='delete-btn' onclick='deleteRowrequiredm(" . $row["ID"] . ")'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No data available</p>";
        }
    }

    // Call the function to display rows
    displayRequiredMedicineRows($conn);
    ?>

    <!-- Row for inserting new data -->
    <table id="newData">
        <tr>
            <td><input type="number" id="newID" placeholder="ID" class="editable"></td>
            <td><input type="text" id="newTypeName" placeholder="Type" class="editable"></td>
            <td><input type="text" id="newNamee" placeholder="Name" class="editable"></td>
            <td><input type="number" id="newQuantity" placeholder="Quantity" class="editable"></td>
            
            <td><button id="insert-btn" onclick="insertRowe()">Insert</button></td>
        </tr>
    </table>
</div>
<div>
    </div>

    <script src="script.js"></script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>
