<?php
/**
 * Green Burials - Dummy Product Setup Script
 * Run this file once to populate WooCommerce with sample products and images
 * 
 * USAGE: Visit this file in your browser: http://localhost/custom-theme-template/wp-content/themes/green-burials/setup-dummy-products.php
 */

// Load WordPress
require_once(__DIR__ . '/../../../wp-load.php');

// Increase limits for image processing
set_time_limit(300); // 5 minutes
ini_set('memory_limit', '512M');

// Check if WooCommerce is active
if (!class_exists('WooCommerce')) {
    die('WooCommerce must be installed and activated!');
}

// Security check
if (!current_user_can('manage_options')) {
    die('You do not have permission to run this script.');
}

// Ensure GD is available
if (!extension_loaded('gd')) {
    die('GD Library is not enabled. Please enable extension=gd in php.ini');
}

echo '<h1>Green Burials - Product Setup & Image Integration</h1>';
echo '<p>Setting up categories, products, and processing images...</p>';

// Include functions.php if not loaded (for compression function)
if (!function_exists('green_burials_compress_image')) {
    require_once(__DIR__ . '/functions.php');
}

// Image Mapping Configuration
// Maps keywords in product names/slugs to filenames in assets/figma_exported_images
$image_map = array(
    'turtle' => '52bafda153bf02a3dc9df959693cb5920fe5f460.png',
    'pillow' => '345dff09b5bb9d2cd65a2921368e90f901482e67.png', // Blue box/pillow
    'pot' => '55fdd57b1677383a803b74a1c908e04488d2dbb2.jpg',
    'basket' => '69224a89386f1eb091359209dfe125b248700954.png', // Woven basket
    'casket' => '69224a89386f1eb091359209dfe125b248700954.png', // Fallback for caskets
    'urn' => '55fdd57b1677383a803b74a1c908e04488d2dbb2.jpg', // Fallback for urns
    'memorial' => 'bougainvillea-petals.svg', // Use existing SVG if no match
    'flower' => 'casket-flowers.svg',
    'burial' => 'field-burial.svg',
);

// Get all exported images
$exported_dir = __DIR__ . '/assets/figma_exported_images';
$exported_images = glob($exported_dir . '/*.{jpg,png,webp}', GLOB_BRACE);

echo '<h2>Processing Images...</h2>';

// Helper to find best matching image
function find_matching_image($product_name, $map, $exported_dir) {
    $name_lower = strtolower($product_name);
    
    // Check explicit map
    foreach ($map as $keyword => $filename) {
        if (strpos($name_lower, $keyword) !== false) {
            $path = $exported_dir . '/' . $filename;
            if (file_exists($path)) {
                return $path;
            }
        }
    }
    
    // Fallback: Return a random image from the folder to ensure everything has an image
    $files = glob($exported_dir . '/*.{jpg,png}', GLOB_BRACE);
    if (!empty($files)) {
        return $files[array_rand($files)];
    }
    
    return false;
}

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

echo '<h3>Categories</h3>';
foreach ($categories as $slug => $name) {
    $term = term_exists($name, 'product_cat');
    if (!$term) {
        $term = wp_insert_term($name, 'product_cat', array('slug' => $slug));
        echo '<p>✓ Created category: ' . $name . '</p>';
    } else {
        echo '<p>- Category already exists: ' . $name . '</p>';
    }
}

