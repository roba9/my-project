<?php
session_start();

// Assuming you have a MySQL database set up with appropriate credentials
include('configdb.php');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $hashedPassword = md5($_POST["password"]); // Hash the password using MD5

    // Query the database to check if the email and password combination exists
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$hashedPassword'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Login successful, store user data in session
        $row = mysqli_fetch_assoc($result);
        $_SESSION["id"] = $row["id"];
        $_SESSION["name"] = $row["name"];

        // Redirect to users.php
        if ($row['role'] == 1) {
            header('location:profile.php');
        } else {
            header('location:users.php');
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  
<div class="header">
    <h2>Login</h2>
</div>
<form method="post">
    <div class="input-group">
        <label>Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" id="password" name="password" required>    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="login_user">Login</button>
    </div>
    <p>
        Not yet a member? <a href="register.php">Register now</a>
    </p>

    <?php
        if (isset($error)) {
            echo "<p style='color:red; text-align:center'>$error</p>";
        }
    ?>
</form>

</body>
</html>
