<?php
require "header.php";
?>

<?php if (isset($_GET['error'])): ?>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            let errorMessage = '';
            switch ("<?= $_GET['error'] ?>") {
                case 'emptyfields':
                    errorMessage = 'Please fill in all fields!';
                    break;
                case 'invalidemailusername':
                    errorMessage = 'Invalid email and username!';
                    break;
                case 'invalidemail':
                    errorMessage = 'Invalid email address!';
                    break;
                case 'invalidusername':
                    errorMessage = 'Invalid username!';
                    break;
                case 'invalidpassword':
                    errorMessage = 'Invalid password!';
                    break;
                case 'passworddontmatch':
                    errorMessage = 'Passwords do not match!';
                    break;
                case 'usernameemailtaken':
                    errorMessage = 'Username or email is already taken!';
                    break;
                case 'sqlerror':
                    errorMessage = 'Database error. Please try again later.';
                    break;
                default:
                    errorMessage = 'An unknown error occurred!';
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
            });
        });
    </script>
<?php elseif (isset($_GET['signup']) && $_GET['signup'] == 'success'): ?>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Sign up successful! Redirecting...',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'index.php';
            });
        });
    </script>
<?php endif; ?>

<header class="header">
    <div class="row">
        <div class="col-md-12 text-center">
            <a class="logo"><img src="./img/logoN.png" alt="FitZone Logo"></a>
        </div>
        <div class="col-md-12 text-center">
            <button type="button" onclick="window.location.href='appointments.php'" class="btn btn-outline-light btn-lg"><em>Book an Appointment Now!</em></button>
        </div>
    </div>
</header>

<style>
.header
{
	background-image:linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)),url(./img/fitness1.jpg);
	height:80vh;
	background-position:center;
	background-size:cover;
}

.flex-column { 
       max-width: 260px;
}
           
.container {
    background:rgb(207, 207, 207);
    border-radius: 10px;
    padding: 20px;
}
      
.img {
    margin: 5px;
}

.logo img {
    width: 500px;
    height: 350px;
    margin-top: 90px;
    margin-bottom: 40px;
}

.btn:hover {
    background-color: #333;
    color: #fff;
    border-color: #fff;
}

</style>

<!-- About Us Section -->
<section id="aboutus" style="background-color: #1a1a1a; color: #ffffff; padding: 50px 0; ">
    <div class="container">
        <h3 class="text-center" style="color:rgb(113, 113, 113); font-size: 2.5rem; font-weight: bold; margin: 40px;">Welcome to FitZone Fitness Center</h3>
        <div class="row align-items-center">
            <!-- Carousel -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="img/f1.jpg" alt="State-of-the-art Gym Facilities" style="border-radius: 10px; height: 600px; object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/f2.jpg" alt="Personal Training Sessions" style="border-radius: 10px; height: 600px; object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/f3.jpg" alt="Group Fitness Classes" style="border-radius: 10px; height: 600px; object-fit: cover;">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <!-- End of Carousel -->

            <!-- About Us Content -->
            <div class="col-md-6">
                <div class="content-box" style="padding: 20px; background-color: #333; border-radius: 10px;">
                    <h4 class="text-center" style="color: #ffffff; font-weight: bold; margin-bottom: 20px;">Our Story</h4>
                    <p style="line-height: 1.8; font-size: 1.1rem; color: #d9d9d9;">
                        At FitZone Fitness Center, we’re committed to helping you lead a healthier and more active lifestyle. Located in the heart of Kurunegala, we offer state-of-the-art fitness equipment, personalized training programs, energizing group classes, and expert nutritional counseling.
                    </p>
                    <p style="line-height: 1.8; font-size: 1.1rem; color: #d9d9d9;">
                        Whether you're a beginner starting your fitness journey or an athlete striving for peak performance, FitZone is the perfect place to achieve your goals. Join our community of fitness enthusiasts and transform your life today.
                    </p>
                    <hr style="border: 1px solid #555;">
                    <p class="text-center" style="color: #ffffff; font-style: italic; font-size: 1.2rem;">
                        "Your journey to fitness starts here. Let’s make it extraordinary!"
                    </p>
                </div>
            </div>
            <!-- End of About Us Content -->
        </div>
    </div>
</section>

