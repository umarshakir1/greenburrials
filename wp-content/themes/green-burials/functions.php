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
        'main-nav-full'  => __('Main Navigation', 'green-burials'),
        'footer-links-1' => __('Footer Column One', 'green-burials'),
        'footer-links-2' => __('Footer Column Two', 'green-burials'),
    ));
    
    // Set image sizes
    set_post_thumbnail_size(400, 400, false);
    add_image_size('product-thumb', 300, 300, false);
    add_image_size('product-thumb-2x', 600, 600, false);
    add_image_size('hero-image', 500, 400, true);
    add_image_size('hero-image-2x', 1000, 800, true);
    
    // Disable WooCommerce image cropping
    add_filter('woocommerce_get_image_size_thumbnail', function($size) {
        $size['crop'] = 0;
        return $size;
    });
    
    // Enable WebP support
    add_filter('upload_mimes', 'green_burials_add_webp_mime');
    function green_burials_add_webp_mime($mimes) {
        $mimes['webp'] = 'image/webp';
        return $mimes;
    }
    
    // Add Gutenberg/Block Editor support
    add_theme_support('align-wide');
    add_theme_support('align-full');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    
    // Add custom color palette for block editor
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary Green', 'green-burials'),
            'slug'  => 'primary-green',
            'color' => '#73884D',
        ),
        array(
            'name'  => __('Dark Green', 'green-burials'),
            'slug'  => 'dark-green',
            'color' => '#5A7A1F',
        ),
        array(
            'name'  => __('Accent Gold', 'green-burials'),
            'slug'  => 'accent-gold',
            'color' => '#C4B768',
        ),
        array(
            'name'  => __('Text Dark', 'green-burials'),
            'slug'  => 'text-dark',
            'color' => '#333333',
        ),
        array(
            'name'  => __('Background Light', 'green-burials'),
            'slug'  => 'bg-light',
            'color' => '#F9F9F9',
        ),
    ));
}
add_action('after_setup_theme', 'green_burials_setup');

// Remove default WooCommerce breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Automated Image Optimization for WooCommerce & Site-wide
 * Resizes images to max 1200px width and converts to WebP
 */
function green_burials_handle_upload_optimization($upload) {
    if ($upload['type'] == 'image/jpeg' || $upload['type'] == 'image/png' || $upload['type'] == 'image/gif') {
        $file_path = $upload['file'];
        
        // Resize and convert to WebP
        $optimized_path = green_burials_compress_image($file_path, 85, 1200);
        
        // If optimization was successful and returned a new path (WebP)
        if ($optimized_path !== $file_path && file_exists($optimized_path)) {
            // Update the upload array to point to the new WebP file
            $upload['file'] = $optimized_path;
            $upload['url'] = str_replace(basename($file_path), basename($optimized_path), $upload['url']);
            $upload['type'] = 'image/webp';
            
            // Optionally delete the original if you want to save space
            // @unlink($file_path); 
        }
    }
    return $upload;
}
add_filter('wp_handle_upload', 'green_burials_handle_upload_optimization');

// Enqueue optimized styles and scripts
function green_burials_scripts() {
    $theme_version = wp_get_theme()->get('Version');
    // Google Fonts - Inter for body text, Times New Roman for headings (System Font)
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Main stylesheet - use timestamp to force cache refresh
    wp_enqueue_style('green-burials-style', get_template_directory_uri() . '/style.css', array('google-fonts'), time());
    
    // Main script - deferred and minified
    wp_enqueue_script('green-burials-script', get_template_directory_uri() . '/js/script.js', array('jquery'), time(), true);
    
    // Mobile menu script
    wp_enqueue_script('green-burials-mobile-menu', get_template_directory_uri() . '/assets/js/mobile-menu.js', array(), '1.0', true);
    
    // Mega menu script
    wp_enqueue_script('green-burials-mega-menu', get_template_directory_uri() . '/assets/js/mega-menu.js', array(), '1.0', true);
    
    // Reviews section styles and scripts
    // wp_enqueue_style('green-burials-reviews', get_template_directory_uri() . '/assets/css/reviews.css', array(), '1.0');
    // wp_enqueue_script('green-burials-reviews', get_template_directory_uri() . '/assets/js/reviews-slider.js', array(), '1.0', true);
    
    // Gutenberg block styles for blog posts and pages
    if (is_singular('post') || is_page()) {
        wp_enqueue_style('green-burials-gutenberg-blocks', get_template_directory_uri() . '/assets/css/gutenberg-blocks.css', array('green-burials-style'), $theme_version);
    }
    
    // Mobile shop/category fixes
    if (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy()) {
        wp_enqueue_style('green-burials-mobile-shop', get_template_directory_uri() . '/assets/css/mobile-shop-fixes.css', array('green-burials-style'), $theme_version . '.1');
    }
    
    // Single Product Page assets
    if (is_product()) {
        wp_enqueue_style('green-burials-single-product', get_template_directory_uri() . '/assets/css/single-product.css', array(), $theme_version . '.2');
        wp_enqueue_style('green-burials-mobile-product', get_template_directory_uri() . '/assets/css/mobile-product-fixes.css', array('green-burials-single-product'), $theme_version . '.1');
        // Ensure WooCommerce variation script is loaded for variable products
        wp_enqueue_script('wc-add-to-cart-variation');
        $sp_js = get_template_directory() . '/assets/js/single-product.js';
        wp_enqueue_script('green-burials-single-product', get_template_directory_uri() . '/assets/js/single-product.js', array('jquery', 'wc-add-to-cart-variation'), file_exists($sp_js) ? filemtime($sp_js) : $theme_version . '.5', true);
        
        // Localize checkout URL for Buy Now button
        wp_localize_script('green-burials-single-product', 'gb_product_params', array(
            'checkout_url' => wc_get_checkout_url(),
            'ajax_url'     => admin_url('admin-ajax.php'),
            'wc_ajax_url'  => WC_AJAX::get_endpoint('%%endpoint%%')
        ));
    }

    // Localize for general cart and AJAX functionality (front page + all pages)
    wp_localize_script('green-burials-script', 'gb_ajax_params', array(
        'ajax_url'    => admin_url('admin-ajax.php'),
        'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
        'nonce'       => wp_create_nonce('gb_ajax_nonce'),
        'login_url'   => wc_get_page_permalink('myaccount'),
        'shop_url'    => wc_get_page_permalink('shop'),
    ));

    // Shop Archive Page assets
    if (is_shop() || is_product_category() || is_product_tag()) {
        wp_enqueue_script('green-burials-shop-filters', get_template_directory_uri() . '/assets/js/shop-filters.js', array(), '1.0', true);
    }
    
    // Global mobile fixes
    wp_enqueue_style('green-burials-global-mobile', get_template_directory_uri() . '/assets/css/global-mobile-fixes.css', array('green-burials-style'), $theme_version . '.1');
    
    // New mobile header layout
    wp_enqueue_style('green-burials-mobile-header-new', get_template_directory_uri() . '/assets/css/mobile-header-new.css', array('green-burials-style'), $theme_version . '.1');
    wp_enqueue_script('green-burials-mobile-header-new', get_template_directory_uri() . '/assets/js/mobile-header-new.js', array(), $theme_version . '.1', true);

    // Custom Checkout assets
    if (is_checkout() && !is_wc_endpoint_url('order-received')) {
        $checkout_css_path = get_template_directory() . '/assets/css/custom-checkout.css';
        $checkout_js_path  = get_template_directory() . '/assets/js/custom-checkout.js';

        $checkout_css_version = file_exists($checkout_css_path) ? filemtime($checkout_css_path) : $theme_version;
        $checkout_js_version  = file_exists($checkout_js_path) ? filemtime($checkout_js_path) : $theme_version;

        wp_enqueue_style('green-burials-checkout', get_template_directory_uri() . '/assets/css/custom-checkout.css', array('green-burials-style'), $checkout_css_version);
        wp_enqueue_script(
            'green-burials-checkout',
            get_template_directory_uri() . '/assets/js/custom-checkout.js',
            array('jquery', 'selectWoo', 'wc-checkout', 'wc-country-select', 'wc-address-i18n'),
            $checkout_js_version,
            true
        );
    }

    // Remove unnecessary WordPress styles/scripts (but keep block styles for blog posts)
    // IMPORTANT: Keep block library styles on blog posts and pages for Gutenberg support
    if (!is_singular('post') && !is_page()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        // Keep global styles dequeued for performance on non-blog pages
        wp_dequeue_style('global-styles');
        wp_deregister_style('global-styles');
    }
    // Always dequeue WooCommerce block styles (not needed)
    wp_dequeue_style('wc-block-style');
}
add_action('wp_enqueue_scripts', 'green_burials_scripts', 100);

// Preload Google Fonts for performance
function green_burials_preload_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'green_burials_preload_fonts', 1);

// Remove jQuery if not needed (but keep on WooCommerce, Homepage, and custom Wishlist/Compare pages)
function green_burials_remove_jquery() {
    // Keep jQuery on WooCommerce, Homepage, and custom Wishlist/Compare pages
    if (!is_admin() && !is_woocommerce() && !is_cart() && !is_checkout() && !is_front_page() && !is_page('wishlist') && !is_page('compare')) {
        wp_deregister_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'green_burials_remove_jquery', 11);

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
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(?!<!)[^\[>].*?-->/s' // strip HTML comments
    );
    $replace = array('>', '<', '\\1', '');
    
    // Safer minification: don't strip newlines from within <script> or <style> tags
    // For now, let's just avoid the aggressive (\s)+ if it's causing issues
    $search = array(
        '/\>[^\S\r\n]+/s',
        '/[^\S\r\n]+\</s',
        '/<!--(?!<!)[^\[>].*?-->/s'
    );
    $replace = array('>', '<', '');
    
    $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}

// function green_burials_start_minify() {
//     if (!is_admin()) {
//         ob_start('green_burials_minify_html');
//     }
// }
// add_action('init', 'green_burials_start_minify', 1);

// Optimize WooCommerce
function green_burials_optimize_woocommerce() {
    // Remove WooCommerce scripts on non-essential pages
    // IMPORTANT: Never dequeue wc-add-to-cart on front page — needed for AJAX add-to-cart
    if (!is_woocommerce() && !is_cart() && !is_checkout() && !is_front_page()) {
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_script('woocommerce-layout');
        wp_dequeue_script('woocommerce-smallscreen');
        wp_dequeue_script('woocommerce');
        wp_dequeue_script('wc-add-to-cart');
    }
}
add_action('wp_enqueue_scripts', 'green_burials_optimize_woocommerce', 99);

// Always enqueue wc-add-to-cart on the homepage so AJAX add-to-cart works
function gb_enqueue_wc_ajax_on_front_page() {
    if ( is_front_page() ) {
        wp_enqueue_script( 'wc-add-to-cart' );
    }
}
add_action( 'wp_enqueue_scripts', 'gb_enqueue_wc_ajax_on_front_page', 101 );

