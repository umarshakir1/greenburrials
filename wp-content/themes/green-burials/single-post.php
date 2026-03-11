<?php
/**
 * Template for displaying single blog posts
 * Matches reference design with breadcrumb, content area, and recent articles sidebar
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

<div class="single-post-breadcrumb">
    <div class="container">
        <div class="breadcrumb">
            <div class="breadcrumb-pill">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="breadcrumb-home-link">
                    <span class="home-icon-wrapper">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                </a>
                <span class="breadcrumb-current">Blog</span>
            </div>
        </div>
    </div>
</div>

<div class="single-post-header">
    <div class="container">
        <div class="blog-heading-wrapper centered">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/figma_exported_images/Mask-group-4.png" alt="decoration" class="blog-heading-decoration">
            <h1 class="single-post-title"><?php the_title(); ?></h1>
        </div>
        <div class="single-post-meta-pill">
            <div class="blog-date-badge-pill">
                <?php echo get_the_date('F d, Y'); ?>
            </div>
        </div>
    </div>
</div>

<div class="single-post-layout">
    <div class="container">
        <div class="single-post-grid">
            <!-- Main Content Area -->
            <article class="single-post-content">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="single-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="single-post-body">
                    <?php the_content(); ?>
                </div>

                <!-- Post Navigation -->
                <div class="post-navigation">
                    <div class="nav-previous">
                        <?php previous_post_link('%link', '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg> Previous Post'); ?>
                    </div>
                    <div class="nav-next">
                        <?php next_post_link('%link', 'Next Post <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>'); ?>
                    </div>
                </div>
            </article>

            <!-- Sidebar: Recent Articles -->
            <aside class="recent-articles-sidebar">
                <h3 class="sidebar-title">Recent Articles</h3>
                <div class="recent-articles-list">
                    <?php
                    $current_post_id = get_the_ID();
                    $recent_args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 4,
                        'post__not_in' => array($current_post_id),
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    $recent_query = new WP_Query($recent_args);
                    
                    if ($recent_query->have_posts()) :
                        while ($recent_query->have_posts()) : $recent_query->the_post();
                    ?>
                    <article class="recent-article-item">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="recent-article-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="recent-article-content">
                            <h4 class="recent-article-title">
                                <a href="<?php the_permalink(); ?>"><?php echo wp_trim_words(get_the_title(), 10); ?></a>
                            </h4>
                            <div class="recent-article-meta">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?php echo get_the_date('F d, Y'); ?>
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
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
