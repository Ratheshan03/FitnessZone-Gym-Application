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
                text: 'Sign up successful! You can now log in.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'index.php';
            });
        });
    </script>
<?php endif; ?>

<header class="header">
    <div class="row justify-content-center align-items-center text-center h-50">
        <div class="col-md-12">
            <a class="logo">
                <img src="./img/logoN.png" alt="FitZone Logo" class="animated-logo">
            </a>
        </div>
        <div class="col-md-12 mt-4">
            <button type="button" onclick="window.location.href='appointments.php'" class="btn btn-outline-light btn-lg zoom-on-hover">
                <em>Book an Appointment Now!</em>
            </button>
        </div>
    </div>
</header>

<style>
/* Header Section */
.header {
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(./img/fitness1.jpg);
    height: 100vh;
    background-position: center;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
    animation: fadeIn 2s;
}

.logo img {
    width: 450px;
    height: auto;
    animation: bounceIn 1.5s infinite alternate;
}

.btn:hover {
    background-color: #333;
    color: #fff;
    border-color: #fff;
    transform: scale(1.1);
    transition: all 0.3s ease;
}

.zoom-on-hover {
    transition: transform 0.3s;
}

.zoom-on-hover:hover {
    transform: scale(1.15);
}

.animated-logo {
    animation: fadeIn 2s;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes bounceIn {
    from {
        transform: translateY(0);
    }
    to {
        transform: translateY(-10px);
    }
}

/* Content Section Styling */
.container {
    background: rgba(0, 0, 0, 0.85);
    border-radius: 10px;
    padding: 30px;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    animation: fadeInUp 1.5s;
}

@keyframes fadeInUp {
    from {
        transform: translateY(50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

h3 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #ff5252;
    animation: fadeIn 1s;
}

.carousel-inner img {
    border-radius: 10px;
    height: 650px;
    transition: transform 0.5s ease-in-out;
    overflow: hidden;
}

.carousel-inner img:hover {
    transform: scale(1.05);
}

.content-box p {
    font-size: 1.1rem;
    line-height: 1.4;
    align-items: center;
    text-align: justify;
}

/* Buttons */
.btn-outline-light {
    font-weight: bold;
    border-radius: 50px;
    padding: 15px 30px;
    font-size: 1.2rem;
}
/* Facilities Section */
.facility-card {
    background: rgba(0, 0, 0, 0.85);
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    transition: transform 0.3s, background-color 0.3s;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
}

.facility-card:hover {
    transform: translateY(-10px);
    background-color: #222;
}

.facility-card h4 {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: #ff5252;
}

.facility-card ul {
    list-style-type: none;
    padding: 0;
    color: #fff;
    font-size: 1.1rem;
    line-height: 1.8;
}

.facility-card .description {
    margin-top: 20px;
    font-style: italic;
    color: #ccc;
}

/* Subscription Cards */
.subscription-card {
    background: rgba(0, 0, 0, 0.85);
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
}

.subscription-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7);
}

.subscription-card img {
    border-radius: 15px;
    height: 250px;
    object-fit: cover;
    width: 100%;
    margin-bottom: 20px;
}

.subscription-card h4 {
    font-size: 1.8rem;
    color: #ff5252;
    margin-bottom: 15px;
}

.subscription-card .price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #f9a825;
    margin-bottom: 20px;
}

.subscription-card ul {
    list-style-type: none;
    padding: 0;
    font-size: 1.1rem;
    line-height: 1.8;
    color: #ddd;
}

/* Inquire Now Button */
.inquire-now-btn {
    background-color: #ff5252;
    border: none;
    padding: 15px 30px;
    font-size: 1.2rem;
    color: white;
    border-radius: 50px;
    transition: transform 0.3s, background-color 0.3s;
}

.inquire-now-btn:hover {
    transform: scale(1.1);
    background-color: #ff3232;
}

/* Appointment and Contact Cards */
.appointment-card, .contact-card {
    background: rgba(0, 0, 0, 0.85);
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.appointment-card img {
    border-radius: 15px;
    height: 300px;
    object-fit: cover;
}

.appointment-card:hover, .contact-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.8);
}

.btn-cta {
    background-color: #ff5252;
    border: none;
    padding: 15px 30px;
    font-size: 1.2rem;
    color: white;
    border-radius: 50px;
    transition: all 0.3s ease;
}

.btn-cta:hover {
    background-color: #ff3232;
    transform: scale(1.1);
}

/* Google Map */
iframe {
    width: 100%;
    height: 300px;
    border: none;
    border-radius: 15px;
}

/* Schedule Card */
.schedule-card {
    background: rgba(0, 0, 0, 0.85);
    padding: 30px;
    border-radius: 15px;
    color: #d9d9d9;
    text-align: left;
}

.schedule-card h4 {
    color: #ff5252;
    font-weight: bold;
}
</style>