// ============================================================================
// Suppress EPO validation errors on GET-based redirects to product pages.
//
// Problem: When a URL like /product/slug/?add-to-cart=1288 is opened in the
// browser (e.g. after our redirect, or a cached old URL), WooCommerce
// processes the ?add-to-cart GET parameter and EPO validates required fields,
// showing "This field is required" notices even though the user never clicked
// Add to Cart on the product page.
//
// Fix: Remove those WC error notices on product pages when the request method
// is GET (not a real POST form submission). This is safe — actual add-to-cart
// form submissions on the product page always POST.
// ============================================================================
// ============================================================================
// FIX 1: Clear EPO "required field" notices when user arrives at product page
//         via redirect (e.g. from a homepage card), not from submitting the
//         product page form itself.
//
// HOW IT WORKS:
//   When a user clicks Add to Cart from a homepage card:
//     1. Browser follows ?add-to-cart=ID (GET request)
//     2. EPO validates required fields → stores error notices in WC session
//     3. WooCommerce redirects to clean product URL
//     4. Product page loads → notices display (BAD — user never filled a form)
//
//   Fix uses HTTP_REFERER to distinguish:
//     - Referer = same product page  → user clicked ATC on product page form
//                                      → KEEP notices (the user needs to see them)
//     - Referer = different page     → user came from homepage/category card
//                                      → CLEAR notices (they shouldn't see them yet)
// ============================================================================
function gb_clear_epo_redirect_notices_on_product_page() {
    if ( ! is_product() ) return;
    if ( strtoupper( $_SERVER['REQUEST_METHOD'] ?? 'GET' ) !== 'GET' ) return;
    if ( ! WC()->session ) return;

    $notices = WC()->session->get( 'wc_notices', [] );
    if ( empty( $notices['error'] ) ) return;

    // Check if the user came from the product page itself.
    // If they did, this is a real form-validation redirect → keep the errors.
    $referer     = isset( $_SERVER['HTTP_REFERER'] ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';
    $product_url = (string) get_permalink( get_queried_object_id() );

    if ( $referer && $product_url ) {
        $referer_path     = rtrim( wp_parse_url( $referer,     PHP_URL_PATH ) ?? '', '/' );
        $product_path     = rtrim( wp_parse_url( $product_url, PHP_URL_PATH ) ?? '', '/' );

        // Referer is this product page → real form submission failed → keep notices.
        if ( $referer_path && $product_path && $referer_path === $product_path ) {
            return;
        }
    }

    // Arrived from somewhere else (homepage, category, external) → clear errors.
    unset( $notices['error'] );
    WC()->session->set( 'wc_notices', $notices );
}
add_action( 'woocommerce_before_single_product', 'gb_clear_epo_redirect_notices_on_product_page', 1 );

// ============================================================================
// FIX 1b: Strip EPO "required field" notices from the checkout page.
//
// WHY: EPO validates required fields during add-to-cart (server-side). When
//      validation fails, EPO calls wc_add_notice() to store error messages in
//      the WC session. Those notices persist across page loads and end up
//      printing on the checkout page even though the user never submitted the
//      checkout form with missing EPO data.
//
//      EPO has NO checkout-specific validation hook — it only runs its check
//      on woocommerce_add_to_cart_validation (priority 50). Therefore any
//      EPO "is a required field." notice on the checkout page is always a
//      stale leftover from a product-page add-to-cart attempt.
//
// FIX: Before the checkout page renders, remove only EPO required-field
//      notices from the session. All other WC error notices (e.g., shipping
//      or billing validation) are left untouched.
// ============================================================================
function gb_clear_epo_notices_on_checkout() {
    if ( ! is_checkout() ) return;
    if ( is_wc_endpoint_url( 'order-received' ) ) return;
    if ( ! WC()->session ) return;

    $notices = WC()->session->get( 'wc_notices', [] );
    if ( empty( $notices['error'] ) ) return;

    $notices['error'] = array_values( array_filter( $notices['error'], function ( $notice ) {
        $msg = is_array( $notice ) ? ( $notice['notice'] ?? '' ) : (string) $notice;
        return strpos( $msg, 'is a required field.' ) === false;
    } ) );

    if ( empty( $notices['error'] ) ) {
        unset( $notices['error'] );
    }

    WC()->session->set( 'wc_notices', $notices );
}
add_action( 'template_redirect', 'gb_clear_epo_notices_on_checkout', 5 );

// ============================================================================
// FIX 2: Allow AJAX add-to-cart for products that have EPO options but NONE
//         of them are required.
//
// PROBLEM: When EPO's "Force select options" setting is ON, it blocks ALL
//          AJAX add-to-cart calls for products that have ANY EPO options —
//          even when none of those options are required. This breaks the AJAX
//          popup modal for non-required EPO products.
//
// FIX: Hook at priority 40 (before EPO's priority 50). If the product has
//      no required EPO options, temporarily remove EPO's validation filter
//      for this specific request so the AJAX add-to-cart succeeds and our
//      popup modal fires.
// ============================================================================
function gb_allow_ajax_for_optional_epo_products( $passed, $product_id ) {
    // Only act on true AJAX add-to-cart requests.
    if ( ! wp_doing_ajax() ) return $passed;
    // Only relevant when EPO plugin is active.
    if ( ! function_exists( 'THEMECOMPLETE_EPO_DATA_STORE' ) || ! function_exists( 'THEMECOMPLETE_EPO_CART' ) ) return $passed;
    // Only relevant when EPO force_select_options is enabled.
    if ( 'yes' !== THEMECOMPLETE_EPO_DATA_STORE()->get( 'tm_epo_force_select_options' ) ) return $passed;

    // If the product has NO required EPO options, bypass EPO's AJAX block.
    if ( ! gb_product_has_required_epo_options( $product_id ) ) {
        remove_filter(
            'woocommerce_add_to_cart_validation',
            [ THEMECOMPLETE_EPO_CART(), 'woocommerce_add_to_cart_validation' ],
            50
        );
    }

    return $passed;
}
add_filter( 'woocommerce_add_to_cart_validation', 'gb_allow_ajax_for_optional_epo_products', 40, 2 );

// Disable WooCommerce cart fragments on homepage for speed
/* 
function green_burials_disable_cart_fragments() {
    if (is_front_page()) {
        wp_dequeue_script('wc-cart-fragments');
    }
}
add_action('wp_enqueue_scripts', 'green_burials_disable_cart_fragments', 100);
*/

/**
 * Custom Checkout Enhancements
 */
// Remove default login notice (we handle it via tabs)
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );

// Force Guest Checkout and Registration on Checkout options
add_filter( 'pre_option_woocommerce_enable_guest_checkout', function($val) { return 'yes'; } );
add_filter( 'pre_option_woocommerce_enable_signup_and_login_from_checkout', function($val) { return 'yes'; } );
add_filter( 'pre_option_woocommerce_checkout_registration', function($val) { return 'yes'; } );

// Always expand the shipping address form — shipping is always required.
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_true' );

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

function green_burials_get_cart_snapshot() {
    $default_amount = function_exists('wc_price') ? wc_price(0) : '$0.00';

    $snapshot = array(
        'count'          => 0,
        'subtotal_html'  => $default_amount,
        'subtotal_plain' => wp_strip_all_tags($default_amount),
    );

    if ( ! class_exists('WooCommerce') || ! function_exists('WC') ) {
        return $snapshot;
    }

    if ( function_exists('wc_load_cart') && ( ! isset(WC()->cart) || ! WC()->cart ) ) {
        wc_load_cart();
    }

    $cart = WC()->cart;

    if ( $cart ) {
        $snapshot['count'] = (int) $cart->get_cart_contents_count();
        $snapshot['subtotal_html'] = $cart->get_cart_subtotal();
        $snapshot['subtotal_plain'] = wp_strip_all_tags( $snapshot['subtotal_html'] );
    }

    return $snapshot;
}

function green_burials_render_header_cart() {
    $cart_url = '#';
    if ( class_exists('WooCommerce') && function_exists('wc_get_cart_url') ) {
        $cart_url = wc_get_cart_url();
    }

    $snapshot = green_burials_get_cart_snapshot();

    ob_start();
    ?>
    <a href="<?php echo esc_url( $cart_url ); ?>" class="header-cart">
        <div class="icon-circle">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        </div>
        <div class="action-text">
            <span class="header-action-label">My Cart</span>
            <span class="header-action-link"><?php echo wp_kses_post( $snapshot['subtotal_html'] ); ?></span>
        </div>
        <?php if ( $snapshot['count'] > 0 ) : ?>
            <span class="cart-badge"><?php echo esc_html( $snapshot['count'] ); ?></span>
        <?php endif; ?>
    </a>
    <?php
    return ob_get_clean();
}

function green_burials_header_cart_fragment( $fragments ) {
    $fragments['a.header-cart'] = green_burials_render_header_cart();
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'green_burials_header_cart_fragment' );

// Add lazy loading to images globally
function green_burials_add_lazy_loading($attr) {
    if (!is_admin()) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'green_burials_add_lazy_loading', 10);
add_filter('get_header_image_tag', function($html) {
    return str_replace('<img', '<img loading="lazy"', $html);
});

