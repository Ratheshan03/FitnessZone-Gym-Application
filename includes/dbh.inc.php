<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "fitzone_fitness_center";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Debug log to confirm connection
error_log("Database connection established successfully.");
?>
