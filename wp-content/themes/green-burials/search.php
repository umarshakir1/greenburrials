<?php
/**
 * The template for displaying search results pages
 */

get_header();
?>

<div class="shop-header-section">
    <div class="container">
        <div class="shop-breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <span class="home-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </span>
            </a>
            <span class="separator">/</span>
            <span class="current-page">Search Results</span>
        </div>
        
        <div class="shop-title-container">
            <h1 class="shop-title">
                <?php printf( esc_html__( 'Search Results for: %s', 'green-burials' ), '<span>' . get_search_query() . '</span>' ); ?>
            </h1>
            <div class="title-divider"></div>
        </div>
    </div>
</div>

<div class="shop-main-layout">
    <div class="container">
        <div class="shop-grid-container">
            <!-- Sidebar -->
            <aside class="shop-sidebar">
                <?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
                    <?php dynamic_sidebar( 'shop-sidebar' ); ?>
                <?php else : ?>
                    <?php get_sidebar( 'shop' ); ?>
                <?php endif; ?>
            </aside>

            <!-- Search Results Grid -->
            <main class="shop-content search-results">
                <?php if ( have_posts() ) : ?>
                    <div class="products columns-3">
                        <?php
                        while ( have_posts() ) :
                            the_post();

                            if ( 'product' === get_post_type() ) {
                                wc_get_template_part( 'content', 'product' );
                            } else {
                                // Fallback for non-product search results
                                ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('product'); ?>>
                                    <div class="product-image-container">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'woocommerce_thumbnail' ); ?>
                                        <?php else : ?>
                                            <img src="<?php echo wc_placeholder_img_src(); ?>" alt="Placeholder">
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-info">
                                        <h2 class="woocommerce-loop-product__title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <div class="post-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </div>
                                </article>
                                <?php
                            }
                        endwhile;
                        ?>
                    </div>

                    <?php
                    the_posts_pagination( array(
                        'prev_text' => '&laquo;',
                        'next_text' => '&raquo;',
                        'class'     => 'blog-v2-pagination'
                    ) );
                    ?>

                <?php else : ?>
                    <div class="no-results-found">
                        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'green-burials' ); ?></p>
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</div>

<?php
get_footer();
