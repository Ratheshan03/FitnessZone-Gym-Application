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
    <link href="css/style.css" rel="stylesheet" type="text/css"> <!-- Style -->
    <link href="css/font-awesome.min.css" rel="stylesheet"> <!-- Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> <!-- Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script> <!-- Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->
    <style>
        .container {
            background: #f9f9f9;
        }
        .logo img {
            width: 150px;
            height: 150px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .navbar-nav.ml-auto {
            margin-left: auto;
        }
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="appointments.php">Book Appointment</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_appointments.php">View Appointments</a></li>
                    <?php if ($_SESSION['role'] == 'staff'): ?>
                        <li class="nav-item"><a class="nav-link" href="manage_classes.php">Manage Classes</a></li>
                        <li class="nav-item"><a class="nav-link" href="manage_schedule.php">Manage Schedule</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="#aboutus">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="#appointments">Appointments</a></li>
                    <li class="nav-item"><a class="nav-link" href="#footer">Find Us</a></li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form class="form-inline" action="includes/logout.inc.php" method="post">
                        <button type="submit" name="logout-submit" class="btn btn-outline-dark">Logout</button>
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
    <div class="modal fade" id="myModal_reg">
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
