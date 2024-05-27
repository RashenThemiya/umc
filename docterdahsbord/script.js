// JavaScript to handle the popup opening



document.getElementById('loginBtn').addEventListener('click', function() {
  document.getElementById('loginPopup').style.display = 'block';
});

// JavaScript to handle the popup closing
document.getElementById('closeBtn').addEventListener('click', function() {
  document.getElementById('loginPopup').style.display = 'none';
});

// JavaScript for opening and closing the login popup
function openLogin() {
  document.getElementById("loginPopup").style.display = "block";
}

function closeLogin() {
  document.getElementById("loginPopup").style.display = "none";
}

// JavaScript for opening and closing the register popup
function openRegister() {
  document.getElementById("registerPopup").style.display = "block";
}

function closeRegister() {
  document.getElementById("registerPopup").style.display = "none";
}

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

// Function to handle form submission
// JavaScript for handling the form submission

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
  var url = 'view_medical_records.php?studentId=' + encodeURIComponent(studentId); // Replace 'your_php_script.php' with the actual path to your PHP script

  // Configure the request
  xhr.open('GET', url, true);

  // Define the onload event handler
  xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
          // Success! Parse and print the response
          var response = xhr.responseText;
          document.getElementById('medicalRecordsDisplay').innerHTML = response;
      } else {
          // Error! Print error message
          document.getElementById('medicalRecordsDisplay').innerHTML = 'Error fetching medical records';
      }
  };

  // Send the request
  xhr.send();
}



   // Get references to the checkbox and hidden input field
   function updateAvailability() {
    var checkbox = document.getElementById("availabilityCheckbox");
    var hiddenInput = document.getElementById("availabilityHidden");
    
    console.log("Checkbox state:", checkbox.checked);
    
    if (checkbox.checked) {
        console.log("Checkbox is checked. Setting availability to 'Available'.");
        hiddenInput.value = "Available";
    } else {
        console.log("Checkbox is not checked. Setting availability to 'Unavailable'.");
        hiddenInput.value = "Unavailable";
    }
    
    console.log("Hidden input value:", hiddenInput.value);
}



/////MEDICATION MANJMENT SCRRIPT

