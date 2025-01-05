<?php
require "header.php";
require 'includes/view.appointments.inc.php';

?>

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

    .table td {
        border: none;
    }

    .btn-danger {
        background-color: #ff5252;
        border: none;
    }

    .btn-danger:hover {
        background-color: #ff3232;
        transition: 0.3s;
    }

    .alert {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid #ff5252;
        border-radius: 10px;
    }
</style>

<div class="container my-5">
    <h3 class="text-center">View Appointments</h3>

    <?php
    if (isset($_SESSION['user_id'])) {
        echo '<p class="text-center bg-dark p-2">' . htmlspecialchars($_SESSION['username']) . ', here you can view your appointment history</p><br>';

        // Display success/error messages
        if (isset($_GET['delete'])) {
            if ($_GET['delete'] == "error") {
                echo '<p class="alert alert-danger text-center">Error deleting the appointment!</p>';
            } elseif ($_GET['delete'] == "success") {
                echo '<p class="alert alert-success text-center">Appointment successfully deleted.</p>';
            }
        }

        // Fetch and display appointments
        $appointments = fetchAppointments($_SESSION['user_id'], $_SESSION['role']);

        if (!empty($appointments)) {
            echo '
                <table class="table table-hover table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Appointment Date</th>
                            <th scope="col">Trainer</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="table-danger">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($appointments as $appointment) {
                echo "
                        <tr>
                            <form action='' method='POST'>
                                <input name='id' type='hidden' value='" . htmlspecialchars($appointment["appointment_id"]) . "'>
                                <th scope='row'>" . htmlspecialchars($appointment["appointment_id"]) . "</th>
                                <td>" . htmlspecialchars($appointment["customer_name"]) . "</td>
                                <td>" . htmlspecialchars($appointment["appointment_date"]) . "</td>
                                <td>" . htmlspecialchars($appointment["trainer_name"] ?: 'N/A') . "</td>
                                <td>" . htmlspecialchars($appointment["status"]) . "</td>
                                <td><button type='submit' name='delete-submit' class='btn btn-danger btn-sm'>Cancel</button></td>
                            </form>
                        </tr>";
            }
            echo '
                    </tbody>
                </table>';
        } else {
            echo '<p class="alert alert-danger text-center">No appointments found!</p>';
        }
    } else {
        echo '<p class="text-center text-danger"><br>You are currently not logged in!<br></p>
              <p class="text-center">Please log in to view your appointments.<br><br></p>';
    }
    ?>
</div>

<?php
require "footer.php";
?>
