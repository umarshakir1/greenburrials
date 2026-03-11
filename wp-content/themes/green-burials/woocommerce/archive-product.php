<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template matches the reference design with a sidebar and a product grid.
 *
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

echo '<!-- ARCHIVE-PRODUCT-TEMPLATE-ACTIVE -->';

get_header();

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_product_data_20 - 30
 */
// do_action( 'woocommerce_before_main_content' );
?>

<div class="shop-header-section">
    <div class="container">
        <?php green_burials_breadcrumb(); ?>
        
        <div class="shop-title-container">
            <h1 class="shop-title"><?php woocommerce_page_title(); ?></h1>
            <div class="title-divider"></div>
        </div>
    </div>
</div>

<div class="shop-main-layout">
    <div class="container">
        <!-- Filter Header Row -->
        <div class="shop-filter-header">
            <div class="filter-toggle-btn" id="toggle-filters">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                <span class="toggle-text">HIDE FILTERS</span>
                <svg class="chevron-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
            </div>

            <div class="grid-layout-switcher desktop-only">
                <button class="grid-btn" data-columns="1" title="1 Column Layout">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" /></svg>
                </button>
                <button class="grid-btn" data-columns="2" title="2 Columns Layout">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="8" height="18" rx="1" /><rect x="13" y="3" width="8" height="18" rx="1" /></svg>
                </button>
                <button class="grid-btn active" data-columns="3" title="3 Columns Layout">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="6" height="18" rx="1" /><rect x="9" y="3" width="6" height="18" rx="1" /><rect x="16" y="3" width="6" height="18" rx="1" /></svg>
                </button>
                <button class="grid-btn" data-columns="4" title="4 Columns Layout">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="4.5" height="18" rx="0.5" /><rect x="7.5" y="3" width="4.5" height="18" rx="0.5" /><rect x="13" y="3" width="4.5" height="18" rx="0.5" /><rect x="18.5" y="3" width="4.5" height="18" rx="0.5" /></svg>
                </button>
            </div>
        </div>

        <div class="shop-grid-container" id="shop-grid-wrapper">
            <!-- Sidebar -->
            <aside class="shop-sidebar" id="shop-sidebar">
                <?php get_sidebar( 'shop' ); ?>
            </aside>

            <!-- Product Grid -->
            <main class="shop-content">
                <?php if ( woocommerce_product_loop() ) : ?>

                    <?php
                    /**
                     * Hook: woocommerce_before_shop_loop.
                     *
                     * @hooked woocommerce_output_all_notices - 10
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    // do_action( 'woocommerce_before_shop_loop' );

                    woocommerce_product_loop_start();

                    if ( wc_get_loop_prop( 'total' ) ) {
                        while ( have_posts() ) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action( 'woocommerce_shop_loop' );

                            wc_get_template_part( 'content', 'product' );
                        }
                    }

                    woocommerce_product_loop_end();

                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    // do_action( 'woocommerce_after_shop_loop' );
                    ?>

                    <?php if (  $wp_query->max_num_pages > 1 ) : ?>
                        <div class="load-more-container">
                            <button id="load-more-products" 
                                    data-page="1" 
                                    data-max-pages="<?php echo $wp_query->max_num_pages; ?>" 
                                    data-category="<?php echo is_shop() ? '' : get_queried_object()->slug; ?>">
                                LOAD MORE
                            </button>
                            <div class="loading-spinner-container" style="display:none;">
                                <div class="loading-spinner"></div>
                                <span>LOADING...</span>
                            </div>
                        </div>
                    <?php endif; ?>

                <?php else : ?>

                    <?php
                    /**
                     * Hook: woocommerce_no_products_found.
                     *
                     * @hooked wc_no_products_found - 10
                     */
                    do_action( 'woocommerce_no_products_found' );
                    ?>

                <?php endif; ?>
            </main>
        </div>
    </div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
// do_action( 'woocommerce_after_main_content' );

get_footer();