<!-- About Us Section -->
<section id="aboutus" style="background-color: #1a1a1a; color: #ffffff; padding: 50px 0;">
    <div class="container">
        <h3 class="text-center">Welcome to FitZone Fitness Center</h3>
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
                            <img class="d-block w-100" src="img/f1.jpg" alt="State-of-the-art Gym Facilities">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/f2.jpg" alt="Personal Training Sessions">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/f3.jpg" alt="Group Fitness Classes">
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
                <div class="content-box">
                    <h4 class="text-center" style="margin-bottom: 20px;">Our Story</h4>
                    <p>
                        At FitZone Fitness Center, we’re committed to helping you lead a healthier and more active lifestyle. Located in the heart of Kurunegala, we offer state-of-the-art fitness equipment, personalized training programs, energizing group classes, and expert nutritional counseling.
                    </p>
                    <p>
                        Whether you're a beginner starting your fitness journey or an athlete striving for peak performance, FitZone is the perfect place to achieve your goals. Join our community of fitness enthusiasts and transform your life today.
                    </p>
                    <hr>
                    <p class="text-center" style="font-style: italic; color:#ff5252;">
                        "Your journey to fitness starts here. Let’s make it extraordinary!"
                    </p>
                </div>
            </div>
            <!-- End of About Us Content -->
        </div>
    </div>
</section>


<!-- Facilities Section -->
<section id="facilities" class="py-5" style="background-color: #1a1a1a; color: #ffffff;">
    <div class="container">
        <h3 class="text-center text-uppercase" style="color: #ff5252; font-size: 2.5rem; font-weight: bold; margin-bottom: 40px;">Our Facilities & Services</h3>
        <div class="row">
            <!-- Group Classes -->
            <div class="col-md-4 mb-4">
                <div class="facility-card">
                    <h4 class="text-center">Group Classes</h4>
                    <ul>
                        <li>Cardio</li>
                        <li>Strength Training</li>
                        <li>Yoga</li>
                        <li>Pilates</li>
                        <li>Zumba</li>
                    </ul>
                    <p class="description">Energizing group classes for all fitness levels, from beginners to advanced.</p>
                </div>
            </div>
            <!-- Personal Training -->
            <div class="col-md-4 mb-4">
                <div class="facility-card">
                    <h4 class="text-center">Personal Training</h4>
                    <p>Our certified trainers specialize in:</p>
                    <ul>
                        <li>Weight Loss</li>
                        <li>Strength Building</li>
                        <li>Muscle Toning</li>
                        <li>Flexibility & Mobility</li>
                        <li>Sports-Specific Training</li>
                    </ul>
                    <p class="description">Get one-on-one sessions to achieve your fitness goals faster and safer.</p>
                </div>
            </div>
            <!-- Gym Equipment -->
            <div class="col-md-4 mb-4">
                <div class="facility-card">
                    <h4 class="text-center">State-of-the-Art Equipment</h4>
                    <p>We provide advanced gym equipment:</p>
                    <ul>
                        <li>Cardio Machines</li>
                        <li>Free Weights & Dumbbells</li>
                        <li>Strength Training Machines</li>
                        <li>Resistance Bands</li>
                        <li>Stretching Areas</li>
                    </ul>
                    <p class="description">Our equipment ensures the best workout experience possible.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Subscriptions and Packages Section -->
<section id="subscriptions" class="py-5" style="background-color: #1a1a1a; color: #ffffff;">
    <div class="container">
        <h3 class="text-center text-uppercase" style="color: #ff5252; font-size: 2.5rem; font-weight: bold; margin-bottom: 40px;">Our Subscriptions & Packages</h3>
        <div class="row justify-content-center">
            <!-- Basic Package -->
            <div class="col-md-4 mb-4">
                <div class="subscription-card">
                    <img src="img/sub1.jpg" alt="Basic Package">
                    <h4 class="text-center">Basic Package</h4>
                    <p class="price">$30/month</p>
                    <ul>
                        <li>Access to gym equipment</li>
                        <li>Basic fitness consultation</li>
                        <li>Group fitness classes</li>
                        <li>Limited hours (9 AM - 6 PM)</li>
                    </ul>
                </div>
            </div>
            <!-- Standard Package -->
            <div class="col-md-4 mb-4">
                <div class="subscription-card">
                    <img src="img/sub2.jpg" alt="Standard Package">
                    <h4 class="text-center">Standard Package</h4>
                    <p class="price">$50/month</p>
                    <ul>
                        <li>Full access to gym equipment</li>
                        <li>Group fitness classes</li>
                        <li>5 personal training sessions</li>
                        <li>Priority class bookings</li>
                        <li>24/7 access</li>
                    </ul>
                </div>
            </div>
            <!-- Premium Package -->
            <div class="col-md-4 mb-4">
                <div class="subscription-card">
                    <img src="img/sub3.jpg" alt="Premium Package">
                    <h4 class="text-center">Premium Package</h4>
                    <p class="price">$100/month</p>
                    <ul>
                        <li>Unlimited gym access</li>
                        <li>Unlimited group classes</li>
                        <li>Unlimited personal training</li>
                        <li>Custom nutrition plans</li>
                        <li>Priority booking for all services</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-outline-light btn-lg inquire-now-btn" onclick="window.location.href='contact.php';">Inquire Now</button>
        </div>
    </div>
