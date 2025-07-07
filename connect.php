<?php
session_start();
// connect.php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'f4_forum';

$conn = mysqli_connect($server, $username, $password, $database);

// Check connectie
if (!$conn) {
    exit('Error: could not establish database connection');
} //else {
    //echo "Succes!<br>";
//}

// Select database
if (!mysqli_select_db($conn, $database)) {
    exit('Error: could not select the database');
} //else {
    //echo "Selected database: ",$database;
//}
?>