<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<div class="account-page-wrapper container">
    <div class="account-grid">
        <!-- Main Content -->
        <div class="account-main-content">
            <div class="account-card lost-password-card">
                <h2 class="card-title">Forgotten Password</h2>
                <div class="card-body">
                    <form method="post" class="woocommerce-ResetPassword lost_reset_password">
                        <p class="lost-password-message"><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'woocommerce' ) ); ?></p>

                        <div class="lost-password-fields-wrapper">
                            <div class="form-row-group">
                                <label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?> <span class="required">*</span></label>
                                <div class="input-button-group">
                                    <input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
                                    <button type="submit" class="woocommerce-Button button btn-reset-password" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset Password', 'woocommerce' ); ?></button>
                                </div>
                            </div>
                        </div>

                        <?php do_action( 'woocommerce_lostpassword_form' ); ?>
                        <?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
                        <input type="hidden" name="wc_reset_password" value="true" />
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="account-sidebar">
            <ul class="account-nav-list">
                <li><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>">Login</a></li>
                <li><a href="<?php echo esc_url( add_query_arg( 'action', 'register', wc_get_page_permalink( 'myaccount' ) ) ); ?>">Register</a></li>
                <li class="active"><a href="<?php echo wp_lostpassword_url(); ?>">Forgotten Password</a></li>
                <li><a href="<?php echo wc_get_endpoint_url('edit-account'); ?>">My Account</a></li>
                <li><a href="<?php echo wc_get_endpoint_url('edit-address'); ?>">Address Book</a></li>
                <li><a href="<?php echo home_url('/wishlist'); ?>">Wish List</a></li>
                <li><a href="<?php echo wc_get_endpoint_url('orders'); ?>">Order History</a></li>
                <li><a href="<?php echo wc_get_endpoint_url('downloads'); ?>">Downloads</a></li>
                <li><a href="<?php echo wc_get_endpoint_url('orders'); ?>#returns">Returns</a></li>
            </ul>
        </div>
    </div>
</div>

<?php
do_action( 'woocommerce_after_lost_password_form' );
