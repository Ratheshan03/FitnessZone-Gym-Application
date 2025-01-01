<?php
session_start();

// Check if user is logged in and has staff privileges
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: index.php");
    exit();
}

require 'includes/dbh.inc.php';

// Handle appointment approval
if (isset($_POST['approve-appointment'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $sql = "UPDATE appointments SET status = 'Approved' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    if ($stmt->execute()) {
        header("Location: staff.php?msg=appointmentapproved");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}

// Handle appointment deletion
if (isset($_POST['delete-appointment'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    if ($stmt->execute()) {
        header("Location: staff.php?msg=appointmentdeleted");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}

// Handle customer deletion
if (isset($_POST['delete-customer'])) {
    $user_id = intval($_POST['user_id']);
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        header("Location: staff.php?msg=customerdeleted");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}

// Retrieve appointments
$appointments_sql = "SELECT * FROM appointments ORDER BY appointment_date ASC";
$appointments_result = $conn->query($appointments_sql);
if (!$appointments_result) {
    die("Error fetching appointments: " . $conn->error);
}

// Retrieve customers
$customers_sql = "SELECT * FROM users";
$customers_result = $conn->query($customers_sql);
if (!$customers_result) {
    die("Error fetching customers: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - FitZone Fitness Center</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #e2e2e2, #ffffff);
        }
        .section-content {
            display: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Staff Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="staff.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-2 d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <h4 class="sidebar-heading">Management</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="toggleSection('appointments')">Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="toggleSection('customers')">Customers</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <!-- Appointments Section -->
                <div id="appointments" class="section-content">
                    <h2>Appointments</h2>
                    <table class="table table-hover table-responsive-sm text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($appointment = $appointments_result->fetch_assoc()) : ?>
                            <tr>
                                <form action="staff.php" method="POST">
                                    <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['id']); ?>">
                                    <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                                    <td>
                                        <button type="submit" name="approve-appointment" class="btn btn-success btn-sm">Approve</button>
                                        <button type="submit" name="delete-appointment" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </form>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Customers Section -->
                <div id="customers" class="section-content">
                    <h2>Customers</h2>
                    <table class="table table-hover table-responsive-sm text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($customer = $customers_result->fetch_assoc()) : ?>
                            <tr>
                                <form action="staff.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($customer['user_id']); ?>">
                                    <td><?php echo htmlspecialchars($customer['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['uidUsers']); ?></td>
                                    <td><?php echo htmlspecialchars($customer['emailUsers']); ?></td>
                                    <td>
                                        <button type="submit" name="delete-customer" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </form>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleSection(id) {
            var sections = document.querySelectorAll('.section-content');
            sections.forEach(function(section) {
                section.style.display = 'none';
            });
            var section = document.getElementById(id);
            section.style.display = (section.style.display === 'none' || section.style.display === '') ? 'block' : 'none';
        }
    </script>
</body>
</html>
