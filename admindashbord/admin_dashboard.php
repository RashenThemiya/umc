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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
        
    </script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<div class="site-wrap">

  <nav class="site-nav">

    <div class="name">
    <h1>Welcome, <?php echo $username; ?></h1>
     
    </div>



    <div class="functions ">
        <ul>
        <li><a href="#" onclick="showProfile()">Account Managment </a></li>
        <li><a href="#" onclick="showAppointments()">Medication Managment</a></li>
        <li><a href="#" onclick="showMedicalRequests()">Website Management</a></li>
        <li><a href="#" onclick="showMedicalRecords()">Appoiment Management</a></li>
        <li><a href="#" onclick="showMedicineManagement()">Other</a></li>
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
  
    <div class="form-section ">
    <h2>Create new Student account</h2>
        <form action="create_student.php" method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <label for="student_index">Student Index:</label><br>
            <input type="text" id="student_index" name="student_index"><br>
            <input type="submit" value="Create Account">
        </form>
    </div>


    
    <div class="form-section ">
    <h2>Update Student Record</h2>
        <div id="searchFormContainer">
            <label for="studentId">Enter Student Index Number:</label>
            <input type="text" id="studentId" name="studentId" required>
            <button onclick="submitSearch()">Search</button>
        </div>
        <div id="studentDetails"></div>
    </div>
</div>
</div>

<!-- Student details display area -->





















        
<div id="appointments" class="hidden">
   <div>
<h1>Medicine Stock Management</h1>
<form id="searchForm" style="margin-bottom: 20px;">
    <label for="searchName" style="font-weight: bold;">Search by Name:</label>
    <input type="text" id="searchName" name="searchName" style="padding: 5px; margin-right: 10px;">
    <button type="button" onclick="searchMedicine()" style="padding: 5px; background-color: #007bff; color: #fff; border: none; cursor: pointer;">Search</button>
</form>


<table id="medicineTable" border="1">
    <tr>
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
    
    <?php
    // Establish database connection
   
    // Check connection
  
include 'db.php'; //
    // Retrieve data from the MedicineAvailability table
    $sql = "SELECT * FROM MedicineAvailability";
    $result = $conn->query($sql);

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
        echo "<tr><td colspan='9'>No medicines available</td></tr>";
    }

   
    ?>
 </table>
</div>
</div>






<div id="medicalRequests" class="hidden">
<script>function toggleForms() {
    var addPostForm = document.getElementById("addPostForm");
    var addNoticeForm = document.getElementById("addNoticeForm");
    var toggleButton = document.getElementById("toggleButton");

    if (addPostForm.style.display === "none") {
        addPostForm.style.display = "block";
        addNoticeForm.style.display = "none";
        toggleButton.textContent = "Add Notice";
    } else {
        addPostForm.style.display = "none";
        addNoticeForm.style.display = "block";
        toggleButton.textContent = "Add Post";
    }
}
</script>
<button id="toggleButton" onclick="toggleForms()">Add Notice</button>
<div id="addNoticeForm" style="display: none;">
<script>
      $(document).ready(function(){
    // Function to fetch notices
    function fetchNotices() {
        $.ajax({
            url: "fetch_notices.php",
            method: "GET",
            success: function(data){
                $("#noticeTable").html(data);
            }
        });
    }

    // Initial fetch of notices when the page loads
    fetchNotices();

    // Function to add notice
    $("#addForm").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "add_notice.php",
            method: "POST",
            data: $("#addForm").serialize(),
            success: function(){
                fetchNotices(); // Fetch and display updated notices after adding
            }
        });
    });

    // Function to delete notice
    $(document).on("click", ".deleteBtn", function(){
        var noticeId = $(this).data("noticeid");
        $.ajax({
            url: "delete_notice.php",
            method: "POST",
            data: { notice_id: noticeId },
            success: function(){
                fetchNotices(); // Fetch and display updated notices after deletion
            }
        });
    });
});

    </script>
