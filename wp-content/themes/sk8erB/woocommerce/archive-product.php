<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); ?>


<section class="style-misc blog-single">
	<div class="inner">
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<div class="post-content">
					<?php
						woocommerce_output_content_wrapper();
					?>

					<div class="shop-title">
						<div class="left">
							<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

								<h1 class="page-title">
									<?php woocommerce_page_title(); ?>
									<span><?php do_action( 'woocommerce_archive_description' ); ?></span>
								</h1>

								
								<?php woocommerce_result_count(); ?>


							<?php endif; ?>
						</div>

						<div class="right">
							<?php woocommerce_catalog_ordering(); ?>
						</div>
					</div>

						<?php if ( have_posts() ) : ?>
							<?php woocommerce_product_loop_start(); ?>

								<?php woocommerce_product_subcategories(); ?>

								<?php while ( have_posts() ) : the_post(); ?>

									<?php wc_get_template_part( 'content', 'product' ); ?>

								<?php endwhile; // end of the loop. ?>

							<?php woocommerce_product_loop_end(); ?>

							<?php
								/**
								 * woocommerce_after_shop_loop hook
								 *
								 * @hooked woocommerce_pagination - 10
								 */
								do_action( 'woocommerce_after_shop_loop' );
							?>

						<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

							<?php wc_get_template( 'loop/no-products-found.php' ); ?>

						<?php endif; ?>

					<?php
						/**
						 * woocommerce_after_main_content hook
						 *
						 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
						 */
						do_action( 'woocommerce_after_main_content' );
					?>
					</div>
				</div>

				<div class="col-md-3">
					<div class="sidebar">
						<?php
							/**
							 * woocommerce_sidebar hook
							 *
							 * @hooked woocommerce_get_sidebar - 10
							 */
							do_action( 'woocommerce_sidebar' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?php get_footer( 'shop' ); ?>