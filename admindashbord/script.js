
// JavaScript for doctor dashboard popup
function showProfile() {
  hideAll();
  console.log('Script is running');
  document.getElementById('profile').classList.remove('hidden');
}

function showAppointments() {
  hideAll();
  document.getElementById('appointments').classList.remove('hidden');
}

function showMedicalRequests() {
  hideAll();
  document.getElementById('medicalRequests').classList.remove('hidden');
}

function showMedicalRecords() {
  hideAll();
  document.getElementById('medicalRecords').classList.remove('hidden');
}

function showMedicineManagement() {
  hideAll();
  document.getElementById('medicineManagement').classList.remove('hidden');
}

function hideAll() {
  var elements = document.querySelectorAll('.container > div');
  elements.forEach(function(element) {
      element.classList.add('hidden');
  });
}
function searchStudent() {
  var searchIndex = document.getElementById("search_student_index").value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          document.getElementById("studentDetails").innerHTML = this.responseText;
      }
  };
  xhttp.open("POST", "update_student.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("search_student_index=" + searchIndex);
}

// Event listener for search button click
document.getElementById("searchButton").addEventListener("click", function(event) {
  event.preventDefault(); // Prevent default form submission
  searchStudent(); // Call function to handle search
});




function submitSearch() {
  // Get the entered student index number
  var studentId = document.getElementById('studentId').value;

  // Perform AJAX request to fetch PHP script content
  fetchPhpScriptContente(studentId);
}

// Function to fetch and print the PHP script content
function fetchPhpScriptContente(studentId) {
  // Create a new XMLHttpRequest object
  var xhr = new XMLHttpRequest();

  // Specify the URL of the PHP script
  var url = 'update_student.php?studentId=' + encodeURIComponent(studentId); // Replace 'your_php_script.php' with the actual path to your PHP script

  // Configure the request
  xhr.open('GET', url, true);

  // Define the onload event handler
  xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
          // Success! Parse and print the response
          var response = xhr.responseText;
          document.getElementById('studentDetails').innerHTML = response;
      } else {
          // Error! Print error message
          document.getElementById('studentDetails').innerHTML = 'Error fetching medical records';
      }
  };

  // Send the request
  xhr.send();
}

// Function to handle form submission
function updateStudentDetails() {
  // Gather form data manually
  var studentIndex = document.getElementById("student_index").value;
  var studentName = document.getElementById("student_name").value;
  var studentPhoneNumber = document.getElementById("student_phone_number").value;
  var studentHomeNumber = document.getElementById("student_home_number").value;
  var studentAddress = document.getElementById("student_address").value;
  var studentBloodType = document.getElementById("student_blood_type").value;
  var birthDate = document.getElementById("birth_date").value;
  var studentAllergies = document.getElementById("student_allergies").value;
  var studentMedicalHistory = document.getElementById("student_medical_history").value;
  var studentHeight = document.getElementById("student_height").value;
  var studentWeight = document.getElementById("student_weight").value;
  var faculty = document.getElementById("faculty").value;
  var department = document.getElementById("department").value;

 alert("FormData:", {
      studentIndex,
      studentName,
      studentPhoneNumber,
      studentHomeNumber,
      studentAddress,
      studentBloodType,
      birthDate,
      studentAllergies,
      studentMedicalHistory,
      studentHeight,
      studentWeight,
      faculty,
      department
  });

  // Construct a query string with the form data
  var formData = new FormData();
  formData.append("student_index", studentIndex);
  formData.append("student_name", studentName);
  formData.append("student_phone_number", studentPhoneNumber);
  formData.append("student_home_number", studentHomeNumber);
  formData.append("student_address", studentAddress);
  formData.append("student_blood_type", studentBloodType);
  formData.append("birth_date", birthDate);
  formData.append("student_allergies", studentAllergies);
  formData.append("student_medical_history", studentMedicalHistory);
  formData.append("student_height", studentHeight);
  formData.append("student_weight", studentWeight);
  formData.append("faculty", faculty);
  formData.append("department", department);

  // Send form data asynchronously using AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "update_student_details.php", true);
  xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              // Check if the response indicates success
              if (xhr.responseText.trim() === "success") {
                  // If successful, reload the page to show the updated account
                  alert("Student details updated successfully.");
                  location.reload();
              } else {
                  // If not successful, display an error message
                  alert("Error updating student details");
              }
          } else {
              // Handle error
              console.error("Error updating student details:", xhr.statusText);
          }
      }
  };
  xhr.send(formData);
}    
 

var allMedicines = ''; // Variable to store all medicines HTML

$(document).ready(function() {
    // Store all medicines HTML when the page is loaded
    allMedicines = $("#medicineTable").html();
});

function searchMedicine() {
    var searchName = $("#searchName").val();
    
    $.ajax({
        url: 'search_medicine.php',
        type: 'GET',
        data: {
            searchName: searchName
        },
        success: function(data) {
            $("#medicineTable").html(data);
            $("#showAllBtn").show(); // Show the "Show All" button after search
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}



function updateStock(medicineID) {
    var newStock = $("#newStock" + medicineID).val();
    
    $.ajax({
        url: 'update_stock.php',
        type: 'POST',
        data: {
            medicineID: medicineID,
            newStock: newStock
        },
        success: function(data) {
            $("#stock" + medicineID).text(newStock);
            $("#message").text("Stock updated successfully");
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


