<?php
require "header.php";
?>

<br><br>
<div class="container">
    <h3 class="text-center"><br>View Equipment/Spaces<br></h3>

    <?php
    if (isset($_SESSION['user_id'])) {
        // Display success/error messages for deletion
        if (isset($_GET['delete'])) {
            if ($_GET['delete'] == "error") {
                echo '<h5 class="bg-danger text-center">Error occurred during deletion!</h5>';
            }
            if ($_GET['delete'] == "success") {
                echo '<h5 class="bg-success text-center">Deletion successful!</h5>';
            }
        }

        // Include the logic to fetch and display equipment/spaces
        require 'includes/view_tables.inc.php';
    } else {
        echo '<p class="text-center"><br>You do not have permission to access this page.<br><br></p>';
    }
    ?>
</div>
<br><br>

<?php
require "footer.php";
?>
