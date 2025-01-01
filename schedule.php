<?php
require "header.php";
?>

<br><br>
<div class="container">
    <h3 class="text-center"><br>Manage Schedule<br></h3>
    <div class="col-md-6 offset-md-3">

<?php 
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'staff') {
        echo '<p class="text-white bg-dark text-center">Set or update the schedule for a specific date</p><br>';

        // Display feedback messages
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "sqlerror") {
                echo '<h5 class="bg-danger text-center">Database error occurred. Please try again!</h5>';
            } else if ($_GET['error'] == "emptyfields") {
                echo '<h5 class="bg-danger text-center">Error: All fields must be filled!</h5>';
            }
        }

        if (isset($_GET['schedule'])) {
            if ($_GET['schedule'] == "created") {
                echo '<h5 class="bg-success text-center">Schedule was successfully created!</h5>';
            } else if ($_GET['schedule'] == "updated") {
                echo '<h5 class="bg-success text-center">Schedule was successfully updated!</h5>';
            }
        }

        // Schedule form
        echo '
        <div class="signup-form">
            <form action="includes/schedule.inc.php" method="post">
                <div class="form-group">
                    <label>Enter Date</label>
                    <input type="date" class="form-control" name="date" placeholder="Date" required="required">
                </div>
                <div class="form-group">
                    <label>Open Time</label>
                    <input type="time" class="form-control" name="opentime" required="required">
                </div>
                <div class="form-group">
                    <label>Close Time</label>
                    <input type="time" class="form-control" name="closetime" required="required">
                </div>
                <div class="form-group">
                    <button type="submit" name="schedule" class="btn btn-dark btn-lg btn-block">Submit Schedule</button>
                </div>
            </form>
            <br><br>
        </div>';
    } else {
        echo '<p class="text-center"><br>You do not have permission to access this page.<br><br></p>';
    }
} else {
    echo '<p class="text-center"><br>Please log in to manage the schedule.<br><br></p>';
}
?>

    </div>
</div>
<br><br>

<?php
require "footer.php";
?>