<!-- Facilities Section -->
<section id="facilities" style="background-color: #1a1a1a; color: #ffffff; padding: 50px 0;">
    <div class="container">
        <h3 class="text-center" style="color:rgb(113, 113, 113); font-size: 2.5rem; font-weight: bold; #ff5733; margin: 40px;">Our Facilities & Services</h3>
        <div class="row">
            <!-- Classes Section -->
            <div class="col-md-4 mb-4">
                <div class="content-box" style="padding: 30px; background-color: #333; border-radius: 10px; color: white; height: 500px;">
                    <h4 class="text-center" style="font-size: 1.8rem; font-weight: bold; margin-bottom: 20px;">Group Classes</h4>
                    <ul style="font-size: 1.1rem; line-height: 1.8;">
                        <li>Cardio</li>
                        <li>Strength Training</li>
                        <li>Yoga</li>
                        <li>Pilates</li>
                        <li>Zumba</li>
                    </ul>
                    <hr style="border: 1px solid #555;">
                    <p class="text-center" style="font-size: 1.1rem;">Energizing group classes for all fitness levels, from beginners to advanced.</p>
                </div>
            </div>

            <!-- Personal Training Section -->
            <div class="col-md-4 mb-4">
                <div class="content-box" style="padding: 30px; background-color: #333; border-radius: 10px; color: white; height: 500px;">
                    <h4 class="text-center" style="font-size: 1.8rem; font-weight: bold; margin-bottom: 20px;">Personal Training</h4>
                    <p style="font-size: 1.1rem; line-height: 1.8;">
                        Our certified trainers specialize in various fitness areas, including:
                    </p>
                    <ul style="font-size: 1.1rem; line-height: 1.8;">
                        <li>Weight Loss</li>
                        <li>Strength Building</li>
                        <li>Muscle Toning</li>
                        <li>Flexibility & Mobility</li>
                        <li>Sports-Specific Training</li>
                    </ul>
                    <hr style="border: 1px solid #555;">
                    <p class="text-center" style="font-size: 1.1rem;">Get one-on-one sessions to achieve your fitness goals faster and safer.</p>
                </div>
            </div>

            <!-- Gym Equipment Section -->
            <div class="col-md-4 mb-4">
                <div class="content-box" style="padding: 30px; background-color: #333; border-radius: 10px; color: white; height: 500px;">
                    <h4 class="text-center" style="font-size: 1.8rem; font-weight: bold; margin-bottom: 20px;">State-of-the-Art Equipment</h4>
                    <p style="font-size: 1.1rem; line-height: 1.8;">
                        We provide advanced gym equipment to enhance your training experience:
                    </p>
                    <ul style="font-size: 1.1rem; line-height: 1.8;">
                        <li>Cardio Machines (Treadmills, Rowers, Bikes)</li>
                        <li>Free Weights & Dumbbells</li>
                        <li>Strength Training Machines</li>
                        <li>Resistance Bands</li>
                        <li>Stretching Areas</li>
                    </ul>
                    <hr style="border: 1px solid #555;">
                    <p class="text-center" style="font-size: 1.1rem;">Our top-tier equipment is designed to give you the best workout possible.</p>
                </div>
            </div>
        </div>

        <!-- View More Button
        <div class="text-center">
            <a href="facilities.php" class="btn" style="background-color:rgb(67, 66, 66); color: white; padding: 15px 30px; font-size: 1.2rem; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">
                View More
            </a>
        </div> -->
    </div>
</section>


