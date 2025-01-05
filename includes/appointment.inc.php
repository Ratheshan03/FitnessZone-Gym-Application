<?php
session_start();

if (isset($_POST['appointment-submit'])) {
    require 'dbh.inc.php';

    // Get session data
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $customer_name = $_POST['customer_name'];
    $service_type = $_POST['service_type'];
    $class_id = !empty($_POST['class_id']) ? $_POST['class_id'] : null;
    $trainer_id = !empty($_POST['trainer_id']) ? $_POST['trainer_id'] : null;
    $appointment_date = $_POST['appointment_date'];

    // Validate required fields
    if (empty($user_id) || empty($customer_name) || empty($service_type) || empty($appointment_date)) {
        header("Location: ../appointments.php?error=emptyfields");
        exit();
    }

    // Ensure user exists
    $user_check_sql = "SELECT user_id FROM users WHERE user_id = ?";
    $user_check_stmt = $conn->prepare($user_check_sql);
    $user_check_stmt->bind_param("i", $user_id);
    $user_check_stmt->execute();
    $result = $user_check_stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: ../appointments.php?error=usernotfound");
        exit();
    }

    // Insert appointment
    $sql = "INSERT INTO appointments (user_id, customer_name, service_type, class_id, trainer_id, appointment_date, status) 
            VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $customer_name, $service_type, $class_id, $trainer_id, $appointment_date);

    if ($stmt->execute()) {
        header("Location: ../appointments.php?appointment=success");
    } else {
        header("Location: ../appointments.php?error=sqlerror");
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../appointments.php");
    exit();
}
