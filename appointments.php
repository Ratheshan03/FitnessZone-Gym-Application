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

    .card {
        background: rgba(255, 255, 255, 0.05);
        border: none;
        border-radius: 10px;
        color: white;
    }

    .card-title {
        color: #ff5252;
        font-weight: bold;
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

    .card-img-top {
        border-radius: 10px 10px 0 0;
    }

    .card-text strong {
        color: #ff5252;
    }

    .card-body button {
        background-color: #ff5252;
        border: none;
    }

    .card-body button:hover {
        background-color: #ff3232;
        transition: 0.3s;
    }

    hr {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .alert {
        color: white;
    }

    .bg-dark {
        background-color: #2c2c2c !important;
    }
</style>

<div class="container my-5">
    <h3 class="text-center">New Appointment</h3>
    <div class="row">
        <div class="col-md-8 offset-md-2 my-4 p-4">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<p class="text-center bg-dark p-2">Welcome ' . htmlspecialchars($_SESSION['username']) . ', Book your appointment here!</p>';
                
                if (isset($_GET['error'])) {
                    switch ($_GET['error']) {
                        case "emptyfields":
                            echo '<p class="alert alert-danger text-center">Fill all fields, Please try again!</p>';
                            break;
                        case "invalidservice":
                            echo '<p class="alert alert-danger text-center">Invalid Service Type, Please try again!</p>';
                            break;
                        case "classnotfound":
                            echo '<p class="alert alert-danger text-center">Selected class does not exist, Please try again!</p>';
                            break;
                        case "invalidcomment":
                            echo '<p class="alert alert-danger text-center">Invalid Comment, Please try again!</p>';
                            break;
                        case "usernotfound":
                            echo '<p class="alert alert-danger text-center">User not found, Please try again!</p>';
                            break;
                    }
                }

                if (isset($_GET['appointment']) && $_GET['appointment'] == "success") {   
                    echo '<p class="alert alert-success text-center">Your appointment was successful!</p>';
                }

                echo '
                <form action="includes/appointment.inc.php" method="post">
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
                        <input type="number" class="form-control" name="class_id" placeholder="Class ID (optional)">
                    </div>
                    <div class="form-group">
                        <label>Enter Appointment Date</label>
                        <input type="datetime-local" class="form-control" name="appointment_date" required>
                    </div>
                    <div class="form-group">
                        <label>Enter Comments</label>
                        <textarea class="form-control" name="comments" placeholder="Comments" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-inline"><input type="checkbox" required> I accept the <a href="#">Terms of Use</a> & <a href="#">Privacy Policy</a></label>
                    </div>
                    <button type="submit" name="appointment-submit" class="btn btn-dark btn-lg btn-block">Submit Appointment</button>
                </form>
                ';
            } else {
                echo '<p class="text-center text-danger">You are currently not logged in!</p>';
                echo '<p class="text-center">To book an appointment, you need to log in or create an account.</p>';
            }
            ?>
        </div>
    </div>
    <hr>
    <h3 class="text-center">Book a Trainer</h3>
    <div class="row">
        <?php
        if (isset($_SESSION['user_id'])) {
            $trainers_sql = "SELECT trainer_id, trainer_name, phone_number, specialty, certification_details, pricing_packages, image_url FROM trainers";
            $result = $conn->query($trainers_sql);

            if ($result && $result->num_rows > 0) {
                while ($trainer = $result->fetch_assoc()) {
                    echo '
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="' . htmlspecialchars($trainer['image_url']) . '" class="card-img-top" alt="Trainer Image">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($trainer['trainer_name']) . '</h5>
                                <p class="card-text"><strong>Phone:</strong> ' . htmlspecialchars($trainer['phone_number']) . '</p>
                                <p class="card-text"><strong>Specialty:</strong> ' . htmlspecialchars($trainer['specialty']) . '</p>
                                <p class="card-text"><strong>Certifications:</strong> ' . htmlspecialchars($trainer['certification_details']) . '</p>
                                <p class="card-text"><strong>Pricing:</strong> ' . htmlspecialchars($trainer['pricing_packages']) . '</p>
                                <form action="includes/book_trainer.inc.php" method="post">
                                    <input type="hidden" name="trainer_id" value="' . htmlspecialchars($trainer['trainer_id']) . '">
                                    <button type="submit" class="btn btn-dark btn-block">Book Now</button>
                                </form>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p class="text-center">No trainers available at the moment.</p>';
            }
        } else {
            echo '<p class="text-center text-danger">Please log in to book a trainer.</p>';
        }
        ?>
    </div>
</div>

<?php
require "footer.php";
?>
