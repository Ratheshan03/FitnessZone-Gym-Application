<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'includes/dbh.inc.php';

if (isset($_SESSION['user_id'])) {
    $user = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    // Handle delete request
    if (isset($_POST['delete-submit'])) {
        $appointment_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if ($appointment_id > 0) {
            $sql = "DELETE FROM appointments WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $appointment_id);
            if ($stmt->execute()) {
                echo "<p class='text-white text-center bg-success'>Appointment deleted successfully!<p>";
            } else {
                echo "<p class='text-white text-center bg-danger'>Error deleting appointment!<p>";
            }
        } else {
            echo "<p class='text-white text-center bg-danger'>Invalid appointment ID!<p>";
        }
    }

    // Fetch appointments
    if ($role == 'admin' || $role == 'staff') {
        $sql = "SELECT * FROM appointments";
    } else {
        $sql = "SELECT * FROM appointments WHERE user_id = $user";
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo '
            <table class="table table-hover table-responsive-sm text-center">
                <thead>
                    <tr>';
        if ($role == 'admin' || $role == 'staff') {
            echo '<th scope="col">ID</th>';
        }
        echo '
                        <th scope="col">Customer Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col">Status</th>
                        <th class="table-danger" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>';
        while ($row = $result->fetch_assoc()) {
            echo "
                    <tr>
                    <form action='' method='POST'>
                    <input name='id' type='hidden' value='" . $row["id"] . "'>";
            if ($role == 'admin' || $role == 'staff') {
                echo "<th scope='row'>" . $row["id"] . "</th>";
            }
            echo "
                      <td>" . htmlspecialchars($row["customer_name"]) . "</td>
                      <td>" . htmlspecialchars($row["appointment_date"]) . "</td>
                      <td>" . htmlspecialchars($row["appointment_time"]) . "</td>
                      <td>" . htmlspecialchars($row["status"]) . "</td>
                      <td class='table-danger'><button type='submit' name='delete-submit' class='btn btn-danger btn-sm'>Cancel</button></td>
                    </form>
                    </tr>";
        }
        echo "
              </tbody>
            </table>";
    } else {
        echo "<p class='text-white text-center bg-danger'>No appointments found!<p>";
    }
    $conn->close();
}
?>
