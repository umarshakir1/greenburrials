<?php
/**
 * Green Burials - Complete Site Setup Script
 * Creates all pages, products, blog posts, and configures WooCommerce
 * 
 * USAGE: Visit in browser: http://localhost/green-burials/wp-content/themes/green-burials/complete-site-setup.php
 */

// Load WordPress
require_once(__DIR__ . '/../../../wp-load.php');

// Security check
if (!current_user_can('manage_options')) {
    die('You do not have permission to run this script.');
}

echo '<!DOCTYPE html>
<html>
<head>
    <title>Green Burials - Complete Site Setup</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1200px; margin: 40px auto; padding: 20px; background: #f5f5f5; }
        h1 { color: #73884D; }
        h2 { color: #333; border-bottom: 2px solid #73884D; padding-bottom: 10px; margin-top: 30px; }
        .success { color: #28a745; }
        .info { color: #17a2b8; }
        .warning { color: #ffc107; }
        .section { background: white; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .button { display: inline-block; padding: 10px 20px; background: #73884D; color: white; text-decoration: none; border-radius: 4px; margin: 10px 5px; }
        .button:hover { background: #5A7A1F; }
    </style>
</head>
<body>';

echo '<h1>🚀 Green Burials - Complete Site Setup</h1>';
echo '<p>This script will create all necessary pages, products, blog posts, and configure your WordPress site.</p>';

// ============================================
// STEP 1: CREATE WORDPRESS PAGES
// ============================================
echo '<div class="section">';
echo '<h2>📄 Step 1: Creating WordPress Pages</h2>';

$pages_to_create = array(
    array(
        'title' => 'About',
        'slug' => 'about',
        'content' => '<h1>About Green Burials</h1>
<p>Welcome to Green Burials, your trusted source for eco-friendly burial products. We specialize in biodegradable urns, caskets, coffins, and burial shrouds that honor both your loved ones and the environment.</p>

<h2>Our Mission</h2>
<p>We believe in sustainable end-of-life solutions that minimize environmental impact while providing dignified, beautiful memorials. All our products are certified by the Green Burial Council for use in natural or green burial grounds.</p>

<h2>Why Choose Green Burials?</h2>
<ul>
    <li><strong>100% Biodegradable Materials</strong> - Our products naturally return to the earth</li>
    <li><strong>Certified Eco-Friendly</strong> - Green Burial Council approved</li>
    <li><strong>Beautiful Designs</strong> - Dignity meets sustainability</li>
    <li><strong>Expert Support</strong> - Compassionate customer service 24/7</li>
</ul>

<h2>Green Burial Council Certification</h2>
<p>We are proud to offer products certified by the Green Burial Council, ensuring they meet the highest standards for environmental sustainability and natural decomposition.</p>'
    ),
    array(
        'title' => 'How To',
        'slug' => 'how-to',
        'content' => '<h1>How To Choose Green Burial Products</h1>

<h2>Understanding Green Burials</h2>
<p>Green burials, also known as natural burials, are an environmentally friendly alternative to traditional burial practices. They avoid embalming chemicals and use biodegradable materials that naturally decompose.</p>

<h2>Choosing the Right Urn</h2>
<h3>Water Cremation Urns</h3>
<p>Designed to dissolve in water, perfect for ocean or lake ceremonies. Our water urns float briefly before gently sinking and dissolving within hours.</p>

<h3>Earth Burial Urns</h3>
<p>Made from natural materials like paper, salt, or plant fibers. These urns decompose within months when buried, returning ashes to the earth naturally.</p>

<h2>Casket Selection Guide</h2>
<ul>
    <li><strong>Woven Materials</strong> - Bamboo, seagrass, and willow caskets</li>
    <li><strong>Size Considerations</strong> - Standard, oversized, and infant options</li>
    <li><strong>Burial Site Requirements</strong> - Check with your cemetery for any restrictions</li>
</ul>

<h2>Frequently Asked Questions</h2>
<p><strong>Q: Are green burials legal everywhere?</strong><br>
A: Yes, green burials are legal throughout the United States. However, individual cemeteries may have specific requirements.</p>

<p><strong>Q: How long do biodegradable urns take to decompose?</strong><br>
A: Water urns dissolve within hours. Earth burial urns typically decompose within 3-12 months depending on soil conditions.</p>'
    ),
    array(
        'title' => 'As Seen In',
        'slug' => 'as-seen-in',
        'content' => '<h1>As Seen In</h1>

<h2>Media Coverage & Recognition</h2>
<p>Green Burials has been featured in leading publications and media outlets for our commitment to sustainable end-of-life solutions.</p>

<h2>Press & Media</h2>
<ul>
    <li><strong>Eco Magazine</strong> - "Leading the Way in Sustainable Memorials"</li>
    <li><strong>Natural Living Today</strong> - "Beautiful, Biodegradable Burial Options"</li>
    <li><strong>Green Business Review</strong> - "Setting Standards for Eco-Friendly Endings"</li>
</ul>

<h2>Customer Testimonials</h2>
<blockquote>
"I wanted to thank you for your excellent customer service. I ordered an urn for my mother\'s ashes and it arrived quickly and was exactly as described. The quality is outstanding and the price was very reasonable."
<footer>— William S. Nageli</footer>
</blockquote>

<blockquote>
"Finding an environmentally friendly option was so important to our family. Green Burials provided exactly what we needed with compassion and professionalism."
<footer>— Sarah M., California</footer>
</blockquote>

<h2>Industry Certifications</h2>
<p>✓ Green Burial Council Certified<br>
✓ Eco-Friendly Business Certification<br>
✓ Sustainable Materials Verified</p>'
    ),
    array(
        'title' => 'Military',
        'slug' => 'military',
        'content' => '<h1>Honoring Our Veterans</h1>

<h2>Military Green Burial Options</h2>
<p>Green Burials is proud to serve military families with eco-friendly burial options that honor the service and sacrifice of our veterans.</p>

<h2>Natural Burial for Veterans</h2>
<p>Many veterans and their families are choosing green burial options that reflect values of service, dignity, and respect for the earth. Our biodegradable caskets and urns provide honorable choices that align with environmental stewardship.</p>

<h2>VA Cemetery Compatibility</h2>
<p>Our products meet requirements for burial in VA national cemeteries. We can help you navigate the process and ensure your selections comply with all regulations.</p>

<h2>Military Honors</h2>
<ul>
    <li>Compatible with flag-draped casket ceremonies</li>
    <li>Suitable for military burial honors</li>
    <li>Meets VA cemetery requirements</li>
    <li>Available in appropriate sizes for full military honors</li>
</ul>

<h2>Special Services for Military Families</h2>
<p><strong>Free Ground Shipping</strong> for all military personnel and veterans<br>
<strong>24/7 Support</strong> - We understand the urgency and provide dedicated assistance<br>
<strong>Expedited Processing</strong> - Priority handling for military families</p>

<h2>Contact Our Military Liaison</h2>
<p>For questions about military burial options, please contact our specialized support team at (555) 123-4567.</p>'
    ),
    array(
        'title' => 'Privacy Policy',
        'slug' => 'privacy-policy',
        'content' => '<h1>Privacy Policy</h1>
<p><em>Last updated: ' . date('F Y') . '</em></p>

<h2>Information We Collect</h2>
<p>When you visit Green Burials, we collect information that you provide directly to us, including:</p>
<ul>
    <li>Name and contact information</li>
    <li>Shipping and billing addresses</li>
    <li>Payment information</li>
    <li>Order history and preferences</li>
</ul>

<h2>How We Use Your Information</h2>
<p>We use the information we collect to:</p>
<ul>
    <li>Process and fulfill your orders</li>
    <li>Communicate with you about your orders</li>
    <li>Send you marketing communications (with your consent)</li>
    <li>Improve our products and services</li>
</ul>

<h2>Information Security</h2>
<p>We implement appropriate security measures to protect your personal information from unauthorized access, alteration, or disclosure.</p>

<h2>Your Rights</h2>
<p>You have the right to:</p>
<ul>
    <li>Access your personal information</li>
    <li>Request correction of your data</li>
    <li>Request deletion of your data</li>
    <li>Opt-out of marketing communications</li>
</ul>

<h2>Contact Us</h2>
<p>Questions about this privacy policy? Contact us at Admin@greenburials.com</p>'
    ),
    array(
        'title' => 'Shipping Policy',
        'slug' => 'shipping-policy',
        'content' => '<h1>Shipping Policy</h1>

<h2>Free Ground Shipping</h2>
<p>We offer <strong>free standard ground shipping</strong> on all orders within the continental United States.</p>

<h2>Shipping Methods</h2>

<h3>Standard Ground Shipping (FREE)</h3>
<ul>
    <li>Delivery: 5-7 business days</li>
    <li>Tracking provided</li>
    <li>Fully insured</li>
</ul>

<h3>Next Day Delivery (Flat Rate)</h3>
<ul>
    <li>Flat rate pricing available at checkout</li>
    <li>Order by 2 PM EST for next-day delivery</li>
    <li>Available Monday-Friday</li>
</ul>

<h2>Processing Time</h2>
<p>Orders are typically processed within 1-2 business days. You will receive a tracking number via email once your order ships.</p>

<h2>International Shipping</h2>
<p>We currently ship to the United States and Canada. International customers should contact us for shipping quotes and availability.</p>

<h2>Package Protection</h2>
<p>All shipments are fully insured and carefully packaged to ensure your items arrive safely.</p>

<h2>Questions?</h2>
<p>Contact our customer service team at (555) 123-4567 or Admin@greenburials.com</p>'
    ),
    array(
        'title' => 'Return Policy',
        'slug' => 'return-policy',
        'content' => '<h1>Return Policy</h1>

<h2>Our Commitment</h2>
<p>We want you to be completely satisfied with your purchase. If you\'re not happy with your order, we\'re here to help.</p>

<h2>30-Day Return Window</h2>
<p>You may return most unused items within 30 days of delivery for a full refund or exchange.</p>

<h2>Return Conditions</h2>
<p>Items must be:</p>
<ul>
    <li>Unused and in original condition</li>
    <li>In original packaging</li>
    <li>Accompanied by proof of purchase</li>
</ul>

<h2>How to Return</h2>
<ol>
    <li>Contact our customer service team at Admin@greenburials.com</li>
    <li>Receive your return authorization number</li>
    <li>Pack item securely in original packaging</li>
    <li>Ship to the address provided (return shipping label included for defective items)</li>
</ol>

<h2>Refund Processing</h2>
<p>Refunds are processed within 5-7 business days after we receive your return. The refund will be issued to your original payment method.</p>

<h2>Exchanges</h2>
<p>To exchange an item, please return the original item and place a new order for the replacement.</p>

<h2>Non-Returnable Items</h2>
<p>Custom or personalized items cannot be returned unless defective.</p>

<h2>Questions?</h2>
<p>Contact us at (555) 123-4567 or Admin@greenburials.com</p>'
    ),
    array(
        'title' => 'Terms & Conditions',
        'slug' => 'terms-conditions',
        'content' => '<h1>Terms & Conditions</h1>
<p><em>Last updated: ' . date('F Y') . '</em></p>

<h2>Agreement to Terms</h2>
<p>By accessing and using the Green Burials website, you agree to be bound by these Terms and Conditions.</p>

<h2>Use of Website</h2>
<p>You may use our website for lawful purposes only. You agree not to:</p>
<ul>
    <li>Use the site in any way that violates applicable laws</li>
    <li>Attempt to gain unauthorized access to our systems</li>
    <li>Interfere with or disrupt the website</li>
</ul>

<h2>Product Information</h2>
<p>We strive to provide accurate product descriptions and images. However, we do not warrant that product descriptions, colors, or other content are accurate, complete, or error-free.</p>

<h2>Pricing</h2>
<p>All prices are in USD and subject to change without notice. We reserve the right to correct any pricing errors.</p>

<h2>Orders and Payment</h2>
<p>By placing an order, you agree to provide current, complete, and accurate purchase information. We reserve the right to refuse or cancel any order.</p>

<h2>Intellectual Property</h2>
<p>All content on this website, including text, graphics, logos, and images, is the property of Green Burials and protected by copyright laws.</p>

<h2>Limitation of Liability</h2>
<p>Green Burials shall not be liable for any indirect, incidental, special, or consequential damages arising from your use of our website or products.</p>

<h2>Contact Information</h2>
<p>For questions about these Terms, contact us at Admin@greenburials.com</p>'
    ),
);

$pages_created = 0;
foreach ($pages_to_create as $page_data) {
    $existing_page = get_page_by_path($page_data['slug']);
    
    if ($existing_page) {
        echo '<p class="info">- Page already exists: ' . $page_data['title'] . '</p>';
    } else {
        $page_id = wp_insert_post(array(
            'post_title' => $page_data['title'],
            'post_name' => $page_data['slug'],
            'post_content' => $page_data['content'],
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1,
        ));
        
        if ($page_id && !is_wp_error($page_id)) {
            echo '<p class="success">✓ Created page: ' . $page_data['title'] . ' (' . home_url('/' . $page_data['slug']) . ')</p>';
            $pages_created++;
        } else {
            echo '<p class="warning">⚠ Failed to create: ' . $page_data['title'] . '</p>';
        }
    }
}

echo '<p><strong>Pages Summary:</strong> ' . $pages_created . ' new pages created.</p>';
echo '</div>';

// ============================================
// STEP 2: CREATE PRODUCTS (Run existing script logic)
// ============================================
echo '<div class="section">';
echo '<h2>🛍️ Step 2: Creating WooCommerce Products</h2>';

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    echo '<p class="warning">⚠ WooCommerce is not installed or activated. Please install WooCommerce first.</p>';
} else {
    // Include the product setup logic from setup-dummy-products-v2.php
    include(__DIR__ . '/setup-dummy-products-v2.php');
}

echo '</div>';

// ============================================
// STEP 3: CREATE BLOG POSTS
// ============================================
echo '<div class="section">';
echo '<h2>📝 Step 3: Creating Blog Posts</h2>';

$blog_posts = array(
    array(
        'title' => 'Green Burials Eco-Friendly: A Complete Guide',
        'slug' => 'green-burials-eco-friendly',
        'content' => '<p>Green burials represent a growing movement toward more sustainable and environmentally conscious end-of-life practices. As awareness of our environmental impact increases, more families are choosing eco-friendly burial options that minimize harm to the planet while honoring their loved ones with dignity and respect.</p>

<h2>What Makes a Burial "Green"?</h2>
<p>A green burial, also known as a natural burial, eschews the traditional practices that can harm the environment. This includes avoiding:</p>
<ul>
    <li>Chemical embalming fluids</li>
    <li>Metal or non-biodegradable caskets</li>
    <li>Concrete burial vaults</li>
    <li>Chemically treated burial grounds</li>
</ul>

<h2>Benefits of Biodegradable Urns</h2>
<p>Biodegradable urns offer a beautiful alternative for cremation services. Made from natural materials like salt, paper, sand, or plant fibers, these urns naturally decompose, allowing ashes to return to the earth or water organically.</p>

<h3>Types of Biodegradable Urns:</h3>
<ul>
    <li><strong>Water Urns:</strong> Designed to float briefly before dissolving in water, perfect for ocean or lake ceremonies</li>
    <li><strong>Earth Urns:</strong> Break down in soil within months, ideal for burial in green cemeteries or private property</li>
    <li><strong>Tree Urns:</strong> Contain seeds that grow into living memorials</li>
</ul>

<h2>The Environmental Impact</h2>
<p>Traditional burials can have significant environmental consequences. Embalming fluids contain toxic chemicals like formaldehyde, and metal caskets take centuries to decompose. Green burials eliminate these concerns while creating natural habitats and preserving green spaces.</p>

<h2>Planning a Green Burial</h2>
<p>If you\'re considering a green burial for yourself or a loved one, start by:</p>
<ol>
    <li>Researching green cemeteries in your area</li>
    <li>Discussing your wishes with family members</li>
    <li>Choosing appropriate biodegradable products</li>
    <li>Documenting your preferences</li>
</ol>

<p>At Green Burials, we\'re committed to providing beautiful, dignified, and environmentally responsible options for every family. All our products are certified by the Green Burial Council for use in natural burial grounds.</p>',
        'excerpt' => 'Discover how biodegradable urns and eco-friendly burial practices can honor loved ones while protecting our planet.',
        'image_hint' => 'urn'
    ),
    array(
        'title' => 'Guide to Baby Caskets, Including Woven Options',
        'slug' => 'guide-to-baby-caskets',
        'content' => '<p>Losing a child is one of life\'s most profound sorrows. During this difficult time, families seek gentle, beautiful options to honor their smallest loved ones. This guide explores compassionate choices for infant burials, with a focus on natural and woven casket options.</p>

<h2>Understanding Baby Casket Sizes</h2>
<p>Baby caskets come in several sizes to accommodate different ages:</p>
<ul>
    <li><strong>Newborn:</strong> Up to 24 inches</li>
    <li><strong>Infant:</strong> 24-36 inches</li>
    <li><strong>Child:</strong> 36-48 inches</li>
</ul>

<h2>Woven Casket Options</h2>
<p>Woven caskets offer a gentle, natural aesthetic that many families find comforting. Made from sustainable materials, these caskets are both beautiful and environmentally friendly.</p>

<h3>Popular Woven Materials:</h3>
<ul>
    <li><strong>Bamboo:</strong> Lightweight and sustainable, with a natural honey color</li>
    <li><strong>Seagrass:</strong> Soft texture with a organic, earthy appearance</li>
    <li><strong>Willow:</strong> Traditional weave with a classic basket appearance</li>
    <li><strong>Banana Leaf:</strong> Eco-friendly option with unique texture</li>
</ul>

<h2>Benefits of Natural Burial for Infants</h2>
<p>Many families choose green burial options for their children, finding comfort in the natural cycle of return to the earth. Biodegradable caskets:</p>
<ul>
    <li>Decompose naturally without harmful chemicals</li>
    <li>Create less environmental impact</li>
    <li>Often cost less than traditional metal caskets</li>
    <li>Provide a gentle, natural aesthetic</li>
</ul>

<h2>Personalizing a Baby Casket</h2>
<p>Natural caskets can be lovingly personalized:</p>
<ul>
    <li>Add soft bedding in favorite colors</li>
    <li>Include cherished toys or blankets</li>
    <li>Decorate with natural flowers</li>
    <li>Attach meaningful ribbons or keepsakes</li>
</ul>

<h2>What to Consider When Choosing</h2>
<p>When selecting a baby casket, consider:</p>
<ul>
    <li>Cemetery requirements (some require burial vaults)</li>
    <li>Personal aesthetic preferences</li>
    <li>Budget considerations</li>
    <li>Environmental values</li>
    <li>Cultural or religious traditions</li>
</ul>

<h2>Support and Resources</h2>
<p>We understand the profound difficulty of this time. Our compassionate customer service team is available 24/7 to help you find the perfect memorial for your precious child.</p>

<p>All our infant caskets are crafted with care and certified for green burial grounds. We offer expedited shipping and handle each order with the utmost sensitivity and respect.</p>',
        'excerpt' => 'A compassionate guide to natural and woven casket options for infant burials, including materials, personalization, and considerations.',
        'image_hint' => 'casket'
    ),
    array(
        'title' => 'Honoring Veterans with Natural Burial Caskets',
        'slug' => 'honoring-veterans-natural-burial',
        'content' => '<p>Our nation\'s veterans dedicated their lives to service, often with a deep connection to the land they protected. Natural burial options offer a meaningful way to honor this service while reflecting values of environmental stewardship that many veterans hold dear.</p>

<h2>Why Veterans Choose Green Burial</h2>
<p>Many veterans are drawn to natural burial for several reasons:</p>
<ul>
    <li>Connection to nature and the land</li>
    <li>Environmental responsibility</li>
    <li>Simpler, more authentic approach</li>
    <li>Personal values aligned with conservation</li>
</ul>

<h2>Natural Caskets for Military Burials</h2>
<p>Biodegradable caskets can be used in military ceremonies while maintaining full honors. Our caskets are designed to:</p>
<ul>
    <li>Accommodate flag-draping ceremonies</li>
    <li>Meet VA cemetery requirements</li>
    <li>Support traditional military honors</li>
    <li>Provide dignified appearance for services</li>
</ul>

<h3>Available Options:</h3>
<ul>
    <li><strong>Woven Bamboo:</strong> Strong, dignified appearance with natural finish</li>
    <li><strong>Wooden Caskets:</strong> Traditional look in biodegradable materials</li>
    <li><strong>Covered Caskets:</strong> Natural materials with draped cloth coverings</li>
</ul>

<h2>VA Cemetery Compatibility</h2>
<p>Natural caskets can be used in VA national cemeteries, though specific requirements vary by location. Key considerations include:  </p>
<ul>
    <li>Size specifications must be met</li>
    <li>Caskets must be structurally sound for ceremony</li>
    <li>Some cemeteries may require outer burial containers</li>
    <li>Pre-approval may be needed - we can assist with this process</li>
</ul>

<h2>Military Honors with Green Burial</h2>
<p>Veterans choosing natural burial can still receive full military honors:</p>
<ul>
    <li>Flag presentation</li>
    <li>Rifle salute</li>
    <li>Playing of Taps</li>
    <li>Military chaplain services</li>
</ul>

<p>The natural casket can be draped with the American flag during the ceremony, just as with traditional caskets.</p>

<h2>Special Considerations for Veterans</h2>
<p>When planning a veteran\'s green burial:</p>
<ol>
    <li><strong>Coordinate with the VA:</strong> Contact the VA cemetery office early in the planning process</li>
    <li><strong>Obtain DD Form 214:</strong> This discharge paperwork is needed for military burial benefits</li>
    <li><strong>Arrange for honors:</strong> Request military honors through your funeral director</li>
    <li><strong>Consider location:</strong> Some VA cemeteries have dedicated natural burial sections</li>
</ol>

<h2>Our Commitment to Veterans</h2>
<p>Green Burials is proud to serve military families. We offer:</p>
<ul>
    <li>Free standard shipping for all veterans and active military</li>
    <li>24/7 dedicated support line</li>
    <li>Expedited processing for military families</li>
    <li>Assistance with VA cemetery requirements</li>
    <li>Expert guidance on compatible products</li>
</ul>

<h2>Honoring Service and Earth</h2>
<p>Choosing a natural burial is a way to honor both military service and the land our veterans protected. It reflects values of duty, honor, and stewardship that define military service.</p>

<p>For questions about natural burial options for veterans, please contact our military liaison team at (555) 123-4567. We\'re honored to serve those who served our nation.</p>',
        'excerpt' => 'Learn how natural burial caskets can honor military service while reflecting veterans\' values of environmental stewardship and connection to the land.',
        'image_hint' => 'casket'
    ),
);

$images_dir = __DIR__ . '/assets/figma_exported_images/';
$available_images = glob($images_dir . '*.{jpg,jpeg,png,webp}', GLOB_BRACE);

$posts_created = 0;
foreach ($blog_posts as $post_data) {
    $existing_post = get_page_by_path($post_data['slug'], OBJECT, 'post');
    
    if ($existing_post) {
        echo '<p class="info">- Blog post already exists: ' . $post_data['title'] . '</p>';
    } else {
        $post_id = wp_insert_post(array(
            'post_title' => $post_data['title'],
            'post_name' => $post_data['slug'],
            'post_content' => $post_data['content'],
            'post_excerpt' => $post_data['excerpt'],
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_author' => 1,
            'post_category' => array(1), // Default category
        ));
        
        if ($post_id && !is_wp_error($post_id)) {
            // Try to attach a featured image
            if (!empty($available_images)) {
                $random_image = $available_images[array_rand($available_images)];
                $filename = basename($random_image);
                $upload_file = wp_upload_bits($filename, null, file_get_contents($random_image));
                
                if (!$upload_file['error']) {
                    $wp_filetype = wp_check_filetype($filename, null);
                    $attachment = array(
                        'post_mime_type' => $wp_filetype['type'],
                        'post_title' => sanitize_file_name($filename),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );
                    
                    $attachment_id = wp_insert_attachment($attachment, $upload_file['file'], $post_id);
                    if (!is_wp_error($attachment_id)) {
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
                        wp_update_attachment_metadata($attachment_id, $attachment_data);
                        set_post_thumbnail($post_id, $attachment_id);
                    }
                }
            }
            
            echo '<p class="success">✓ Created blog post: ' . $post_data['title'] . '</p>';
            $posts_created++;
        } else {
            echo '<p class="warning">⚠ Failed to create blog post: ' . $post_data['title'] . '</p>';
        }
    }
}

echo '<p><strong>Blog Posts Summary:</strong> ' . $posts_created . ' new blog posts created.</p>';
echo '</div>';

// ============================================
// STEP 4: CREATE NAVIGATION MENU
// ============================================
echo '<div class="section">';
echo '<h2>🧭 Step 4: Creating Navigation Menu</h2>';

$menu_name = 'Primary Menu';
$menu_exists = wp_get_nav_menu_object($menu_name);

if ($menu_exists) {
    echo '<p class="info">- Menu already exists: ' . $menu_name . '</p>';
    $menu_id = $menu_exists->term_id;
} else {
    $menu_id = wp_create_nav_menu($menu_name);
    echo '<p class="success">✓ Created menu: ' . $menu_name . '</p>';
}

// Add menu items
$menu_items = array(
    array('title' => 'Home', 'url' => home_url('/'), 'order' => 1),
    array('title' => 'About', 'page' => 'about', 'order' => 2),
    array('title' => 'How To', 'page' => 'how-to', 'order' => 3),
    array('title' => 'As Seen In', 'page' => 'as-seen-in', 'order' => 4),
    array('title' => 'Military', 'page' => 'military', 'order' => 5),
    array('title' => 'Blog', 'url' => home_url('/blog'), 'order' => 6),
);

// Add Shop if WooCommerce is active
if (class_exists('WooCommerce')) {
    $menu_items[] = array('title' => 'Shop', 'url' => get_permalink(wc_get_page_id('shop')), 'order' => 7);
}

foreach ($menu_items as $item) {
    if (isset($item['page'])) {
        $page = get_page_by_path($item['page']);
        if ($page) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => $item['title'],
                'menu-item-object-id' => $page->ID,
                'menu-item-object' => 'page',
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
                'menu-item-position' => $item['order'],
            ));
        }
    } else {
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $item['title'],
            'menu-item-url' => $item['url'],
            'menu-item-type' => 'custom',
            'menu-item-status' => 'publish',
            'menu-item-position' => $item['order'],
        ));
    }
}

// Assign menu to location
$locations = get_theme_mod('nav_menu_locations');
$locations['primary'] = $menu_id;
set_theme_mod('nav_menu_locations', $locations);

echo '<p class="success">✓ Menu configured with ' . count($menu_items) . ' items and assigned to Primary location</p>';
echo '</div>';

// ============================================
// STEP 5: CONFIGURE WOOCOMMERCE
// ============================================
if (class_exists('WooCommerce')) {
    echo '<div class="section">';
    echo '<h2>⚙️ Step 5: Configuring WooCommerce</h2>';
    
    // Set currency
    update_option('woocommerce_currency', 'USD');
    
    // Enable tax calculation
    update_option('woocommerce_calc_taxes', 'no');
    
    // Set products per page
    update_option('woocommerce_catalog_columns', 4);
    update_option('woocommerce_catalog_rows', 4);
    
    echo '<p class="success">✓ Set currency to USD</p>';
    echo '<p class="success">✓ Configured product display (4 columns)</p>';
    echo '<p class="success">✓ Basic WooCommerce settings configured</p>';
    
    echo '</div>';
}

// ============================================
// COMPLETION SUMMARY
// ============================================
echo '<div class="section">';
echo '<h2>🎉 Setup Complete!</h2>';
echo '<p><strong>Your Green Burials website is now fully configured!</strong></p>';

echo '<h3>What was created:</h3>';
echo '<ul>';
echo '<li>✅ ' . $pages_created . ' WordPress pages</li>';
echo '<li>✅ WooCommerce products with images</li>';
echo '<li>✅ ' . $posts_created . ' blog posts</li>';
echo '<li>✅ Navigation menu</li>';
if (class_exists('WooCommerce')) {
    echo '<li>✅ WooCommerce configured</li>';
}
echo '</ul>';

echo '<h3>Next Steps:</h3>';
echo '<p>
<a href="' . home_url() . '" class="button">View Homepage</a>
<a href="' . admin_url() . '" class="button">WordPress Admin</a>
<a href="' . admin_url('edit.php?post_type=product') . '" class="button">View Products</a>
</p>';

echo '<p><em>Note: You may need to clear your browser cache and WordPress transients to see all updates.</em></p>';

// Clear transients
if (function_exists('wc_delete_product_transients')) {
    wc_delete_product_transients();
    echo '<p class="success">✓ Cleared WooCommerce transients</p>';
}

echo '</div>';

echo '</body></html>';
