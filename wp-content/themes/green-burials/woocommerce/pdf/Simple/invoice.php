<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<?php do_action( 'wpo_wcpdf_before_document', $this->get_type(), $this->order ); ?>

<?php
/* Collect store info once */
$store_addr1  = get_option( 'woocommerce_store_address', '' );
$store_addr2  = get_option( 'woocommerce_store_address_2', '' );
$store_city   = get_option( 'woocommerce_store_city', '' );
$store_state  = get_option( 'woocommerce_store_state', '' );
$store_zip    = get_option( 'woocommerce_store_postcode', '' );
$store_email  = get_option( 'woocommerce_email_from_address', get_bloginfo( 'admin_email' ) );
$store_phone  = get_option( 'woocommerce_store_phone', '' );
$store_url    = get_bloginfo( 'url' );

/* Invoice number: use plugin number when enabled, otherwise order number */
$inv_num = $this->order->get_order_number();
if ( isset( $this->settings['display_number'] ) && method_exists( $this, 'get_formatted_number' ) ) {
	$fmt = $this->get_formatted_number();
	if ( ! empty( $fmt ) ) { $inv_num = $fmt; }
}
?>

<!-- ========== DECORATIVE MARK + TITLE ========== -->
<div class="gb-deco-mark">&#9650;</div>
<h1 class="gb-invoice-title">Invoice #<?php echo esc_html( $inv_num ); ?></h1>

<!-- ========== ORDER DETAILS (store info left | order meta right) ========== -->
<table class="gb-tbl gb-details-tbl">
	<thead>
		<tr>
			<th colspan="2" class="gb-section-hdr">Order Details</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<!-- Left: store info -->
			<td class="gb-store-cell">
				<strong class="gb-store-name">GreenBurials.com</strong><br>
				House of Urns, LLC<br>
				<?php if ( $store_addr1 ) : echo esc_html( $store_addr1 ) . '<br>'; endif; ?>
				<?php if ( $store_addr2 ) : echo esc_html( $store_addr2 ) . '<br>'; endif; ?>
				<?php if ( $store_city ) : echo esc_html( $store_city ) . ', ' . esc_html( $store_state ) . '<br>'; endif; ?>
				<?php if ( $store_zip ) : echo esc_html( $store_zip ) . '<br>'; endif; ?>
				<br>
				<?php if ( $store_phone ) : ?>
					<strong>Telephone</strong> <?php echo esc_html( $store_phone ); ?><br>
				<?php endif; ?>
				<strong>E-Mail</strong> <?php echo esc_html( $store_email ); ?><br>
				<strong>Web Site:</strong> <?php echo esc_html( $store_url ); ?><br>
				(<?php echo esc_html( $store_url ); ?>)
			</td>
			<!-- Right: order meta -->
			<td class="gb-meta-cell">
				<?php $order_date = $this->order->get_date_created(); ?>
				<strong>Date Added</strong> <?php echo $order_date ? esc_html( $order_date->date( 'm/d/Y' ) ) : '&mdash;'; ?><br>
				<strong>Order ID:</strong> <?php echo esc_html( $this->order->get_order_number() ); ?><br>
				<strong>Payment Method</strong> <?php echo esc_html( $this->order->get_payment_method_title() ); ?><br>
				<strong>Shipping Method</strong> <?php echo esc_html( get_invoice_shipping_label( $this->order ) ); ?>
			</td>
		</tr>
	</tbody>
</table>

<!-- ========== ADDRESSES (Payment Address | Shipping Address) ========== -->
<table class="gb-tbl gb-addr-tbl">
	<tbody>
		<tr>
			<!-- Billing / Payment Address -->
			<td class="gb-addr-col">
				<div class="gb-addr-hdr">Payment Address</div>
				<?php do_action( 'wpo_wcpdf_before_billing_address', $this->get_type(), $this->order ); ?>
				<div class="gb-addr-body"><?php $this->billing_address(); ?></div>
				<?php do_action( 'wpo_wcpdf_after_billing_address', $this->get_type(), $this->order ); ?>
			</td>
			<!-- Shipping Address -->
			<td class="gb-addr-col">
				<div class="gb-addr-hdr">Shipping Address</div>
				<?php do_action( 'wpo_wcpdf_before_shipping_address', $this->get_type(), $this->order ); ?>
				<div class="gb-addr-body"><?php $this->shipping_address(); ?></div>
				<?php if ( $this->order->get_billing_phone() ) : ?>
					<div class="gb-phone-cursive">(<?php echo esc_html( $this->order->get_billing_phone() ); ?>)</div>
				<?php endif; ?>
				<?php do_action( 'wpo_wcpdf_after_shipping_address', $this->get_type(), $this->order ); ?>
			</td>
		</tr>
	</tbody>
