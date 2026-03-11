<?php
/**
 * Custom Checkout shipping information form
 *
 * Keeps the native checkbox hidden for compatibility while presenting
 * the shipping fields inside a custom modal experience.
 */

defined( 'ABSPATH' ) || exit;

$checkout            = WC()->checkout();
$shipping_fields      = $checkout->get_checkout_fields( 'shipping' );
$needs_shipping_modal = true;

error_log( "Shipping fields: " . print_r( $shipping_fields, true ) );
error_log( "Shipping country value: " . $checkout->get_value( 'shipping_country' ) );
error_log( "Base country: " . WC()->countries->get_base_country() );
?>
<div class="woocommerce-shipping-fields">

	<?php /* Keep WooCommerce checkbox in DOM for compatibility */ ?>
	<h3 id="ship-to-different-address" class="screen-reader-text">
		<label class="checkbox">
			<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" />
			<span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
		</label>
	</h3>

	<?php if ( $needs_shipping_modal ) : ?>
		<div id="shipping-address-modal" class="shipping-address-modal" aria-hidden="true">
			<div class="shipping-address-modal__overlay" data-shipping-modal-dismiss></div>
			<div class="shipping-address-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="shipping-modal-title">
				<button type="button" class="shipping-address-modal__close" data-shipping-modal-dismiss aria-label="<?php esc_attr_e( 'Close shipping address form', 'woocommerce' ); ?>">
					<span aria-hidden="true">&times;</span>
				</button>
				<div class="shipping-address-modal__content">
					<h3 id="shipping-modal-title"><?php esc_html_e( 'Shipping details', 'woocommerce' ); ?></h3>
					<p class="shipping-address-modal__intro"><?php esc_html_e( 'Please provide the destination information for your order.', 'woocommerce' ); ?></p>
					<div class="shipping-address-modal__notice" role="alert" hidden></div>

					<div class="shipping_address">
						<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

						<div class="woocommerce-shipping-fields__field-wrapper">
							<?php
							if ( ! empty( $shipping_fields ) ) {
								foreach ( $shipping_fields as $key => $field ) {
									error_log( "Shipping field $key: " . print_r( $field, true ) );
									woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
								}
							} else {
								echo '<p class="woocommerce-info">' . esc_html__( 'No shipping fields are currently available. Please contact support if this is unexpected.', 'woocommerce' ) . '</p>';
							}
							?>
						</div>

						<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>
					</div>

					<div class="shipping-address-modal__actions">
						<button type="button" class="button shipping-address-modal__cancel" id="cancel-shipping-address"><?php esc_html_e( 'Cancel', 'woocommerce' ); ?></button>
						<button type="button" class="button alt shipping-address-modal__save" id="save-shipping-address"><?php esc_html_e( 'Save Address', 'woocommerce' ); ?></button>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
