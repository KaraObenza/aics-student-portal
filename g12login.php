<?php
// Connect to database
$host = "localhost";
$username = "root";
$password = "";
$dbName = "aics";

$connection = mysqli_connect($host, $username, $password, $dbName);

if (!$connection) {
    die("Error: Could not connect to the database. " . mysqli_connect_error());
}

// Get user input
$email = $_POST['email'];
$password = $_POST['password'];

// Check if user exists
$check_query = "SELECT * FROM accountuser WHERE email='$email' AND password='$password'";
$result = mysqli_query($connection, $check_query);

if (mysqli_num_rows($result) == 1) {
    echo "<script>alert('Login successful.')</script>";
    session_start();
    $_SESSION['user']  = $result;
    header('Location: index.html');  // Redirect to homepage or dashboard
    exit();
} else {
    echo "<script>alert('Invalid email or password.')</script>";
    header('Location: g12login.html');  // Redirect back to login page
    exit();
}

mysqli_close($connection);
?>
