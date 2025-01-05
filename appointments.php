<?php
require "header.php";
require "includes/dbh.inc.php"; // Include the database connection file
?>

<style>
    body {
        background: linear-gradient(to right, #2c2c2c, #1a1a1a);
        color: white;
    }

    .container {
        background: rgba(0, 0, 0, 0.8);
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    h3 {
        font-weight: bold;
        color: #ff5252;
        margin-top: 20px;
    }

    .btn-dark {
        background-color: #ff5252;
        border: none;
    }

    .btn-dark:hover {
        background-color: #ff3232;
        transition: 0.3s;
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

    .card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    border: none;
    color: white;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(255, 255, 255, 0.2);
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
        border-bottom: 2px solid #ff5252;
    }

    .card-title {
        color: #ff5252;
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .card-body {
        background: rgba(0, 0, 0, 0.8);
        padding: 1.5rem;
        border-radius: 0 0 10px 10px;
    }

    .card-body p {
        margin: 0.5rem 0;
        color: rgba(255, 255, 255, 0.7);
    }

    hr {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<div class="container my-5">
    <h3 class="text-center">New Appointment</h3>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<p class="text-center bg-dark p-2">Welcome ' . htmlspecialchars($_SESSION['username']) . ', Book your appointment here!</p>';
                
                if (isset($_GET['error'])) {
                    echo '<p class="alert alert-danger text-center">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                if (isset($_GET['appointment']) && $_GET['appointment'] == "success") {   
                    echo '<p class="alert alert-success text-center">Your appointment was successful!</p>';
                }

                echo '
                <form action="includes/appointment.inc.php" method="post">
                    <div class="form-group">
                        <label>Customer Full Name</label>
                        <input type="text" class="form-control" name="customer_name" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label>Service Type</label>
                        <select class="form-control" name="service_type" required>
                            <option value="personal_training">Personal Training</option>
                            <option value="group_class">Group Class</option>
                            <option value="nutrition_counseling">Nutrition Counseling</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Fitness Class (For Group Classes Only)</label>
                        <select class="form-control" name="class_id">
                            <option value="">None</option>';
                
                $classes_sql = "SELECT class_id, class_name FROM fitness_classes";
                $classes_result = $conn->query($classes_sql);
                if ($classes_result->num_rows > 0) {
                    while ($class = $classes_result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($class['class_id']) . '">' . htmlspecialchars($class['class_name']) . '</option>';
                    }
                }
                echo '
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Select Trainer (Optional)</label>
                        <select class="form-control" name="trainer_id">
                            <option value="">None</option>';
                
                $trainers_sql = "SELECT trainer_id, trainer_name FROM trainers";
                $trainers_result = $conn->query($trainers_sql);
                if ($trainers_result->num_rows > 0) {
                    while ($trainer = $trainers_result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($trainer['trainer_id']) . '">' . htmlspecialchars($trainer['trainer_name']) . '</option>';
                    }
                }
                echo '
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Enter Appointment Date</label>
                        <input type="datetime-local" class="form-control" name="appointment_date" required>
                    </div>
                    <button type="submit" name="appointment-submit" class="btn btn-dark btn-lg btn-block">Submit Appointment</button>
                </form>';
            } else {
                echo '<p class="text-center text-danger">You are currently not logged in!</p>';
            }
            ?>
        </div>
    </div>
    <hr>
    <h3 class="text-center">Available Trainers</h3>
    <div class="row">
        <?php
        $trainers_sql = "SELECT trainer_id, trainer_name, phone_number, specialty, certification_details, pricing_packages, image_url FROM trainers";
        $result = $conn->query($trainers_sql);

        if ($result && $result->num_rows > 0) {
            while ($trainer = $result->fetch_assoc()) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg">
                        <img src="' . htmlspecialchars($trainer['image_url']) . '" class="card-img-top" alt="Trainer Image">
                        <div class="card-body text-center">
                            <h5 class="card-title">' . htmlspecialchars($trainer['trainer_name']) . '</h5>
                            <p><strong>Specialty:</strong> ' . htmlspecialchars($trainer['specialty']) . '</p>
                            <p><strong>Phone:</strong> ' . htmlspecialchars($trainer['phone_number']) . '</p>
                            <p><strong>Certifications:</strong> ' . htmlspecialchars($trainer['certification_details']) . '</p>
                            <p><strong>Pricing:</strong> ' . htmlspecialchars($trainer['pricing_packages']) . '</p>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<p class="text-center">No trainers available at the moment.</p>';
        }
        ?>
    </div>

</div>

<?php
require "footer.php";
?>
