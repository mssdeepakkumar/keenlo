<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
 get_header(); ?>
<?php while (have_posts()) : the_post(); 

 /* Featured Image/Post Thumbnail - USED FOR PAGE TITLE   */ 
if ( has_post_thumbnail() ) {
	$header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');	?>

	<div class="jumbotron" style="padding-top: 12%; background-image:url(<?php echo $header_img[0]; ?>); no-repeat center center fixed; -webkit-background-size: cover;   -moz-background-size: cover;  -o-background-size: cover;  background-size: cover;">
      <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
      </div>
    </div>	
<?php 
}else{
	?>
	<div class="jumbotron" style="padding-top: 12%; background-color: #333;  -o-background-size: cover;  background-size: cover;">
      <div class="container">
        <h1 class="entry-title"><?php the_title(); ?></h1>
      </div>
    </div>	
<?php     	
}; 
?>
<?php endwhile; // end of the loop. ?>
<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Above Content')) : ?>
<?php endif; ?>	
	<div class="container" style="">
		<div class="row">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Above Content')) : ?>

		<?php endif; ?>				
			<div class="col-md-8">
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
			
						
							<?php get_template_part( 'content', 'page' ); ?>
			
							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || '0' != get_comments_number() )
									comments_template();
							?>
			
						
			
					</main><!-- #main -->
				</div><!-- #primary -->
			</div><!-- .col-md-8 -->
			
			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div><!-- .col-md-4 -->
		</div><!-- .row -->
	</div><!-- .container -->
<?php get_footer(); ?>
