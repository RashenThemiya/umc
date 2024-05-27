<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UMC - Your Health & Wellness Partner</title>
  <link rel="stylesheet" href="style.css">
  <style></style>
</head>
<body>
  <header>
    <div class="container">
      <h1>University Medical Center (UMC)</h1>
      <p>Supporting Your Health & Well-being</p>
    </div>
  </header>
  <nav>
    <div class="container">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact Us</a></li>
        <li class="login">
          <a href="#" onclick="openLogin()">Login</a>
        </li>
      </ul>
    </div>
  </nav>
  <main>
    <section class="hero">
      <div class="container">
        <h2>Welcome to UMC!</h2>
        <p>We're dedicated to providing comprehensive healthcare services for all students at Sabaragamuwa University.</p>
        <p>Take charge of your health and explore our resources:</p>
        <ul>
          <li><a href="#">Health Education & Safety</a></li>
          <li><a href="#">Schedule Appointment</a> (requires login)</li>
        </ul>
      </div>
    </section>
    <section class="health-data">
      <div class="container">
        <h2>Health Data & Resources</h2>
        <p>Access valuable information to stay informed and healthy.</p>
        <div class="data-cards">
          <div class="card">
            <h3>Required Medicine</h3>
            <p>**Placeholder** (Replace with data from backend)</p>
          </div>
          <div class="card">
            <h3>Doctor Availability</h3>
            <p>**Placeholder** (Replace with data from backend)</p>
          </div>
        </div>
      </div>
    </section>
    <section class="donations">
      <div class="container">
        <h2>Support UMC</h2>
        <p>Your contributions help us provide essential resources for students.</p>
        <div class="donation-info">
          <p>Learn how you can donate:</p>
          <ul>
            <li><a href="#">Donate Medications</a></li>
            <li><a href="#">Make a Financial Donation</a></li>
          </ul>
        </div>
        <div class="donors">
          <h3>Thank you to our Recent Donors!</h3>
          <p>**Placeholder** (Replace with data from backend)</p>
        </div>
      </div>
    </section>
  </main>
  <footer>
    <div class="container">
      <p>&copy; University Medical Center - Sabaragamuwa University</p>
    </div>
  </footer>

  <!-- Login Popup -->
  <div id="loginPopup" class="popup" style="display: none;">
    <div class="popup-content">
      <span onclick="closeLogin()" style="cursor: pointer; float: right;">&times;</span>
      <h2>Login</h2>
      <!-- Your login form goes here -->
      <form action="login.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
      </form>
      <p>Don't have an account? <a href="#" onclick="openRegister() ,closeLogin()">Register</a></p>
    </div>
  </div>

  <!-- Register Popup -->
  <div id="registerPopup" class="popup" style="display: none;">
    <div class="popup-content">
      <span onclick="closeRegister()" style="cursor: pointer; float: right;">&times;</span>
      <h2>Register</h2>
      <!-- Your registration form goes here -->
      <form action="register.php" method="post">
        <label for="index">University Index:</label><br>
        <input type="text" id="index" name="index"><br>
        <label for="fullname">Full Name:</label><br>
        <input type="text" id="fullname" name="fullname"><br>
        <label for="age">Age:</label><br>
        <input type="text" id="age" name="age"><br>
        <!-- Add more fields as necessary -->
        <input type="submit" value="Register">
      </form>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
