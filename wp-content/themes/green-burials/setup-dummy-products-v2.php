<?php
/**
 * Green Burials - Enhanced Dummy Product Setup Script v2
 * Intelligently assigns exported Figma images to products
 * Includes image compression and optimization
 * 
 * USAGE: Visit in browser: http://localhost/custom-theme-template/wp-content/themes/green-burials/setup-dummy-products-v2.php
 */

// Load WordPress
require_once(__DIR__ . '/../../../wp-load.php');

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    die('WooCommerce must be installed and activated!');
}

// Security check
if (!current_user_can('manage_options')) {
    die('You do not have permission to run this script.');
}

echo '<h1>Green Burials - Enhanced Product Setup v2</h1>';
echo '<p>Setting up products with real Figma images...</p>';

// Get all exported images
$images_dir = __DIR__ . '/assets/figma_exported_images/';
$available_images = glob($images_dir . '*.{jpg,jpeg,png,webp}', GLOB_BRACE);

echo '<h2>Found ' . count($available_images) . ' images in figma_exported_images folder</h2>';

// Create Product Categories
$categories = array(
    'water-cremation-urns' => 'Water Cremation Urns',
    'earth-burial-urns' => 'Earth Burial Urns',
    'caskets' => 'Caskets',
    'biodegradable-caskets' => 'Biodegradable Caskets',
    'burial-shrouds' => 'Burial Shrouds',
    'memorial-products' => 'Memorial Products',
    'memorial-petals' => 'Memorial Petals',
    'water-burials' => 'Water Burials',
);

echo '<h2>Creating Categories...</h2>';
foreach ($categories as $slug => $name) {
    $term = term_exists($name, 'product_cat');
    if (!$term) {
        $term = wp_insert_term($name, 'product_cat', array('slug' => $slug));
        echo '<p>✓ Created category: ' . $name . '</p>';
    } else {
        echo '<p>- Category already exists: ' . $name . '</p>';
    }
}

// Helper function to upload and attach image
function gb_attach_product_image($product_id, $image_path) {
    if (!file_exists($image_path)) {
        return false;
    }
    
    // Compress image if GD is available
    if (function_exists('green_burials_compress_image')) {
        $image_path = green_burials_compress_image($image_path, 75, 600);
    }
    
    $filename = basename($image_path);
    $upload_file = wp_upload_bits($filename, null, file_get_contents($image_path));
    
    if (!$upload_file['error']) {
        $wp_filetype = wp_check_filetype($filename, null);
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );
        
        $attachment_id = wp_insert_attachment($attachment, $upload_file['file'], $product_id);
        
        if (!is_wp_error($attachment_id)) {
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file['file']);
            wp_update_attachment_metadata($attachment_id, $attachment_data);
            set_post_thumbnail($product_id, $attachment_id);
            return true;
        }
    }
    
    return false;
}

// Helper to find matching image for product
function gb_find_product_image($product_name, $available_images) {
    $name_lower = strtolower($product_name);
    
    // Direct keyword matching
    $keywords = array(
        'turtle' => array('turtle', 'Ellipse 1', 'Ellipse 2'),
        'urn' => array('Mask group', 'urn', 'vase'),
        'casket' => array('casket', 'Mask-group', 'Rectangle'),
        'bamboo' => array('bamboo', 'woven'),
        'petal' => array('petal', 'flower', 'bougainvillea'),
        'shroud' => array('shroud', 'fabric'),
        'box' => array('box', 'container'),
    );
    
    // Try to match by keywords
    foreach ($keywords as $key => $patterns) {
        if (strpos($name_lower, $key) !== false) {
            foreach ($available_images as $img) {
                $img_name = basename($img);
                foreach ($patterns as $pattern) {
                    if (stripos($img_name, $pattern) !== false) {
                        return $img;
                    }
                }
            }
        }
    }
    
    // Return random image if no match
    if (!empty($available_images)) {
        return $available_images[array_rand($available_images)];
    }
    
    return false;
}

