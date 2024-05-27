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

