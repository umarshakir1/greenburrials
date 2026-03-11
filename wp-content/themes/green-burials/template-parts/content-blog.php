<article class="blog-card">
    <?php if (has_post_thumbnail()) : ?>
        <div class="blog-card-image">
            <?php the_post_thumbnail('medium'); ?>
        </div>
    <?php endif; ?>
    <div class="blog-card-content">
        <div class="blog-date-badge-pill">
            <?php echo get_the_date('F d, Y'); ?>
        </div>
        <h3 class="blog-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <div class="blog-card-excerpt">
            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
        </div>
        <a href="<?php the_permalink(); ?>" class="btn-read-more">Read More</a>
    </div>
</article>
