<?php
/**
 * Cross-sells
 *
 * @package GreenBurials\WooCommerce
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $cross_sells ) ) {
    return;
}

$heading = apply_filters( 'woocommerce_product_cross_sells_products_heading', __( 'You may be interested in&hellip;', 'woocommerce' ) );
$columns = isset( $columns ) ? (int) $columns : 4;

// Ensure global post is restored after our custom loop.
$previous_post = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : null;
?>

<section class="cart-cross-sells">
    <?php if ( $heading ) : ?>
        <div class="cart-cross-sells-header">
            <h2 class="cart-cross-sells-title"><?php echo esc_html( $heading ); ?></h2>
        </div>
    <?php endif; ?>

    <div class="cart-cross-sells-grid" data-columns="<?php echo esc_attr( $columns ); ?>">
        <?php foreach ( $cross_sells as $cross_sell ) :
            $post_object = get_post( $cross_sell->get_id() );

            if ( ! $post_object ) {
                continue;
            }

            $GLOBALS['post'] = $post_object; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            setup_postdata( $post_object );

            $product      = wc_get_product( $cross_sell->get_id() );
            $permalink    = $product ? $product->get_permalink() : get_permalink( $cross_sell->get_id() );
            $image        = $product ? $product->get_image( 'woocommerce_thumbnail' ) : get_the_post_thumbnail( $post_object, 'woocommerce_thumbnail' );
            $price_html   = $product ? $product->get_price_html() : '';
            $rating_html  = ( $product && $product->get_rating_count() ) ? wc_get_rating_html( $product->get_average_rating(), $product->get_rating_count() ) : '';
            $is_on_sale   = $product && $product->is_on_sale();
            $button_label = $product ? $product->single_add_to_cart_text() : __( 'View Product', 'woocommerce' );
            $add_to_cart  = $product ? apply_filters(
                'woocommerce_loop_add_to_cart_link',
                sprintf(
                    '<a href="%s" data-quantity="1" class="btn-latest-shop button" data-product_id="%s" data-product_sku="%s" aria-label="%s">%s</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( $product->get_id() ),
                    esc_attr( $product->get_sku() ),
                    esc_attr( $product->add_to_cart_description() ),
                    esc_html( $button_label )
                ),
                $product, $cross_sell
            ) : '';
            ?>

            <div class="category-product-card latest-product-card cart-cross-card">
                <a href="<?php echo esc_url( $permalink ); ?>" class="card-link-overlay" aria-label="<?php the_title_attribute(); ?>"></a>
                <div class="category-product-image latest-product-image">
                    <?php if ( $is_on_sale ) : ?>
                        <span class="sale-badge"><?php esc_html_e( 'Sale', 'woocommerce' ); ?></span>
                    <?php endif; ?>
                    <?php echo $image ?: wc_placeholder_img( 'woocommerce_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
                <div class="category-product-info latest-product-info cart-cross-info">
                    <h3 class="category-product-title latest-product-title">
                        <a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="category-product-price-rating latest-price-rating">
                        <div class="category-product-price latest-product-price"><?php echo wp_kses_post( $price_html ); ?></div>
                        <div class="category-product-rating latest-product-rating">
                            <?php echo wp_kses_post( $rating_html ); ?>
                        </div>
                    </div>
                    <div class="category-product-actions latest-product-actions cart-cross-actions">
                        <?php echo $add_to_cart; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php
wp_reset_postdata();

if ( $previous_post instanceof WP_Post ) {
    $GLOBALS['post'] = $previous_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
} else {
    unset( $GLOBALS['post'] );
}
