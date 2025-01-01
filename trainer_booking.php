<?php
session_start();
include 'includes/dbh.inc.php';

if (!isset($_GET['trainer_id'])) {
    header("Location: index.php");
    exit();
}

$trainerId = intval($_GET['trainer_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_session'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?error=notloggedin");
        exit();
    }

    $userId = $_SESSION['user_id'];
    $bookingDate = $_POST['booking_date'];
    $comments = $_POST['comments'];

    $query = $conn->prepare("INSERT INTO appointments (user_id, service_type, class_id, appointment_date, status) VALUES (?, 'personal_training', ?, ?, 'pending')");
    $query->bind_param("iis", $userId, $trainerId, $bookingDate);
    $query->execute();
    $query->close();

    header("Location: index.php?booking=success");
    exit();
}

$query = $conn->prepare("SELECT users.username, trainers.specialty, trainers.pricing_packages FROM trainers JOIN users ON trainers.user_id = users.user_id WHERE trainers.trainer_id = ?");
$query->bind_param("i", $trainerId);
$query->execute();
$query->bind_result($trainerName, $specialty, $pricingPackages);
$query->fetch();
$query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Session with <?= htmlspecialchars($trainerName) ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #e2e2e2, #ffffff);
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Book Session with <?= htmlspecialchars($trainerName) ?></h2>
        <p class="text-center"><strong>Specialty:</strong> <?= htmlspecialchars($specialty) ?></p>
        <p class="text-center"><strong>Pricing Packages:</strong> <?= htmlspecialchars($pricingPackages) ?></p>
        <form method="POST" action="">
            <div class="form-group">
                <label for="booking_date">Booking Date:</label>
                <input type="datetime-local" class="form-control" id="booking_date" name="booking_date" required>
            </div>
            <div class="form-group">
                <label for="comments">Comments (Optional):</label>
                <textarea class="form-control" id="comments" name="comments" rows="3"></textarea>
            </div>
            <button type="submit" name="book_session" class="btn btn-primary btn-block">Book Session</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