// Defer JavaScript loading for better performance
function green_burials_defer_scripts($tag, $handle, $src) {
    $defer_scripts = array(
        'green-burials-script',
        'green-burials-mobile-menu',
        'green-burials-mega-menu',
        'green-burials-reviews'
    );
    
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
/*
add_action('wp', function() {
    if (is_front_page()) {
        wp_dequeue_script('wc-cart-fragments');
    }
});
*/

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
    body{font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;line-height:1.6;color:#333;background:#fff}
    .site-header{background:var(--primary-green);color:#fff;position:sticky;top:0;z-index:1000}
    .hero-section{padding:5rem 0}
    .hero-text h1{font-size:4rem;color:var(--primary-green);font-family:'Times New Roman',Times,serif;font-weight:700;line-height:1.1;text-transform:uppercase}
    .container{max-width:100%;margin:0 auto;padding:0 20px}
    @media (max-width: 768px) { .container { padding: 0 15px; } }
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

// Register Sidebars
function green_burials_widgets_init() {
    register_sidebar(array(
        'name'          => __('Shop Sidebar', 'green-burials'),
        'id'            => 'shop-sidebar',
        'description'   => __('Add widgets here to appear in your shop sidebar.', 'green-burials'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'green_burials_widgets_init');

// ============================================================================
// EPO (Extra Product Options) Detection Helper
// Detects whether a product has required fields via TM Extra Product Options.
// Works safely whether the plugin is active or not.
// ============================================================================

/**
 * Returns true if a product has any REQUIRED extra product option fields
 * from the TM WooCommerce Extra Product Options plugin.
 *
 * Strategy:
 *   1. Use the plugin's own API (THEMECOMPLETE_EPO_API()->has_options()) if available.
 *   2. Fallback: scan the product's local CPT meta for any tmcp_required = 1 field.
 *
 * @param  int $product_id  WC product ID.
 * @return bool
 */
function gb_product_has_required_epo_options( $product_id ) {
    // Static cache — one check per product per request.
    static $cache = array();
    $product_id = absint( $product_id );
    if ( isset( $cache[ $product_id ] ) ) {
        return $cache[ $product_id ];
    }

    $has_required = false;

    // ── Path 1: Plugin API is available ──────────────────────────────────────
    if ( function_exists( 'THEMECOMPLETE_EPO' ) && function_exists( 'THEMECOMPLETE_EPO_API' ) ) {
        try {
            $epos = THEMECOMPLETE_EPO()->get_product_tm_epos( $product_id, '', false, true );
            if ( $epos && is_array( $epos ) ) {
                // Merge global + local price arrays.
                $all_sections = array();
                if ( ! empty( $epos['global'] ) && is_array( $epos['global'] ) ) {
                    foreach ( $epos['global'] as $priority_group ) {
                        if ( isset( $priority_group['sections'] ) && is_array( $priority_group['sections'] ) ) {
                            $all_sections = array_merge( $all_sections, $priority_group['sections'] );
                        }
                    }
                }
                if ( ! empty( $epos['local'] ) && is_array( $epos['local'] ) ) {
                    foreach ( $epos['local'] as $priority_group ) {
                        if ( isset( $priority_group['sections'] ) && is_array( $priority_group['sections'] ) ) {
                            $all_sections = array_merge( $all_sections, $priority_group['sections'] );
                        }
                    }
                }
                foreach ( $all_sections as $section ) {
                    if ( ! isset( $section['elements'] ) || ! is_array( $section['elements'] ) ) {
                        continue;
                    }
                    foreach ( $section['elements'] as $element ) {
                        if ( ! empty( $element['required'] ) ) {
                            $has_required = true;
                            break 2;
                        }
                    }
                }
            }
        } catch ( Exception $e ) {
            // Plugin API failed — fall through to DB fallback.
            $has_required = false;
        }
    } else {
        // ── Path 2: Direct DB lookup as a reliable fallback ──────────────────
        // The plugin stores each option field as its own CPT post (type: "tm-product").
        // Each field's "required" flag is in the post meta key `tmcp_required`.
        global $wpdb;

        // Get all option group IDs attached to this product (local options).
        $local_groups = get_post_meta( $product_id, 'tm_meta_cpf', true );
        $group_ids    = array();
        if ( is_array( $local_groups ) && ! empty( $local_groups['tm_epo'] ) ) {
            $group_ids = (array) $local_groups['tm_epo'];
        }

        // Also check global option groups (post type: tm-product, applied to this product or all).
        $global_groups = $wpdb->get_col( $wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts}
              WHERE post_type = 'tm-product'
                AND post_status = 'publish'"
        ) );
        $group_ids = array_unique( array_merge( $group_ids, $global_groups ) );

        if ( ! empty( $group_ids ) ) {
            $placeholders = implode( ', ', array_fill( 0, count( $group_ids ), '%d' ) );
            // Look for any child field posts that have tmcp_required = 1.
            $result = $wpdb->get_var( $wpdb->prepare(
                "SELECT pm.meta_value
                   FROM {$wpdb->postmeta} pm
                   JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                  WHERE p.post_parent IN ( $placeholders )
                    AND p.post_type = 'tm-product'
                    AND pm.meta_key = 'tmcp_required'
                    AND pm.meta_value = '1'
                  LIMIT 1",
                ...$group_ids
            ) );
            $has_required = ! empty( $result );
        }
    }

    $cache[ $product_id ] = $has_required;
    return $has_required;
}

// ============================================================================
// AJAX endpoint: JS can ask "does this product have required EPO options?"
// Used dynamically if product data wasn't embedded at render time.
// ============================================================================
function gb_ajax_check_product_epo() {
    $product_id = absint( $_POST['product_id'] ?? 0 );
    if ( ! $product_id ) {
        wp_send_json_error( 'Invalid product ID' );
    }
    wp_send_json_success( array(
        'has_required_options' => gb_product_has_required_epo_options( $product_id ),
        'product_url'          => get_permalink( $product_id ),
    ) );
}
add_action( 'wp_ajax_gb_check_product_epo',        'gb_ajax_check_product_epo' );
add_action( 'wp_ajax_nopriv_gb_check_product_epo', 'gb_ajax_check_product_epo' );

// ============================================================================
// Fix: Price Filter Range & Filtering for EPO-Priced Products
//
// Problem: WooCommerce's wc_product_meta_lookup table stores min_price /
//          max_price by reading _price post-meta directly (bypasses all
//          woocommerce_product_get_price filters). Products with $0 base
//          price that rely on EPO options therefore have $0 in the lookup
//          table → the price filter slider shows the wrong range AND filters
//          products incorrectly.
//
// Fix:     After every product save WooCommerce overwrites the lookup row
//          with the raw $0 value. We re-run immediately afterwards (priority
//          20) and overwrite it again with the EPO-effective price, using
//          EPO's own add_product_tc_prices() / tc_get_price() API.
//          A one-time bulk sync (admin_init, transient-guarded) covers all
//          products that already existed before this fix was deployed.
// ============================================================================

/**
 * Sync a single product's EPO-effective price into wc_product_meta_lookup.
 *
 * @param int|WC_Product $product Product ID or object.
 */
function gb_sync_epo_price_to_lookup( $product ) {
    if ( ! function_exists( 'THEMECOMPLETE_EPO' ) || ! function_exists( 'THEMECOMPLETE_EPO_DATA_STORE' ) ) {
        return;
    }
    if ( 'yes' !== THEMECOMPLETE_EPO_DATA_STORE()->get( 'tm_epo_include_possible_option_pricing' ) ) {
        return;
    }

    if ( is_numeric( $product ) ) {
        $product_id = (int) $product;
        $product    = wc_get_product( $product_id );
    } else {
        $product_id = $product->get_id();
    }

    if ( ! $product instanceof WC_Product ) {
        return;
    }

    // Populate EPO's internal min/max option price cache for this product.
    $minmax = THEMECOMPLETE_EPO()->add_product_tc_prices( $product_id );
    if ( false === $minmax ) {
        return; // Product has no EPO options — nothing to do.
    }

    $base_price = (float) get_post_meta( $product_id, '_price', true );
    $tc_min     = isset( $minmax['tc_min_price'] ) ? (float) $minmax['tc_min_price'] : 0.0;
    $tc_max     = isset( $minmax['tc_max_price'] ) ? (float) $minmax['tc_max_price'] : $tc_min;

    $effective_min = $base_price + $tc_min;
    $effective_max = $base_price + $tc_max;

    // Only update when EPO actually adds value above the stored base price.
    if ( $effective_min <= $base_price ) {
        return;
    }

    global $wpdb;
    $wpdb->update(
        $wpdb->prefix . 'wc_product_meta_lookup',
        array(
            'min_price' => $effective_min,
            'max_price' => $effective_max,
        ),
        array( 'product_id' => $product_id ),
        array( '%f', '%f' ),
        array( '%d' )
    );
}

// Re-sync after every product save.
// Priority 20 ensures this runs after WooCommerce's own lookup table update
// (which overwrites with the raw $0 value at default priority).
add_action( 'woocommerce_after_product_object_save', 'gb_sync_epo_price_to_lookup', 20 );

/**
 * One-time bulk sync: update wc_product_meta_lookup for ALL published products.
 * Runs only in WP-admin (never on the public frontend) and is protected by a
 * 30-day transient so it only executes once per deployment.
 *
 * To force a re-sync (e.g. after adding new EPO options) visit:
 *   /wp-admin/?gb_reset_epo_lookup=1  (while logged in as admin)
 */
function gb_bulk_sync_epo_prices_to_lookup() {
    if ( ! is_admin() ) {
        return;
    }
    if ( ! function_exists( 'THEMECOMPLETE_EPO' ) || ! function_exists( 'THEMECOMPLETE_EPO_DATA_STORE' ) ) {
        return;
    }
    if ( 'yes' !== THEMECOMPLETE_EPO_DATA_STORE()->get( 'tm_epo_include_possible_option_pricing' ) ) {
        return;
    }

    // Allow an admin to force a re-sync by visiting ?gb_reset_epo_lookup=1.
    if ( isset( $_GET['gb_reset_epo_lookup'] ) && current_user_can( 'manage_options' ) ) {
        delete_transient( 'gb_epo_lookup_synced_v1' );
    }

    if ( get_transient( 'gb_epo_lookup_synced_v1' ) ) {
        return;
    }

    global $wpdb;
    $product_ids = $wpdb->get_col(
        "SELECT ID FROM {$wpdb->posts}
          WHERE post_type = 'product' AND post_status = 'publish'"
    );

    foreach ( $product_ids as $product_id ) {
        gb_sync_epo_price_to_lookup( (int) $product_id );
    }

    set_transient( 'gb_epo_lookup_synced_v1', true, 30 * DAY_IN_SECONDS );
}
add_action( 'admin_init', 'gb_bulk_sync_epo_prices_to_lookup' );

// ============================================================================
// Match homepage product layout: "Shop Now" pill + circular "Cart" icon
// On archive/category pages, smart-detect required EPO options:
//   - No required options → AJAX popup (normal behaviour)
//   - Has required options → redirect to product page
// ============================================================================
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'green_burials_product_loop_actions', 10 );

function green_burials_product_loop_actions() {
    global $product;
    if ( ! $product ) return;

    $product_id        = $product->get_id();
    $has_required_epo  = gb_product_has_required_epo_options( $product_id );
    $product_permalink = esc_url( $product->get_permalink() );

    echo '<div class="category-product-actions">';

    // 1. Shop Now Button — always redirects to product page (never Buy Now logic)
    echo '<a href="' . $product_permalink . '" class="btn-category-shop">' . __( 'Shop Now', 'woocommerce' ) . '</a>';

    if ( $has_required_epo ) {
        // 2a. Product HAS required EPO fields:
        //     Button redirects to product page so user can fill in required options.
        printf(
            '<a href="%s"
                class="btn-category-add-to-cart add_to_cart_button product_type_%s gb-epo-redirect"
                data-product_id="%d"
                data-product-permalink="%s"
                data-has-required-options="1"
                aria-label="%s"
                rel="nofollow"
             ><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></a>',
            $product_permalink,
            esc_attr( $product->get_type() ),
            $product_id,
            $product_permalink,
            esc_attr( $product->add_to_cart_description() )
        );
    } else {
        // 2b. Product has NO required EPO fields:
        //     Use the normal WooCommerce AJAX add-to-cart flow (triggers popup).
        $class = implode( ' ', array_filter( array(
            'btn-category-add-to-cart add_to_cart_button',
            'product_type_' . $product->get_type(),
            $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
        ) ) );
        $attributes = array(
            'data-product_id'          => $product_id,
            'data-product_sku'         => $product->get_sku(),
            'data-has-required-options'=> '0',
            'aria-label'               => $product->add_to_cart_description(),
            'rel'                      => 'nofollow',
        );
        printf(
            '<a href="%s" data-quantity="1" class="%s" %s><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( $class ),
            wc_implode_html_attributes( $attributes )
        );
    }

    echo '</div>';
}


// Filter to change "Add to cart" text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'green_burials_custom_cart_button_text' );
function green_burials_custom_cart_button_text() {
    return __( 'Add to Cart', 'woocommerce' );
}

// Display "Available Options" heading above variable products
function green_burials_display_options_heading() {
    global $product;
    if ( $product && $product->is_type( 'variable' ) ) {
        echo '<div class="options-header"><h3 class="options-title">AVAILABLE OPTIONS</h3></div>';
    }
}
add_action( 'woocommerce_before_add_to_cart_form', 'green_burials_display_options_heading', 5 );
// Wrap Add to Cart button
add_action( 'woocommerce_before_add_to_cart_quantity', function() {
    echo '<div class="product-buttons-row">';
}, 5 );

add_action( 'woocommerce_after_add_to_cart_quantity', function() {
    echo '<div class="action-group cart-group">';
}, 10 );

add_action( 'woocommerce_after_add_to_cart_button', function() {
    echo '</div>'; // Close cart-group
}, 10 );

// Add Buy Now button and Secondary Actions
function green_burials_add_buy_now_button() {
    global $product;
    
    // Buy Now Button Group
    echo '<div class="action-group buy-now-group">';
    echo '<button type="button" class="btn-buy-now button alt" data-product-id="' . esc_attr( $product->get_id() ) . '">Buy Now</button>';
    echo '</div>'; // Close buy-now-group
    
    // Secondary Actions Row (Wishlist & Compare)
    echo '<div class="secondary-actions-row">';
    ?>
    <a href="#" class="add-to-wishlist gb-add-to-wishlist" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="color: #6b7a4d;"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
        <span class="secondary-action-label">Add To Wishlist</span>
    </a>
    <a href="#" class="add-to-compare gb-add-to-compare" data-product-id="<?php echo esc_attr($product->get_id()); ?>">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #6b7a4d;"><path d="M16 3h5v5M4 20L21 3M21 16v5h-5M15 15l6 6M4 4l5 5"></path></svg>
        <span class="secondary-action-label">Add To Compare</span>
    </a>
    <?php
    echo '</div>'; // Close secondary-actions-row
    
    echo '</div>'; // Close product-buttons-row
}
add_action( 'woocommerce_after_add_to_cart_button', 'green_burials_add_buy_now_button', 20 );

// Buy Now script moved to single-product.js

// Handle Add to Compare functionality (Redirect Fallback)
function green_burials_handle_compare() {
    if ( isset( $_GET['add-to-compare'] ) ) {
        $product_id = absint( $_GET['add-to-compare'] );
        
        $compare = isset($_COOKIE['gb_compare']) ? json_decode(stripslashes($_COOKIE['gb_compare']), true) : array();
        if (!is_array($compare)) $compare = array();
        
        if ( ! in_array( $product_id, $compare ) ) {
            if (count($compare) < 3) {
                $compare[] = $product_id;
                setcookie('gb_compare', json_encode($compare), time() + (86400 * 30), COOKIEPATH, COOKIE_DOMAIN);
            }
        }
        
        // Redirect to compare page
        $compare_page = get_page_by_path('compare');
        $url = $compare_page ? get_permalink($compare_page) : wc_get_page_permalink( 'shop' );
        wp_redirect( $url );
        exit;
    }
}
add_action( 'template_redirect', 'green_burials_handle_compare' );

// Dynamic Ex Tax Price
function green_burials_get_ex_tax_price($product) {
    if (!$product) return '';
    $price = $product->get_price();
    if ($product->is_taxable()) {
        // Assuming tax is included in price, calculate ex-tax
        // Or if tax is not included, it's already ex-tax
        // For matching the image, we'll show a calculated ex-tax
        $ex_tax = wc_get_price_excluding_tax($product);
        return wc_price($ex_tax);
    }
    return wc_price($price);
}

/**
 * Add Sort Order field to Product Category taxonomy
 */
function green_burials_add_category_sort_order_field() {
    ?>
    <div class="form-field">
        <label for="category_sort_order"><?php _e( 'Sort Order', 'green-burials' ); ?></label>
        <input type="number" name="category_sort_order" id="category_sort_order" value="0">
        <p class="description"><?php _e( 'Enter a number to control the display order (lower numbers first).', 'green-burials' ); ?></p>
    </div>
    <?php
}
add_action( 'product_cat_add_form_fields', 'green_burials_add_category_sort_order_field', 10 );

function green_burials_edit_category_sort_order_field( $term ) {
    $sort_order = get_term_meta( $term->term_id, 'category_sort_order', true );
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="category_sort_order"><?php _e( 'Sort Order', 'green-burials' ); ?></label></th>
        <td>
            <input type="number" name="category_sort_order" id="category_sort_order" value="<?php echo esc_attr( $sort_order ? $sort_order : '0' ); ?>">
            <p class="description"><?php _e( 'Enter a number to control the display order (lower numbers first).', 'green-burials' ); ?></p>
        </td>
    </tr>
    <?php
}
add_action( 'product_cat_edit_form_fields', 'green_burials_edit_category_sort_order_field', 10 );

function green_burials_save_category_sort_order( $term_id ) {
    if ( isset( $_POST['category_sort_order'] ) ) {
        update_term_meta( $term_id, 'category_sort_order', sanitize_text_field( $_POST['category_sort_order'] ) );
    }
}
add_action( 'edited_product_cat', 'green_burials_save_category_sort_order', 10 );
add_action( 'create_product_cat', 'green_burials_save_category_sort_order', 10 );

/**
 * Fix Product Catalog Visibility
 * WooCommerce adds a product_visibility tax_query that hides products set to
 * "hidden" from catalog/search. This ensures ALL published products are
 * visible when browsing category pages and shop, regardless of visibility setting.
 */
function green_burials_fix_product_visibility( $q ) {
    if ( ! is_admin() && $q->is_main_query() ) {
        if ( is_shop() || is_product_category() || is_product_tag() ) {
            // Remove the WooCommerce-added catalog visibility exclusion
            // so products set to 'hidden' visibility still appear on category pages
            $tax_query = $q->get( 'tax_query' );
            if ( is_array( $tax_query ) ) {
                foreach ( $tax_query as $key => $tq ) {
                    if ( isset( $tq['taxonomy'] ) && $tq['taxonomy'] === 'product_visibility'
                         && isset( $tq['operator'] ) && $tq['operator'] === 'NOT IN' ) {
                        unset( $tax_query[ $key ] );
                    }
                }
                $q->set( 'tax_query', array_values( $tax_query ) );
            }
        }
    }
}
add_action( 'pre_get_posts', 'green_burials_fix_product_visibility', 20 );

/**
 * Support 'term_order' as an orderby argument in get_terms() for product categories.
 * WooCommerce stores category drag-and-drop order in a 'term_order' column.
 * We map this gracefully with a fallback to alphabetical name ordering.
 */
function green_burials_get_terms_orderby( $orderby, $query_vars, $taxonomies ) {
    if ( isset( $query_vars['orderby'] ) && 'term_order' === $query_vars['orderby'] ) {
        global $wpdb;
        // Check if term_order column exists in term_taxonomy table (WooCommerce adds this)
        $columns = $wpdb->get_col( "SHOW COLUMNS FROM {$wpdb->term_taxonomy} LIKE 'term_order'" );
        if ( ! empty( $columns ) ) {
            return 'tt.term_order';
        }
        // Gracefully fall back to alphabetical name sorting
        return 't.name';
    }
    return $orderby;
}
add_filter( 'get_terms_orderby', 'green_burials_get_terms_orderby', 10, 3 );

/**
 * Shipping Modal → WooCommerce Native Integration
 *
 * Fix 1: If any shipping field has data in POST, force ship_to_different_address=1
 *         so WooCommerce processes and saves the shipping fields natively.
 * Fix 2: Explicitly copy shipping fields to order meta after order creation so
 *         the WooCommerce order dashboard always shows the shipping address.
 * Fix 3: Save shipping address to user profile (My Account → Addresses).
 */

/**
 * Force WooCommerce to treat shipping fields as different-from-billing
 * whenever the user has entered shipping data.
 */
function green_burials_force_ship_to_different_on_submit() {
    if ( ! is_checkout() ) {
        return;
    }
    $has_shipping_data = (
        ! empty( $_POST['shipping_first_name'] ) ||
        ! empty( $_POST['shipping_address_1'] ) ||
        ! empty( $_POST['shipping_city'] )
    );
    if ( $has_shipping_data ) {
        $_POST['ship_to_different_address'] = 1;
    }
}
add_action( 'woocommerce_before_checkout_process', 'green_burials_force_ship_to_different_on_submit', 5 );

/**
 * After order is created, explicitly write shipping address fields to order meta.
 * Ensures dashboard, emails, and REST API all show the correct shipping address.
 */
function green_burials_save_shipping_address_to_order( $order_id ) {
    if ( ! $order_id ) return;

    $shipping_fields = array(
        'first_name', 'last_name', 'company',
        'address_1', 'address_2',
        'city', 'state', 'postcode', 'country', 'phone'
    );

    $order = wc_get_order( $order_id );
    if ( ! $order ) return;

    // Only proceed if at least one shipping field was submitted
    $has_shipping = false;
    foreach ( $shipping_fields as $field ) {
        if ( ! empty( $_POST[ 'shipping_' . $field ] ) ) {
            $has_shipping = true;
            break;
        }
    }
    if ( ! $has_shipping ) return;

    $shipping_address = array();
    foreach ( $shipping_fields as $field ) {
        $value = isset( $_POST[ 'shipping_' . $field ] )
            ? sanitize_text_field( wp_unslash( $_POST[ 'shipping_' . $field ] ) )
            : '';
        $shipping_address[ $field ] = $value;
    }

    $order->set_address( $shipping_address, 'shipping' );
    $order->save();
}
add_action( 'woocommerce_checkout_order_created', 'green_burials_save_shipping_address_to_order', 10 );

/**
 * Save shipping address to user meta so it appears on My Account → Addresses.
 */
function green_burials_save_shipping_address_to_user( $order_id ) {
    if ( ! $order_id ) return;

    $order = wc_get_order( $order_id );
    if ( ! $order || ! $order->get_customer_id() ) return;

    $customer_id = $order->get_customer_id();
    $map = array(
        'first_name' => 'get_shipping_first_name',
        'last_name'  => 'get_shipping_last_name',
        'company'    => 'get_shipping_company',
        'address_1'  => 'get_shipping_address_1',
        'address_2'  => 'get_shipping_address_2',
        'city'       => 'get_shipping_city',
        'state'      => 'get_shipping_state',
        'postcode'   => 'get_shipping_postcode',
        'country'    => 'get_shipping_country',
        'phone'      => 'get_shipping_phone',
    );

    $has_shipping = false;
    foreach ( $map as $field => $method ) {
        if ( method_exists( $order, $method ) && ! empty( $order->$method() ) ) {
            $has_shipping = true;
            break;
        }
    }
    if ( ! $has_shipping ) return;

    foreach ( $map as $field => $method ) {
        if ( method_exists( $order, $method ) ) {
            update_user_meta( $customer_id, 'shipping_' . $field, $order->$method() );
        }
    }
}
add_action( 'woocommerce_checkout_order_created', 'green_burials_save_shipping_address_to_user', 20 );

/**
 * Bi-directional Sync: Checkout → My Account Profile
 * Ensures that changes made in the custom shipping modal are saved to the 
 * user's profile during the checkout process.
 */
function green_burials_sync_checkout_to_user_profile( $customer, $data ) {
    if ( ! is_user_logged_in() ) {
        return;
    }

    $shipping_fields = array(
        'first_name', 'last_name', 'company',
        'address_1', 'address_2',
        'city', 'state', 'postcode', 'country',
        'phone'
    );

    foreach ( $shipping_fields as $field ) {
        $posted_key = 'shipping_' . $field;
        if ( isset( $_POST[ $posted_key ] ) ) {
            $value = sanitize_text_field( wp_unslash( $_POST[ $posted_key ] ) );
            $customer->{"set_shipping_$field"}( $value );
            // Also explicitly update meta to be safe (for My Account pages)
            update_user_meta( $customer->get_id(), 'shipping_' . $field, $value );
        }
    }
}
add_action( 'woocommerce_checkout_update_customer', 'green_burials_sync_checkout_to_user_profile', 10, 2 );

/**
 * AJAX Load More Products
 */
function green_burials_load_more() {
    // EPO's tm_woocommerce_get_price filter is only registered when ! is_admin().
    // AJAX requests hit admin-ajax.php so is_admin() = true and the filter is skipped,
    // causing products with $0 base price to display $0 instead of their option price.
    // Re-attach the filter here so prices are computed correctly for AJAX-loaded products.
    if (
        function_exists( 'THEMECOMPLETE_EPO' ) &&
        function_exists( 'THEMECOMPLETE_EPO_DATA_STORE' ) &&
        'yes' === THEMECOMPLETE_EPO_DATA_STORE()->get( 'tm_epo_include_possible_option_pricing' )
    ) {
        add_filter( 'woocommerce_product_get_price', [ THEMECOMPLETE_EPO(), 'tm_woocommerce_get_price' ], 2, 2 );
    }

    $paged = isset($_POST['page']) ? absint($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'date';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $existing_ids = isset($_POST['existing_ids']) ? explode(',', sanitize_text_field($_POST['existing_ids'])) : array();

    // Log for debugging
    error_log("Load More AJAX: Page $paged, Category $category, Skipping IDs: " . (count($existing_ids)));

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 20, // Increased from 4 for better shop experience and consistency
        'orderby' => $orderby,
        'order' => $order,
    );

    // If we have existing IDs, skip them and don't use 'paged' offset, 
    // just get the next $posts_per_page results that are NOT in the list.
    if (!empty($existing_ids)) {
        $args['post__not_in'] = array_map('absint', $existing_ids);
        $args['paged'] = 1; // Always get the "first" page of the remaining products
    } else {
        $args['paged'] = $paged;
    }

    if (!empty($category) || !empty($_POST['filter_size'])) {
        $args['tax_query'] = array('relation' => 'AND');
        
        if (!empty($category)) {
            $args['tax_query'][] = array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => $category,
            );
        }

        if (!empty($_POST['filter_size'])) {
            $args['tax_query'][] = array(
                'taxonomy' => 'pa_size',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_POST['filter_size']),
            );
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            wc_get_template_part('content', 'product');
        endwhile;
    else:
        // Optional: Send a signal that no more posts are available if needed, 
        // though empty response usually suffices for the JS handler.
        error_log("Load More AJAX: No products found.");
    endif;

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_green_burials_load_more', 'green_burials_load_more');
add_action('wp_ajax_nopriv_green_burials_load_more', 'green_burials_load_more');

/**
 * Handle Size Filter in Main Query
 */
function green_burials_handle_size_filter_query($query) {
    if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category() || is_product_tag())) {
        if (!empty($_GET['filter_size'])) {
            $tax_query = (array) $query->get('tax_query');
            $tax_query[] = array(
                'taxonomy' => 'pa_size',
                'field'    => 'slug',
                'terms'    => sanitize_text_field($_GET['filter_size']),
                'operator' => 'IN',
            );
            $query->set('tax_query', $tax_query);
        }

        // IMPORTANT: Match the posts_per_page used in the AJAX Load More script (20)
        // This prevents product duplication and ensures consistent page counts.
        $query->set( 'posts_per_page', 20 );
    }
}
add_action('pre_get_posts', 'green_burials_handle_size_filter_query');

/**
 * Utility: Clear All Caches / Transients
 * Trigger this by adding ?clear_all_caches=1 to any URL while logged in as admin.
 */
function green_burials_handle_cache_clearing() {
    if ( isset( $_GET['clear_all_caches'] ) && current_user_can( 'manage_options' ) ) {
        // 1. Flush WP Object Cache (Memcached/Redis)
        wp_cache_flush();
        
        // 2. Clear all transients from DB
        global $wpdb;
        $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%' OR option_name LIKE '_site_transient_%'" );
        
        // 3. Clear WooCommerce attribute lookup table / transients
        if ( function_exists( 'wc_delete_product_transients' ) ) {
            wc_delete_product_transients();
        }

        error_log( "Green Burials: All shop caches and transients cleared via URL trigger." );
        
        wp_die( '<h1>Caches Cleared Successfully</h1><p>Transients and object caches have been flushed. <a href="' . esc_url( remove_query_arg( 'clear_all_caches' ) ) . '">Return to site</a></p>' );
    }
}
add_action( 'init', 'green_burials_handle_cache_clearing' );

/**
 * Custom Breadcrumb Helper - Pill Style
 */
function green_burials_breadcrumb() {
    if (is_front_page()) return;

    echo '<div class="gb-breadcrumb-pill">';
    
    // Home Part with green background
    echo '<div class="breadcrumb-home-part">';
    echo '<a href="' . esc_url(home_url('/')) . '">';
    echo '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">';
    echo '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>';
    echo '<polyline points="9 22 9 12 15 12 15 22"></polyline>';
    echo '</svg>';
    echo '</a>';
    echo '</div>';

    // Text Part
    echo '<div class="breadcrumb-text-part">';
    
    $links = array();

    if (is_home() || is_archive() || is_single()) {
        if (is_home() || (is_archive() && !is_post_type_archive('product') && !is_tax('product_cat') && !is_tax('product_tag'))) {
            $links[] = '<span>BLOGS</span>';
        } elseif (is_single() && get_post_type() === 'post') {
            $links[] = '<a href="' . esc_url(get_post_type_archive_link('post')) . '">BLOG</a>';
            $links[] = '<span>' . strtoupper(get_the_title()) . '</span>';
        } elseif (is_post_type_archive('product') || is_shop()) {
            $links[] = '<span>SHOP</span>';
        } elseif (is_tax('product_cat')) {
            $links[] = '<span>' . strtoupper(single_term_title('', false)) . '</span>';
        } elseif (is_product()) {
            $links[] = '<span>' . strtoupper(get_the_title()) . '</span>';
        }
    } elseif (is_page()) {
        $links[] = '<span>' . strtoupper(get_the_title()) . '</span>';
    }

    if (!empty($links)) {
        echo implode('<span class="breadcrumb-sep">/</span>', $links);
    }

    echo '</div>';
    echo '</div>';
}

/**
 * Enqueue Blog Load More Script
 */
function green_burials_enqueue_blog_script() {
    if (is_home() || is_archive()) {
        wp_enqueue_script('green-burials-blog-load-more', get_template_directory_uri() . '/assets/js/blog-load-more.js', array(), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'green_burials_enqueue_blog_script');

/**
 * AJAX Load More Blog Posts
 */
function green_burials_load_more_posts() {
    $paged = isset($_POST['page']) ? absint($_POST['page']) : 1;

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 6, // Match the grid query in home.php
        'paged' => $paged,
        'offset' => 1 + (($paged - 1) * 6), // Account for the featured post offset (1) + pagination
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // Use the new template part
            get_template_part('template-parts/content', 'blog');
        endwhile;
    endif;

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_green_burials_load_more_posts', 'green_burials_load_more_posts');
add_action('wp_ajax_nopriv_green_burials_load_more_posts', 'green_burials_load_more_posts');

/**
 * Custom WooCommerce Registration Fields
 */

// Registration fields are now handled directly in form-login.php for better UI control

// Validate extra registration fields
function green_burials_validate_extra_register_fields( $validation_errors, $username, $email ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!', 'woocommerce' ) );
    }
    return $validation_errors;
}
add_filter( 'woocommerce_registration_errors', 'green_burials_validate_extra_register_fields', 10, 3 );

// Save extra registration fields
function green_burials_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['billing_first_name'] ) ) {
        update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    }
    if ( isset( $_POST['billing_last_name'] ) ) {
        update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }
    if ( isset( $_POST['newsletter_subscribe'] ) ) {
        update_user_meta( $customer_id, 'newsletter_subscribe', 'yes' );
    } else {
        update_user_meta( $customer_id, 'newsletter_subscribe', 'no' );
    }
}
add_action( 'woocommerce_created_customer', 'green_burials_save_extra_register_fields' );

/**
 * Access Control for My Account Subpages
 */
function green_burials_account_access_control() {
    if ( is_account_page() && ! is_user_logged_in() ) {
        global $wp_query;
        // Allow the main account page, lost password, and comparison
        if ( is_wc_endpoint_url() ) {
            $allowed_endpoints = array( 'lost-password', 'comparison' );
            $is_allowed = false;
            foreach ( $allowed_endpoints as $endpoint ) {
                if ( is_wc_endpoint_url( $endpoint ) ) {
                    $is_allowed = true;
                    break;
                }
            }
            
            // Extra check for custom 'comparison' query var
            if ( isset( $wp_query->query_vars['comparison'] ) ) {
                $is_allowed = true;
            }

            if ( ! $is_allowed ) {
                wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
                exit;
            }
        }
    }
}
add_action( 'template_redirect', 'green_burials_account_access_control' );

/**
 * Prevent WooCommerce from redirecting guests away from the Comparison endpoint
 */
add_action( 'template_redirect', function() {
    if ( is_account_page() && ! is_user_logged_in() && ( is_wc_endpoint_url( 'comparison' ) || isset( $_GET['comparison'] ) ) ) {
        remove_action( 'template_redirect', array( 'WC_Form_Handler', 'redirect_to_login_if_not_logged_in' ) );
    }
}, 5 );

/**
 * Wishlist and Compare Functionality
 */

function green_burials_normalize_wishlist_items($items) {
    if (!is_array($items)) {
        return array();
    }

    $clean = array();
    foreach ($items as $item) {
        $id = intval($item);
        if ($id > 0) {
            $clean[] = $id;
        }
    }

    return array_values(array_unique($clean));
}

function green_burials_get_current_wishlist_items() {
    $items = array();

    if ( is_user_logged_in() ) {
        /*
         * LOGGED-IN USERS: user meta is the SOLE source of truth.
         *
         * ❌ Old code merged cookie + meta on every read.
         *    Problem: after removing a product, the cookie could still hold the
         *    old ID. On the next page load the merge would add it back → product
         *    reappeared after reload.
         *
         * ✅ Fix: read ONLY user meta. The cookie is kept in sync on write
         *    (store function), but we never read it for logged-in users.
         */
        $user_id    = get_current_user_id();
        $user_items = get_user_meta( $user_id, 'gb_wishlist', true );
        if ( is_array( $user_items ) ) {
            foreach ( $user_items as $id ) {
                $items[] = intval( $id );
            }
        }
    } else {
        /*
         * GUEST USERS: cookie is the only store available.
         */
        if ( ! empty( $_COOKIE['gb_wishlist'] ) ) {
            $cookie_data = stripslashes( $_COOKIE['gb_wishlist'] );
            $decoded     = json_decode( $cookie_data, true );
            if ( is_array( $decoded ) ) {
                foreach ( $decoded as $id ) {
                    $items[] = intval( $id );
                }
            }
        }
    }

    return green_burials_normalize_wishlist_items( $items );
}

function green_burials_store_current_wishlist_items( $items ) {
    $items   = green_burials_normalize_wishlist_items( $items );
    $encoded = json_encode( $items );

    $path   = defined( 'COOKIEPATH' )    ? COOKIEPATH    : '/';
    $domain = defined( 'COOKIE_DOMAIN' ) ? COOKIE_DOMAIN : '';

    /*
     * httponly = FALSE  ← critical fix.
     * The old code set httponly=true, which blocks JavaScript from reading/
     * clearing the cookie. That means the stale cookie survived even after
     * PHP updated it, causing the reappear-on-reload bug for edge cases.
     *
     * samesite = Strict prevents CSRF while still allowing normal navigation.
     */
    $cookie_options = array(
        'expires'  => time() + ( 86400 * 30 ),
        'path'     => $path,
        'domain'   => $domain,
        'secure'   => is_ssl(),
        'httponly' => false,   // JS must be able to read + clear this cookie
        'samesite' => 'Strict',
    );

    if ( PHP_VERSION_ID >= 70300 ) {
        // PHP 7.3+: use array form (supports SameSite natively)
        setcookie( 'gb_wishlist', $encoded, $cookie_options );
    } else {
        // PHP < 7.3 fallback
        setcookie( 'gb_wishlist', $encoded, $cookie_options['expires'], $path, $domain, is_ssl(), false );
    }

    // Update the superglobal so the current request sees the new value immediately
    $_COOKIE['gb_wishlist'] = $encoded;

    // For logged-in users, user meta is the authoritative persistent store
    if ( is_user_logged_in() ) {
        update_user_meta( get_current_user_id(), 'gb_wishlist', $items );
    }

    // ── Auto-purge LiteSpeed Cache for the wishlist page ─────────────────────
    // Called on every write (add OR remove) so the cached page is always fresh.
    // LiteSpeed Cache plugin exposes these action hooks natively.
    green_burials_purge_wishlist_cache();

    return $items;
}

/**
 * Purge every known caching layer for the wishlist page.
 * Supports: LiteSpeed Cache plugin, WP Super Cache, W3 Total Cache, WP Rocket.
 * Safe to call even if none of those plugins are active.
 */
function green_burials_purge_wishlist_cache() {
    // 1. Find the wishlist page URL
    $wishlist_page = get_page_by_path( 'wishlist' );
    $wishlist_url  = $wishlist_page ? get_permalink( $wishlist_page->ID ) : home_url( '/wishlist/' );

    // 2. LiteSpeed Cache — purge by URL (most specific, least collateral)
    if ( class_exists( '\LiteSpeed\Purge' ) ) {
        do_action( 'litespeed_purge_url', $wishlist_url );
    }

    // 3. LiteSpeed Cache — purge by post ID (belt-and-suspenders)
    if ( $wishlist_page && has_action( 'litespeed_purge_post' ) ) {
        do_action( 'litespeed_purge_post', $wishlist_page->ID );
    }

    // 4. WP Super Cache
    if ( function_exists( 'wp_cache_post_change' ) && $wishlist_page ) {
        wp_cache_post_change( $wishlist_page->ID );
    }

    // 5. W3 Total Cache
    if ( function_exists( 'w3tc_pgcache_flush_url' ) ) {
        w3tc_pgcache_flush_url( $wishlist_url );
    }

    // 6. WP Rocket
    if ( function_exists( 'rocket_clean_post' ) && $wishlist_page ) {
        rocket_clean_post( $wishlist_page->ID );
    }
}

function green_burials_sync_wishlist_on_login($user_login, $user) {
    $cookie_items = array();
    if (isset($_COOKIE['gb_wishlist'])) {
        $cookie_items = json_decode(stripslashes($_COOKIE['gb_wishlist']), true);
    }

    $cookie_items = green_burials_normalize_wishlist_items($cookie_items);
    $stored_items = get_user_meta($user->ID, 'gb_wishlist', true);
    $stored_items = green_burials_normalize_wishlist_items($stored_items);

    $merged = green_burials_normalize_wishlist_items(array_merge($stored_items, $cookie_items));
    update_user_meta($user->ID, 'gb_wishlist', $merged);

    $encoded = json_encode($merged);
    setcookie('gb_wishlist', $encoded, time() + (86400 * 30), COOKIEPATH, COOKIE_DOMAIN);
    $_COOKIE['gb_wishlist'] = $encoded;
}
add_action('wp_login', 'green_burials_sync_wishlist_on_login', 10, 2);

// Add to Wishlist AJAX
function green_burials_add_to_wishlist() {
    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;

    if ( ! $product_id ) {
        wp_send_json_error( array( 'message' => 'Invalid Product ID' ) );
        return;
    }

    // --- Guest / Not Logged In ---
    // Return a specific error code so JavaScript can display the right message.
    if ( ! is_user_logged_in() ) {
        $product      = wc_get_product( $product_id );
        $product_name = $product ? $product->get_name() : 'this product';
        wp_send_json_error( array(
            'code'         => 'not_logged_in',
            'product_name' => $product_name,
            'message'      => sprintf(
                'You must log in or create an account to save %s to your wishlist!',
                $product_name
            ),
        ) );
        return;
    }

    // --- Logged-In User ---
    $wishlist = green_burials_get_current_wishlist_items();

    if ( ! in_array( $product_id, $wishlist ) ) {
        $wishlist[] = $product_id;
        $message    = 'Added to wishlist';
    } else {
        $message = 'Already in wishlist';
    }

    $wishlist = green_burials_store_current_wishlist_items( $wishlist );

    wp_send_json_success( array( 'message' => $message, 'count' => count( $wishlist ) ) );
}
add_action( 'wp_ajax_gb_add_to_wishlist',        'green_burials_add_to_wishlist' );
add_action( 'wp_ajax_nopriv_gb_add_to_wishlist', 'green_burials_add_to_wishlist' );

// Remove from Wishlist AJAX
function green_burials_remove_from_wishlist() {
    $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;

    if ( $product_id <= 0 ) {
        wp_send_json_error( array( 'message' => 'Invalid Product ID' ) );
        return;
    }

    /*
     * Read the wishlist, filter out the target ID, then write back.
     * Every ID is cast to int before comparison to prevent string/int mismatches
     * that could make the filter silently skip the item → product stays in list.
     */
    $wishlist     = green_burials_get_current_wishlist_items();
    $new_wishlist = array();
    $found        = false;

    foreach ( $wishlist as $id ) {
        $id = intval( $id );        // ← explicit cast, prevents type mismatch
        if ( $id === $product_id ) {
            $found = true;          // skip this one (remove it)
        } else {
            $new_wishlist[] = $id;
        }
    }

    /*
     * Always write back — even if $found is false.
     * This self-heals any desync between cookie and user meta:
     * both stores are overwritten with the clean list right now.
     */
    green_burials_store_current_wishlist_items( $new_wishlist );

    wp_send_json_success( array(
        'message'    => $found ? 'Product removed from wishlist' : 'Product was not in wishlist',
        'count'      => count( $new_wishlist ),
        'removed_id' => $product_id,
    ) );
}

add_action('wp_ajax_gb_remove_from_wishlist', 'green_burials_remove_from_wishlist');
add_action('wp_ajax_nopriv_gb_remove_from_wishlist', 'green_burials_remove_from_wishlist');

function green_burials_clear_wishlist_cookie() {
    setcookie('gb_wishlist', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);
    unset($_COOKIE['gb_wishlist']);
}

// Add to Compare AJAX
function green_burials_add_to_compare() {
    // check_ajax_referer('gb_ajax_nonce', 'security');
    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    
    if (!$product_id) {
        wp_send_json_error('Invalid Product ID');
    }

    $compare = isset($_COOKIE['gb_compare']) ? json_decode(stripslashes($_COOKIE['gb_compare']), true) : array();
    
    if (!is_array($compare)) {
        $compare = array();
    }

    if (!in_array($product_id, $compare)) {
        if (count($compare) >= 3) {
            wp_send_json_error('You can only compare up to 3 products.');
        }
        $compare[] = $product_id;
        setcookie('gb_compare', json_encode($compare), time() + (86400 * 30), COOKIEPATH, COOKIE_DOMAIN);
        wp_send_json_success(array('message' => 'Added to compare', 'count' => count($compare)));
    } else {
        wp_send_json_success(array('message' => 'Already in compare list', 'count' => count($compare)));
    }
}
add_action('wp_ajax_gb_add_to_compare', 'green_burials_add_to_compare');
add_action('wp_ajax_nopriv_gb_add_to_compare', 'green_burials_add_to_compare');

// Remove from Compare AJAX
function green_burials_remove_from_compare() {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    
    if (!$product_id) {
        wp_send_json_error('Invalid Product ID');
    }

    $cookie_data = isset($_COOKIE['gb_compare']) ? stripslashes($_COOKIE['gb_compare']) : '[]';
    $compare = json_decode($cookie_data, true);
    
    if (!is_array($compare)) {
        $compare = array();
    }

    $new_compare = array();
    $found = false;
    foreach ($compare as $id) {
        if (intval($id) === $product_id) {
            $found = true;
            continue;
        }
        $new_compare[] = intval($id);
    }

    // Explicitly sync cookie
    $encoded = json_encode(array_values($new_compare));
    $path = defined('COOKIEPATH') ? COOKIEPATH : '/';
    $domain = defined('COOKIE_DOMAIN') ? COOKIE_DOMAIN : '';
    setcookie('gb_compare', $encoded, time() + (86400 * 30), $path, $domain, is_ssl(), true);
    $_COOKIE['gb_compare'] = $encoded;

    wp_send_json_success(array(
        'message' => $found ? 'Removed' : 'Already removed',
        'count' => count($new_compare)
    ));
}
add_action('wp_ajax_gb_remove_from_compare', 'green_burials_remove_from_compare');
add_action('wp_ajax_nopriv_gb_remove_from_compare', 'green_burials_remove_from_compare');

// Register Wishlist and Compare Pages on activation
function green_burials_register_feature_pages() {
    $pages = array(
        'wishlist' => 'Wishlist',
        'compare' => 'Compare'
    );
    
    foreach ($pages as $slug => $title) {
        if (!get_page_by_path($slug)) {
            wp_insert_post(array(
                'post_title' => $title,
                'post_name' => $slug,
                'post_status' => 'publish',
                'post_type' => 'page',
                'post_content' => '', // Handled by page templates
            ));
        }
    }
}
add_action('after_switch_theme', 'green_burials_register_feature_pages');

/**
 * AJAX handler for fetching cart info after adding to cart
 */
function green_burials_get_cart_info_after_add() {
    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    
    if (!$product_id) {
        wp_send_json_error('Invalid product ID');
    }
    
    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error('Product not found');
    }
    
    $cart = WC()->cart;
    
    $snapshot = green_burials_get_cart_snapshot();
    
    $data = array(
        'name' => $product->get_name(),
        'image' => get_the_post_thumbnail_url($product_id, 'medium'),
        'price' => $product->get_price_html(),
        'subtotal' => $snapshot['subtotal_html'],
        'count' => $snapshot['count'],
    );
    
    wp_send_json_success($data);
}
add_action('wp_ajax_gb_get_cart_info', 'green_burials_get_cart_info_after_add');
add_action('wp_ajax_nopriv_gb_get_cart_info', 'green_burials_get_cart_info_after_add');
/**
 * My Account: Comparison Tab
 */

