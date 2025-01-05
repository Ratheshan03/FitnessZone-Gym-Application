<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'includes/dbh.inc.php';

function fetchAppointments($user_id, $role) {
    global $conn;

    // Fetch appointments including trainer details
    if ($role === 'admin' || $role === 'staff') {
        $sql = "
            SELECT 
                a.appointment_id, 
                u.username AS customer_name, 
                a.appointment_date, 
                a.status, 
                t.trainer_name AS trainer_name
            FROM appointments a
            LEFT JOIN users u ON a.user_id = u.user_id
            LEFT JOIN trainers t ON a.class_id = t.trainer_id
        ";
        $stmt = $conn->prepare($sql);
    } else {
        $sql = "
            SELECT 
                a.appointment_id, 
                u.username AS customer_name, 
                a.appointment_date, 
                a.status, 
                t.trainer_name AS trainer_name
            FROM appointments a
            LEFT JOIN users u ON a.user_id = u.user_id
            LEFT JOIN trainers t ON a.class_id = t.trainer_id
            WHERE a.user_id = ?
        ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $appointments = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    return $appointments;
}
?>