<!-- Subscriptions and Packages Section -->
<section id="subscriptions" style="background-color: #1a1a1a; color: #ffffff; padding: 50px 0;">
    <div class="container">
        <h3 class="text-center" style="color: rgb(113, 113, 113); font-size: 2.5rem; font-weight: bold; margin: 40px;">Our Gym Subscriptions & Packages</h3>
        <div class="row justify-content-center">
            
            <!-- Subscription Package 1 -->
            <div class="col-md-4 mb-4">
                <div class="card" style="background-color: #333; border-radius: 10px; padding: 20px; height: 800px;">
                    <img src="img/placeholder1.jpg" alt="Basic Package" class="card-img-top" style="height: 250px; object-fit: cover; border-radius: 10px;">
                    <div class="card-body">
                        <h4 class="card-title" style="font-size: 1.8rem; color: #f0f0f0; text-align: center;">Basic Package</h4>
                        <p class="card-text" style="line-height: 1.8; font-size: 1.1rem; color: #d9d9d9;">
                            Perfect for beginners! Includes full access to the gym floor and basic fitness equipment.
                        </p>
                        <p class="card-text" style="line-height: 1.8; font-size: 1.1rem; color: #d9d9d9;">
                            <b>Price:</b> <span style="color:rgb(250, 130, 130);" >$30/month</span><br>
                            <b>Features:</b><br>
                            - Access to gym equipment<br>
                            - Basic fitness consultation<br>
                            - Group fitness classes<br>
                            - Limited hours (9 AM - 6 PM)
                        </p>
                        <button class="btn btn-outline-light btn-block" style="background-color: #d9d9d9; color: black;" onclick="window.location.href='contactus.php';">Inquire Now</button>
                    </div>
                </div>
            </div>
            
            <!-- Subscription Package 2 -->
            <div class="col-md-4 mb-4">
                <div class="card" style="background-color: #333; border-radius: 10px; padding: 20px; height: 800px;">
                    <img src="img/placeholder2.jpg" alt="Standard Package" class="card-img-top" style="height: 250px; object-fit: cover; border-radius: 10px;">
                    <div class="card-body">
                        <h4 class="card-title" style="font-size: 1.8rem; color: #f0f0f0; text-align: center;">Standard Package</h4>
                        <p class="card-text" style="line-height: 1.8; font-size: 1.1rem; color: #d9d9d9;">
                            Ideal for those looking to level up their fitness. Includes additional classes and personal training.
                        </p>
                        <p class="card-text" style="line-height: 1.8; font-size: 1.1rem; color: #d9d9d9;">
                            <b>Price:</b> <span style="color:rgb(250, 130, 130);" >$50/month</span><br>
                            <b>Features:</b><br>
                            - Full access to gym equipment<br>
                            - Group fitness classes<br>
                            - 5 personal training sessions per month<br>
                            - Priority booking for classes<br>
                            - 24/7 access
                        </p>
                        <button class="btn btn-outline-light btn-block" style="background-color: #d9d9d9; color: black;" onclick="window.location.href='contactus.php';">Inquire Now</button>
                    </div>
                </div>
            </div>
            
            <!-- Subscription Package 3 -->
            <div class="col-md-4 mb-4">
                <div class="card" style="background-color: #333; border-radius: 10px; padding: 20px; height: 800px;">
                    <img src="img/placeholder3.jpg" alt="Premium Package" class="card-img-top" style="height: 250px; object-fit: cover; border-radius: 10px;">
                    <div class="card-body">
                        <h4 class="card-title" style="font-size: 1.8rem; color: #f0f0f0; text-align: center;">Premium Package</h4>
                        <p class="card-text" style="line-height: 1.8; font-size: 1.1rem; color: #d9d9d9;">
                            The ultimate fitness experience. Includes unlimited personal training, nutrition plans, and more.
                        </p>
                        <p class="card-text" style="line-height: 1.8; font-size: 1.1rem; color: #d9d9d9;">
                            <b>Price:</b><span style="color:rgb(250, 130, 130); " > $100/month</span> <br>
                            <b>Features:</b><br>
                            - Unlimited access to gym equipment<br>
                            - Unlimited group fitness classes<br>
                            - Unlimited personal training sessions<br>
                            - Custom nutrition plans<br>
                            - Priority booking for all services
                        </p>
                        <button class="btn btn-outline-light btn-block" style="background-color: #d9d9d9; color: black;" onclick="window.location.href='contactus.php';">Inquire Now</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="text-center">
            <button class="btn btn-outline-light" style="background-color:rgb(99, 99, 99); color: black;" onclick="window.location.href='contactus.php';">For Inquiries</button>
        </div> -->
    </div>
</section>
<!-- End of Subscriptions and Packages Section -->


