<?php
/**
 * Template Name: Information Page
 * Description: A reusable template for informational pages like About Us, Privacy Policy, etc.
 */

get_header();
?>

<div class="info-page-wrapper">

    <!-- Hero Section (same style as Contact Us) -->
    <div class="contact-hero">
        <div class="container">
            <h1 class="contact-title"><?php the_title(); ?></h1>
        </div>
    </div>

    <!-- Page Content -->
    <div class="info-content-area">
        <?php
        while (have_posts()) : the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>

</div>

<?php get_footer(); ?>
