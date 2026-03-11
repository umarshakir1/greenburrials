<?php
/**
 * The Sidebar containing the shop widget area.
 */

if ( ! is_active_sidebar( 'shop-sidebar' ) && ! is_product_category() && ! is_shop() ) {
	return;
}
?>

<aside id="secondary" class="widget-area shop-sidebar-inner">
    <!-- Price Filter Section -->
    <div class="sidebar-filter-section active">
        <div class="filter-section-header">
            <h3 class="filter-title">Price</h3>
            <span class="filter-toggle-icon">×</span>
        </div>
        <div class="filter-section-content">
            <?php
            // Display the default WooCommerce Price Filter widget
            the_widget( 'WC_Widget_Price_Filter', array( 'title' => '' ) );
            ?>
        </div>
    </div>

    <!-- Size Filter Section -->
    <div class="sidebar-filter-section">
        <div class="filter-section-header">
            <h3 class="filter-title">Size</h3>
            <span class="filter-toggle-icon">+</span>
        </div>
        <div class="filter-section-content">
            <ul class="product-sizes-list">
                <?php
                $sizes = get_terms( array(
                    'taxonomy'   => 'pa_size',
                    'hide_empty' => false,
                ) );

                if ( ! is_wp_error( $sizes ) && ! empty( $sizes ) ) {
                    $current_size = isset( $_GET['filter_size'] ) ? sanitize_text_field( $_GET['filter_size'] ) : '';
                    
                    foreach ( $sizes as $size ) {
                        $is_active = ( $current_size === $size->slug ) ? 'active' : '';
                        $link = add_query_arg( 'filter_size', $size->slug );
                        
                        // If clicking an already active size, remove the filter
                        if ( $is_active ) {
                            $link = remove_query_arg( 'filter_size' );
                        }

                        echo '<li class="size-item ' . $is_active . '">';
                        echo '<a href="' . esc_url( $link ) . '">' . esc_html( $size->name ) . '</a>';
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Category Filter Section -->
    <div class="sidebar-filter-section">
        <div class="filter-section-header">
            <h3 class="filter-title">Categories</h3>
            <span class="filter-toggle-icon">+</span>
        </div>
        <div class="filter-section-content">
            <ul class="product-categories-list">
                <?php
                $current_cat = get_queried_object();
                $current_cat_id = ( isset( $current_cat->term_id ) ) ? $current_cat->term_id : 0;

                // Get categories ordered by menu order (WooCommerce built-in)
                $categories = get_terms( array(
                    'taxonomy'     => 'product_cat',
                    'hide_empty'   => false,
                    'parent'       => 0,
                    'orderby'      => 'meta_value_num',
                    'meta_key'     => 'order',
                    'order'        => 'ASC',
                ) );

                if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
                    foreach ( $categories as $category ) {
                        $is_active = ( $current_cat_id == $category->term_id ) ? 'active' : '';
                        
                        $is_parent_active = false;
                        if ( is_product_category() ) {
                            $ancestors = get_ancestors( $current_cat_id, 'product_cat' );
                            if ( in_array( $category->term_id, $ancestors ) ) {
                                $is_parent_active = true;
                            }
                        }

                        echo '<li class="cat-item ' . $is_active . ( $is_parent_active ? ' parent-active' : '' ) . '">';
                        echo '<a href="' . get_term_link( $category ) . '">' . $category->name . '</a>';


                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>

    <?php 
    // Removed redundant dynamic_sidebar call that was showing unwanted default widgets
    /*
    if ( is_active_sidebar( 'shop-sidebar' ) ) :
        dynamic_sidebar( 'shop-sidebar' );
    endif; 
    */
    ?>
    
    <!-- Featured Products in Sidebar -->
    <div class="sidebar-block featured-sidebar-products">
        <h2 class="widget-title">FEATURED PRODUCTS</h2>
        <div class="sidebar-products-list">
            <?php
            $featured_args = array(
                'post_type'      => 'product',
                'posts_per_page' => 3,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'product_visibility',
                        'field'    => 'name',
                        'terms'    => 'featured',
                    ),
                ),
            );
            $featured_query = new WP_Query( $featured_args );
            if ( $featured_query->have_posts() ) :
                while ( $featured_query->have_posts() ) : $featured_query->the_post();
                    global $product;
                    ?>
                    <div class="sidebar-product-item">
                        <div class="sidebar-product-img">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'thumbnail' ); ?>
                            </a>
                        </div>
                        <div class="sidebar-product-info">
                            <h4 class="sidebar-product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <div class="sidebar-product-price"><?php echo $product->get_price_html(); ?></div>
                            <div class="sidebar-product-rating">
                                <?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</aside>