<h2>Add Notice</h2>
    <form id="addForm">
        <label for="notice_heading">Notice Heading:</label><br>
        <input type="text" id="notice_heading" name="notice_heading" required><br>
        <label for="notice_details">Notice Details:</label><br>
        <textarea id="notice_details" name="notice_details" required></textarea><br>
        <input type="hidden" name="created_by" value="1"> <!-- Assuming admin's user_id is 1 -->
        <input type="submit" value="Add Notice">
    </form>

    <h2>Notices</h2>
    <div id="noticeTable">
        <!-- Notices will be dynamically loaded here -->
    </div>
        
    </div>  
    <div id="addPostForm" >
    <h2>Add Post</h2>
    <form id="addFormEE" enctype="multipart/form-data">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br>
    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required></textarea><br>
    <label for="image">Image:</label><br>
    <input type="file" id="image" name="image" accept="image/*" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px;"><br>
    <input type="submit" value="Add Post" style="padding: 10px 20px; background-color:#007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
</form>


    <h2>Posts</h2>
    <div id="postList">
        <!-- Posts will be dynamically loaded here -->
    </div>
<script>
    $(document).ready(function(){
    // Function to fetch posts
    function fetchPosts() {
        $.ajax({
            url: "fetch_posts.php",
            method: "GET",
            success: function(data){
                $("#postList").html(data);
            }
        });
    }

    // Initial fetch of posts when the page loads
    fetchPosts();

    
    // Function to add post
    $("#addFormEE").submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "add_post.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(){
                fetchPosts(); // Fetch and display updated posts after adding
                $("#addForm")[0].reset(); // Reset form after submission
            }
        });
    });

    // Function to delete post
    $(document).on("click", ".deleteBtn", function(){
        var postId = $(this).data("postid");
        $.ajax({
            url: "delete_post.php",
            method: "POST",
            data: { post_id: postId },
            success: function(){
                fetchPosts(); // Fetch and display updated posts after deletion
            }
        });
    });
});
</script>

</div>  
        
        
        
        
        
        
        
        
</div>




































    <div id="medicalRecords" class="hidden">

    <h1>under devloping</h1>

    </div>


















        <div id="medicineManagement" class="hidden">
     
<h2>Ambulance List</h2>
<div id="ambulanceListContainer">
    <!-- Ambulance list will be displayed here -->
</div>

<h2>Add Ambulance</h2>
<form id="addAmbulanceForm">
    <label for="register_number">Register Number:</label><br>
    <input type="text" id="register_number" name="register_number" required><br>
    <label for="contact_number">Contact Number:</label><br>
    <input type="text" id="contact_number" name="contact_number" required><br>
    <label for="location">Location:</label><br>
    <input type="text" id="location" name="location" required><br>
    <input type="submit" value="Add Ambulance">
</form>

<script>
$(document).ready(function(){
    // Load ambulance list on page load
    function loadAmbulances() {
        $.ajax({
            url: 'fetch_ambulances.php',
            type: 'GET',
            success: function(response) {
                $('#ambulanceListContainer').html(response);
            }
        });
    }
    loadAmbulances(); // Load ambulances initially

    // Add ambulance
    $('#addAmbulanceForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'fetch_ambulances.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
               // alert(response);
                loadAmbulances(); // Reload ambulance list
                // Clear input fields after successful addition
                $('#register_number, #contact_number, #location').val('');
            }
        });
    });

    // Delete ambulance
    $(document).on('click', '.deleteBtn', function(){
        var ambulance_id = $(this).data('ambulanceid');
        $.ajax({
            url: 'fetch_ambulances.php',
            type: 'POST',
            data: { delete_id: ambulance_id },
            success: function(response) {
               // alert(response);
                loadAmbulances(); // Reload ambulance list
            }
        });
    });

    // Change availability
    $(document).on('change', '.availabilitySelect', function(){
        var ambulance_id = $(this).data('ambulanceid');
        var availability = $(this).val();
        $.ajax({
            url: 'fetch_ambulances.php',
            type: 'POST',
            data: { ambulance_id: ambulance_id, availability: availability },
            success: function(response) {
              //  alert(response);
            }
        });
    });
});
</script>
        </div>



    <script src="script.js"></script>
</body>
</html>
<?php
// Close the database connection
$conn->close();
?>