// Products data with image hints
$products_data = array(
    array(
        'name' => 'Adult Size Turtle',
        'price' => 249.00,
        'category' => 'water-cremation-urns',
        'description' => 'Beautiful turtle-shaped biodegradable urn for water cremation. Made from natural materials that dissolve safely in water.',
        'featured' => true,
        'best_seller' => true,
        'image_hint' => 'turtle',
    ),
    array(
        'name' => 'Compassion Water',
        'price' => 160.00,
        'category' => 'water-cremation-urns',
        'description' => 'Elegant water cremation urn with compassionate design. Perfect for ocean or lake ceremonies.',
        'featured' => true,
        'image_hint' => 'urn',
    ),
    array(
        'name' => 'Journey Water Urn',
        'price' => 129.00,
        'category' => 'water-cremation-urns',
        'description' => 'Simple yet dignified water burial urn for the final journey.',
        'featured' => true,
        'image_hint' => 'urn',
    ),
    array(
        'name' => 'Ocean Blue Pillow',
        'price' => 320.00,
        'sale_price' => 280.00,
        'category' => 'water-cremation-urns',
        'description' => 'Premium pillow-style urn in ocean blue. Biodegradable and eco-friendly.',
        'featured' => true,
        'image_hint' => 'pillow',
    ),
    array(
        'name' => 'Unity Earth',
        'price' => 150.00,
        'category' => 'earth-burial-urns',
        'description' => 'Natural earth burial urn that returns to soil within months.',
        'best_seller' => true,
        'image_hint' => 'urn',
    ),
    array(
        'name' => 'Simplicity Earth',
        'price' => 100.00,
        'category' => 'earth-burial-urns',
        'description' => 'Simple, elegant design for earth burial. Made from sustainable materials.',
        'image_hint' => 'urn',
    ),
    array(
        'name' => 'Memorial White',
        'price' => 29.00,
        'category' => 'earth-burial-urns',
        'description' => 'Affordable white memorial urn for earth burial.',
        'image_hint' => 'urn',
    ),
    array(
        'name' => 'Woven Bamboo Casket',
        'price' => 120.00,
        'category' => 'biodegradable-caskets',
        'description' => 'Handwoven bamboo casket, fully biodegradable and sustainable.',
        'best_seller' => true,
        'image_hint' => 'bamboo',
    ),
    array(
        'name' => 'Seagrass Natural Casket',
        'price' => 895.00,
        'category' => 'biodegradable-caskets',
        'description' => 'Beautiful seagrass casket with natural finish.',
        'image_hint' => 'casket',
    ),
    array(
        'name' => 'Bougainvillea Memorial Petals',
        'price' => 35.00,
        'category' => 'memorial-petals',
        'description' => 'Beautiful dried bougainvillea petals for memorial services.',
        'image_hint' => 'petal',
    ),
);

// Add more products to reach 27 total
for ($i = 0; $i < 17; $i++) {
    $products_data[] = array(
        'name' => 'Memorial Product ' . ($i + 1),
        'price' => rand(50, 300),
        'category' => array_rand(array_flip(array_keys($categories))),
        'description' => 'Quality eco-friendly memorial product for green burials.',
        'image_hint' => 'urn',
    );
}

echo '<h2>Creating Products with Images...</h2>';
$created_count = 0;
$image_index = 0;

foreach ($products_data as $product_data) {
    // Check if product already exists
    $existing = get_page_by_title($product_data['name'], OBJECT, 'product');
    if ($existing) {
        echo '<p>- Product already exists: ' . $product_data['name'] . '</p>';
        continue;
    }
    
    // Create product
    $product = new WC_Product_Simple();
    $product->set_name($product_data['name']);
    $product->set_status('publish');
    $product->set_catalog_visibility('visible');
    $product->set_description($product_data['description']);
    $product->set_short_description(substr($product_data['description'], 0, 100) . '...');
    $product->set_regular_price($product_data['price']);
    
    if (isset($product_data['sale_price'])) {
        $product->set_sale_price($product_data['sale_price']);
    }
    
    $product->set_stock_status('instock');
    $product->set_manage_stock(false);
    
    $product_id = $product->save();
    
    // Assign category
    if (isset($product_data['category'])) {
        $term = get_term_by('slug', $product_data['category'], 'product_cat');
        if ($term) {
            wp_set_object_terms($product_id, $term->term_id, 'product_cat');
        }
    }
    
    // Set as featured
    if (isset($product_data['featured']) && $product_data['featured']) {
        $product->set_featured(true);
        $product->save();
    }
    
    // Add best seller tag
    if (isset($product_data['best_seller']) && $product_data['best_seller']) {
        update_post_meta($product_id, 'total_sales', rand(50, 200));
    }
    
    // Attach image
    $image_attached = false;
    if (!empty($available_images)) {
        $matching_image = gb_find_product_image($product_data['name'], $available_images);
        if ($matching_image && gb_attach_product_image($product_id, $matching_image)) {
            $image_attached = true;
            echo '<p>✓ Created: ' . $product_data['name'] . ' - $' . $product_data['price'] . ' <strong>[Image: ' . basename($matching_image) . ']</strong></p>';
        }
    }
    
    if (!$image_attached) {
        echo '<p>✓ Created: ' . $product_data['name'] . ' - $' . $product_data['price'] . ' [No image]</p>';
    }
    
    $created_count++;
}

echo '<h2>Setup Complete!</h2>';
echo '<p><strong>' . $created_count . ' products created successfully.</strong></p>';
echo '<p><a href="' . admin_url('edit.php?post_type=product') . '">View Products in Admin</a></p>';
echo '<p><a href="' . home_url() . '">View Homepage</a></p>';
echo '<p><em>Note: Clear all caches (browser + WordPress transients) to see updated products.</em></p>';
