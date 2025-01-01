<?php
session_start();

function between($val, $x, $y) {
    $val_len = strlen($val);
    return ($val_len >= $x && $val_len <= $y) ? TRUE : FALSE;
}

if (isset($_POST['appointment-submit'])) {
    require 'dbh.inc.php';

    $user_id = $_SESSION['user_id'];
    $service_type = $_POST['service_type'];
    $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : null;
    $appointment_date = $_POST['appointment_date'];
    $comments = isset($_POST['comments']) ? $_POST['comments'] : '';

    // Validation
    if (empty($service_type) || empty($appointment_date)) {
        header("Location: ../appointments.php?error=emptyfields");
        exit();
    }

    if (!in_array($service_type, ['personal_training', 'group_class', 'nutrition_counseling'])) {
        header("Location: ../appointments.php?error=invalidservice");
        exit();
    }

    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $comments) || !between($comments, 0, 200)) {
        header("Location: ../appointments.php?error=invalidcomment");
        exit();
    }

    // Check if user exists in users table
    $sql = "SELECT user_id FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        header("Location: ../appointments.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) === 0) {
        header("Location: ../appointments.php?error=usernotfound");
        exit();
    }

    // Check class availability (if group class is selected)
    if ($service_type === 'group_class' && $class_id !== null) {
        $sql = "SELECT class_id FROM fitness_classes WHERE class_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            header("Location: ../appointments.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "i", $class_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) === 0) {
            header("Location: ../appointments.php?error=classnotfound");
            exit();
        }
    }

    // Insert appointment into the database
    $sql = "INSERT INTO appointments (user_id, service_type, class_id, appointment_date, status) VALUES (?, ?, ?, ?, 'pending')";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        header("Location: ../appointments.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $service_type, $class_id, $appointment_date);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../appointments.php?appointment=success");
    } else {
        header("Location: ../appointments.php?error=sqlerror1");
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../appointments.php");
    exit();
}
?>
