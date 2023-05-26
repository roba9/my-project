<?php
// Database connection code
include('configdb.php');

// Check if user ID is provided in the URL
if(isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Retrieve user data from the database
    $query = "SELECT * FROM users WHERE id = '{$user_id}'";
    $result = $conn->query($query);

    // Check if the query was successful
    if($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}

?>



<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>


<?php
    include("configdb.php");
    $ID = $_GET['id'];
    $up = mysqli_query($conn , "SELECT * FROM users WHERE id=$ID");
    $data = mysqli_fetch_array($up);

    ?>




<div class="header">
    <h2>Edit Register</h2>
</div>

<form method="post">
    <div class="input-group">
     <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value='<?php echo $data['email']?>'>
    </div>

	<div class="input-group">
  <label for="name">Name:</label>
        <input type="text" id="name" name="name" required value='<?php echo $data['name']?>'>
    </div>
    <div class="input-group">
    <label for="password">Password:</label>
        <input type="password" id="password" name="password" required value='<?php echo $data['password']?>'>
    </div>
    <div class="input-group">
    <label for="confirm-password">Confirm Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required value='<?php echo $data['password']?>'>
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
  
 
</body>

<?php
// Assuming you have a MySQL database set up with appropriate credentials
include('configdb.php');

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm-password"];

    // Check if the password matches the confirm password
    if ($password !== $confirmPassword) {
        echo "Error: Passwords do not match.";
    } else {
        // Sanitize the input data to prevent SQL injection
        $name = mysqli_real_escape_string($conn, $name);
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        // Insert the data into the "users" table
        $sql = "UPDATE users SET name='$name' , email='$email' , password='$password'  WHERE id=$ID";

        if (mysqli_query($conn, $sql)) {

          $_SESSION["name"] = $name;
          print_r($_SESSION);

            echo "<p style='color:green; text-align:center'>Registration successful!</p>";
            header('location:users.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);  ?>




</html>
