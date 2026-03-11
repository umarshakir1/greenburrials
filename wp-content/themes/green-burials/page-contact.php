<?php
/**
 * Template Name: Contact Us
 */

$message_sent = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $to = 'Admin@greenburials.com';
    $subject = 'New Contact Form Submission: ' . sanitize_text_field($_POST['subject']);
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $phone = sanitize_text_field($_POST['phone']);
    $company = sanitize_text_field($_POST['company']);
    $reach_out_as = sanitize_text_field($_POST['reach_out_as']);
    $message_content = sanitize_textarea_field($_POST['message']);

    $body = "New message from Contact Form:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Reaching out as: $reach_out_as\n";
    if (!empty($company)) {
        $body .= "Company: $company\n";
    }
    $body .= "\nMessage:\n$message_content\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>');

    if (wp_mail($to, $subject, $body, $headers)) {
        $message_sent = true;
    } else {
        $error_message = 'There was an error sending your message. Please try again later.';
    }
}

get_header();
?>

<div class="contact-page-wrapper">
    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="container">
            <h1 class="contact-title">Contact us</h1>
            <p class="contact-subtitle">Have questions about a product, want to learn more about partnering with us or need help placing an order? Please complete the form below and we'll get right back to you.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="contact-main-content">
        <div class="container">
            <div class="contact-grid">
                <!-- Left Column: Form -->
                <div class="contact-form-column">
                    <?php if ($message_sent) : ?>
                        <div class="contact-success-message" style="background: #f4f7ed; color: #73884D; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #73884D;">
                            <h3 style="margin-top: 0;">Thank you!</h3>
                            <p>Your message has been sent successfully. We'll get back to you shortly.</p>
                        </div>
                    <?php else : ?>
                        <?php if ($error_message) : ?>
                            <div class="contact-error-message" style="background: #fff5f5; color: #c53030; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #c53030;">
                                <?php echo esc_html($error_message); ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?php echo esc_url(get_permalink()); ?>" method="post" class="contact-form" id="contact-form-main">
                            <div class="form-group">
                                <label>I'm reaching out as...</label>
                                <div class="radio-group">
                                    <label class="radio-label">
                                        <input type="radio" name="reach_out_as" value="funeral_professional" checked id="radio_funeral_professional">
                                        <span>Funeral Professional</span>
                                    </label>
                                    <label class="radio-label">
                                        <input type="radio" name="reach_out_as" value="member_of_public" id="radio_member_of_public">
                                        <span>Member of the Public</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact_name">Name *</label>
                                    <input type="text" id="contact_name" name="name" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact_email">Email *</label>
                                    <input type="email" id="contact_email" name="email" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact_phone">Phone Number *</label>
                                    <input type="tel" id="contact_phone" name="phone" required>
                                </div>
                            </div>

                            <!-- Company field: hidden for Member of the Public, visible for Funeral Professional -->
                            <div class="form-row" id="company-field-row">
                                <div class="form-group">
                                    <label for="contact_company">Company *</label>
                                    <input type="text" id="contact_company" name="company">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact_subject">Subject *</label>
                                    <input type="text" id="contact_subject" name="subject" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="contact_message">Message *</label>
                                    <textarea id="contact_message" name="message" rows="5" required></textarea>
                                </div>
                            </div>

                            <div class="form-footer">
                                <p class="captcha-text">Protected by reCAPTCHA, Privacy Policy &amp; Terms of Service apply.</p>
                                <button type="submit" class="btn-submit">Submit</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>

                <!-- Right Column: Info -->
                <div class="contact-info-column">
                    <div class="contact-info-card">
                        <h3 class="info-title">Green Burials</h3>
                        
                        <div class="info-item">
                            <span class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </span>
                            <p><strong>ILLINOIS, USA</strong><br>14448 Golf Rd. Orland Park, IL 60462</p>
                        </div>

                        <div class="info-item">
                            <span class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </span>
                            <p><a href="tel:+18669460030">1-866-946-0030</a></p>
                        </div>

                        <div class="info-item">
                            <span class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </span>
                            <p><a href="mailto:Admin@greenburials.com">Admin@greenburials.com</a></p>
                        </div>

                        <a href="#" class="btn-appointment">Book an Appointment</a>

                        <!-- Inline Map -->
                        <div class="contact-inline-map">
                            <p class="contact-inline-map-label">Our Location</p>
                            <iframe
                                id="contact-google-map"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2977.0!2d-87.880224!3d41.626779!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e0f0000000001%3A0x0!2s14448+Golf+Rd%2C+Orland+Park%2C+IL+60462%2C+USA!5e0!3m2!1sen!2sus!4v1700000000000!5m2!1sen!2sus"
                                width="100%"
                                height="200"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Green Burials Location - 14448 Golf Rd, Orland Park, IL 60462">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    var companyRow = document.getElementById('company-field-row');
    var companyInput = document.getElementById('contact_company');
    var radios = document.querySelectorAll('input[name="reach_out_as"]');

    function updateCompanyVisibility() {
        var selectedValue = document.querySelector('input[name="reach_out_as"]:checked');
        if (!selectedValue) return;

        if (selectedValue.value === 'member_of_public') {
            // Hide company field smoothly
            companyRow.style.overflow = 'hidden';
            companyRow.style.transition = 'max-height 0.35s ease, opacity 0.35s ease, margin 0.35s ease';
            companyRow.style.maxHeight = '0';
            companyRow.style.opacity = '0';
            companyRow.style.marginBottom = '0';
            companyInput.removeAttribute('required');
            companyInput.value = '';
        } else {
            // Show company field smoothly
            companyRow.style.overflow = 'hidden';
            companyRow.style.transition = 'max-height 0.35s ease, opacity 0.35s ease, margin 0.35s ease';
            companyRow.style.maxHeight = '120px';
            companyRow.style.opacity = '1';
            companyRow.style.marginBottom = '';
            companyInput.setAttribute('required', 'required');
        }
    }

    // Set initial state based on default checked radio (funeral_professional = visible)
    // Use max-height trick for smooth animation
    companyRow.style.overflow = 'hidden';
    companyRow.style.maxHeight = '120px';
    companyRow.style.opacity = '1';

    // Attach change listeners
    radios.forEach(function(radio) {
        radio.addEventListener('change', updateCompanyVisibility);
    });

    // Run on page load to set correct initial state
    updateCompanyVisibility();
})();
</script>

<?php get_footer(); ?>