// 1. Register Endpoint
function green_burials_add_comparison_endpoint() {
    add_rewrite_endpoint( 'comparison', EP_PAGES );
    
    // Dynamic slug for better compatibility
    $account_id = function_exists('wc_get_page_id') ? wc_get_page_id('myaccount') : 0;
    $account_slug = $account_id ? get_post_field('post_name', $account_id) : 'my-account';
    
    add_rewrite_rule( '^' . $account_slug . '/comparison/?$', 'index.php?pagename=' . $account_slug . '&comparison=1', 'top' );
}
add_action( 'init', 'green_burials_add_comparison_endpoint' );

// 1.1 Register query vars (Global and WooCommerce)
add_filter( 'query_vars', function( $vars ) {
    $vars[] = 'comparison';
    return $vars;
}, 0 );

function green_burials_add_query_vars( $vars ) {
    $vars['comparison'] = 'comparison';
    return $vars;
}
add_filter( 'woocommerce_get_query_vars', 'green_burials_add_query_vars' );

// 1.2 Flush Rules once if missing
add_action( 'init', function() {
    if ( ! get_option( 'gb_comparison_flushed_v3' ) || isset( $_GET['flush_gb_rules'] ) ) {
        green_burials_add_comparison_endpoint();
        flush_rewrite_rules();
        update_option( 'gb_comparison_flushed_v3', 1 );
        if ( isset( $_GET['flush_gb_rules'] ) ) {
            echo 'Permalinks Flushed!';
        }
    }
}, 20 );

