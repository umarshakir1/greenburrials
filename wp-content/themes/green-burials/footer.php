</main>

<footer class="site-footer-modern">
    <div class="footer-top">
        <div class="container">
            <div class="footer-grid">
                <!-- Column 1: Logo & Info (40% width) -->
                <div class="footer-col-logo">
                    <div class="footer-logo-card">
                        <div class="footer-logo-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/logo.png" alt="Green Burials">
                        </div>
            
                    </div>
                    <p class="footer-info-text">
                        GREENBURIALS.Com Is An Informational Research Resource Website And Seller Of Green And Natural Burial Cremation Urn. We Offer Smart, Compassionate, "Green" Eco-Friendly Urns, Caskets, Scattering Tubes, And Shrouds
                    </p>
                </div>

                <!-- Column 2: Resources (30% width) -->
                <div class="footer-col-resources">
                    <h3 class="footer-heading resources-center">Resources</h3>
                    <div class="resources-two-cols">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-links-1',
                            'menu_class'     => 'footer-links',
                            'container'      => false,
                            'fallback_cb'    => false,
                        ));
                        wp_nav_menu(array(
                            'theme_location' => 'footer-links-2',
                            'menu_class'     => 'footer-links',
                            'container'      => false,
                            'fallback_cb'    => false,
                        ));
                        ?>
                    </div>
                </div>

                <!-- Column 3: Contact (20% width) -->
                <div class="footer-col-contact">
                    <h3 class="footer-heading">Contact Us</h3>
                    <div class="contact-info">
                        <p class="contact-location"><strong>ILLINOIS, USA</strong><br><span class="address-text">14448 Golf Rd. Orland Park, IL 60462</span></p>
                        <p class="contact-item"><span class="contact-bullet">⦿</span> <a href="mailto:Admin@greenburials.com">Admin@greenburials.com</a></p>
                        <p class="contact-item"><span class="contact-bullet">⦿</span> <a href="<?php echo esc_url(home_url('/contact')); ?>">Contact Form</a></p>
                        <p class="contact-item"><span class="contact-bullet">⦿</span> <a href="tel:+18669460030">1.866.946.0030</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-middle">
        <div class="container">
            <div class="footer-middle-flex">
                <div class="sitemap-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/site-map.png" alt="Green Burials Site Map">
                </div>
                <div class="payment-info">
                    <div class="payment-methods-text">
                        <p>~ Online secure gateways:</p>
                        <p><strong>AUTHORIZE.NET</strong> and <strong>PAYPAL</strong></p>
                        <p>~ Offline transaction via <strong>PHONE</strong></p>
                    </div>
                    <p class="payment-desc">
                        Green Burials understands its clients' need for simple, fast, and secure online paying experiences and has, therefore, teamed up with two of the most respected and secure gateways available: Authorize.Net and PayPal. Both gateways allow MasterCard, Visa, Diners Club, and American Express credit cards. PayPal, in addition, allows you to use your PayPal address for payments as well.
                    </p>
                    <div class="payment-logos">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/payment-method.png" alt="Payment Methods" class="payment-methods-img">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container footer-bottom-flex">
            <div class="copyright">
                &copy; GreenBurials.com Is A Division Of House Of Urns, LLC. Copyright <?php echo date('Y'); ?>.
            </div>
            <div class="social-icons-footer">
    <a href="#" aria-label="Facebook">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
        </svg>
    </a>

    <a href="#" aria-label="Instagram">
        <svg viewBox="0 0 24 24" width="16" height="16" class="icon-instagram">
            <rect x="2" y="2" width="20" height="20" rx="5"
                  stroke="currentColor" stroke-width="2" fill="none"/>
            <circle cx="12" cy="12" r="4"
                    stroke="currentColor" stroke-width="2" fill="none"/>
            <circle cx="17.5" cy="6.5" r="1.2"
                    fill="currentColor"/>
        </svg>
    </a>

    <a href="#" aria-label="Twitter">
     <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
    <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"></path>
</svg>
    </a>

    <a href="#" aria-label="YouTube">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path>
            <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02" fill="#fff"></polygon>
        </svg>
    </a>

    <a href="#" aria-label="Pinterest">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.399.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.951-7.252 4.173 0 7.41 2.967 7.41 6.923 0 4.133-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.367 18.62 0 12.017 0z"></path>
        </svg>
    </a>
</div>

        </div>
    </div>
</footer>

<!-- Cart Success Modal -->
<div id="gb-cart-modal" class="gb-modal">
    <div class="gb-modal-content">
        <div class="gb-modal-header">
            <h2 class="gb-modal-title">Added to cart successfully. What is next?</h2>
            <button class="gb-modal-close">&times;</button>
        </div>
        <div class="gb-modal-body">
            <div class="gb-modal-product-info">
                <div class="gb-modal-product-image">
                    <!-- Dynamic Product Image -->
                </div>
                <div class="gb-modal-product-details">
                    <h3 class="gb-modal-product-name"></h3>
                    <p class="gb-modal-product-price-qty"></p>
                </div>
            </div>
            <div class="gb-modal-cart-summary">
                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn-modal-checkout">Checkout</a>
                <div class="gb-modal-subtotal-block">
                    <span class="subtotal-label">Order subtotal</span>
                    <span class="subtotal-value"></span>
                    <span class="cart-count-text"></span>
                </div>
                <button class="btn-modal-continue">Continue shopping</button>
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn-modal-view-cart">View Cart</a>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
