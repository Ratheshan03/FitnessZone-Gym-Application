<?php
require "header.php";
?>

<br><br>
<div class="container">
    <h3 class="text-center"><br>View Appointments<br></h3>

    <?php
    if (isset($_SESSION['user_id'])) {
        echo '<p class="text-white bg-dark text-center">' . htmlspecialchars($_SESSION['username']) . ', here you can view your appointment history</p><br>';

        // Display success/error messages
        if (isset($_GET['delete'])) {
            if ($_GET['delete'] == "error") {
                echo '<h5 class="bg-danger text-center">Error!</h5>';
            } elseif ($_GET['delete'] == "success") {
                echo '<h5 class="bg-success text-center">Appointment successfully deleted</h5>';
            }
        }

        // Include appointments logic
        require 'includes/view_appointments.inc.php';
    } else {
        echo '<p class="text-center text-danger"><br>You are currently not logged in!<br></p>
              <p class="text-center">Please log in to view your appointments.<br><br></p>';
    }
    ?>
</div>
<br><br>

<?php
require "footer.php";
?>
