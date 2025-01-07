<?php
require "header.php";
require "includes/dbh.inc.php"; // Database connection
?>

<br>
<!-- Blogs Section -->
<section class="blogs-section" style="background-color: #1a1a1a; color: white; padding: 50px 0;">
    <div class="container">
        <h3 class="text-center mb-4" style="font-weight: bold; font-size: 2.5rem; color: white;">Our Blogs</h3>
        <p class="text-center" style="color: #ddd; font-size: 1.2rem;">
            Explore our blogs on workout routines, healthy recipes, meal plans, and success stories.
        </p>
        <div class="row mt-4">
            <?php
            // Fetch blogs from the database
            $sql = "SELECT * FROM blogs ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($blog = $result->fetch_assoc()) {
                    echo '
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card blog-card" style="background-color: #333; color: white; border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: transform 0.3s, box-shadow 0.3s;">
                            <img src="' . htmlspecialchars($blog['image_url']) . '" class="card-img-top" alt="Blog Image" style="border-radius: 10px 10px 0 0; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title" style="color: #f0f0f0; font-weight: bold;">' . htmlspecialchars($blog['title']) . '</h5>
                                <p class="card-text" style="color: #d9d9d9; line-height: 1.6;">' . htmlspecialchars(substr($blog['content'], 0, 100)) . '...</p>
                                <a href="blog_details.php?blog_id=' . htmlspecialchars($blog['blog_id']) . '" class="btn btn-light btn-block" style="color: #1a1a1a; font-weight: bold;">Read More</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p class="text-center w-100" style="color: #d9d9d9;">No blogs available at the moment. Check back later!</p>';
            }
            $conn->close(); // Close the database connection
            ?>
        </div>
    </div>
</section>
<style>
    .blogs-section {
        background: linear-gradient(to bottom, #1a1a1a, #111);
        margin-top: 50px;
    }
    .card.blog-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card.blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }
    .btn-light {
        background: #ff5252;
        color: white;
        font-weight: bold;
        transition: all 0.3s;
    }
    .btn-light:hover {
        background: #ff3232;
        color: white;
    }
</style>

<?php
require "footer.php";
?>