// Function to handle editing of a row
// Function to handle editing a row
// Function to handle editing a row
function editRow(id) {
  // Debugging: Log the ID to ensure it's correct
  console.log("Editing row with ID:", id);

  // Find the row with the specified id
  var row = document.querySelector("[data-id='" + id + "']");
  
  // Debugging: Log the found row to check if it exists
  console.log("Found row:", row);
  
  // Check if the row exists
  if (row) {
      // Get all editable cells within the row
      var cells = row.querySelectorAll(".editable");
      
      // Debugging: Log the found cells to ensure they exist
      console.log("Editable cells:", cells);
      
      // Show the save button and hide the edit button
      var saveButton = row.querySelector(".save-btn[data-rowid='" + id + "']");
      var editButton = row.querySelector(".edit-btn[data-rowid='" + id + "']");
      
      // Debugging: Log the found buttons to ensure they exist
      console.log("Save button:", saveButton);
      console.log("Edit button:", editButton);
      
      if (saveButton && editButton) {
          // Iterate over each editable cell
          cells.forEach(function(cell) {
              // Enable content editing for the cell
              cell.contentEditable = "true";
              // Optionally, change the background color to indicate editing mode
              cell.style.backgroundColor = "#f0f0f0";
          });

          // Debugging: Check if classes are being properly toggled
          console.log("Toggling classes...");
          
          // Remove hide class from save button and add it to edit button
          saveButton.classList.remove("hide");
          editButton.classList.add("hide");
      } else {
          console.error("Save button or edit button not found!");
      }
  } else {
      console.error("Row not found!");
  }
}




  // Function to handle deleting a row
  function deleteRow(id) {
    var confirmation = confirm("Are you sure you want to delete this row?");
    if (confirmation) {
        // Find the row containing the delete button
        var row = document.querySelector("[data-id='" + id + "']").closest("tr");
        
        // Send AJAX request to delete the row from the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_row.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        // If deletion from the database is successful, remove the row from the table
                        row.remove();
                        alert("Row deleted successfully");
                    } else {
                        alert("Error: " + response.message);
                    }
                } else {
                    alert("An error occurred while processing your request");
                }
            }
        };
        // Send the row id in the request body
        var data = { id: id };
        xhr.send(JSON.stringify(data));
    }
}

  // Function to handle inserting a new row
  // Function to handle inserting a new row
  function insertRow() {
    // Get the values from the input fields
    var newMedicineID = $("#newMedicineID").val();
    var newType = $("#newType").val();
    var newName = $("#newName").val();
    var newStock = $("#newStock").val();
    var newExpiryDate = $("#newExpiryDate").val();
    var newManufacturer = $("#newManufacturer").val();
    var newManufactureDate = $("#newManufactureDate").val();
    var newSupplier = $("#newSupplier").val();

    var data = {
        newMedicineID: newMedicineID,
        newType: newType,
        newName: newName,
        newStock: newStock,
        newExpiryDate: newExpiryDate,
        newManufacturer: newManufacturer,
        newManufactureDate: newManufactureDate,
        newSupplier: newSupplier
    };

    // Send the AJAX request using jQuery
    $.ajax({
        url: 'insert_row.php', // Modify the URL as per your server setup
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            console.log('Response:', response); // Log the response for debugging
            try {
                var responseData = JSON.parse(response);
                if (responseData.status === "success") {
                    alert("New row inserted successfully");
                    // Add the new row to the table dynamically
                    addRowToTable(data);
                } else {
                    alert("Error: " + responseData.message);
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
                alert("An error occurred while processing the response");
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            alert("An error occurred while processing your request");
        }
    });
}

function addRowToTable(data) {
    var newRowID = Date.now(); // Example: using current timestamp
    var newRow = "<tr id='row_" + newRowID + "'>" +
        "<td>" + data.newMedicineID + "</td>" +
        "<td class='editable' data-column='Type' data-id='type_" + newRowID + "'>" + data.newType + "</td>" +
        "<td class='editable' data-column='Name' data-id='name_" + newRowID + "'>" + data.newName + "</td>" +
        "<td class='editable' data-column='Stock' data-id='stock_" + newRowID + "'>" + data.newStock + "</td>" +
        "<td class='editable' data-column='ExpiryDate' data-id='expiry_" + newRowID + "'>" + data.newExpiryDate + "</td>" +
        "<td class='editable' data-column='Manufacturer' data-id='manufacturer_" + newRowID + "'>" + data.newManufacturer + "</td>" +
        "<td class='editable' data-column='ManufactureDate' data-id='manufacture_" + newRowID + "'>" + data.newManufactureDate + "</td>" +
        "<td class='editable' data-column='Supplier' data-id='supplier_" + newRowID + "'>" + data.newSupplier + "</td>" +
        "<td>" +
        "<button class='delete-btn' onclick='deleteRow(" + newRowID + ")'>Delete</button>" +
        "</td>" +
        "</tr>";

    // Append the new row to the table body
    $("#medicineTable tbody").append(newRow);

    // Clear the input fields after insertion
    $("#newMedicineID").val("");
    $("#newType").val("");
    $("#newName").val("");
    $("#newStock").val("");
    $("#newExpiryDate").val("");
    $("#newManufacturer").val("");
    $("#newManufactureDate").val("");
    $("#newSupplier").val("");
}







function insertRowe() {
    // Get the values from the input fields
    var newID = $("#newID").val();
    var newTypeName = $("#newTypeName").val();
    var newName = $("#newNamee").val();
    var newQuantity = $("#newQuantity").val();

    // Prepare the data to be sent in the AJAX request
    var data = {
        newID: newID,
        newTypeName: newTypeName,
        newName: newName,
        newQuantity: newQuantity
    };

    // Send the AJAX request using jQuery
    $.ajax({
        url: 'insert_required_row.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            console.log('Response:', response);
            try {
                var responseData = JSON.parse(response);
                if (responseData.status === "success") {
                    alert("New row inserted successfully");
                    // Add the new row to the table dynamically
                    addRowToTables(data);
                } else {
                    alert("Error: " + responseData.message);
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
                alert("An error occurred while processing the response");
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
            alert("An error occurred while processing your request");
        }
    });
}

function addRowToTables(data) {
    var newRowID = Date.now();
    var newRow = "<tr>" +
        "<td>" + data.newID + "</td>" +
        "<td>" + data.newTypeName + "</td>" +
        "<td>" + data.newName + "</td>" +
        "<td>" + data.newQuantity + "</td>" +
        "<td><button class='delete-btn' onclick='deleteRow(" + data.newID + ")'>Delete</button></td>" +
        "</tr>";
    $("#requiredMedicineTable tbody").append(newRow);

    // Clear the input fields after insertion
    $("#newID").val("");
    $("#newTypeName").val("");
    $("#newNamee").val("");
    $("#newQuantity").val("");
}


function deleteRowrequiredm(id) {
    var confirmation = confirm("Are you sure you want to delete this row?");
    if (confirmation) {
        // Send AJAX request to delete the row from the database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_rowRM.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        // If deletion from the database is successful, remove the row from the table
                        var row = document.querySelector("[data-id='" + id + "']").closest("tr");
                        if (row) {
                            row.remove();
                            alert("Row deleted successfully");
                        } else {
                            console.error("Row not found");
                        }
                    } else {
                        alert("Error: " + response.message);
                    }
                } else {
                    alert("An error occurred while processing your request");
                }
            }
        };
        
        // Send the row id in the request body
        var data = { id: id };
        xhr.send(JSON.stringify(data));
    }
}

