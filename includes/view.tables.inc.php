<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    require 'includes/dbh.inc.php';

    $user = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    // Display reserved tables (or gym equipment) per date and time zone
    if ($role === 'admin' || $role === 'staff') {
        // Reserved equipment per date and time slot
        $sql = "SELECT SUM(num_tables) AS reserved_tables, t_date, time_zone 
                FROM appointments 
                GROUP BY t_date, time_zone";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo '
                <div class="container">
                    <div class="row">
                        <div class="col-sm text-center">
                            <p class="text-white bg-dark text-center">Reserved Equipment/Spaces per Date and Time Zone</p><br>
                            <table class="table table-hover table-bordered table-responsive-sm text-center">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time Zone</th>
                                        <th scope="col">Reserved Equipment</th>
                                    </tr>
                                </thead>';
            while ($row = $result->fetch_assoc()) {
                echo "
                                <tbody>
                                    <tr>
                                        <th scope='row'>" . htmlspecialchars($row['t_date']) . "</th>
                                        <td>" . htmlspecialchars($row['time_zone']) . "</td>
                                        <td>" . htmlspecialchars($row['reserved_tables']) . "</td>
                                    </tr>
                                </tbody>";
            }
            echo "</table>";
        } else {
            echo "<p class='text-center'>No reserved equipment/spaces found!<p>";
        }
        echo '</div>';

        // Display total equipment/spaces available per date
        $sql = "SELECT * FROM tables ORDER BY t_date";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo '
                <div class="col-sm text-center">
                    <p class="text-white bg-dark text-center">Total Equipment/Spaces Available per Date</p>
                    <label>Default total equipment/spaces is 20</label><br>
                    <table class="table table-hover table-bordered table-responsive-sm text-center">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Total Equipment/Spaces</th>
                                <th class="table-danger" scope="col"></th>
                            </tr>
                        </thead>';
            while ($row = $result->fetch_assoc()) {
                echo "
                        <tbody>
                            <tr>
                                <form action='includes/delete.php' method='POST'>
                                    <input name='tables_id' type='hidden' value='" . htmlspecialchars($row['tables_id']) . "'>
                                    <th scope='row'>" . htmlspecialchars($row['t_date']) . "</th>
                                    <td>" . htmlspecialchars($row['t_tables']) . "</td>
                                    <td class='table-danger'>
                                        <button type='submit' name='delete-table' class='btn btn-danger btn-sm'>Delete</button>
                                    </td>
                                </form>
                            </tr>
                        </tbody>";
            }
            echo "</table>";
        } else {
            echo "<p class='text-center'>No data available!<p>";
        }
        echo '</div></div></div>';
    }

    $conn->close();
}
?>