// 2. Add to Account Menu
function green_burials_add_comparison_link_my_account( $items ) {
    // Add Comparison after Dashboard or at the end
    $new_items = array();
    foreach ( $items as $key => $value ) {
        $new_items[$key] = $value;
        if ( 'dashboard' === $key ) {
            $new_items['comparison'] = __( 'Comparison', 'green-burials' );
        }
    }
    
    // If dashboard wasn't found, just append it
    if ( ! isset( $new_items['comparison'] ) ) {
        $new_items['comparison'] = __( 'Comparison', 'green-burials' );
    }
    
    return $new_items;
}
add_filter( 'woocommerce_account_menu_items', 'green_burials_add_comparison_link_my_account' );

// 3. Endpoint Content
function green_burials_comparison_content() {
    // Fallback: Handle removal via URL parameter if AJAX fails
    if (isset($_GET['remove-compare'])) {
        $remove_id = intval($_GET['remove-compare']);
        $cookie_data = isset($_COOKIE['gb_compare']) ? stripslashes($_COOKIE['gb_compare']) : '[]';
        $compare = json_decode($cookie_data, true);
        if (is_array($compare)) {
            $compare = array_map('intval', $compare);
            $key = array_search($remove_id, $compare);
            if ($key !== false) {
                unset($compare[$key]);
                $compare = array_values($compare);
                setcookie('gb_compare', json_encode($compare), time() + (86400 * 30), COOKIEPATH, COOKIE_DOMAIN);
                wp_redirect(remove_query_arg('remove-compare'));
                exit;
            }
        }
    }

    $compare_ids = isset($_COOKIE['gb_compare']) ? json_decode(stripslashes($_COOKIE['gb_compare']), true) : array();
    
    if (empty($compare_ids)) {
        echo '<div class="woocommerce-info">' . __('You have no products to compare.', 'green-burials') . ' <a class="button" href="' . esc_url(wc_get_page_permalink('shop')) . '">' . __('Go Shop', 'green-burials') . '</a></div>';
        return;
    }

    $products = array();
    foreach ($compare_ids as $id) {
        $product = wc_get_product($id);
        if ($product) {
            $products[] = $product;
        }
    }

    if (empty($products)) {
        echo '<div class="woocommerce-info">' . __('Comparison list is empty.', 'green-burials') . '</div>';
        return;
    }

    ?>
    <div class="product-comparison-wrapper">
        <header class="compare-page-header">
            <h2 class="compare-title"><?php _e('Product Comparison', 'green-burials'); ?></h2>
        </header>

        <div class="compare-table-responsive">
            <table class="compare-table">
            <thead>
                <tr>
                    <th colspan="<?php echo count($products) + 1; ?>"><?php _e('Product Details', 'green-burials'); ?></th>
                </tr>
            </thead>
            <tbody>
                <!-- Product Name -->
                <tr class="prop-row product-name-row">
                    <td class="prop-label"><?php _e('Product', 'green-burials'); ?></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value"><strong><?php echo $product->get_name(); ?></strong></td>
                    <?php endforeach; ?>
                </tr>
                <!-- Image -->
                <tr class="prop-row product-image-row">
                    <td class="prop-label"><?php _e('Image', 'green-burials'); ?></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value">
                            <div class="compare-img-box">
                                <?php echo $product->get_image('thumbnail'); ?>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <!-- Price -->
                <tr class="prop-row product-price-row">
                    <td class="prop-label"><?php _e('Price', 'green-burials'); ?></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value price-cell"><?php echo $product->get_price_html(); ?></td>
                    <?php endforeach; ?>
                </tr>
                <!-- Model (SKU) -->
                <tr class="prop-row product-model-row">
                    <td class="prop-label"><?php _e('Model', 'green-burials'); ?></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value"><?php echo $product->get_sku() ? $product->get_sku() : 'N/A'; ?></td>
                    <?php endforeach; ?>
                </tr>
                <!-- Brand (e.g., Category) -->
                <tr class="prop-row product-brand-row">
                    <td class="prop-label"><?php _e('Brand', 'green-burials'); ?></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value"><?php echo wc_get_product_category_list($product->get_id(), ', ', '', ''); ?></td>
                    <?php endforeach; ?>
                </tr>
                <!-- Availability -->
                <tr class="prop-row product-stock-row">
                    <td class="prop-label"><?php _e('Availability', 'green-burials'); ?></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value"><?php echo $product->is_in_stock() ? __('In Stock', 'green-burials') : __('Out of Stock', 'green-burials'); ?></td>
                    <?php endforeach; ?>
                </tr>
                <!-- Summary -->
                <tr class="prop-row product-summary-row">
                    <td class="prop-label"><?php _e('Summary', 'green-burials'); ?></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value summary-cell"><?php echo wp_trim_words($product->get_short_description(), 20); ?></td>
                    <?php endforeach; ?>
                </tr>
                <!-- Weight -->
                <tr class="prop-row product-weight-row">
                    <td class="prop-label"><?php _e('Weight', 'green-burials'); ?></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value"><?php echo $product->get_weight() ? $product->get_weight() . ' ' . get_option('woocommerce_weight_unit') : 'N/A'; ?></td>
                    <?php endforeach; ?>
                </tr>
                <!-- Dimensions -->
                <tr class="prop-row product-dims-row">
                    <td class="prop-label"><?php _e('Dimensions', 'green-burials'); ?></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value"><?php echo $product->get_dimensions() ? $product->get_dimensions() : 'N/A'; ?></td>
                    <?php endforeach; ?>
                </tr>
                <!-- Actions -->
                <tr class="prop-row product-actions-row">
                    <td class="prop-label"></td>
                    <?php foreach ($products as $product) : ?>
                        <td class="prop-value action-cell">
                            <div class="compare-actions-btngroup">
                                <a href="?add-to-cart=<?php echo $product->get_id(); ?>" class="button add_to_cart_button ajax_add_to_cart" data-product-id="<?php echo $product->get_id(); ?>"><?php _e('ADD TO CART', 'green-burials'); ?></a>
                                <a href="<?php echo esc_url(add_query_arg('remove-compare', $product->get_id())); ?>" class="remove-compare-item" data-product-id="<?php echo $product->get_id(); ?>"><?php _e('REMOVE', 'green-burials'); ?></a>
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    <?php
}
add_action( 'woocommerce_account_comparison_endpoint', 'green_burials_comparison_content' );

