<?php
/**
 * The template for displaying product content within loops
 *
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure the product object is fresh and correctly typed (prevents $0.00 on variable products).
$product = wc_get_product( get_the_ID() );

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'category-product-card product', $product ); ?>>
    <a href="<?php the_permalink(); ?>" class="card-link-overlay" aria-label="View <?php the_title_attribute(); ?>"></a>
    
    <div class="category-product-image">
        <?php if ($product->is_on_sale()) : ?>
            <span class="sale-badge">Sale</span>
        <?php endif; ?>

        <?php 
        if (has_post_thumbnail()) {
            the_post_thumbnail('woocommerce_thumbnail', array('loading' => 'lazy'));
        } else {
            echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.svg" alt="' . get_the_title() . '" loading="lazy">';
        }
        ?>
    </div>

    <div class="category-product-info">
        <h3 class="category-product-title"><?php the_title(); ?></h3>
        
        <div class="category-product-price-rating">
            <div class="category-product-price">
                <?php echo $product->get_price_html(); ?>
            </div>
            <div class="category-product-rating">
                <?php 
                $rating_count = $product->get_rating_count();
                $average = $product->get_average_rating();
                echo wc_get_rating_html($average, $rating_count);
                ?>
            </div>
        </div>

        <?php
        /**
         * Hook: woocommerce_after_shop_loop_item.
         *
         * @hooked green_burials_product_loop_actions - 10
         */
        do_action( 'woocommerce_after_shop_loop_item' );
        ?>
    </div>
</li>

