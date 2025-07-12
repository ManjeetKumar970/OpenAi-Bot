<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";     // Database host
$user = "root";          // MySQL username (default for XAMPP)
$password = "";          // MySQL password (empty by default for XAMPP)
$dbname = "openai"; // Replace with your database name  fliter_text_and_rember_text

$con=new mysqli($host,$user,$password,$dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}else{
    echo "Connection Successfully";
}
?>


