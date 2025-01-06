<?php
require "header.php";
?>

<br><br>
<!-- Contact Section -->
<section class="contact-section" style="background-color: #1a1a1a; color: white; padding: 50px 0;">
    <div class="container">
        <h3 class="text-center" style="font-weight: bold; font-size: 2.5rem; color: #ffffff;">Contact Us</h3>
        <p class="text-center mb-5" style="font-size: 1.2rem; color: #d9d9d9;">
            We’re here to assist you! Explore FAQs or send us your inquiries below.
        </p>

        <div class="row">
            <!-- Contact Information -->
            <div class="col-md-6 mb-4">
                <div class="content-box" style="background-color: #333; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                    <h4 style="color: #ffffff; font-weight: bold;">Contact Information</h4>
                    <p><i class="fa fa-phone"></i> <strong>Phone:</strong> +94 76 123 4567</p>
                    <p><i class="fa fa-envelope"></i> <strong>Email:</strong> support@fitzone.com</p>
                    <p><i class="fa fa-map-marker"></i> <strong>Address:</strong> 123 Main Street, Kurunegala, Sri Lanka</p>
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.1752722894!2d80.62112201819763!3d7.290572548230756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae369410d7d77ff%3A0x1fa0f6e63c15ad93!2sKurunegala%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1690384396892!5m2!1sen!2slk"
                        style="width: 100%; height: 250px; border: none; border-radius: 10px; margin-top: 20px;" allowfullscreen>
                    </iframe>
                </div>
            </div>

            <!-- Inquiry Form -->
            <div class="col-md-6 mb-4">
                <div class="content-box" style="background-color: #333; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.3);">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <h4 style="color: #ffffff; font-weight: bold;">Send Us an Inquiry</h4>
                        <form action="includes/contact.inc.php" method="post">
                            <div class="form-group">
                                <label for="subject" style="color: #d9d9d9;">Subject</label>
                                <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter the subject" required>
                            </div>
                            <div class="form-group">
                                <label for="message" style="color: #d9d9d9;">Message</label>
                                <textarea id="message" name="message" class="form-control" rows="5" placeholder="Type your message here..." required></textarea>
                            </div>
                            <button type="submit" name="send-inquiry" class="btn btn-light btn-block" style="color: #1a1a1a; font-weight: bold;">Submit Inquiry</button>
                        </form>
                    <?php else: ?>
                        <h4 style="color: #ffffff; font-weight: bold;">Log in to Send an Inquiry</h4>
                        <p style="color: #d9d9d9;">Please <a href="#" data-toggle="modal" data-target="#myModal_login" style="color: #ff5252;">log in</a> to send us a message.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr style="border-color: #555; margin: 40px 0;">

        <!-- FAQ Section -->
        <h4 class="text-center" style="color: #ffffff; font-weight: bold; margin-bottom: 20px;">Frequently Asked Questions (FAQ)</h4>
        <div id="faq" class="accordion">
            <div class="card" style="background-color: #333; border: none; margin-bottom: 10px; border-radius: 10px;">
                <div class="card-header" id="faq1">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-white" style="text-decoration: none;" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            What are your operating hours?
                        </button>
                    </h5>
                </div>
                <div id="collapse1" class="collapse show" aria-labelledby="faq1" data-parent="#faq">
                    <div class="card-body" style="background-color: #444; color: #d9d9d9; border-radius: 10px;">
                        Our fitness center operates from 5:00 AM to 11:00 PM daily.
                    </div>
                </div>
            </div>
            <div class="card" style="background-color: #333; border: none; margin-bottom: 10px; border-radius: 10px;">
                <div class="card-header" id="faq2">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-white" style="text-decoration: none;" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            Do you offer personal training services?
                        </button>
                    </h5>
                </div>
                <div id="collapse2" class="collapse" aria-labelledby="faq2" data-parent="#faq">
                    <div class="card-body" style="background-color: #444; color: #d9d9d9; border-radius: 10px;">
                        Yes, we offer personalized training sessions tailored to individual goals.
                    </div>
                </div>
            </div>
            <div class="card" style="background-color: #333; border: none; margin-bottom: 10px; border-radius: 10px;">
                <div class="card-header" id="faq3">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-white" style="text-decoration: none;" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            How can I book a membership?
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse" aria-labelledby="faq3" data-parent="#faq">
                    <div class="card-body" style="background-color: #444; color: #d9d9d9; border-radius: 10px;">
                        Visit the subscriptions page or contact us directly for assistance.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Styles -->
<style>
    .accordion .card-header button {
        color: #ff5252;
        font-weight: bold;
        text-decoration: none;
        width: 100%;
        text-align: left;
    }

    .accordion .card-header button:hover {
        color: #ffffff;
    }

    .accordion .card-body {
        padding: 15px;
    }

    .btn-light {
        background: #ff5252;
        color: white;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background: #ff3232;
        color: white;
    }
</style>

<?php
require "footer.php";
?>
