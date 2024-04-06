<?php
// Connect sa database
$host = "localhost";
$username = "root";
$password = "";
$dbName = "aics";

// $connection = new PDO('mysql:host=localhost;dbname=aics', 'root');

// phpinfo();
// exit;
$connection = mysqli_connect($host, $username, $password, $dbName);

if (!$connection) {
    die("Error: Could not connect to the database. " . mysqli_connect_error());
}

// Kunin ang mga ipinasa ng user mula sa form
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];


$check_query = "SELECT * FROM signup WHERE email='$email' OR password='$password'";
$result = mysqli_query($connection, $check_query);

if (mysqli_num_rows($result) > 0) {
    echo "<script>alert('name already exists. Please use a different username.')</script>";
} else {

    $insert_query = "INSERT INTO signup (name,email,password)
                     VALUES ('$name', '$email', '$password')";

    if (mysqli_query($connection, $insert_query)) {
        echo "<script>alert('Account created successfully.')</script>";
        header('Location: ./g11announcementuser/g11user.php');
        exit();
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($connection);
    }
}


mysqli_close($connection);
?>
127.0.0.1