// Flush rewrite rules for comparison endpoint
function green_burials_flush_rewrite_rules() {
    green_burials_add_comparison_endpoint();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'green_burials_flush_rewrite_rules' );
/**
 * Remove default WooCommerce flat rate shipping methods.
 */
add_filter( 'woocommerce_package_rates', 'gb_remove_default_flat_rate', 5, 2 );
function gb_remove_default_flat_rate( $rates, $package ) {
    foreach ( $rates as $key => $rate ) {
        if ( $rate->get_method_id() === 'flat_rate' && 
             is_numeric( $rate->get_instance_id() ) ) {
            unset( $rates[ $key ] );
        }
    }
    return $rates;
}

/**
 * Custom Shipping Rates and Notices
 */
function green_burials_custom_shipping_logic( $rates, $package ) {
    // 0. FREE GROUND SHIPPING
    $rates['free_ground_shipping'] = new WC_Shipping_Rate( 
        'free_ground_shipping', 
        __( 'FREE GROUND SHIPPING', 'green-burials' ), 
        0, 
        array(), 
        'flat_rate' 
    );

    // 1. FLAT-RATE FOR 2ND DAY ($35)
    $rates['flat_rate_2nd_day'] = new WC_Shipping_Rate( 
        'flat_rate_2nd_day', 
        __( 'FLAT-RATE FOR 2ND DAY', 'green-burials' ), 
        35, 
        array(), 
        'flat_rate' 
    );

    // 2. Standard Overnight Delivering ($80)
    $rates['standard_overnight'] = new WC_Shipping_Rate( 
        'standard_overnight', 
        __( 'Standard Overnight Delivering', 'green-burials' ), 
        80, 
        array(), 
        'flat_rate' 
    );

    return $rates;
}
add_filter( 'woocommerce_package_rates', 'green_burials_custom_shipping_logic', 10, 2 );

