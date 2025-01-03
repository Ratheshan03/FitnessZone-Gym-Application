<?php
require "header.php";
?>

<br><br>
<div class="container" style="background-color: #1a1a1a; color: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
    <h3 class="text-center" style="font-weight: bold; font-size: 2.5rem;">Contact Us</h3>
    <p class="text-center" style="font-size: 1.2rem;">We’re here to assist you! Explore FAQs or send us your inquiries below.</p>
    <hr style="border-color: #555;">

    <!-- Contact Information -->
    <div class="row">
        <div class="col-md-6">
            <h4>Contact Information</h4>
            <p><i class="fa fa-phone"></i> Phone: +94 76 123 4567</p>
            <p><i class="fa fa-envelope"></i> Email: support@fitzone.com</p>
            <p><i class="fa fa-map-marker"></i> Address: 123 Main Street, Kurunegala, Sri Lanka</p>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.1752722894!2d80.62112201819763!3d7.290572548230756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae369410d7d77ff%3A0x1fa0f6e63c15ad93!2sKurunegala%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1690384396892!5m2!1sen!2slk"
                style="width: 100%; height: 250px; border-radius: 10px; margin-top: 20px; border: 1px solid #555;" allowfullscreen></iframe>
        </div>

        <!-- Inquiry Form -->
        <div class="col-md-6">
            <?php if (isset($_SESSION['user_id'])): ?>
                <h4>Send Us an Inquiry</h4>
                <form action="includes/contact.inc.php" method="post">
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter the subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" class="form-control" rows="5" placeholder="Type your message here..." required></textarea>
                    </div>
                    <button type="submit" name="send-inquiry" class="btn btn-light btn-block" style="color: #1a1a1a;">Submit Inquiry</button>
                </form>
            <?php else: ?>
                <h4>Log in to Send an Inquiry</h4>
                <p>Please <a href="#" data-toggle="modal" data-target="#myModal_login" style="color: #f8f9fa;">log in</a> to send us a message.</p>
            <?php endif; ?>
        </div>
    </div>

    <hr style="border-color: #555; margin-top: 40px;">

    <!-- FAQ Section -->
    <h4>Frequently Asked Questions (FAQ)</h4>
    <div id="faq" class="accordion">
        <div class="card" style="background: #333; border: none; margin-bottom: 10px;">
            <div class="card-header" id="faq1">
                <h5 class="mb-0">
                    <button class="btn btn-link text-white" style="text-decoration: none;" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        What are your operating hours?
                    </button>
                </h5>
            </div>
            <div id="collapse1" class="collapse show" aria-labelledby="faq1" data-parent="#faq">
                <div class="card-body" style="background: #444;">
                    Our fitness center operates from 5:00 AM to 11:00 PM daily.
                </div>
            </div>
        </div>
        <div class="card" style="background: #333; border: none; margin-bottom: 10px;">
            <div class="card-header" id="faq2">
                <h5 class="mb-0">
                    <button class="btn btn-link text-white" style="text-decoration: none;" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        Do you offer personal training services?
                    </button>
                </h5>
            </div>
            <div id="collapse2" class="collapse" aria-labelledby="faq2" data-parent="#faq">
                <div class="card-body" style="background: #444;">
                    Yes, we offer personalized training sessions tailored to individual goals.
                </div>
            </div>
        </div>
        <div class="card" style="background: #333; border: none; margin-bottom: 10px;">
            <div class="card-header" id="faq3">
                <h5 class="mb-0">
                    <button class="btn btn-link text-white" style="text-decoration: none;" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                        How can I book a membership?
                    </button>
                </h5>
            </div>
            <div id="collapse3" class="collapse" aria-labelledby="faq3" data-parent="#faq">
                <div class="card-body" style="background: #444;">
                    Visit the subscriptions page or contact us directly for assistance.
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>

<?php
require "footer.php";
?>
