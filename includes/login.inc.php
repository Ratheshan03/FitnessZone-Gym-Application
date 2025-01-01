<?php
session_start();

if (isset($_POST['login-submit'])) {
    require 'dbh.inc.php';

    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];

    // Admin credentials
    $admin_email = 'admin@fitzone.com';
    $admin_password = 'admin1234';

    if (empty($mailuid) || empty($password)) {
        header("Location: ../index.php?error1=emptyfields");
        exit();
    } else {
        // Check if the credentials match the admin credentials
        if ($mailuid === $admin_email && $password === $admin_password) {
            $_SESSION['user_id'] = 1; // Admin ID
            $_SESSION['username'] = 'admin';
            $_SESSION['role'] = 'admin';
            header("Location: ../admin.php");
            exit();
        } else {
            // Proceed with user login validation
            $sql = "SELECT * FROM users WHERE username=? OR email=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.php?error1=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $pwdCheck = password_verify($password, $row['password_hash']);
                    if ($pwdCheck == false) {
                        header("Location: ../index.php?error1=wrongpwd");
                        exit();   
                    } else if ($pwdCheck == true) {
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['role'] = $row['role'];
                        
                        if ($_SESSION['role'] === 'staff') {
                            header("Location: ../staff.php?login=success");
                        } else {
                            header("Location: ../reservation.php?login=success");
                        }
                        exit();
                    } else {
                        header("Location: ../index.php?error1=error2");
                        exit();    
                    }
                } else {
                    header("Location: ../index.php?error1=nouser");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
