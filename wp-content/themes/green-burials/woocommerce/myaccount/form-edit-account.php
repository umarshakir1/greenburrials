<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<div class="edit-account-details">
    <h2 class="account-details-title">My Account Information</h2>

    <form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

        <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

        <div class="form-section">
            <h3 class="section-title">Your Personal Details</h3>

            <div class="horizontal-form-row">
                <label for="account_first_name"><?php esc_html_e( 'First Name', 'woocommerce' ); ?> <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
                </div>
            </div>

            <div class="horizontal-form-row">
                <label for="account_last_name"><?php esc_html_e( 'Last Name', 'woocommerce' ); ?> <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
                </div>
            </div>

            <div class="horizontal-form-row">
                <label for="account_email"><?php esc_html_e( 'E-Mail', 'woocommerce' ); ?> <span class="required">*</span></label>
                <div class="input-wrapper">
                    <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
                </div>
            </div>
            
            <input type="hidden" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" />
        </div>

        <?php do_action( 'woocommerce_edit_account_form' ); ?>

        <div class="form-footer-actions">
            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="btn-back">Back</a>
            
            <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
            <button type="submit" class="woocommerce-Button button btn-continue-account" name="save_account_details" value="<?php esc_attr_e( 'CONTINUE', 'woocommerce' ); ?>"><?php esc_html_e( 'CONTINUE', 'woocommerce' ); ?></button>
            <input type="hidden" name="action" value="save_account_details" />
        </div>

        <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
    </form>
</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
