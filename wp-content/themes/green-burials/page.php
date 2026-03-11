<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

<div class="container page-main-container">
    <?php
    while (have_posts()) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="page-header">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="title-divider"></div>
            </header>
            
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile;
    ?>
</div>

<?php
get_footer();
