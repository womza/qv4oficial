<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Sk8er
 */
get_header(); ?>

		<section class="style-misc single-page">
			<div class="inner">
				<div class="container">
					<div class="col-md-9">
						<div class="single-content">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>

							
							<?php if (wp_link_pages()): ?>
								<div class="page-nav" style="DISPLAY:NONE;">
									<?php wp_link_pages(); ?>
								</div>
							<?php endif ?>

							<?php edit_post_link( __( 'Edit', 'sk8er' ), '<span class="edit-link btn btn-default">', '</span>' ); ?>

							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
							?>
						<?php endwhile; // end of the loop. ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="sidebar">
							<?php get_sidebar(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>

<?php get_footer(); ?>
