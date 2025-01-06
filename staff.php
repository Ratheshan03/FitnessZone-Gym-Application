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
    $sql = "UPDATE appointments SET status = 'Approved' WHERE appointment_id = ?";
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
    $sql = "DELETE FROM appointments WHERE appointment_id = ?";
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

// Handle blog creation
if (isset($_POST['add-blog'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];
    $author_id = $_SESSION['user_id'];

    $sql = "INSERT INTO blogs (title, content, author_id, category, image_url) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $title, $content, $author_id, $category, $image_url);
    if ($stmt->execute()) {
        header("Location: staff.php?msg=blogadded");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}

// Handle blog deletion
if (isset($_POST['delete-blog'])) {
    $blog_id = intval($_POST['blog_id']);
    $sql = "DELETE FROM blogs WHERE blog_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);
    if ($stmt->execute()) {
        header("Location: staff.php?msg=blogdeleted");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}

// Handle inquiry resolution
if (isset($_POST['resolve-inquiry'])) {
    $inquiry_id = intval($_POST['inquiry_id']);
    $sql = "UPDATE inquiries SET status = 'closed' WHERE inquiry_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inquiry_id);
    if ($stmt->execute()) {
        header("Location: staff.php?msg=inquiryresolved");
        exit();
    } else {
        die("Error: " . $stmt->error);
    }
}

// Retrieve data
$appointments_sql = "
    SELECT 
        appointments.appointment_id, 
        appointments.service_type, 
        appointments.appointment_date, 
        appointments.status, 
        users.username 
    FROM appointments 
    JOIN users ON appointments.user_id = users.user_id
    ORDER BY appointment_date ASC";
$appointments_result = $conn->query($appointments_sql);

$customers_sql = "SELECT user_id, username, email, phone_number FROM users WHERE role = 'customer'";
$customers_result = $conn->query($customers_sql);

$blogs_sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$blogs_result = $conn->query($blogs_sql);

// Retrieve inquiries
$inquiries_sql = "
    SELECT 
        inquiries.inquiry_id, 
        inquiries.subject, 
        inquiries.message, 
        inquiries.created_at, 
        users.username, 
        users.phone_number 
    FROM inquiries 
    LEFT JOIN users ON inquiries.user_id = users.user_id
    WHERE inquiries.status = 'open'
    ORDER BY created_at DESC";
$inquiries_result = $conn->query($inquiries_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logoN.png">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #2c2c2c, #1a1a1a);
            color: white;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .nav .nav-link{
            color: rgb(230, 220, 220);
            text-decoration: none;
        }

        .nav .nav-link:hover {
            background: #ff5252;
            transition: 0.3s;
        }

        .sidebar {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 5px;
        }

        .table th, .table td {
            color: white;
        }
        .table {
            background: rgba(255, 255, 255, 0.05);
        }
        .btn {
            margin: 5px;
        }
        .section-content {
            display: none;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Staff Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="staff.php">Dashboard</a></li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3 sidebar">
                <h4>Management</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="#" onclick="toggleSection('appointments')">Appointments</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" onclick="toggleSection('customers')">Customers</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" onclick="toggleSection('blogs')">Manage Blogs</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" onclick="toggleSection('inquiries')">Inquiries</a></li>
                </ul>
            </div>

            <div class="col-md-9">
                <!-- Appointments Section -->
                <div id="appointments" class="section-content">
                    <h2>Appointments</h2>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Service Type</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($appointment = $appointments_result->fetch_assoc()) : ?>
                                <tr>
                                    <form action="staff.php" method="POST">
                                        <input type="hidden" name="appointment_id" value="<?php echo $appointment['appointment_id']; ?>">
                                        <td><?php echo $appointment['appointment_id']; ?></td>
                                        <td><?php echo htmlspecialchars($appointment['username']); ?></td>
                                        <td><?php echo htmlspecialchars($appointment['service_type']); ?></td>
                                        <td><?php echo $appointment['appointment_date']; ?></td>
                                        <td><?php echo $appointment['status']; ?></td>
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
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($customer = $customers_result->fetch_assoc()) : ?>
                                <tr>
                                    <form action="staff.php" method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $customer['user_id']; ?>">
                                        <td><?php echo $customer['user_id']; ?></td>
                                        <td><?php echo htmlspecialchars($customer['username']); ?></td>
                                        <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                        <td><?php echo htmlspecialchars($customer['phone_number']); ?></td>
                                        <td>
                                            <button type="submit" name="delete-customer" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Blogs Section -->
                <div id="blogs" class="section-content">
                    <h2>Manage Blogs</h2>
                    <form action="staff.php" method="POST">
                        <div class="form-group">
                            <label>Blog Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea class="form-control" name="content" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category" required>
                                <option value="workout_routines">Workout Routines</option>
                                <option value="healthy_recipes">Healthy Recipes</option>
                                <option value="meal_plans">Meal Plans</option>
                                <option value="success_stories">Success Stories</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Image URL</label>
                            <input type="text" class="form-control" name="image_url">
                        </div>
                        <button type="submit" name="add-blog" class="btn btn-success">Add Blog</button>
                    </form>
                    <hr>
                    <h3>Existing Blogs</h3>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($blog = $blogs_result->fetch_assoc()) : ?>
                                <tr>
                                    <form action="staff.php" method="POST">
                                        <input type="hidden" name="blog_id" value="<?php echo $blog['blog_id']; ?>">
                                        <td><?php echo htmlspecialchars($blog['title']); ?></td>
                                        <td><?php echo htmlspecialchars($blog['category']); ?></td>
                                        <td><?php echo htmlspecialchars($blog['created_at']); ?></td>
                                        <td>
                                            <button type="submit" name="delete-blog" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Inquiries Section -->
                <div id="inquiries" class="section-content">
                    <h2>Inquiries</h2>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Reported At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($inquiry = $inquiries_result->fetch_assoc()) : ?>
                                <tr>
                                    <form action="staff.php" method="POST">
                                        <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['inquiry_id']; ?>">
                                        <td><?php echo $inquiry['inquiry_id']; ?></td>
                                        <td><?php echo htmlspecialchars($inquiry['username'] ?? 'Anonymous'); ?></td>
                                        <td><?php echo htmlspecialchars($inquiry['phone_number'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($inquiry['subject']); ?></td>
                                        <td><?php echo htmlspecialchars($inquiry['message']); ?></td>
                                        <td><?php echo $inquiry['created_at']; ?></td>
                                        <td>
                                            <button type="submit" name="resolve-inquiry" class="btn btn-success btn-sm">Resolve</button>
                                        </td>
                                    </form>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSection(id) {
            document.querySelectorAll('.section-content').forEach(section => section.style.display = 'none');
            document.getElementById(id).style.display = 'block';
        }
    </script>
</body>
</html>
