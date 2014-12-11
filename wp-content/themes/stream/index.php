<?php
/**
 * The main template file.
 *
 * 
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
get_header();          
?>
	<div class="container" >
	<div class="row">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Above Content')) : ?>
		<?php endif; ?>	
		<div  class="tab-content home-tabs">
			<?php
	        echo '<div class="col-md-8 col-lg-8">
				  	<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">';

									 if ( have_posts() ) : ?>
									
										<?php while ( have_posts() ) : the_post(); ?>
							
											<?php  // if( $post->ID == $do_not_duplicate ) continue;
												/* Include the Post-Format-specific template for the content.
												 * If you want to override this in a child theme, then include a file
												 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
												 */
												get_template_part('content', get_post_format());												
												$do_not_duplicate = $post->ID;
											?>
							
										<?php endwhile; ?>
							
										<?php 
										upbootwp_content_nav('nav-below'); 
										 else : ?>
											<?php get_template_part( 'no-results', 'index' ); ?>
										<?php endif; ?>
			
						</main><!-- #main -->
					</div><!-- #primary -->
				</div><!-- .col-md-8 -->

			<div id="sidebar" class="col-md-4 col-lg-4">
				<?php get_sidebar(); ?>	
			</div><!-- .col-md-4 -->
		</div><!-- .row -->
	</div><!-- .container -->
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Below Blog/Index')) : ?>


		<?php endif; ?>	
<?php get_footer(); ?>