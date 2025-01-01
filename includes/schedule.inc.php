<?php

if (isset($_POST['schedule'])) {
    require 'dbh.inc.php';

    $date = $_POST['date'];
    $openTime = $_POST['opentime'];
    $closeTime = $_POST['closetime'];

    // Validation
    if (empty($date) || empty($openTime) || empty($closeTime)) {
        header("Location: ../schedule.php?error=emptyfields");
        exit();
    }

    // Check if the schedule already exists for the given date
    $sql = "SELECT date FROM schedule WHERE date=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../schedule.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if ($resultCheck > 0) {
            // Update existing schedule
            $sql = "UPDATE schedule SET open_time=?, close_time=? WHERE date=?";
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../schedule.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "sss", $openTime, $closeTime, $date);
            mysqli_stmt_execute($stmt);
            header("Location: ../schedule.php?schedule=updated");
            exit();
        } else {
            // Insert new schedule
            $sql = "INSERT INTO schedule (date, open_time, close_time) VALUES (?, ?, ?)";
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../schedule.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "sss", $date, $openTime, $closeTime);
            mysqli_stmt_execute($stmt);
            header("Location: ../schedule.php?schedule=created");
            exit();
        }
    }
    // Close the connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
