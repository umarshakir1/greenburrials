<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header();
?>

<div class="container blog-single-container">
	<main id="primary" class="site-main">
		<?php green_burials_breadcrumb(); ?>

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="blog-header">
					<?php the_title( '<h1 class="blog-title">', '</h1>' ); ?>
                    <div class="title-divider"></div>
				</header>

				<div class="blog-content entry-content single-post-body">
					<?php the_content(); ?>
				</div>
			</article>

			<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->
</div><!-- .container -->

<?php
get_footer();