/**
 * Display specific Shipping Info on Single Product Page
 */
function green_burials_display_shipping_info_single() {
    global $product;
    if ( ! $product ) return;

    $is_casket = false;
    $terms = get_the_terms( $product->get_id(), 'product_cat' );
    if ( $terms && ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            if ( stripos( $term->name, 'casket' ) !== false ) {
                $is_casket = true;
                break;
            }
        }
    }

    echo '<div class="product-shipping-details-box">';
    echo '<div class="shipping-rate-line"><strong>FREE GROUND SHIPPING</strong></div>';
    echo '<div class="shipping-notice-line">Within The Contiguous U.S. = Shipments Usually Processed Within 48 Hours Of Purchase.</div>';
    echo '<div class="shipping-divider"></div>';
    echo '<div class="shipping-rate-line"><strong>FLAT-RATE FOR 2ND DAY ($35)</strong></div>';
    echo '<div class="shipping-rate-line"><strong>Standard Overnight Delivering ($80)</strong></div>';
    
    if ( $is_casket ) {
        echo '<div class="casket-shipping-warning">(Caskets, Shipping Not Supported Rates Additional)</div>';
    }
    
    echo '<div class="intl-shipping-notice">Please Call For All International Shipments</div>';
    echo '</div>';
}
// add_action( 'woocommerce_single_product_summary', 'green_burials_display_shipping_info_single', 35 );

/**
 * Enable menu_order support for WooCommerce product categories
 * This allows categories to be sorted by the "Menu Order" field in admin
 */
add_filter('get_terms_args', 'green_burials_enable_category_menu_order', 10, 2);
function green_burials_enable_category_menu_order($args, $taxonomies) {
    // Only apply to product_cat taxonomy
    if (in_array('product_cat', (array) $taxonomies)) {
        // If orderby is set to menu_order, we need to handle it
        if (isset($args['orderby']) && $args['orderby'] === 'menu_order') {
            // Get terms with their order meta
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'order';
        }
    }
    return $args;
}

/**
 * Alternative: Force product category ordering by menu order
 */
add_filter('woocommerce_product_categories_widget_args', 'green_burials_category_widget_order');
function green_burials_category_widget_order($args) {
    $args['orderby'] = 'meta_value_num';
    $args['meta_key'] = 'order';
    $args['order'] = 'ASC';
    return $args;
}

// =============================================================================
// CUSTOM CHECKOUT TEMPLATE — FORCE OVERRIDE (Local + Live)
// =============================================================================

/**
 * Hook 1: woocommerce_locate_template
 * Forces WooCommerce to load our custom form-checkout.php from the theme,
 * overriding any plugin that tries to hijack the checkout template.
 */
add_filter( 'woocommerce_locate_template', 'gb_force_custom_checkout_template', 20, 3 );
function gb_force_custom_checkout_template( $template, $template_name, $template_path ) {
    // Only intercept the checkout form template
    if ( $template_name !== 'checkout/form-checkout.php' ) {
        return $template;
    }
    $custom = get_stylesheet_directory() . '/woocommerce/checkout/form-checkout.php';
    if ( file_exists( $custom ) ) {
        return $custom;
    }
    return $template;
}

/**
 * Hook 2: wc_get_template_part
 * Catches WooCommerce template-part loading as a secondary safety net.
 */
add_filter( 'wc_get_template_part', 'gb_force_custom_checkout_template_part', 20, 3 );
function gb_force_custom_checkout_template_part( $template, $slug, $name ) {
    if ( $slug === 'checkout' && ( $name === 'form-checkout' || $name === '' ) ) {
        $custom = get_stylesheet_directory() . '/woocommerce/checkout/form-checkout.php';
        if ( file_exists( $custom ) ) {
            return $custom;
        }
    }
    return $template;
}

/**
 * Hook 3: woocommerce_before_checkout_form (priority 1)
 * Clears any competing content that might have been added before our form.
 */
add_action( 'woocommerce_checkout_init', 'gb_checkout_init_debug', 1 );
function gb_checkout_init_debug( $checkout ) {
    // Ensure WooCommerce registers our theme as having a template override
    // by confirming the template directory is correct.
    if ( ! defined( 'GB_CHECKOUT_OVERRIDE' ) ) {
        define( 'GB_CHECKOUT_OVERRIDE', true );
    }
}

/**
 * Hook 4: template_include (nuclear option)
 * If the checkout page loads but doesn't show our custom form,
 * this forces the entire WooCommerce checkout flow through our theme.
 */
add_filter( 'template_include', 'gb_force_checkout_page_template', 99 );
function gb_force_checkout_page_template( $template ) {
    if ( ! is_checkout() || is_wc_endpoint_url( 'order-received' ) || is_wc_endpoint_url( 'order-pay' ) ) {
        return $template;
    }
    // Look for a custom page template in the theme
    $theme_checkout = get_stylesheet_directory() . '/page-checkout.php';
    if ( file_exists( $theme_checkout ) ) {
        return $theme_checkout;
    }
    return $template;
}

/**
 * Hook 5: Remove plugins that may override checkout template
 * Strips common page-builder / checkout-plugin overrides so our
 * woocommerce/checkout/form-checkout.php always wins.
 */
add_action( 'wp', 'gb_protect_checkout_from_plugin_overrides', 1 );
function gb_protect_checkout_from_plugin_overrides() {
    if ( ! is_checkout() ) return;

    // Remove Elementor Pro WooCommerce checkout override (if active)
    remove_filter( 'woocommerce_locate_template', 'elementor_pro_woocommerce_locate_template', 10 );

    // Remove WooCommerce Checkout Add-Ons or similar overrides
    remove_filter( 'woocommerce_locate_template', 'wc_checkout_addons_locate_template', 10 );

    // Remove any "override" added by checkout customizer plugins at priority ≤ 10
    // Our hook at priority 20 in Hook 1 above will still run after these are removed.
}

/**
 * Hook 6: wc_get_template (filter for older WooCommerce versions)
 * Targets the lower-level template loading function directly.
 */
add_filter( 'wc_get_template', 'gb_wc_get_template_override', 20, 5 );
function gb_wc_get_template_override( $located, $template_name, $args, $template_path, $default_path ) {
    if ( $template_name !== 'checkout/form-checkout.php' ) {
        return $located;
    }
    $custom = get_stylesheet_directory() . '/woocommerce/checkout/form-checkout.php';
    if ( file_exists( $custom ) ) {
        return $custom;
    }
    return $located;
}


//gagan hook
/* 
 * Sync WooCommerce Main Price & Ex Tax 
 * With EPO Final Total (Override Disabled Safe Version)
 */

