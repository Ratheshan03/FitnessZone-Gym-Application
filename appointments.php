<?php
require "header.php";
?>

<br><br>
<div class="container">
    <h3 class="text-center"><br>New Appointment<br></h3>
    <div class="row">
        <div class="col-md-6 offset-md-3">

<?php
if (isset($_SESSION['user_id'])) {
    echo '<p class="text-white bg-dark text-center">Welcome ' . htmlspecialchars($_SESSION['username']) . ', Book your appointment here!</p>';
    
    // Error handling
    if (isset($_GET['error'])) {
        switch ($_GET['error']) {
            case "emptyfields":
                echo '<h5 class="bg-danger text-center">Fill all fields, Please try again!</h5>';
                break;
            case "invalidservice":
                echo '<h5 class="bg-danger text-center">Invalid Service Type, Please try again!</h5>';
                break;
            case "classnotfound":
                echo '<h5 class="bg-danger text-center">Selected class does not exist, Please try again!</h5>';
                break;
            case "invalidcomment":
                echo '<h5 class="bg-danger text-center">Invalid Comment, Please try again!</h5>';
                break;
            case "usernotfound":
                echo '<h5 class="bg-danger text-center">User not found, Please try again!</h5>';
                break;
        }
    }

    if (isset($_GET['appointment']) && $_GET['appointment'] == "success") {   
        echo '<h5 class="bg-success text-center">Your appointment was successful!</h5>';
    }

    echo '<br>';

    // Appointment form  
    echo '  
    <div class="signup-form">
        <form action="includes/appointment.inc.php" method="post">
            <div class="form-group">
                <label>Service Type</label>
                <select class="form-control" name="service_type" required="required">
                    <option value="personal_training">Personal Training</option>
                    <option value="group_class">Group Class</option>
                    <option value="nutrition_counseling">Nutrition Counseling</option>
                </select>
                <small class="form-text text-muted">Choose the type of service</small>
            </div>
            <div class="form-group">
                <label>Select Fitness Class (For Group Classes Only)</label>
                <input type="number" class="form-control" name="class_id" placeholder="Class ID (optional)">
                <small class="form-text text-muted">Enter the class ID if booking a group class</small>
            </div>
            <div class="form-group">
                <label>Enter Appointment Date</label>
                <input type="datetime-local" class="form-control" name="appointment_date" required="required">
            </div>
            <div class="form-group">
                <label>Enter Comments</label>
                <textarea class="form-control" name="comments" placeholder="Comments" rows="3"></textarea>
                <small class="form-text text-muted">Comments must be less than 200 characters</small>
            </div>        
            <div class="form-group">
                <label class="checkbox-inline"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
            </div>
            <div class="form-group">
                <button type="submit" name="appointment-submit" class="btn btn-dark btn-lg btn-block">Submit Appointment</button>
            </div>
        </form>
        <br><br>
    </div>';
} else {
    echo '<p class="text-center text-danger"><br>You are currently not logged in!<br></p>
          <p class="text-center">In order to book an appointment you have to create an account!<br><br></p>';  
}
?>

        </div>
    </div>
    <hr>
    <h3 class="text-center">Book a Trainer</h3>
    <div class="row">
        <?php
        if (isset($_SESSION['user_id'])) {
            // Fetch trainers
            $trainers_sql = "SELECT t.trainer_id, u.username, t.specialty, t.certification_details, t.pricing_packages FROM trainers t JOIN users u ON t.user_id = u.user_id";
            $result = $conn->query($trainers_sql);

            if ($result->num_rows > 0) {
                while ($trainer = $result->fetch_assoc()) {
                    echo '
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($trainer['username']) . '</h5>
                                <p class="card-text"><strong>Specialty:</strong> ' . htmlspecialchars($trainer['specialty']) . '</p>
                                <p class="card-text"><strong>Certifications:</strong> ' . htmlspecialchars($trainer['certification_details']) . '</p>
                                <p class="card-text"><strong>Pricing:</strong> ' . htmlspecialchars($trainer['pricing_packages']) . '</p>
                                <form action="includes/book_trainer.inc.php" method="post">
                                    <input type="hidden" name="trainer_id" value="' . htmlspecialchars($trainer['trainer_id']) . '">
                                    <button type="submit" class="btn btn-primary btn-block">Book Now</button>
                                </form>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p class="text-center">No trainers available at the moment.</p>';
            }
        } else {
            echo '<p class="text-center justify text-danger">Please log in to book a trainer.</p>';
        }
        ?>
    </div>
</div>
<br><br>

<?php
require "footer.php";
?>
