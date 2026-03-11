<?php
/**
 * Template Name: Blog Archive
 * Description: Blog listing page with featured post and grid layout
 */

get_header();
?>

<div class="blog-page-header">
    <div class="container">
        <?php green_burials_breadcrumb(); ?>
        <h1 class="page-title">Blogs</h1>
    </div>
</div>

<div class="blog-layout">
    <div class="container">
        <!-- Hero Section: Featured Post + Recent Posts -->
        <div class="blog-hero-section">
            <!-- Left Column: Featured Post -->
            <div class="blog-hero-main">
                <?php
                $featured_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 1
                );
                $featured_query = new WP_Query($featured_args);
                
                if ($featured_query->have_posts()) :
                    while ($featured_query->have_posts()) : $featured_query->the_post();
                ?>
                
                <article class="featured-blog-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-blog-image">
                            <?php the_post_thumbnail('large'); ?>
                            <div class="blog-date-badge">
                                <span class="date-day"><?php echo get_the_date('d'); ?></span>
                                <span class="date-month"><?php echo get_the_date('M'); ?></span>
                                <span class="date-year"><?php echo get_the_date('Y'); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="featured-blog-content">
                        <h2 class="featured-blog-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <div class="blog-meta">
                            <span class="blog-date">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?php echo get_the_date('F d, Y'); ?>
                            </span>
                        </div>
                        <div class="featured-blog-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn-read-more">Read More</a>
                    </div>
                </article>
                
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            
            <!-- Right Column: Recent Posts (No Heading) -->
            <aside class="blog-hero-sidebar">
                <div class="sidebar-blog-list">
                    <?php
                    $sidebar_args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 4,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    $sidebar_query = new WP_Query($sidebar_args);
                    
                    if ($sidebar_query->have_posts()) :
                        while ($sidebar_query->have_posts()) : $sidebar_query->the_post();
                    ?>
                    <article class="sidebar-blog-item">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="sidebar-blog-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="sidebar-blog-content">
                            <h4 class="sidebar-blog-title">
                                <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 8); ?></a>
                            </h4>
                            <div class="sidebar-blog-meta">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?php echo get_the_date('F d, Y'); ?>
                            </div>
                            <div class="sidebar-blog-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 12); ?>
                            </div>
                        </div>
                    </article>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </aside>
        </div>
        
        <!-- Full-Width Blog Grid Below Hero -->
        <div class="blog-grid-section">
            <div class="blog-grid">
                <?php
                $grid_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 6,
                    'offset' => 1, // Skip the first post (featured)
                    'paged' => get_query_var('paged') ? get_query_var('paged') : 1
                );
                $grid_query = new WP_Query($grid_args);
                
                if ($grid_query->have_posts()) :
                    while ($grid_query->have_posts()) : $grid_query->the_post();
                ?>
                
                <article class="blog-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="blog-card-image">
                            <?php the_post_thumbnail('medium'); ?>
                            <div class="blog-date-badge">
                                <span class="date-day"><?php echo get_the_date('d'); ?></span>
                                <span class="date-month"><?php echo get_the_date('M'); ?></span>
                                <span class="date-year"><?php echo get_the_date('Y'); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="blog-card-content">
                        <h3 class="blog-card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <div class="blog-meta">
                            <span class="blog-date">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?php echo get_the_date('F d, Y'); ?>
                            </span>
                        </div>
                        <div class="blog-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn-read-more">Read More</a>
                    </div>
                </article>
                
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($grid_query->max_num_pages > 1) : ?>
            <div class="blog-pagination">
                <?php
                echo paginate_links(array(
                    'total' => $grid_query->max_num_pages,
                    'current' => max(1, get_query_var('paged')),
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                    'type' => 'list'
                ));
                ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
