<?php
    $user = "mamp";
    $pass = "root";
    $host = "localhost";
    $dbdb = "pidatabase";
    
$conn = new mysqli($host, $user, $pass, $dbdb);
   if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>