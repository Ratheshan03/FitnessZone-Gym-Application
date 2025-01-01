<?php

if (isset($_POST['class_capacity'])) {
    require 'dbh.inc.php';

    $date = $_POST['date_classes'];
    $capacity = $_POST['class_capacity'];

    // Validation
    if (empty($date) || empty($capacity)) {
        header("Location: ../tables.php?error=emptyfields");
        exit();
    }

    // Check if the capacity is already set for the given date
    $sql = "SELECT t_date FROM tables WHERE t_date=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../tables.php?error=sqlerror");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $date);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);

        if ($resultCheck > 0) {
            // Update existing capacity
            $sql = "UPDATE tables SET t_tables=? WHERE t_date=?";
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../tables.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "is", $capacity, $date);
            mysqli_stmt_execute($stmt);
            header("Location: ../tables.php?capacity=updated");
            exit();
        } else {
            // Insert new capacity
            $sql = "INSERT INTO tables (t_date, t_tables) VALUES (?, ?)";
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../tables.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "si", $date, $capacity);
            mysqli_stmt_execute($stmt);
            header("Location: ../tables.php?capacity=created");
            exit();
        }
    }

    // Close connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
