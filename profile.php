<?php
session_start();
require "includes/dbh.inc.php";

// Redirect if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch subscription plans
$subscriptions_sql = "SELECT plan_name FROM membership_plans";
$subscriptions_result = $conn->query($subscriptions_sql);

if ($subscriptions_result->num_rows === 0) {
    die("Error: No subscription plans found in the database.");
}


// Fetch user inquiries
$inquiries_sql = "SELECT * FROM inquiries WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($inquiries_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$inquiries_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logoN.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #2c2c2c, #1a1a1a);
            color: white;
        }

        .container {
            background: rgba(0, 0, 0, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }

        h3 {
            font-weight: bold;
            color: #ff5252;
            margin-top: 20px;
        }

        .btn-danger, .btn-dark {
            background-color: #ff5252;
            border: none;
        }

        .btn-danger:hover, .btn-dark:hover {
            background-color: #ff3232;
            transition: 0.3s;
        }

        .table {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            color: white;
        }

        .table th {
            background-color: #ff5252;
            color: white;
            border: none;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid #555;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid #ff5252;
            box-shadow: none;
        }

        .alert {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid #ff5252;
            border-radius: 10px;
        }
    </style>
    <script>
        function toggleEditForm() {
            document.querySelector('.details-section').classList.toggle('d-none');
            document.querySelector('.form-section').classList.toggle('d-none');
        }
    </script>
</head>
<body>
    <?php require "header.php"; ?>

    <div class="container my-5">
        <h3 class="text-center">Your Profile</h3>
        <hr>

        <!-- Profile Picture and Details -->
        <div class="details-section">
            <div class="text-center">
                <img src="<?php echo htmlspecialchars($user['image_url'] ?? 'img/default-profile.png'); ?>" 
                     alt="Profile Picture" 
                     class="rounded-circle" 
                     style="width: 150px; height: 150px; object-fit: cover; margin-bottom: 20px;">
                <h4><?php echo htmlspecialchars($user['username']); ?></h4>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
                <button class="btn btn-dark" onclick="toggleEditForm()">Edit Profile</button>
            </div>
            <hr>
            <h4>Additional Details</h4>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['fullname'] ?? 'N/A'); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number'] ?? 'N/A'); ?></p>
            <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age'] ?? 'N/A'); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address'] ?? 'N/A'); ?></p>
            <p><strong>Height:</strong> <?php echo htmlspecialchars($user['height'] ?? 'N/A'); ?> cm</p>
            <p><strong>Weight:</strong> <?php echo htmlspecialchars($user['weight'] ?? 'N/A'); ?> kg</p>
            <p><strong>Guardian Name:</strong> <?php echo htmlspecialchars($user['guardian_name'] ?? 'N/A'); ?></p>
            <p><strong>Subscription:</strong> <?php echo htmlspecialchars($user['subscription'] ?? 'N/A'); ?></p>
        </div>

        <!-- Edit Profile Form -->
        <div class="form-section d-none">
            <h4>Edit Profile</h4>
            <form action="includes/update_profile.inc.php" method="POST">
                <div class="form-group">
                    <label>Username:</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Phone Number:</label>
                    <input type="text" name="phone_number" class="form-control" value="<?php echo htmlspecialchars($user['phone_number']); ?>">
                </div>
                <div class="form-group">
                    <label>Age:</label>
                    <input type="number" name="age" class="form-control" value="<?php echo htmlspecialchars($user['age'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Address:</label>
                    <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Height (in cm):</label>
                    <input type="number" name="height" class="form-control" value="<?php echo htmlspecialchars($user['height'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Weight (in kg):</label>
                    <input type="number" name="weight" class="form-control" value="<?php echo htmlspecialchars($user['weight'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Guardian Name:</label>
                    <input type="text" name="guardian_name" class="form-control" value="<?php echo htmlspecialchars($user['guardian_name'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Profile Picture URL:</label>
                    <input type="text" name="image_url" class="form-control" value="<?php echo htmlspecialchars($user['image_url'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Subscription:</label>
                    <select name="subscription" class="form-control">
                        <option value="">Select Subscription</option>
                        <?php while ($subscription = $subscriptions_result->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars(strtolower($subscription['plan_name'])); ?>" 
                                <?php echo ($user['subscription'] === strtolower($subscription['plan_name'])) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($subscription['plan_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" name="update-profile" class="btn btn-dark btn-block">Save Changes</button>
                <button type="button" class="btn btn-secondary btn-block" onclick="toggleEditForm()">Cancel</button>
            </form>
        </div>

        <hr>

        <!-- Inquiries Section -->
        <h4>Your Inquiries</h4>
        <?php if ($inquiries_result->num_rows > 0): ?>
            <table class="table table-hover table-bordered text-center">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($inquiry = $inquiries_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($inquiry['subject']); ?></td>
                            <td><?php echo htmlspecialchars($inquiry['message']); ?></td>
                            <td><?php echo htmlspecialchars($inquiry['status']); ?></td>
                            <td><?php echo htmlspecialchars($inquiry['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-danger text-center">No inquiries submitted yet.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="appointments.php" class="btn btn-dark">Appointments</a>
            <a href="contact.php" class="btn btn-dark">Contact Us</a>
        </div>
    </div>
</body>
</html>

<?php
require "footer.php";
?>