<?php
require "header.php";
?>

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
.flex-column { 
       max-width: 260px;
}
           
.container {
    background: #f9f9f9;
}
      
.img {
    margin: 5px;
}

.logo img {
    width: 400px;
    height: 300px;
    margin-top: 90px;
    margin-bottom: 40px;
}
</style>

<!-- About Us Section -->
<section id="aboutus">
    <div class="container">
        <h3 class="text-center"><br><br>FitZone Fitness Center</h3>
        <div class="row">
            <!-- Carousel -->
            <div class="col-sm"><br><br>
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="img/f1.jpg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/f2.jpg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/f3.jpg" alt="Third slide">
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
                </div><br><br>
            </div>
            <!-- End of Carousel -->

            <div class="col-sm">
                <div class="arranging"><br><hr>
                    <h4 class="text-center">Our Story</h4>
                    <p><br>
                        FitZone Fitness Center, situated in Kurunegala, is a premier destination for fitness enthusiasts. We offer a wide range of services including state-of-the-art equipment, personalized training sessions, group classes, and nutrition counseling. Join us to achieve your fitness goals in a supportive environment.
                    <br></p><hr>
                </div>
            </div>
        </div><br>
    </div>
</section>
<!-- End of About Us Section -->

<!-- Appointments Section -->
<div class="container" id="appointments">
    <h3 class="text-center"><br><br>Appointments<br><br></h3>
    <img src="img/fitness2.jpg" class="img-fluid rounded">
    <button type="button" onclick="window.location.href='appointments.php'" class="btn btn-outline-dark btn-block btn-lg">Book an Appointment Now!</button>
</div><br><br>

<!-- Opening Hours Section -->
<section class="map" id="footer">
    <div class="container">
        <h3 class="text-center"><br><br>Find Us!</h3><br>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.1752722894!2d80.62112201819763!3d7.290572548230756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae369410d7d77ff%3A0x1fa0f6e63c15ad93!2sKurunegala%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1690384396892!5m2!1sen!2slk"
            style="width:100%; height:250px; border:0;"
            allowfullscreen
        ></iframe>
        <div class="row staff">
            <div class="col">
                <h4><strong>Opening Hours</strong></h4>
                <div class="signup-form">
                    <form action="#footer" method="post">
                        <div class="form-group">
                            <label>Enter Date</label>
                            <input type="date" class="form-control" name="date" placeholder="Date" required="required">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="check_schedule" class="btn btn-dark btn-block">Check Open Time</button>
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
                <table class='table table-sm table-striped table-dark text-center'>
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
                <table class='table table-striped table-dark text-center'>
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
                </div><br>
            </div>

            <div class="col">
                <h4 class="text-right"><strong>Visit Us</strong></h4>
                <p class="text-right">FitZone Fitness Center<br><i class="fa fa-map-marker"></i>&nbsp; No. 123, Kurunegala Main Street <br>Kurunegala <br><br>email: fitzone@gmail.com<br>phone: 076-123-4567</p>
            </div>
        </div>
    </div>
</section>
<!-- End of Opening Hours Section -->

<?php
require "footer.php";
?>
