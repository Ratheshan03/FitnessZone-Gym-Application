<?php

session_start();
session_unset();
session_destroy();

// Debug log to confirm session destruction
error_log("User logged out successfully.");

header("Location: ../index.php");
exit();
