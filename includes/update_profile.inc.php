<?php
session_start();
require "dbh.inc.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Validate subscription value
$valid_subscriptions = ['basic', 'standard', 'premium'];
if (!in_array($subscription, $valid_subscriptions) && !is_null($subscription)) {
    header("Location: ../profile.php?error=invalidsubscription");
    exit();
}


// Check if the form was submitted
if (isset($_POST['update-profile'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'] ?? null;
    $phone_number = $_POST['phone_number'] ?? null;
    $age = $_POST['age'] ?? null;
    $address = $_POST['address'] ?? null;
    $height = $_POST['height'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $guardian_name = $_POST['guardian_name'] ?? null;
    $image_url = $_POST['image_url'] ?? null;
    $subscription = $_POST['subscription'] ?? null;

    // Validate required fields
    if (empty($username) || empty($email)) {
        header("Location: ../profile.php?error=emptyfields");
        exit();
    }

    // Check if the username or email already exists for another user
    $check_sql = "SELECT user_id FROM users WHERE (username = ? OR email = ?) AND user_id != ?";
    $stmt = $conn->prepare($check_sql);
    error_log("Subscription Value: " . $subscription); // Logs to PHP error log for debugging
    $stmt->bind_param("ssi", $username, $email, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../profile.php?error=useroremailtaken");
        exit();
    }

    // Update user details
    $update_sql = "
        UPDATE users 
        SET 
            username = ?, 
            email = ?,
            fullname = ?, 
            phone_number = ?, 
            age = ?, 
            address = ?, 
            height = ?, 
            weight = ?, 
            guardian_name = ?, 
            image_url = ?,
            subscription = ? 
        WHERE user_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param(
        "ssssississsi",
        $username,
        $email,
        $fullname,
        $phone_number,
        $age,
        $address,
        $height,
        $weight,
        $guardian_name,
        $image_url,
        $subscription,
        $user_id
    );

    if ($stmt->execute()) {
        header("Location: ../profile.php?success=profileupdated");
    } else {
        header("Location: ../profile.php?error=sqlerror");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../profile.php");
    exit();
}
