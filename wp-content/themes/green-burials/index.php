<?php
/**
 * The main template file
 */

get_header();
?>

<div class="container">
    <div class="content-area">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                    </header>
                    
                    <div class="entry-content">
                        <?php the_excerpt(); ?>
                    </div>
                </article>
                <?php
            endwhile;
        else :
            ?>
            <p>No content found.</p>
            <?php
        endif;
        ?>
    </div>
</div>

<?php
get_footer();
