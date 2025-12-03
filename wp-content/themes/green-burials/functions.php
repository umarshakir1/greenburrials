<?php
/**
 * Green Burials Theme Functions
 * Optimized for extreme speed with WooCommerce support
 */

// Theme Setup
function green_burials_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'green-burials'),
    ));
    
    // Set image sizes
    set_post_thumbnail_size(400, 400, true);
    add_image_size('product-thumb', 300, 300, true);
    add_image_size('product-thumb-2x', 600, 600, true);
    add_image_size('hero-image', 500, 400, true);
    add_image_size('hero-image-2x', 1000, 800, true);
    
    // Enable WebP support
    add_filter('upload_mimes', 'green_burials_add_webp_mime');
    function green_burials_add_webp_mime($mimes) {
        $mimes['webp'] = 'image/webp';
        return $mimes;
    }
}
add_action('after_setup_theme', 'green_burials_setup');

// Enqueue optimized styles and scripts
function green_burials_scripts() {
    // Google Fonts - Playfair Display only (Body uses system fonts)
    wp_enqueue_style('playfair-font', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&display=swap', array(), null);
    
    // Main stylesheet - minified inline
    wp_enqueue_style('green-burials-style', get_stylesheet_uri(), array('playfair-font'), '1.1');
    
    // Main script - deferred
    wp_enqueue_script('green-burials-script', get_template_directory_uri() . '/js/script.js', array(), '1.1', true);
    
    // Remove unnecessary WordPress styles/scripts
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
    wp_dequeue_style('global-styles');
    wp_deregister_style('global-styles');
}
add_action('wp_enqueue_scripts', 'green_burials_scripts', 100);

// Preload Google Fonts for performance
function green_burials_preload_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'green_burials_preload_fonts', 1);

// Remove jQuery if not needed
function green_burials_remove_jquery() {
    if (!is_admin()) {
        wp_deregister_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'green_burials_remove_jquery');

// Remove emoji scripts
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove WordPress version
remove_action('wp_head', 'wp_generator');

// Disable embeds
function green_burials_disable_embeds() {
    wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'green_burials_disable_embeds');

// HTML Minification for speed
function green_burials_minify_html($buffer) {
    $search = array(
        '/\>[^\S ]+/s',
        '/[^\S ]+\</s',
        '/(\s)+/s',
        '/<!--(?!<!)[^\[>].*?-->/s'
    );
    $replace = array('>', '<', '\\1', '');
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}

function green_burials_start_minify() {
    if (!is_admin()) {
        ob_start('green_burials_minify_html');
    }
}
add_action('init', 'green_burials_start_minify', 1);

// Optimize WooCommerce
function green_burials_optimize_woocommerce() {
    // Remove WooCommerce scripts on non-shop pages
    if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_front_page()) {
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
        wp_dequeue_script('wc-cart-fragments');
        wp_dequeue_script('woocommerce');
        wp_dequeue_script('wc-add-to-cart');
    }
}
add_action('wp_enqueue_scripts', 'green_burials_optimize_woocommerce', 99);

// Disable WooCommerce cart fragments on homepage for speed
function green_burials_disable_cart_fragments() {
    if (is_front_page()) {
        wp_dequeue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'green_burials_disable_cart_fragments', 100);

// Custom WooCommerce product query for homepage
function green_burials_get_products($args = array()) {
    $defaults = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    );
    
    $args = wp_parse_args($args, $defaults);
    return new WP_Query($args);
}

// Old product functions removed - now using cached versions below (lines 413-441)

// Get products by category
function green_burials_get_products_by_category($category_slug, $limit = 4) {
    return green_burials_get_products(array(
        'posts_per_page' => $limit,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $category_slug,
            ),
        ),
    ));
}

// Custom cart count
function green_burials_cart_count() {
    if (function_exists('WC')) {
        return WC()->cart->get_cart_contents_count();
    }
    return 0;
}

// Add lazy loading to images
function green_burials_add_lazy_loading($attr) {
    $attr['loading'] = 'lazy';
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'green_burials_add_lazy_loading');

// Defer JavaScript loading
function green_burials_defer_scripts($tag, $handle, $src) {
    $defer_scripts = array('green-burials-script');
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'green_burials_defer_scripts', 10, 3);

