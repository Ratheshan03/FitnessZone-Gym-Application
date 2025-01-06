<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" sizes="42x42" href="img/logoN.png">
    <title>FitZone Fitness Center</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/alert.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <style>
        /* General Styles */
        body {
            background: linear-gradient(to right, #2c2c2c, #1a1a1a);
            color: white;
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.1); /* Glassmorphism */
            backdrop-filter: blur(10px);
            padding: 10px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .navbar-brand {
            font-size: 1.8rem;
            color: #ffffff;
            font-weight: bold;
        }
        .navbar-brand:hover {
            color: #ff5252;
            transition: color 0.3s;
        }
        .navbar-nav .nav-link {
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        .navbar-nav .nav-link:hover {
            color: #ff5252;
            text-decoration: none;
            border-radius: 5px;
        }
        .nav-item.active .nav-link {
            color: #ff5252;
            font-weight: bold;
            border-radius: 5px;
        }

        .navbar-toggler-icon {
            background-color: white;
        }

        /* Buttons */
        .btn-outline-dark {
            border: 2px solid #ff5252;
            border-radius: 10px;
            color: #ff5252;
            transition: all 0.3s ease;
        }
        .btn-outline-dark:hover {
            background-color: #ff5252;
            color: white;
        }

        /* Modal Styling */
        .modal-content {
            background-color: rgba(0, 0, 0, 0.9);
            border-radius: 10px;
            color: white;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
        }
        .modal-header h4 {
            font-size: 1.5rem;
            color: #ff5252;
            margin: 0;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid #555;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #ff5252;
            box-shadow: none;
        }
        .btn-dark {
            background-color: #ff5252;
            border: none;
        }
        .btn-dark:hover {
            background-color: #ff3232;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md fixed-top">
        <a class="navbar-brand" href="index.php">FitZone</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navi">
            <ul class="navbar-nav">
                <!-- Always visible links -->
                <li class="nav-item"><a class="nav-link" href="index.php#aboutus">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#facilities">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="blogs.php">Blogs</a></li>
                <li class="nav-item"><a class="nav-link" href="appointments.php">Bookings</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="appointments.php">Book Appointment</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_appointments.php">View Appointments</a></li>
                    <?php if ($_SESSION['role'] == 'staff'): ?>
                        <li class="nav-item"><a class="nav-link" href="schedule.php">Manage Schedule</a></li>
                        <li class="nav-item"><a class="nav-link" href="staff.php">Dashboard</a></li>
                    <?php endif; ?>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="admin.php">Dashboard</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <form action="includes/logout.inc.php" method="post" class="form-inline">
                        <button type="submit" name="logout-submit" class="btn btn-outline-dark ml-2">Logout</button>
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