<!-- Appointments Section -->
<section id="appointments" style="background-color: #1a1a1a; color: #ffffff; padding: 50px 0;">
    <div class="container">
        <h3 class="text-center" style="color: rgb(113, 113, 113); font-size: 2.5rem; font-weight: bold; margin: 40px;">
            Book Your Appointment</h3>
        <div class="row align-items-center">
            <!-- Image and Appointment Button -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="content-box" style="padding: 20px; background-color: #333; border-radius: 10px; text-align: center;">
                    <img src="img/fitness2.jpg" class="img-fluid rounded" style="border-radius: 10px; max-height: 400px; object-fit: cover;">
                    <p style="font-size: 1.1rem; color: #d9d9d9; line-height: 1.8; margin-top: 20px;">
                        At FitZone, we offer personalized training sessions and wellness consultations. Whether you're starting your fitness journey or looking to improve, our expert trainers are here to guide you.
                    </p>
                    <button type="button" onclick="window.location.href='appointments.php'" class="btn btn-outline-dark btn-block btn-lg" style="border-radius: 5px; font-weight: bold; padding: 15px; background-color: #f8f9fa; color: #333; border: 2px solid #333; transition: all 0.3s ease;">
                        Book an Appointment Now!
                    </button>
                </div>
            </div>
            <!-- Contact Information and Additional Content -->
            <div class="col-md-6">
                <div class="content-box" style="padding: 20px; background-color: #333; border-radius: 10px;">
                    <h4 class="text-center" style="color: #ffffff; font-weight: bold; margin-bottom: 20px;">Get in Touch</h4>
                    <p style="font-size: 1.1rem; color: #d9d9d9; line-height: 1.8;">
                        Need assistance? Contact our support team for help with booking or inquiries.
                    </p>
                    <p style="font-size: 1.1rem; color: #d9d9d9; line-height: 1.8;">
                        <strong>Email:</strong> support@fitzone.com<br>
                        <strong>Phone:</strong> +1 800 123 4567<br>
                        <strong>Address:</strong> 123 FitZone Street, Kurunegala
                    </p>
                    <button type="button" onclick="window.location.href='contact-us.php'" class="btn btn-outline-dark btn-block btn-lg" style="border-radius: 5px; font-weight: bold; padding: 15px; margin-top: 20px; background-color: #f8f9fa; color: #333; border: 2px solid #333; transition: all 0.3s ease;">
                        Contact Us
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Opening Hours Section -->
<section id="opening-hours" style="background-color: #1a1a1a; color: #ffffff; padding: 50px 0;">
    <div class="container">
        <h3 class="text-center" style="color: rgb(113, 113, 113); font-size: 2.5rem; font-weight: bold; margin: 40px;">
            Opening Hours & Location</h3>
        <div class="row align-items-center">
            <!-- Google Map -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="content-box" style="padding: 20px; background-color: #333; border-radius: 10px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.1752722894!2d80.62112201819763!3d7.290572548230756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae369410d7d77ff%3A0x1fa0f6e63c15ad93!2sKurunegala%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1690384396892!5m2!1sen!2slk"
                        style="width: 100%; height: 300px; border: 0; border-radius: 10px;" allowfullscreen></iframe>
                </div>
            </div>
            
            <!-- Opening Hours and Check Schedule -->
            <div class="col-md-6">
                <div class="content-box" style="padding: 20px; background-color: #333; border-radius: 10px;">
                    <h4 style="color: #ffffff; font-weight: bold; margin-bottom: 20px;">Opening Hours</h4>
                    <div class="signup-form">
                        <form action="#opening-hours" method="post">
                            <div class="form-group">
                                <label for="date" style="color: #d9d9d9;">Select Date</label>
                                <input type="date" class="form-control" name="date" id="date" placeholder="Date" required="required" style="border-radius: 5px; padding: 10px;">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="check_schedule" class="btn btn-dark btn-block" 
                                    style="font-weight: bold; padding: 15px; background-color: #f8f9fa; color: #333; border-radius: 5px; transition: all 0.3s ease;">
                                    Check Open Time
                                </button>
                            </div>
                        </form>

                        <?php
                        if (isset($_POST['check_schedule'])) {
                            require 'includes/dbh.inc.php';
                            $date = $_POST['date'];
                            $sql = "SELECT * FROM schedule WHERE date = '$date'";
                            $result = $conn->query($sql);
                            if ($result->num_rows == 1) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                                        <table class='table table-sm table-striped table-dark text-center' style='margin-top: 20px;'>
                                           <thead>
                                            <tr>
                                            <th scope='col'>Date</th>
                                            <th scope='col'>Open Time</th>
                                            <th scope='col'>Close Time</th>
                                            </tr>
                                           </thead>
                                           <tbody>
                                            <tr>
                                            <th scope='row'><em>". $date . "</em></th>
                                            <td>".$row['open_time']."</td>
                                            <td>".$row['close_time']."</td>
                                            </tr>
                                           </tbody>
                                        </table>";
                                }
                            } else {
                                echo "
                                        <table class='table table-striped table-dark text-center' style='margin-top: 20px;'>
                                           <thead>
                                            <tr>
                                            <th scope='col'>Date</th>
                                            <th scope='col'>Open Time</th>
                                            <th scope='col'>Close Time</th>
                                            </tr>
                                           </thead>
                                           <tbody>
                                            <tr>
                                            <th scope='row'><em>". $date . "</em></th>
                                            <td>12:00</td>
                                            <td>00:00</td>
                                            </tr>
                                           </tbody>
                                        </table>";
                            }
                            mysqli_close($conn);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Info -->
        <div class="row mt-4">
            <div class="col text-center">
                <h4 style="color:rgb(27, 27, 27); font-weight: bold; margin-bottom: 20px;">Visit Us</h4>
                <p style="font-size: 1.1rem; color:rgb(56, 55, 55); line-height: 1.8;">
                    FitZone Fitness Center<br>
                    <i class="fa fa-map-marker"></i>&nbsp; No. 123, Kurunegala Main Street<br>
                    Kurunegala<br><br>
                </p>
            </div>
        </div>
    </div>
</section>
<!-- End of Opening Hours Section -->

<!-- Hover Effect for Button -->
<script>
    document.querySelector('.btn-dark').addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#333';
        this.style.color = '#fff';
        this.style.borderColor = '#fff';
    });

    document.querySelector('.btn-dark').addEventListener('mouseleave', function() {
        this.style.backgroundColor = '#f8f9fa';
        this.style.color = '#333';
        this.style.borderColor = '#333';
    });
</script>


<?php
require "footer.php";
?>