function toggleAvailableMedicineList() {
    var availableMedicineList = document.getElementById("availableMedicineList");
    if (availableMedicineList) {
        availableMedicineList.style.display = document.getElementById("toggleAvailableMedicine").checked ? "block" : "none";
    } else {
        console.error("Element with ID 'availableMedicineList' not found.");
    }
}

function toggleRequiredMedicineList() {
    var requiredMedicineList = document.getElementById("requiredMedicineList");
    if (requiredMedicineList) {
        requiredMedicineList.style.display = document.getElementById("toggleRequiredMedicine").checked ? "block" : "none";
    } else {
        console.error("Element with ID 'requiredMedicineList' not found.");
    }
}







///////////medical reqset for students
document.addEventListener("DOMContentLoaded", function() {
    fetchMedicalRecords();
});

function fetchMedicalRecords() {
    fetch('Mreq.php')
        .then(response => response.json())
        .then(records => {
            const tableBody = document.querySelector('#medicalRecords tbody');
            tableBody.innerHTML = '';
            records.forEach(record => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${record.student_index}</td>
                    <td>${record.document}</td>
                    <td>${record.date}</td>
                    <td>${record.time}</td>
                    <td>${record.medical_duration}</td>
                    <td>${record.exam_or_lecture_details}</td>
                    <td>${record.faculty}</td>
                    <td>${record.department}</td>
                    <td>
                        <button onclick="approveRecord(${record.request_id})">Approve</button>
                        <button onclick="notApproveRecord(${record.request_id})">Not Approve</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        });
}

function approveRecord(requestId) {
    fetch(`approve_record.php?request_id=${requestId}`)
        .then(response => {
            if (response.ok) {
                alert('Medical record approved successfully.');
                fetchMedicalRecords();
            } else {
                alert('Failed to approve medical record.');
            }
        });
}

function notApproveRecord(requestId) {
    fetch(`not_approve_record.php?request_id=${requestId}`)
        .then(response => {
            if (response.ok) {
                alert('Medical record marked as not approved.');
                fetchMedicalRecords();
            } else {
                alert('Failed to mark medical record as not approved.');
            }
        });
}
function approveRecord(requestID) {
    $.ajax({
        type: 'POST',
        url: 'approve_request.php',
        data: { requestID: requestID },
        success: function(response) {
            if (response === 'success') {
                // Hide the row containing the approved request
                alert(response);
                var k = document.querySelector("[data-id='" + requestID + "']").closest("tr");
                k.remove();
            } else {
                alert('Failed to approve request. '+response);
            }
        }
    });
}
function notApproveRecord(requestID) {
    $.ajax({
        type: 'POST',
        url: 'not_approve_request.php',
        data: { requestID: requestID },
        success: function(response) {
            if (response === 'success') {
                alert(response);
                var k = document.querySelector("[data-id='" + requestID + "']").closest("tr");
                k.remove();
            } else {
                alert('Failed to not approve request. ' + response);
            }
        }
    });
}



function Searche() {
    // Get the entered student index number
    document.getElementById('pendinglist').style.display = 'block';
    var studentIndex = document.getElementById('studentIndex').value;
  
    // Perform AJAX request to fetch PHP script content
    fetchPhpScriptContent(studentIndex);
}

// Function to fetch and print the PHP script content
function fetchPhpScriptContent(studentIndex) {
    document.getElementById('pending').style.display = 'none';

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();
  
    // Specify the URL of the PHP script
    var url = 'search_medical_requests.php?student_index=' + encodeURIComponent(studentIndex); // Corrected parameter name
  
    // Configure the request
    xhr.open('GET', url, true);
  
    // Define the onload event handler
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Success! Parse and print the response
            var response = xhr.responseText;
            document.getElementById('pendinglist').innerHTML = response;
        } else {
            // Error! Print error message
            document.getElementById('pendinglist').innerHTML = 'Error fetching medical records';
        }
    };
  
    // Send the request
    xhr.send();
}

function RequestDelete(requestId) {
    // Confirm deletion
    var confirmDelete = confirm("Are you sure you want to delete this request?");
    if (confirmDelete) {
        // Perform AJAX request to delete the medical request
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Check if the deletion was successful
                if (xhr.responseText === "success") {
                    // Remove the deleted request's row from the table
                    var rowToDelete = document.querySelector("[data-id='" + requestId + "']").closest("tr");
                    rowToDelete.remove();
                } else {
                    alert("Error deleting request: " + xhr.responseText);
                }
            }
        };
        xhr.open("GET", "delete_request.php?request_id=" + requestId, true);
        xhr.send();
    }
}
function goBack() {
    // Navigate back in the browser history
    document.getElementById('pending').style.display = 'block';
    document.getElementById('pendinglist').style.display = 'none';
}

