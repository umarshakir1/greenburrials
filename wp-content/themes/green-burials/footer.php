</main>

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <div class="footer-logo">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L4 7v9c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-8-5zm0 2.18l6 3.75v7.07c0 4.45-2.93 8.6-6 9.8-3.07-1.2-6-5.35-6-9.8V7.93l6-3.75z"/>
                    </svg>
                    <span>Green Burials</span>
                </div>
                <h3>Resources</h3>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/green-burial-resources')); ?>">Green Burial Resources</a></li>
                    <li><a href="<?php echo esc_url(home_url('/eco-friendly-options')); ?>">Eco-Friendly Options</a></li>
                    <li><a href="<?php echo esc_url(home_url('/sustainability')); ?>">Sustainability</a></li>
                    <li><a href="<?php echo esc_url(home_url('/faq')); ?>">FAQ</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Shop</h3>
                <ul>
                    <?php if (function_exists('wc_get_page_permalink')): ?>
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">All Products</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo esc_url(home_url('/product-category/water-cremation-urns')); ?>">Water Cremation Urns</a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/earth-burial-urns')); ?>">Earth Burial Urns</a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/biodegradable-caskets')); ?>">Biodegradable Caskets</a></li>
                    <li><a href="<?php echo esc_url(home_url('/product-category/burial-shrouds')); ?>">Burial Shrouds</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Contact</h3>
                <ul>
                    <li>123 Green Way</li>
                    <li>Eco City, EC 12345</li>
                    <li>Phone: (555) 123-4567</li>
                    <li>Email: info@greenburials.com</li>
                </ul>
                <div class="payment-icons">
                    <svg width="40" height="24" viewBox="0 0 40 24" fill="none">
                        <rect width="40" height="24" rx="4" fill="#1434CB"/>
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="white" font-size="10" font-weight="bold">VISA</text>
                    </svg>
                    <svg width="40" height="24" viewBox="0 0 40 24" fill="none">
                        <rect width="40" height="24" rx="4" fill="#EB001B"/>
                        <circle cx="14" cy="12" r="6" fill="#FF5F00"/>
                        <circle cx="26" cy="12" r="6" fill="#F79E1B"/>
                    </svg>
                    <svg width="40" height="24" viewBox="0 0 40 24" fill="none">
                        <rect width="40" height="24" rx="4" fill="#0079C1"/>
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="white" font-size="8" font-weight="bold">AMEX</text>
                    </svg>
                </div>
            </div>
            
            <div class="footer-column">
                <h3>Information</h3>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url(home_url('/shipping-policy')); ?>">Shipping Policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/return-policy')); ?>">Return Policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms-conditions')); ?>">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Green Burials. All rights reserved. | Biodegradable Urns, Caskets, Coffins & Burial Shrouds</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
