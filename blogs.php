<?php
require "header.php";
require "includes/dbh.inc.php"; // Database connection
?>

<br><br>
<div class="container" style="background-color: #1a1a1a; color: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); margin-bottom: 20px;">
    <h3 class="text-center mb-4" style="font-weight: bold; font-size: 2.5rem; color: white;">Our Blogs</h3>
    <p class="text-center" style="color: #ddd; font-size: 1.2rem;">
        Explore our blogs on workout routines, healthy recipes, meal plans, and success stories.
    </p>
    <div class="row">

        <?php
        // Fetch blogs from the database
        $sql = "SELECT * FROM blogs ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($blog = $result->fetch_assoc()) {
                echo '
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card" style="background-color: #333; color: white; border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        <img src="' . htmlspecialchars($blog['image_url']) . '" class="card-img-top" alt="Blog Image" style="border-radius: 10px 10px 0 0; height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #f0f0f0;">' . htmlspecialchars($blog['title']) . '</h5>
                            <p class="card-text" style="color: #d9d9d9; line-height: 1.6;">' . htmlspecialchars(substr($blog['content'], 0, 100)) . '...</p>
                            <a href="blog_details.php?blog_id=' . htmlspecialchars($blog['blog_id']) . '" class="btn btn-light btn-block" style="color: #1a1a1a;">Read More</a>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<p class="text-center" style="color: #d9d9d9;">No blogs available at the moment. Check back later!</p>';
        }

        $conn->close(); // Close the database connection
        ?>
    </div>
</div>
<br><br>

<?php
require "footer.php";
?>
