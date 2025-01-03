<?php
if (isset($_POST['send-inquiry'])) {
    session_start();
    require 'dbh.inc.php';

    $userId = $_SESSION['user_id'];
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO inquiries (user_id, subject, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $userId, $subject, $message);

    if ($stmt->execute()) {
        header("Location: ../contact.php?status=success");
    } else {
        header("Location: ../contact.php?status=error");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../contact.php");
    exit();
}
