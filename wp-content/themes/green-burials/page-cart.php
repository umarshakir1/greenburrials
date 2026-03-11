<?php
/**
 * Template Name: Custom Cart Page
 * Description: Cart page with hero banner — same style as Information page.
 *
 * HOW TO ACTIVATE:
 * 1. WordPress Admin → Pages → Cart
 * 2. Right sidebar → Page Attributes → Template → "Custom Cart Page"
 * 3. Click Update
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    wp_redirect( home_url( '/' ) );
    exit;
}

get_header();
?>

<div class="cart-page-wrapper">

    <!-- Hero Banner (same as Information & Checkout pages) -->
    <div class="contact-hero">
        <div class="container">
            <h1 class="contact-title">Your Cart</h1>
        </div>
    </div>

    <!-- Cart Content — uses same outer padding as WooCommerce default, no extra constraints -->
    <div class="woocommerce-page-content">
        <div class="container">
            <?php echo do_shortcode( '[woocommerce_cart]' ); ?>
        </div>
    </div>

</div>

<style>
/* Only add vertical breathing room — do NOT touch width/float/flex
   so WooCommerce cart table + totals stay side-by-side */
.woocommerce-page-content {
    padding: 3rem 0 5rem;
}
</style>

<?php get_footer(); ?>
