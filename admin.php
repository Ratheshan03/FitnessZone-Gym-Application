<?php
session_start();
include 'includes/dbh.inc.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Handle trainer addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_trainer'])) {
    $trainer_name = $_POST['trainer_name'];
    $phone_number = $_POST['trainer_phone'];
    $specialty = $_POST['specialty'];
    $pricing = $_POST['pricing_packages'];
    $image = $_FILES['trainer_image']['name'];
    $image_tmp = $_FILES['trainer_image']['tmp_name'];
    $target_dir = "img/trainers/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($image_tmp, $target_file)) {
        $query = $conn->prepare("INSERT INTO trainers (trainer_name, phone_number, specialty, pricing_packages, image_url) VALUES (?, ?, ?, ?, ?)");
        $query->bind_param("sssss", $trainer_name, $phone_number, $specialty, $pricing, $target_file);
        $query->execute();
        $query->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<p class='alert alert-danger'>Failed to upload image.</p>";
    }
}

// Handle trainer deletion
if (isset($_GET['delete_trainer'])) {
    $trainerId = intval($_GET['delete_trainer']);
    if ($trainerId > 0) {
        $query = $conn->prepare("DELETE FROM trainers WHERE trainer_id = ?");
        $query->bind_param("i", $trainerId);
        $query->execute();
        $query->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Handle staff addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_staff'])) {
    $staff_name = $_POST['staff_name'];
    $email = $_POST['staff_email'];
    $phone_number = $_POST['staff_phone'];
    $temporary_password = password_hash($_POST['temporary_password'], PASSWORD_DEFAULT);

    $query = $conn->prepare("INSERT INTO users (username, email, password_hash, role, phone_number) VALUES (?, ?, ?, 'staff', ?)");
    $query->bind_param("ssss", $staff_name, $email, $temporary_password, $phone_number);
    $query->execute();
    $query->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Handle staff deletion
if (isset($_GET['delete_staff'])) {
    $staff_id = intval($_GET['delete_staff']);
    $query = $conn->prepare("DELETE FROM users WHERE user_id = ? AND role = 'staff'");
    $query->bind_param("i", $staff_id);
    $query->execute();
    $query->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch trainers and staff
$trainersQuery = "SELECT trainer_id, trainer_name, phone_number, specialty, pricing_packages, image_url FROM trainers";
$trainersResult = $conn->query($trainersQuery);

$staffQuery = "SELECT user_id, username, email, phone_number FROM users WHERE role = 'staff'";
$staffResult = $conn->query($staffQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FitZone Fitness Center</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Body Styling */
            body {
                background: linear-gradient(to right, #2c2c2c, #1a1a1a); /* Dark gradient background */
                color: #ffffff; /* White text for readability */
                font-family: Arial, sans-serif;
            }

            /* Navbar Styling */
            .navbar {
                background: rgba(255, 255, 255, 0.1); /* Transparent with glassmorphism effect */
                backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }
            .navbar-brand {
                color: #ffffff !important; /* White brand text */
            }
            .navbar-nav .nav-link {
                color: #ffffff !important;
                transition: color 0.3s ease, background-color 0.3s ease;
            }
            .navbar-nav .nav-link:hover {
                color: #ff5252; /* Accent color for hover */
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 5px;
            }

            /* Tab Navigation Styling */
            .nav-tabs .nav-item .nav-link {
                background: rgba(255, 255, 255, 0.1); /* Transparent tabs */
                color: #ffffff; /* White text */
                border: 1px solid rgba(255, 255, 255, 0.2); /* Subtle border */
                border-radius: 5px 5px 0 0;
            }
            .nav-tabs .nav-item .nav-link.active {
                background: #ff5252; /* Accent color for active tab */
                color: #ffffff;
            }

            /* Container Styling */
            .container {
                background: rgba(255, 255, 255, 0.05); /* Slightly transparent container background */
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5); /* Subtle shadow */
                padding: 2rem;
                margin-top: 4rem;
            }

            /* Form Styling */
            .form-control, .form-control-file {
                background: rgba(255, 255, 255, 0.1); /* Transparent input background */
                color: #ffffff; /* White text */
                border: 1px solid rgba(255, 255, 255, 0.2); /* Subtle border */
            }
            .form-control:focus, .form-control-file:focus {
                background: rgba(255, 255, 255, 0.2); /* Brighter on focus */
                border-color: #ff5252; /* Accent border on focus */
                color: #ffffff;
            }
            .btn-primary {
                background: #ff5252; /* Accent color for buttons */
                border: none;
                transition: background-color 0.3s ease;
            }
            .btn-primary:hover {
                background: #e04141; /* Darker accent on hover */
            }
            .btn-danger {
                background: #ff4d4d; /* Danger button color */
                border: none;
                transition: background-color 0.3s ease;
            }
            .btn-danger:hover {
                background: #e03e3e; /* Darker danger on hover */
            }

            /* Table Styling */
            .table {
                background: rgba(255, 255, 255, 0.1); /* Transparent table background */
                color: #ffffff; /* White text */
                border-radius: 5px;
                overflow: hidden; /* Ensure rounded borders are clean */
            }
            .table th, .table td {
                border-color: rgba(255, 255, 255, 0.2); /* Subtle border */
            }
            .table thead th {
                background: rgba(255, 255, 255, 0.2); /* Slightly brighter head */
                color: #ffffff;
                }

                /* Image Styling */
                img {
                    border-radius: 8px;
                    max-width: 100%;
                    height: auto;
                    object-fit: cover;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5); /* Subtle shadow around images */
                }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">FitZone Admin</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="admin.php">Dashboard</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Admin Dashboard</h2>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#add-trainer">Add Trainer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#manage-trainers">Manage Trainers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#add-staff">Add Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#manage-staff">Manage Staff</a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Add Trainer -->
            <div id="add-trainer" class="tab-pane active">
                <h3>Add Trainer</h3>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Trainer Name</label>
                        <input type="text" class="form-control" name="trainer_name" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="trainer_phone" required>
                    </div>
                    <div class="form-group">
                        <label>Specialty</label>
                        <input type="text" class="form-control" name="specialty" required>
                    </div>
                    <div class="form-group">
                        <label>Pricing Packages</label>
                        <input type="text" class="form-control" name="pricing_packages" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control-file" name="trainer_image" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="add_trainer">Add Trainer</button>
                </form>
            </div>

            <!-- Manage Trainers -->
            <div id="manage-trainers" class="tab-pane">
                <h3>Manage Trainers</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Specialty</th>
                            <th>Pricing</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($trainer = $trainersResult->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($trainer['trainer_name']); ?></td>
                            <td><?php echo htmlspecialchars($trainer['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($trainer['specialty']); ?></td>
                            <td><?php echo htmlspecialchars($trainer['pricing_packages']); ?></td>
                            <td><a href="?delete_trainer=<?php echo $trainer['trainer_id']; ?>" class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Staff -->
            <div id="add-staff" class="tab-pane">
                <h3>Add Staff</h3>
                <form method="post">
                    <div class="form-group">
                        <label>Staff Name</label>
                        <input type="text" class="form-control" name="staff_name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="staff_email" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="staff_phone" required>
                    </div>
                    <div class="form-group">
                        <label>Temporary Password</label>
                        <input type="text" class="form-control" name="temporary_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="add_staff">Add Staff</button>
                </form>
            </div>

            <!-- Manage Staff -->
            <div id="manage-staff" class="tab-pane">
                <h3>Manage Staff</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($staff = $staffResult->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($staff['username']); ?></td>
                            <td><?php echo htmlspecialchars($staff['email']); ?></td>
                            <td><?php echo htmlspecialchars($staff['phone_number']); ?></td>
                            <td><a href="?delete_staff=<?php echo $staff['user_id']; ?>" class="btn btn-danger">Delete</a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
