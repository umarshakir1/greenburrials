<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'single-product-container container', $product ); ?>>

    <!-- Custom Breadcrumb & Category Badge -->
    <div class="product-navigation">
        <?php green_burials_breadcrumb(); ?>
    </div>

    <div class="product-main-layout">
        <!-- Left Column: Gallery -->
        <div class="product-gallery">
            <div class="main-image-container">
                <?php
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'full' );
                } else {
                    echo '<img src="' . wc_placeholder_img_src() . '" alt="Placeholder">';
                }
                ?>
            </div>
            
            <?php
            $attachment_ids = $product->get_gallery_image_ids();
            if ( $attachment_ids ) {
                echo '<div class="thumbnail-gallery">';
                // Add main image as first thumbnail
                if ( has_post_thumbnail() ) {
                    $main_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
                    $main_full = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
                    echo '<div class="thumbnail-item active"><img src="' . esc_url( $main_thumb[0] ) . '" data-large-src="' . esc_url( $main_full[0] ) . '"></div>';
                }
                foreach ( $attachment_ids as $attachment_id ) {
                    $thumb_url = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
                    $full_url = wp_get_attachment_image_src( $attachment_id, 'full' );
                    echo '<div class="thumbnail-item"><img src="' . esc_url( $thumb_url[0] ) . '" data-large-src="' . esc_url( $full_url[0] ) . '"></div>';
                }
                echo '</div>';
            }
            ?>
        </div>

        <!-- Right Column: Info -->
        <div class="product-info-panel">
            <div class="product-heading-overlay">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group (2).png" alt="Overlay" class="heading-overlay-img">
            </div>
            <div class="product-title-row">
                <h1 class="product-title"><?php the_title(); ?></h1>
            </div>

            <div class="product-price-row">
                <div class="price-main"><?php echo $product->get_price_html(); ?></div>
                <?php if ( $product->is_taxable() ) : ?>
                    <div class="price-ex-tax">Ex Tax: <?php echo green_burials_get_ex_tax_price($product); ?></div>
                <?php endif; ?>
            </div>

            <div class="review-summary">
                <span class="review-count"><?php echo $product->get_review_count(); ?> Reviews</span>
                <div class="stars">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                </div>
            </div>

            <div class="product-meta-box">
                <div class="meta-row">
                    <span class="meta-label">Product Code:</span>
                    <span class="meta-value sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Stock</span>
                    <div class="meta-value stock-status">
                        <span class="stock-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </span>
                        <span class="availability"><?php echo $product->get_stock_quantity() ? $product->get_stock_quantity() : ($product->is_in_stock() ? esc_html__( 'In Stock', 'woocommerce' ) : esc_html__( 'Out of Stock', 'woocommerce' )); ?></span>
                    </div>
                </div>
                <div class="delivery-badge">
                    Express Delivery Is Available At Checkout
                </div>
            </div>

            <div class="product-actions-wrapper">
                <?php
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
                remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
                
                do_action( 'woocommerce_single_product_summary' );
                ?>
            </div>

        </div>
    </div>

    <!-- Tabs -->
    <div class="product-tabs">
        <div class="tab-nav">
            <button class="tab-btn active" data-tab="description">Description</button>
            <button class="tab-btn" data-tab="reviews">Reviews (<?php echo $product->get_review_count(); ?>)</button>
        </div>
        <div class="tab-content active" id="description">
            <?php the_content(); ?>
        </div>
        <div class="tab-content" id="reviews">
            <?php comments_template(); ?>
        </div>
    </div>

    <div class="related-products">
        <div class="related-header">
            <div class="related-title-wrapper">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask group (2).png" alt="Overlay" class="related-heading-overlay">
                <h2 class="related-title">Related Products</h2>
            </div>
            <div class="slider-arrows">
                <button class="arrow-btn prev"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                <button class="arrow-btn next"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
            </div>
        </div>
        <div class="related-slider-container">
            <div class="related-slider latest-products-track">
                <?php
                $related_ids = wc_get_related_products( $product->get_id(), 8 );
                if ( $related_ids ) {
                    foreach ( $related_ids as $related_id ) {
                        $rel_product = wc_get_product( $related_id );
                        if ( ! $rel_product || ! is_a( $rel_product, 'WC_Product' ) ) {
                            continue;
                        }

                        $rel_permalink = $rel_product->get_permalink();
                        $rel_name      = $rel_product->get_name();
                        $rel_price     = $rel_product->get_price_html();
                        $rel_image     = $rel_product->get_image( 'woocommerce_thumbnail' );
                        $rating_count  = $rel_product->get_rating_count();
                        $average       = $rel_product->get_average_rating();
                        ?>
                        <div class="category-product-card latest-product-card">
                            <a href="<?php echo esc_url( $rel_permalink ); ?>" class="card-link-overlay" aria-label="View <?php echo esc_attr( $rel_name ); ?>"></a>
                            <div class="category-product-image">
                                <?php
                                if ( $rel_product->is_on_sale() ) {
                                    echo '<span class="sale-badge">Sale</span>';
                                }

                                if ( $rel_image ) {
                                    echo $rel_image;
                                } else {
                                    echo '<img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="' . esc_attr( $rel_name ) . '">';
                                }
                                ?>
                            </div>
                            <div class="category-product-info latest-product-info">
                                <h3 class="category-product-title latest-product-title"><?php echo esc_html( $rel_name ); ?></h3>
                                <div class="category-product-price-rating latest-price-rating">
                                    <div class="category-product-price latest-product-price"><?php echo wp_kses_post( $rel_price ); ?></div>
                                    <div class="category-product-rating latest-product-rating">
                                        <?php echo wc_get_rating_html( $average, $rating_count ); ?>
                                    </div>
                                </div>
                                <div class="category-product-actions latest-product-actions">
                                    <a href="<?php echo esc_url( $rel_permalink ); ?>" class="btn-latest-shop">Shop Now</a>
                                    <?php echo apply_filters( 'woocommerce_loop_add_to_cart_link', sprintf( '<a href="%s" data-quantity="1" class="btn-category-add-to-cart add_to_cart_button ajax_add_to_cart" data-product_id="%s" aria-label="%s"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></a>', esc_url( $rel_product->add_to_cart_url() ), esc_attr( $rel_product->get_id() ), esc_attr( $rel_product->add_to_cart_description() ) ), $rel_product ); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