</section>


<!-- Appointments Section -->
<section id="appointments" class="py-5" style="background-color: #1a1a1a; color: #ffffff;">
    <div class="container">
        <h3 class="text-center text-uppercase" style="color: #ff5252; font-size: 2.5rem; font-weight: bold; margin-bottom: 40px;">
            Book Your Appointment
        </h3>
        <div class="row align-items-center">
            <!-- Appointment Image & Button -->
            <div class="col-md-6 mb-4">
                <div class="content-box appointment-card">
                    <img src="img/fitness2.jpg" class="img-fluid rounded shadow" alt="Fitness Image">
                    <p class="mt-4">
                        At FitZone, we offer personalized training sessions and wellness consultations. Whether you're starting your fitness journey or looking to improve, our expert trainers are here to guide you.
                    </p>
                    <button class="btn btn-cta btn-lg" onclick="window.location.href='appointments.php';">
                        Book an Appointment Now!
                    </button>
                </div>
            </div>
            <!-- Contact Info -->
            <div class="col-md-6 mb-4">
                <div class="content-box contact-card">
                    <h4>Get in Touch</h4>
                    <p>
                        Need assistance? Contact our support team for help with booking or inquiries.
                    </p>
                    <p>
                        <strong>Email:</strong> support@fitzone.com<br>
                        <strong>Phone:</strong> +1 800 123 4567<br>
                        <strong>Address:</strong> 123 FitZone Street, Kurunegala
                    </p>
                    <button class="btn btn-cta btn-lg" onclick="window.location.href='contact.php';">
                        Contact Us
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Opening Hours Section -->
<section id="opening-hours" class="py-5" style="background-color: #1a1a1a; color: #ffffff;">
    <div class="container">
        <h3 class="text-center text-uppercase" style="color: #ff5252; font-size: 2.5rem; font-weight: bold; margin-bottom: 40px;">
            Opening Hours & Location
        </h3>
        <div class="row">
            <!-- Google Map -->
            <div class="col-md-6 mb-4">
                <div class="content-box" style="padding: 20px; background-color: #333; border-radius: 10px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.1752722894!2d80.62112201819763!3d7.290572548230756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae369410d7d77ff%3A0x1fa0f6e63c15ad93!2sKurunegala%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1690384396892!5m2!1sen!2slk"
                        style="width: 100%; height: 300px; border: 0; border-radius: 10px;" allowfullscreen></iframe>
                </div>
            </div>
            <!-- Opening Hours -->
            <div class="col-md-6 mb-4">
                <div class="content-box schedule-card">
                    <h4>Opening Hours</h4>
                    <form action="#opening-hours" method="post" class="mt-3">
                        <div class="form-group">
                            <label for="date">Select Date</label>
                            <input type="date" class="form-control" name="date" id="date" required>
                        </div>
                        <button type="submit" name="check_schedule" class="btn btn-cta btn-lg btn-block">
                            Check Open Time
                        </button>
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
                                    <table class='table table-dark mt-4'>
                                       <thead>
                                           <tr>
                                               <th>Date</th>
                                               <th>Open Time</th>
                                               <th>Close Time</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           <tr>
                                               <td>{$date}</td>
                                               <td>{$row['open_time']}</td>
                                               <td>{$row['close_time']}</td>
                                           </tr>
                                       </tbody>
                                    </table>";
                            }
                        } else {
                            echo "
                                <table class='table table-dark mt-4'>
                                   <thead>
                                       <tr>
                                           <th>Date</th>
                                           <th>Open Time</th>
                                           <th>Close Time</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       <tr>
                                           <td>{$date}</td>
                                           <td>12:00</td>
                                           <td>00:00</td>
                                       </tr>
                                   </tbody>
                                </table>";
                        }
                        $conn->close();
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Location Info -->
        <div class="row mt-4">
            <div class="col text-center">
                <h4 style="color:rgb(105, 105, 105); font-weight: bold; margin-bottom: 20px;">Visit Us</h4>
                <p style="font-size: 1.1rem; color:rgb(56, 55, 55); line-height: 1.8;">
                    FitZone Fitness Center<br>
                    <i class="fa fa-map-marker"></i>&nbsp; No. 123, Kurunegala Main Street, <br>
                    Kurunegala, Sri Lanka<br><br>
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
