<?php
require "header.php";
?>

<br><br>
<div class="container">
    <h3 class="text-center"><br>Manage Class Capacity<br></h3>
    <div class="col-md-6 offset-md-3">

<?php 
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'staff') {
        echo '<p class="text-white bg-dark text-center">Set the class capacity for a specific date</p><br>';

        // Display error messages
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "sqlerror") {
                echo '<h5 class="bg-danger text-center">Database error occurred. Please try again!</h5>';
            } else if ($_GET['error'] == "emptyfields") {
                echo '<h5 class="bg-danger text-center">Error: All fields must be filled!</h5>';
            }
        }

        // Display success messages
        if (isset($_GET['capacity'])) {
            if ($_GET['capacity'] == "created") {
                echo '<h5 class="bg-success text-center">Class capacity was successfully created!</h5>';
            } else if ($_GET['capacity'] == "updated") {
                echo '<h5 class="bg-success text-center">Class capacity was successfully updated!</h5>';
            }
        }

        // Form for managing class capacity
        echo '
        <div class="signup-form">
            <form action="includes/tables.inc.php" method="post">
                <div class="form-group">
                    <label>Enter Date</label>
                    <input type="date" class="form-control" name="date_classes" placeholder="Date" required="required">
                </div>
                <div class="form-group">
                    <label>Class Capacity</label>
                    <input type="number" class="form-control" min="1" name="class_capacity" required="required">
                    <small class="form-text text-muted">Default capacity is 20</small>
                </div>
                <div class="form-group">
                    <button type="submit" name="class_capacity" class="btn btn-dark btn-lg btn-block">Submit Capacity</button>
                </div>
            </form>
            <br><br>
        </div>';
    } else {
        echo '<p class="text-center"><br>You do not have permission to access this page.<br><br></p>';
    }
} else {
    echo '<p class="text-center"><br>Please log in to manage class capacity.<br><br></p>';
}
?>

    </div>
</div>
<br><br>

<?php
require "footer.php";
?>