</table>

<?php do_action( 'wpo_wcpdf_before_order_details', $this->get_type(), $this->order ); ?>

<!-- ========== LINE ITEMS TABLE ========== -->
<table class="gb-tbl gb-items-tbl">
	<thead>
		<tr>
			<th class="gb-th gb-th-product">Product</th>
			<th class="gb-th gb-th-model">Model</th>
			<th class="gb-th gb-th-qty">Quantity</th>
			<th class="gb-th gb-th-price">Unit Price</th>
			<th class="gb-th gb-th-total">Total</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $this->get_order_items() as $item_id => $item ) : ?>
		<tr>
			<td class="gb-td gb-td-product">
				<strong><?php echo esc_html( $item['name'] ); ?></strong>
				<?php
				/* Build "- Label: Value" option lines from raw item meta */
				$wc_item = $this->order->get_item( isset( $item['item_id'] ) ? $item['item_id'] : $item_id );
				if ( $wc_item ) {
					foreach ( $wc_item->get_meta_data() as $meta ) {
						if ( empty( $meta->key ) || substr( $meta->key, 0, 1 ) === '_' ) { continue; }
						$label = wc_attribute_label( $meta->key, is_callable( [ $wc_item, 'get_product' ] ) ? $wc_item->get_product() : null );
						$value = is_array( $meta->value ) ? implode( ', ', $meta->value ) : $meta->value;
						if ( '' === (string) $value ) { continue; }
						echo '<div class="gb-opt-line"> - ' . esc_html( $label ) . ': ' . esc_html( $value ) . '</div>';
					}
				} elseif ( ! empty( $item['meta'] ) ) {
					echo '<div class="gb-item-meta">' . wp_kses_post( $item['meta'] ) . '</div>';
				}
				?>
			</td>
			<td class="gb-td gb-td-model"><?php echo ! empty( $item['sku'] ) ? esc_html( $item['sku'] ) : ''; ?></td>
			<td class="gb-td gb-td-qty"><?php echo esc_html( $item['quantity'] ); ?></td>
			<td class="gb-td gb-td-price"><?php echo ! empty( $item['price'] ) ? wp_kses_post( $item['price'] ) : wp_kses_post( $item['order_price'] ); ?></td>
			<td class="gb-td gb-td-total"><?php echo wp_kses_post( $item['order_price'] ); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<!-- ========== TOTALS ========== -->
<table class="gb-tbl gb-totals-tbl">
	<tfoot>
		<?php foreach ( $this->get_woocommerce_totals() as $key => $total ) : ?>
		<tr class="<?php echo esc_attr( $key ); ?>">
			<td class="gb-tot-spacer"></td>
			<th class="gb-tot-label"><?php echo esc_html( $total['label'] ); ?></th>
			<td class="gb-tot-value"><?php echo wp_kses_post( $total['value'] ); ?></td>
		</tr>
		<?php endforeach; ?>
	</tfoot>
</table>

<!-- ========== NOTES ========== -->
<?php do_action( 'wpo_wcpdf_before_document_notes', $this->get_type(), $this->order ); ?>
<?php if ( $this->get_document_notes() ) : ?>
	<div class="gb-notes"><?php $this->document_notes(); ?></div>
<?php endif; ?>
<?php do_action( 'wpo_wcpdf_after_document_notes', $this->get_type(), $this->order ); ?>
<?php do_action( 'wpo_wcpdf_before_customer_notes', $this->get_type(), $this->order ); ?>
<?php if ( $this->get_shipping_notes() ) : ?>
	<div class="gb-notes"><?php $this->shipping_notes(); ?></div>
<?php endif; ?>
<?php do_action( 'wpo_wcpdf_after_customer_notes', $this->get_type(), $this->order ); ?>

<?php do_action( 'wpo_wcpdf_after_order_details', $this->get_type(), $this->order ); ?>

<div class="gb-spacer"></div>

<?php if ( $this->get_footer() ) : ?>
	<htmlpagefooter name="docFooter">
		<div id="footer"><?php $this->footer(); ?></div>
	</htmlpagefooter>
<?php endif; ?>

<?php do_action( 'wpo_wcpdf_after_document', $this->get_type(), $this->order ); ?>
