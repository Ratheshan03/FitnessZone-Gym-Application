<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png"> <!-- Favicon -->
    <title>FitZone Fitness Center</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/alert.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <style>
        /* Global styles for the header */
        body {
            background: linear-gradient(to right, #6a5b5b, #a55d5d); /* Gradient background */
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.2); /* Glassmorphism background */
            backdrop-filter: blur(10px); /* Glassmorphism effect */
            padding: 10px 20px;
        }
        .navbar-brand strong em {
            font-size: 1.5rem;
            color: #ffffff;
        }
        .navbar-nav .nav-link {
            color: white !important;
            padding: 10px 15px;
        }
        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
            text-decoration: underline;
        }
        .navbar-nav .nav-item.active .nav-link {
            color: #f8f9fa;
            font-weight: bold;
        }
        .navbar-toggler-icon {
            background-color: white;
        }
        .nav-item:last-child {
            margin-right: 0;
        }
        /* Modal styling */
        .modal-body h5 {
            text-align: center;
        }
        .bg-danger, .bg-success {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top">
        <a class="navbar-brand" href="index.php">
            <strong><em>FitZone</em></strong>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navi">
            <ul class="navbar-nav">
                <!-- Always show navigation options -->
                <li class="nav-item"><a class="nav-link" href="index.php#aboutus">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#facilities">Facilities</a></li>
                <li class="nav-item"><a class="nav-link" href="blogs.php">Blogs</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#subscriptions">Subscriptions</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li> <!-- New Contact Us link -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="appointments.php">Book Appointment</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_appointments.php">View Appointments</a></li>
                    <?php if ($_SESSION['role'] == 'staff'): ?>
                        <li class="nav-item"><a class="nav-link" href="manage_classes.php">Manage Classes</a></li>
                        <li class="nav-item"><a class="nav-link" href="manage_schedule.php">Manage Schedule</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form class="form-inline" action="includes/logout.inc.php" method="post">
                        <button type="submit" name="logout-submit" class="btn btn-outline-light">Logout</button>
                    </form>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#myModal_reg">Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="modal" data-target="#myModal_login">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Login Modal -->
    <div class="modal fade" id="myModal_login">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Login</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_GET['error1'])): ?>
                        <h5 class="bg-danger text-center">
                            <?php 
                            switch ($_GET['error1']) {
                                case "emptyfields":
                                    echo "Fill all fields, Please try again!";
                                    break;
                                case "wrongpwd":
                                    echo "Wrong Password, Please try again!";
                                    break;
                                case "nouser":
                                    echo "Username or email not found, Please try again!";
                                    break;
                                default:
                                    echo "Unknown error, Please try again!";
                            }
                            ?>
                        </h5>
                    <?php endif; ?>
                    <form action="includes/login.inc.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="mailuid" placeholder="Username Or Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="pwd" placeholder="Password" required>
                        </div>
                        <button type="submit" name="login-submit" class="btn btn-dark btn-lg btn-block">Log In</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="myModal_reg" style="color: black;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Register</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php if (isset($_GET['error'])): ?>
                        <h5 class="bg-danger text-center">
                            <?php 
                            switch ($_GET['error']) {
                                case "emptyfields":
                                    echo "Fill all fields, Please try again!";
                                    break;
                                case "invalidemailusername":
                                    echo "Username or Email are invalid!";
                                    break;
                                case "usernameemailtaken":
                                    echo "Username or email is already taken!";
                                    break;
                                case "passworddontmatch":
                                    echo "Passwords do not match!";
                                    break;
                                default:
                                    echo "Unknown error, Please try again!";
                            }
                            ?>
                        </h5>
                    <?php elseif (isset($_GET['signup']) && $_GET['signup'] == "success"): ?>
                        <h5 class="bg-success text-center">Sign up was successful! Please Log in!</h5>
                    <?php endif; ?>
                    <form action="includes/signup.inc.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="uid" placeholder="Username" required>
                            <small class="form-text text-muted">Username must be 4-20 characters long</small>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="mail" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="pwd" placeholder="Password" required>
                            <small class="form-text text-muted">Password must be 6-20 characters long</small>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="pwd-repeat" placeholder="Confirm Password" required>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" required> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a>
                            </label>
                        </div>
                        <button type="submit" name="signup-submit" class="btn btn-dark btn-lg btn-block">Register Now</button>
                    </form>
                    <div class="text-center">Already have an account? <a href="#" data-toggle="modal" data-target="#myModal_login">Sign in</a></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
