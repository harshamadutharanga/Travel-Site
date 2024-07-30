<?php 
session_start();
$con = mysqli_connect('localhost', 'root', '', 'harsha');

$email = ""; // Initialize the variable to avoid undefined variable error

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
}else{
    // If email and password session variables are not set, redirect to login page
    header('Location: login-user.php');
    exit(); // Make sure to exit after redirecting
}
?>


<?php
// Step 1: Establish a connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "userform";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Fetch data from the database
$sql = "SELECT *  FROM booking";
$result = $conn->query($sql);
?>