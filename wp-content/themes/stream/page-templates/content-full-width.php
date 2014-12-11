<?php
/**
 * Template Name: Page - Full width
 * The template used for displaying page content in page.php
 *
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

	<div class="jumbotron" style="padding-top: 15%; background-image:url(<?php echo $header_img[0]; ?>); no-repeat center center fixed; -webkit-background-size: cover;   -moz-background-size: cover;  -o-background-size: cover;  background-size: cover; background-position: center;">
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




	<div class="container" style="margin-top: 40px;">
		<div class="row">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Above Content')) : ?>

		<?php endif; ?>				
			<div class="col-md-12">
				<?php
				if ( has_post_thumbnail() ) { 
				// do nothing 
				}else{ 
				?>
					<header class="entry-header page-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
				<?php 
				}; //endIf ?>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php endwhile; // end of the loop. ?>
					<?php
						wp_link_pages(array(
							'before' => '<div class="page-links">'.__('Pages:', 'upbootwp'),
							'after'  => '</div>',
						));
					?>
				</div><!-- .entry-content -->
				<?php edit_post_link( __( 'Edit', 'upbootwp' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
	
			</div><!-- .col-md-12 -->
		</div><!-- .row -->
	</div><!-- .container -->
<?php get_footer(); ?>