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
    $name = $_POST['trainer_name'];
    $specialty = $_POST['specialty'];
    $pricing = $_POST['pricing_packages'];
    $image = $_FILES['trainer_image']['name'];
    $image_tmp = $_FILES['trainer_image']['tmp_name'];
    $target_dir = "img/trainers/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($image_tmp, $target_file)) {
        $query = $conn->prepare("INSERT INTO trainers (name, specialty, pricing_packages, image_url) VALUES (?, ?, ?, ?)");
        $query->bind_param("ssss", $name, $specialty, $pricing, $target_file);
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

// Fetch existing trainers
$trainersQuery = "SELECT trainer_id, name, specialty, pricing_packages, image_url FROM trainers";
$trainersResult = $conn->query($trainersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - FitZone Fitness Center</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e2e2e2, #ffffff);
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 2rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .trainer-table img {
            max-width: 80px;
            max-height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Panel - FitZone Fitness Center</h2>
    <ul class="nav nav-tabs" id="adminTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="add-trainer-tab" data-toggle="tab" href="#add-trainer" role="tab" aria-controls="add-trainer" aria-selected="true">Add Trainer</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="manage-trainers-tab" data-toggle="tab" href="#manage-trainers" role="tab" aria-controls="manage-trainers" aria-selected="false">Manage Trainers</a>
        </li>
    </ul>

    <div class="tab-content" id="adminTabContent">
        <!-- Add Trainer -->
        <div class="tab-pane fade show active" id="add-trainer" role="tabpanel" aria-labelledby="add-trainer-tab">
            <h3>Add Trainer</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="trainer_name">Trainer Name</label>
                    <input type="text" class="form-control" id="trainer_name" name="trainer_name" required>
                </div>
                <div class="form-group">
                    <label for="specialty">Specialty</label>
                    <input type="text" class="form-control" id="specialty" name="specialty" required>
                </div>
                <div class="form-group">
                    <label for="pricing_packages">Pricing Packages</label>
                    <input type="text" class="form-control" id="pricing_packages" name="pricing_packages" required>
                </div>
                <div class="form-group">
                    <label for="trainer_image">Image</label>
                    <input type="file" class="form-control-file" id="trainer_image" name="trainer_image" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary" name="add_trainer">Add Trainer</button>
            </form>
        </div>

        <!-- Manage Trainers -->
        <div class="tab-pane fade" id="manage-trainers" role="tabpanel" aria-labelledby="manage-trainers-tab">
            <h3>Manage Trainers</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Specialty</th>
                        <th>Pricing</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($trainer = $trainersResult->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($trainer['name']); ?></td>
                            <td><?php echo htmlspecialchars($trainer['specialty']); ?></td>
                            <td><?php echo htmlspecialchars($trainer['pricing_packages']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($trainer['image_url']); ?>" alt="Trainer Image"></td>
                            <td>
                                <a href="?delete_trainer=<?php echo $trainer['trainer_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
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