// Remove query strings from static resources
function green_burials_remove_query_strings($src) {
    if (strpos($src, '?ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'green_burials_remove_query_strings', 10, 2);
add_filter('script_loader_src', 'green_burials_remove_query_strings', 10, 2);

// Optimize database queries
function green_burials_optimize_queries() {
    if (!is_admin()) {
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    }
}
add_action('init', 'green_burials_optimize_queries');

// Theme activation - run setup
function green_burials_activation() {
    // Create default pages if they don't exist
    $pages = array(
        'about' => 'About',
        'how-to' => 'How To',
        'as-seen-in' => 'As Seen In',
        'military' => 'Military',
        'blog' => 'Blog',
    );
    
    foreach ($pages as $slug => $title) {
        $page = get_page_by_path($slug);
        if (!$page) {
            wp_insert_post(array(
                'post_title' => $title,
                'post_name' => $slug,
                'post_status' => 'publish',
                'post_type' => 'page',
            ));
        }
    }
    
    // Set homepage
    $homepage = get_page_by_path('home');
    if (!$homepage) {
        $homepage_id = wp_insert_post(array(
            'post_title' => 'Home',
            'post_name' => 'home',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '', // Content handled by front-page.php
        ));
        update_option('page_on_front', $homepage_id);
        update_option('show_on_front', 'page');
    }
}
add_action('after_switch_theme', 'green_burials_activation');

// Custom excerpt length
function green_burials_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'green_burials_excerpt_length');

// Custom excerpt more
function green_burials_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'green_burials_excerpt_more');

// Image Compression Function using GD Library
function green_burials_compress_image($file_path, $quality = 80, $max_width = 800) {
    // Check if GD is available
    if (!extension_loaded('gd')) {
        return $file_path; // Return original if GD not available
    }
    
    // Get image info
    $image_info = @getimagesize($file_path);
    if (!$image_info) {
        return $file_path;
    }
    
    list($width, $height, $type) = $image_info;
    
    // Skip if already small enough
    if ($width <= $max_width && filesize($file_path) < 50000) {
        return $file_path;
    }
    
    // Create optimized folder if it doesn't exist
    $upload_dir = wp_upload_dir();
    $optimized_dir = $upload_dir['basedir'] . '/optimized';
    if (!file_exists($optimized_dir)) {
        wp_mkdir_p($optimized_dir);
    }
    
    // Generate optimized filename
    $filename = basename($file_path);
    $optimized_path = $optimized_dir . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp';
    
    // Check if already optimized
    if (file_exists($optimized_path) && filemtime($optimized_path) >= filemtime($file_path)) {
        return $optimized_path;
    }
    
    // Load image based on type
    $image = null;
    switch ($type) {
        case IMAGETYPE_JPEG:
            $image = @imagecreatefromjpeg($file_path);
            break;
        case IMAGETYPE_PNG:
            $image = @imagecreatefrompng($file_path);
            break;
        case IMAGETYPE_GIF:
            $image = @imagecreatefromgif($file_path);
            break;
        case IMAGETYPE_WEBP:
            return $file_path; // Already WebP
        default:
            return $file_path;
    }
    
    if (!$image) {
        return $file_path;
    }
    
    // Calculate new dimensions
    if ($width > $max_width) {
        $new_width = $max_width;
        $new_height = intval($height * ($max_width / $width));
    } else {
        $new_width = $width;
        $new_height = $height;
    }
    
    // Create resized image
    $resized = imagecreatetruecolor($new_width, $new_height);
    
    // Preserve transparency for PNG/GIF
    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
        imagefilledrectangle($resized, 0, 0, $new_width, $new_height, $transparent);
    }
    
    imagecopyresampled($resized, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Save as WebP if supported
    if (function_exists('imagewebp')) {
        imagewebp($resized, $optimized_path, $quality);
    } else {
        // Fallback to JPEG
        $optimized_path = str_replace('.webp', '.jpg', $optimized_path);
        imagejpeg($resized, $optimized_path, $quality);
    }
    
    imagedestroy($image);
    imagedestroy($resized);
    
    return $optimized_path;
}

// Enhanced WooCommerce product queries with caching
function green_burials_get_products_cached($args = array(), $cache_key = 'products') {
    $transient_key = 'gb_' . $cache_key . '_' . md5(serialize($args));
    $cached = get_transient($transient_key);
    
    if ($cached !== false) {
        return $cached;
    }
    
    $defaults = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    );
    
    $args = wp_parse_args($args, $defaults);
    $query = new WP_Query($args);
    
    // Cache for 1 hour
    set_transient($transient_key, $query, HOUR_IN_SECONDS);
    
    return $query;
}

// Override existing product functions to use caching
function green_burials_get_featured_products($limit = 4) {
    return green_burials_get_products_cached(array(
        'posts_per_page' => $limit,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'featured',
            ),
        ),
    ), 'featured');
}

function green_burials_get_best_sellers($limit = 4) {
    return green_burials_get_products_cached(array(
        'posts_per_page' => $limit,
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    ), 'bestsellers');
}

function green_burials_get_latest_products($limit = 4) {
    return green_burials_get_products_cached(array(
        'posts_per_page' => $limit,
        'orderby' => 'date',
        'order' => 'DESC',
    ), 'latest');
}

// Disable WooCommerce cart fragments on homepage
add_action('wp', function() {
    if (is_front_page()) {
        wp_dequeue_script('wc-cart-fragments');
    }
});

// Remove query strings from static resources
function green_burials_remove_ver($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'green_burials_remove_ver', 9999);
add_filter('script_loader_src', 'green_burials_remove_ver', 9999);

// Inline critical CSS for above-the-fold content
function green_burials_inline_critical_css() {
    if (!is_front_page()) return;
    ?>
    <style id="critical-css">
    :root{--primary-green:#73884D;--dark-green:#5A7A1F;--accent-gold:#C4B768;--text-dark:#333333;--bg-light:#F9F9F9;--sale-orange:#FF5722}
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:Arial,Helvetica,sans-serif;line-height:1.6;color:#333;background:#fff}
    .site-header{background:var(--primary-green);color:#fff;position:sticky;top:0;z-index:1000}
    .hero-section{padding:5rem 0}
    .hero-text h1{font-size:4rem;color:var(--primary-green);font-family:'Playfair Display',serif;font-weight:700;font-style:italic;line-height:1.1;text-transform:uppercase}
    .container{max-width:1200px;margin:0 auto;padding:0 1.5rem}
    </style>
    <?php
}
add_action('wp_head', 'green_burials_inline_critical_css', 2);

// Performance monitoring (optional - for testing)
function green_burials_performance_monitor() {
    if (!is_front_page() || !current_user_can('manage_options')) return;
    
    $load_time = timer_stop(0, 3);
    echo '<!-- Page generated in ' . $load_time . ' seconds -->';
}
add_action('wp_footer', 'green_burials_performance_monitor', 999);
