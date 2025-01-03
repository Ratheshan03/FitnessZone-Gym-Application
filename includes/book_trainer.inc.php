<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../appointment.php?error=notloggedin");
    exit();
}

require 'dbh.inc.php';

if (isset($_POST['trainer_id'])) {
    $trainer_id = intval($_POST['trainer_id']);
    $user_id = $_SESSION['user_id'];
    $appointment_date = date("Y-m-d H:i:s");

    $sql = "INSERT INTO appointments (user_id, service_type, class_id, appointment_date, status) VALUES (?, 'personal_training', NULL, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $appointment_date);

    if ($stmt->execute()) {
        header("Location: ../appointment.php?appointment=success");
        exit();
    } else {
        header("Location: ../appointment.php?error=sqlerror");
        exit();
    }
} else {
    header("Location: ../appointment.php?error=invalidrequest");
    exit();
}
?>
