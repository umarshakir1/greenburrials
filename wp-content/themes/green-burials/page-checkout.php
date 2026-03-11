<?php
/**
 * Template Name: Custom Checkout Page
 * Description: Full custom checkout page — use this template on the WooCommerce Checkout page.
 *
 * HOW TO USE ON LOCAL OR LIVE SITE:
 * 1. Go to WordPress Admin → Pages → Checkout
 * 2. On the right sidebar, under "Page Attributes" → "Template"
 * 3. Select "Custom Checkout Page"
 * 4. Click Update/Publish
 * That's it — no other settings needed.
 */

// Redirect to shop if WooCommerce is not active
if ( ! class_exists( 'WooCommerce' ) ) {
    wp_redirect( home_url( '/' ) );
    exit;
}

// If cart is empty, determine where to send the user.
// WooCommerce empties the cart BEFORE payment processing, so if payment fails
// the cart is empty but there is a pending order in the session. Redirect to
// the order pay page so the customer sees the error and can retry — not to shop.
if ( function_exists( 'WC' ) && WC()->cart && WC()->cart->is_empty() ) {
    $order_id = WC()->session ? absint( WC()->session->get( 'order_awaiting_payment' ) ) : 0;
    if ( $order_id ) {
        $order = wc_get_order( $order_id );
        if ( $order && $order->needs_payment() ) {
            wp_redirect( $order->get_checkout_payment_url() );
            exit;
        }
    }
    // Truly empty cart with no pending order — send to shop.
    wp_redirect( wc_get_page_permalink( 'shop' ) );
    exit;
}

// Manually enqueue checkout CSS/JS since this is a page template (not relying on is_checkout())
add_action( 'wp_enqueue_scripts', function() {
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    $css_path = $theme_dir . '/assets/css/custom-checkout.css';
    $js_path  = $theme_dir . '/assets/js/custom-checkout.js';

    wp_enqueue_style(
        'green-burials-checkout',
        $theme_uri . '/assets/css/custom-checkout.css',
        array( 'green-burials-style' ),
        file_exists( $css_path ) ? filemtime( $css_path ) : '1.0'
    );

    wp_enqueue_script(
        'green-burials-checkout',
        $theme_uri . '/assets/js/custom-checkout.js',
        array( 'jquery', 'wc-checkout' ),
        file_exists( $js_path ) ? filemtime( $js_path ) : '1.0',
        true
    );
}, 5 );

get_header();
?>

<div class="checkout-page-wrapper">

    <!-- Page Hero Banner -->
    <div class="contact-hero">
        <div class="container">
            <h1 class="contact-title">Checkout</h1>
        </div>
    </div>

    <!-- Checkout Content -->
    <div class="checkout-content-area">
        <div class="container">

            <?php
            // Show WooCommerce notices (errors, info)
            if ( function_exists( 'wc_print_notices' ) ) {
                wc_print_notices();
            }

            // Bootstrap the WooCommerce checkout object
            $checkout = WC()->checkout();

            // Load our custom form-checkout.php from the theme
            $custom_template = get_template_directory() . '/woocommerce/checkout/form-checkout.php';

            if ( file_exists( $custom_template ) ) {
                // Pass the $checkout variable exactly as WooCommerce does
                include $custom_template;
            } else {
                // Fallback: use WooCommerce's built-in shortcode
                echo do_shortcode( '[woocommerce_checkout]' );
            }
            ?>

        </div>
    </div>

</div>

<?php get_footer(); ?>
