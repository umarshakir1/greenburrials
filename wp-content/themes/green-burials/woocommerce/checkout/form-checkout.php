<?php
/**
 * Custom Checkout Form
 * 
 * Includes Login/Register/Guest options and custom Shipping toggle.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Ensure checkout registration is enabled for the 'Register' tab to make sense
// though we'll handle display logic here.
?>

<div class="custom-checkout-container">
    
    <?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?>

    <?php if ( ! is_user_logged_in() ) : ?>
        <div class="checkout-access-section">
            <div class="checkout-access-options">
                <div class="access-tab active" data-target="guest">Guest Checkout</div>
                <div class="access-tab" data-target="login">Sign In</div>
                <div class="access-tab" data-target="register">Create Account</div>
            </div>

            <div class="access-forms">
                <div id="guest-checkout-msg" class="access-form-content active">
                    <p style="margin: 0; color: #64748b; font-size: 1.1rem;">Proceeding as a guest. You will have the option to create an account after completing your order to track your shipment.</p>
                </div>
                <div id="login-form-content" class="access-form-content">
                    <div class="login-form-wrapper">
                        <p style="margin-bottom: 2rem; color: #64748b;">Welcome back! Please enter your credentials to access your saved details.</p>
                        <?php 
                        woocommerce_login_form(array(
                            'redirect' => wc_get_checkout_url(),
                            'hidden'   => false
                        )); 
                        ?>
                    </div>
                </div>
                <div id="register-form-content" class="access-form-content">
                    <p style="margin: 0; color: #64748b; font-size: 1.1rem;">Fill in your details below and check the <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" style="color: #73884D; font-weight: 700; text-decoration: underline;">"Create an account?"</a> option to save your information for future purchases.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <?php if ( $checkout->get_checkout_fields() ) : ?>

            <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

            <div class="customer-details-wrapper" id="customer_details">
                <div class="billing-details-section">
                    <?php do_action( 'woocommerce_checkout_billing' ); ?>
                </div>

                <div class="shipping-details-section">
                    <?php
                    // Detect if logged-in user has a saved shipping address
                    $user_has_shipping = false;
                    if ( is_user_logged_in() ) {
                        $uid = get_current_user_id();
                        $user_has_shipping = ! empty( get_user_meta( $uid, 'shipping_address_1', true ) )
                                          || ! empty( get_user_meta( $uid, 'shipping_first_name', true ) )
                                          || ! empty( get_user_meta( $uid, 'shipping_city', true ) );
                    }
                    ?>

                    <div class="shipping-details-header">
                        <h3>Shipping address</h3>
                        <p class="shipping-details-description">Provide a different shipping destination if it differs from your billing address.</p>
                    </div>

                    <?php /* Toggle switch: same-as-billing vs different address */ ?>
                    <label class="gb-shipping-toggle" id="gb-shipping-toggle-label">
                        <input
                            type="checkbox"
                            id="gb-ship-different"
                            <?php checked( $user_has_shipping, true ); ?>
                            data-has-saved-shipping="<?php echo $user_has_shipping ? '1' : '0'; ?>"
                        />
                        <span class="gb-shipping-toggle__track">
                            <span class="gb-shipping-toggle__thumb"></span>
                        </span>
                        <span class="gb-shipping-toggle__text">Ship to a different address?</span>
                    </label>

                    <div id="gb-shipping-address-controls" <?php echo $user_has_shipping ? '' : 'hidden'; ?>>

                    <div class="shipping-summary" id="shipping-summary">
                        <p class="shipping-summary__empty">Shipping will use the billing address unless you add one below.</p>
                        <div class="shipping-summary__details" hidden></div>
                        <button type="button" class="shipping-summary__reset" id="remove-shipping-address" hidden>Use billing address instead</button>
                    </div>

                    <button
                        type="button"
                        id="add-shipping-address-btn"
                        class="shipping-address-trigger"
                        data-add-label="Add Shipping Address"
                        data-edit-label="Edit Shipping Address"
                    ><?php esc_html_e( 'Add Shipping Address', 'woocommerce' ); ?></button>

                    </div><!-- /#gb-shipping-address-controls -->

                    <?php do_action( 'woocommerce_checkout_shipping' ); ?>

                    <?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
                        <div class="create-account-checkout-box">
                            <?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
                                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

        <?php endif; ?>
        
        <div class="order-review-section">
            <h3 id="order_review_heading"><?php esc_html_e( 'Review Your Order', 'woocommerce' ); ?></h3>
            
            <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

            <div id="order_review" class="woocommerce-checkout-review-order">
                <?php do_action( 'woocommerce_checkout_order_review' ); ?>
            </div>
        </div>

    </form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
