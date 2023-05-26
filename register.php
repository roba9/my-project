<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
    <h2>Register</h2>
</div>

<form method="post">
    <div class="input-group">
    <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>

	<div class="input-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="input-group">
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
    </div>

    <div class="input-group">
        <label for="isAdmin">Admin or User</label>
        <select class="form-control" name="isAdmin" id="isAdmin">
            <option value="2">Admin</option>
            <option value="1">User</option>
        </select>
    </div>

    <div class="input-group">
        <button type="submit" class="btn" name="reg_user">Register</button>
    </div>
    <p>
        Already a member? <a href="index.php">Sign in</a>
    </p>
</form>

<footer>
    <?php include('footer.php');?>
</footer>

<?php
// Assuming you have a MySQL database set up with appropriate credentials
include('configdb.php');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Start the session
session_start();

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm-password"];
    $role = $_POST['isAdmin'];

    // Check if the password matches the confirm password
    if ($password !== $confirmPassword) {
        echo "Error: Passwords do not match.";
    } else {
        // Sanitize the input data to prevent SQL injection
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $hashedPassword = md5($password); // Hash the password using MD5

        // Insert the data into the "users" table
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashedPassword', '$role')";

        if (mysqli_query($conn, $sql)) {
            // Retrieve the last inserted ID
            $id = mysqli_insert_id($conn);

            // Save the ID in a session variable
            $_SESSION["id"] = $id;
            $_SESSION["name"] = $name;
            // var_dump($_SESSION);
            echo "<p style='color:green; text-align:center'>Registration successful!</p>";
            if ($role == 1) {
                header('location:profile.php');
            } else {
                header('location:users.php');
              }
          } else {
              echo "Error: " . mysqli_error($conn);
          }
      }
  }
  
  // Close the database connection
  mysqli_close($conn);
  ?>
  
  </body>
  </html>
  