// Dummy Products Data (Updated from Figma)
$products_data = array(
    // Hero/Featured Items
    array(
        'name' => 'Adult Size Turtle',
        'price' => 249.00,
        'category' => 'water-cremation-urns',
        'description' => 'Biodegradable turtle urn for water burial. Handcrafted from recycled paper and non-toxic glues.',
        'featured' => true,
        'best_seller' => true,
    ),
    array(
        'name' => 'Ocean Blue Pillow',
        'price' => 320.00,
        'sale_price' => 280.00,
        'category' => 'water-cremation-urns',
        'description' => 'Deep ocean blue biodegradable pillow urn. Designed for a peaceful water ceremony.',
        'featured' => true,
    ),
    array(
        'name' => 'Memorial Pot',
        'price' => 160.00,
        'category' => 'earth-burial-urns',
        'description' => 'Natural clay memorial pot, perfect for earth burial or keeping at home.',
        'featured' => true,
    ),
    array(
        'name' => 'Woven Bamboo Basket',
        'price' => 120.00,
        'category' => 'biodegradable-caskets',
        'description' => 'Handwoven bamboo basket casket. Sustainable, lightweight, and fully biodegradable.',
        'featured' => true,
        'best_seller' => true,
    ),
    
    // More Products
    array(
        'name' => 'Journey Water Urn',
        'price' => 129.00,
        'category' => 'water-cremation-urns',
        'description' => 'Simple yet dignified water burial urn for the final journey.',
    ),
    array(
        'name' => 'Unity Earth Urn',
        'price' => 150.00,
        'category' => 'earth-burial-urns',
        'description' => 'Natural earth burial urn that returns to soil within months.',
        'best_seller' => true,
    ),
    array(
        'name' => 'Seagrass Natural Casket',
        'price' => 895.00,
        'category' => 'biodegradable-caskets',
        'description' => 'Beautiful seagrass casket with natural finish.',
    ),
    array(
        'name' => 'Memorial Stone Marker',
        'price' => 75.00,
        'category' => 'memorial-products',
        'description' => 'Natural stone memorial marker for grave sites.',
    ),
    array(
        'name' => 'Natural Cotton Shroud',
        'price' => 125.00,
        'category' => 'burial-shrouds',
        'description' => 'Pure cotton burial shroud, unbleached and natural.',
    ),
    array(
        'name' => 'Bougainvillea Petals',
        'price' => 35.00,
        'category' => 'memorial-petals',
        'description' => 'Beautiful dried bougainvillea petals for memorial services.',
    ),
);

echo '<h3>Products</h3>';
$created_count = 0;

foreach ($products_data as $product_data) {
    // Check if product already exists
    $existing = get_page_by_title($product_data['name'], OBJECT, 'product');
    
    if ($existing) {
        $product = wc_get_product($existing->ID);
        echo '<p>- Updating existing product: ' . $product_data['name'] . '</p>';
    } else {
        $product = new WC_Product_Simple();
        $product->set_name($product_data['name']);
        echo '<p>✓ Creating product: ' . $product_data['name'] . '</p>';
    }

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
    
    // Set featured/best seller
    if (isset($product_data['featured']) && $product_data['featured']) {
        $product->set_featured(true);
    }
    if (isset($product_data['best_seller']) && $product_data['best_seller']) {
        update_post_meta($product_id, 'total_sales', rand(50, 200));
    }
    
    // Process and Attach Image
    $image_path = find_matching_image($product_data['name'], $image_map, $exported_dir);
    
    if ($image_path) {
        // Compress/Optimize Image
        $optimized_path = green_burials_compress_image($image_path);
        
        // Upload to WordPress Media Library
        $upload_dir = wp_upload_dir();
        $filename = basename($optimized_path);
        $new_file = $upload_dir['path'] . '/' . $filename;
        
        // Copy if not exists
        if (!file_exists($new_file)) {
            copy($optimized_path, $new_file);
        }
        
        // Check if attachment exists
        $attachment_id = 0;
        $existing_attachment = get_posts(array(
            'post_type' => 'attachment',
            'meta_key' => '_wp_attached_file',
            'meta_value' => $upload_dir['subdir'] . '/' . $filename,
            'posts_per_page' => 1,
        ));
        
        if ($existing_attachment) {
            $attachment_id = $existing_attachment[0]->ID;
        } else {
            $filetype = wp_check_filetype($filename, null);
            $attachment = array(
                'post_mime_type' => $filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment($attachment, $new_file, $product_id);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attachment_id, $new_file);
            wp_update_attachment_metadata($attachment_id, $attach_data);
        }
        
        if ($attachment_id) {
            set_post_thumbnail($product_id, $attachment_id);
            echo '  - Attached image: ' . $filename . '<br>';
        }
    }
    
    $product->save();
    $created_count++;
}

echo '<h2>Setup Complete!</h2>';
echo '<p><strong>Processed ' . $created_count . ' products.</strong></p>';
echo '<p><a href="' . home_url() . '">View Homepage</a></p>';

