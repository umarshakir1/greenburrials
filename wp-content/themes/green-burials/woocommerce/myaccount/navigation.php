<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<div class="account-sidebar">
    <ul class="account-nav-list">
        <?php if ( ! is_user_logged_in() ) : ?>
            <li class="<?php echo ( is_account_page() && ! is_wc_endpoint_url() ) ? 'active' : ''; ?>"><a href="<?php echo wc_get_page_permalink('myaccount'); ?>">Login</a></li>
            <li><a href="#" id="sidebarRegister">Register</a></li>
            <li><a href="<?php echo wp_lostpassword_url(); ?>">Forgotten Password</a></li>
        <?php else : ?>
            <li><a href="<?php echo esc_url( wc_logout_url() ); ?>">Logout</a></li>
        <?php endif; ?>
        
        <li class="<?php echo is_wc_endpoint_url('edit-account') ? 'active' : ''; ?>"><a href="<?php echo wc_get_endpoint_url('edit-account'); ?>">My Account</a></li>
        <li class="<?php echo is_wc_endpoint_url('edit-address') ? 'active' : ''; ?>"><a href="<?php echo wc_get_endpoint_url('edit-address'); ?>">Address Book</a></li>
        <li><a href="<?php echo home_url('/wishlist'); ?>">Wish List</a></li>
        <li class="<?php echo is_wc_endpoint_url('comparison') ? 'active' : ''; ?>"><a href="<?php echo wc_get_endpoint_url('comparison'); ?>">Comparison</a></li>
        <li class="<?php echo is_wc_endpoint_url('orders') ? 'active' : ''; ?>"><a href="<?php echo wc_get_endpoint_url('orders'); ?>">Order History</a></li>
        <li class="<?php echo is_wc_endpoint_url('downloads') ? 'active' : ''; ?>"><a href="<?php echo wc_get_endpoint_url('downloads'); ?>">Downloads</a></li>
        <li><a href="<?php echo wc_get_endpoint_url('orders'); ?>#returns">Returns</a></li>
        <?php /* Future functionality - uncomment when ready
        <li><a href="<?php echo wc_get_endpoint_url('comments'); ?>">Comments</a></li>
        */ ?>
    </ul>
</div>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