add_action('wp_footer', 'gb_manual_price_sync', 100);
function gb_manual_price_sync() {

    if ( ! is_product() ) return;
    ?>
    
    <script>
    jQuery(function($){

        function updatePrice() {

            // Get Final Total amount
            var finalAmount = $('.tm-epo-totals .amount').last().html();

            if(!finalAmount) return;

            // Update Main Price
            $('.price-main .woocommerce-Price-amount.amount').html(finalAmount);

            // Update Ex Tax
            $('.price-ex-tax .woocommerce-Price-amount.amount').html(finalAmount);
        }

        // Run on load
        setTimeout(updatePrice, 300);

        // Run when options change
        $(document).on('change', '.tmcp-field, select, input', function(){
            setTimeout(updatePrice, 200);
        });

    });
    </script>

    <?php
}
// =============================================================================
// END CUSTOM CHECKOUT TEMPLATE OVERRIDE
// =============================================================================

// =============================================================================
// PayPal / Venmo product-page checkout bypass fix
//
// PROBLEM: The WooCommerce PayPal Payments plugin renders "Pay with PayPal"
//   and "Pay with Venmo" smart buttons directly on the single-product page.
//   Clicking them triggers PayPal's Express Checkout flow: the product is
//   silently added to the cart and the user is sent to PayPal without ever
//   seeing — let alone filling — the WooCommerce billing/shipping form.
//   Orders therefore arrive with no customer address data.
//
// ROOT CAUSE (confirmed in CreateOrderEndpoint::handle_request()):
//   Early/basic form validation only runs when $data['context'] === 'checkout'.
//   When context is 'product', zero validation is performed server-side.
//
// FIX — three layers:
//
//   Layer 1 (JS / front-end):
//     Filter `woocommerce_paypal_payments_localized_script_data` to set
//     `single_product_buttons_enabled = false` on product pages. The PPCP JS
//     reads this flag and skips rendering the buttons entirely.
//
//   Layer 2 (Server-side safety net):
//     Hook into `woocommerce_paypal_payments_create_order_request_started`
//     (fires at the very top of CreateOrderEndpoint::handle_request() before
//     any order is created). If the request context is 'product' or
//     'mini-cart', immediately return a JSON error — no PayPal order is
//     created and the user sees a redirect-to-checkout message.
//
//   Layer 3 (Checkout-page validation):
//     On the checkout page, force both PPCP checkout-validation flags to true
//     so the PPCP JS calls ValidateCheckoutEndpoint (which runs WC's own
//     validate_checkout()) before creating a PayPal order. This ensures all
//     required billing/shipping fields are present before PayPal is invoked.
// =============================================================================

function gb_enforce_checkout_before_paypal( array $data ): array {
    if ( is_product() ) {
        $data['single_product_buttons_enabled'] = false;
    }

    if ( is_checkout() ) {
        $data['basic_checkout_validation_enabled'] = true;
        $data['early_checkout_validation_enabled'] = true;
    }

    return $data;
}
add_filter( 'woocommerce_paypal_payments_localized_script_data', 'gb_enforce_checkout_before_paypal' );

function gb_block_paypal_product_page_order( array $data ): void {
    $context = $data['context'] ?? '';

    if ( in_array( $context, [ 'product', 'mini-cart' ], true ) ) {
        wp_send_json_error( [
            'name'    => 'validation-error',
            'message' => __( 'Please add the product to your cart and complete the checkout form before paying with PayPal.', 'woocommerce' ),
            'code'    => 0,
            'details' => [],
        ] );
    }
}

// =============================================================================
// ISSUE 2 — Force shipping address fields required + server-side validation
// =============================================================================

/**
 * Make every shipping address field required in the checkout form.
 */
add_filter( 'woocommerce_checkout_fields', 'gb_force_shipping_fields_required' );
function gb_force_shipping_fields_required( $fields ) {
    $required_keys = [
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address_1',
        'shipping_city',
        'shipping_state',
        'shipping_postcode',
        'shipping_country',
    ];
    foreach ( $required_keys as $key ) {
        if ( isset( $fields['shipping'][ $key ] ) ) {
            $fields['shipping'][ $key ]['required'] = true;
        }
    }
    return $fields;
}

/**
 * Server-side guard: reject checkout submission if any shipping field is empty.
 */
add_action( 'woocommerce_checkout_process', 'gb_validate_shipping_fields_server_side' );
function gb_validate_shipping_fields_server_side() {
    $required = [
        'shipping_first_name' => 'Shipping First Name',
        'shipping_last_name'  => 'Shipping Last Name',
        'shipping_address_1'  => 'Shipping Address',
        'shipping_city'       => 'Shipping City',
        'shipping_state'      => 'Shipping State / County',
        'shipping_postcode'   => 'Shipping Postcode / ZIP',
        'shipping_country'    => 'Shipping Country',
    ];
    foreach ( $required as $key => $label ) {
        if ( empty( $_POST[ $key ] ) ) {
            /* translators: %s field label */
            wc_add_notice( sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . $label . '</strong>' ), 'error' );
        }
    }
}

// =============================================================================
// ISSUE 3 — Block PayPal / express payments from bypassing checkout validation
// =============================================================================

/**
 * Remove all PayPal SDK button components when outside the checkout page.
 * This prevents smart-button / express checkout from appearing on cart/product pages.
 */
add_filter( 'woocommerce_paypal_payments_sdk_components_hook', 'gb_disable_paypal_express_outside_checkout' );
function gb_disable_paypal_express_outside_checkout( $components ) {
    if ( ! is_checkout() ) {
        return [];
    }
    return $components;
}

/**
 * Remove PayPal express buttons from cart and mini-cart in the init hook,
 * after the plugin has had a chance to register its own actions.
 */
add_action( 'init', 'gb_remove_paypal_express_cart_buttons', 20 );
function gb_remove_paypal_express_cart_buttons() {
    remove_action( 'woocommerce_cart_actions', 'paypal_express_checkout_button_on_cart' );
    remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
}

/**
 * Server-side checkout validation for express / PayPal payment methods.
 * Runs on woocommerce_checkout_process (before order creation).
 */
add_action( 'woocommerce_checkout_process', 'gb_validate_fields_for_express_payments' );
function gb_validate_fields_for_express_payments() {
    $method = isset( $_POST['payment_method'] ) ? sanitize_key( $_POST['payment_method'] ) : '';
    $express_methods = [ 'ppcp-gateway', 'paypal', 'ppec_paypal', 'stripe', 'apple-pay', 'google-pay' ];

    if ( ! in_array( $method, $express_methods, true ) ) {
        return;
    }

    $required = [
        'billing_first_name'  => 'Billing First Name',
        'billing_last_name'   => 'Billing Last Name',
        'billing_address_1'   => 'Billing Address',
        'billing_city'        => 'Billing City',
        'billing_postcode'    => 'Billing Postcode / ZIP',
        'billing_country'     => 'Billing Country',
        'billing_email'       => 'Billing Email Address',
        'shipping_first_name' => 'Shipping First Name',
        'shipping_last_name'  => 'Shipping Last Name',
        'shipping_address_1'  => 'Shipping Address',
        'shipping_city'       => 'Shipping City',
        'shipping_postcode'   => 'Shipping Postcode / ZIP',
        'shipping_country'    => 'Shipping Country',
    ];
    foreach ( $required as $key => $label ) {
        if ( empty( $_POST[ $key ] ) ) {
            wc_add_notice( sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . $label . '</strong>' ), 'error' );
        }
    }
}

/**
 * Last-resort guard: if an order reaches the database without billing or
 * shipping address, cancel it immediately and bounce the customer back.
 */
add_action( 'woocommerce_checkout_order_processed', 'gb_block_order_if_address_missing', 10, 3 );
function gb_block_order_if_address_missing( $order_id, $posted_data, $order ) {
    if ( empty( $order->get_shipping_address_1() ) || empty( $order->get_billing_address_1() ) ) {
        $order->update_status( 'cancelled', 'Auto-cancelled: missing billing or shipping address.' );
        wc_add_notice( __( 'Your order could not be placed. Please enter your full billing and shipping address.', 'woocommerce' ), 'error' );
        wp_safe_redirect( wc_get_checkout_url() );
        exit;
    }
}
add_action( 'woocommerce_paypal_payments_create_order_request_started', 'gb_block_paypal_product_page_order' );

// ============================================================================
// SMART SHIPPING LABEL RESOLVER
//
// Problem: When shipping is provided as a product add-on option (e.g.
// "Ground Shipping Included") rather than a real WooCommerce shipping-zone
// method, $order->get_shipping_method() returns empty and the PDF invoice
// shows a blank Shipping Method field.
//
// This function checks multiple sources in priority order:
//   1. Real WooCommerce shipping line items (standard method)
//   2. get_shipping_method() string fallback
//   3. Product add-on meta containing shipping-related keywords
//   4. _shipping_method_title order meta
//
// The function is used by:
//   - The theme's PDF invoice template (woocommerce/pdf/Simple/invoice.php)
//   - woocommerce_order_shipping_method filter (WP-Admin order detail page)
//   - woocommerce_email_order_meta_fields filter (order confirmation emails)
// ============================================================================

/**
 * Smart shipping label resolver.
 *
 * @param  WC_Order $order
 * @return string   Human-readable shipping label, or 'N/A'.
 */
function get_invoice_shipping_label( $order ) {
    if ( ! $order ) {
        return 'N/A';
    }

    // SOURCE 1: Real WooCommerce shipping line items.
    foreach ( $order->get_items( 'shipping' ) as $item ) {
        if ( $item->get_name() ) {
            return $item->get_name();
        }
    }

    // SOURCE 2: get_shipping_method() string fallback.
    $method = $order->get_shipping_method();
    if ( ! empty( $method ) ) {
        return $method;
    }

    // SOURCE 3: Scan product add-on meta for shipping-related keywords.
    // Catches values like "Ground Shipping Included", "Overnight +$250", etc.
    $keywords = array( 'shipping', 'overnight', 'ground', 'express', 'delivery', '2nd day', 'expedited', 'freight' );

    foreach ( $order->get_items() as $item ) {
        // Check the product name itself.
        $product_name = strtolower( $item->get_name() );
        foreach ( $keywords as $kw ) {
            if ( strpos( $product_name, $kw ) !== false ) {
                return $item->get_name();
            }
        }

        // Check every meta entry on the item (product add-on fields).
        foreach ( $item->get_meta_data() as $meta ) {
            // Skip internal (underscore-prefixed) keys.
            if ( empty( $meta->key ) || substr( (string) $meta->key, 0, 1 ) === '_' ) {
                continue;
            }
            $key   = strtolower( (string) $meta->key );
            $value = strtolower( is_array( $meta->value ) ? implode( ' ', $meta->value ) : (string) $meta->value );
            foreach ( $keywords as $kw ) {
                if ( stripos( $key, $kw ) !== false || stripos( $value, $kw ) !== false ) {
                    // Return in "Label: Value" format.
                    $display_value = is_array( $meta->value ) ? implode( ', ', $meta->value ) : (string) $meta->value;
                    return $meta->key . ': ' . $display_value;
                }
            }
        }
    }

    // SOURCE 4: Direct order meta fallback.
    $m = $order->get_meta( '_shipping_method_title' );
    if ( ! empty( $m ) ) {
        return $m;
    }

    return 'N/A';
}

/**
 * Fix empty Shipping Method line in WooCommerce order confirmation emails.
 */
add_filter( 'woocommerce_email_order_meta_fields', 'gb_fix_shipping_in_email', 10, 3 );
function gb_fix_shipping_in_email( $fields, $sent_to_admin, $order ) {
    if ( empty( $order->get_shipping_method() ) ) {
        $fields['shipping_method'] = array(
            'label' => __( 'Shipping Method', 'woocommerce' ),
            'value' => get_invoice_shipping_label( $order ),
        );
    }
    return $fields;
}