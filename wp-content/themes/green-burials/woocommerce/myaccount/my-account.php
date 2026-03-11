<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="account-page-wrapper container">
    <div class="account-grid">
        <!-- Main Content -->
        <div class="account-main-content">
            <div class="account-breadcrumb">
                <?php
                $current_label = 'My Account';
                global $wp_query;
                if ( is_wc_endpoint_url( 'edit-account' ) ) {
                    $current_label = 'Edit Information';
                } elseif ( is_wc_endpoint_url( 'orders' ) ) {
                    $current_label = 'Orders';
                } elseif ( is_wc_endpoint_url( 'edit-address' ) ) {
                    $current_label = 'Addresses';
                } elseif ( is_wc_endpoint_url( 'lost-password' ) ) {
                    $current_label = 'Forgotten Password';
                } elseif ( is_wc_endpoint_url( 'comparison' ) || isset($wp_query->query_vars['comparison']) ) {
                    $current_label = 'Product Comparison';
                }
                ?>
                <a href="<?php echo home_url(); ?>">Home</a> &gt; Account &gt; <span><?php echo esc_html( $current_label ); ?></span>
            </div>

            <div class="woocommerce-MyAccount-content">
                <?php
                /**
                 * My Account content.
                 *
                 * @since 2.6.0
                 */
                do_action( 'woocommerce_account_content' );
                ?>
            </div>
        </div>

        <!-- Sidebar -->
        <?php
        /**
         * My Account navigation.
         *
         * @since 2.6.0
         */
        do_action( 'woocommerce_account_navigation' );
        ?>
    </div>
</div>
