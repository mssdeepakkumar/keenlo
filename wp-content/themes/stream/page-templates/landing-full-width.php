<?php
/**
 * Template Name: Page - Landing 
 * The template used for displaying page the home page
 *
 * @author Heath Taskis | http://f-d.com.au
 * @package Stream 0.1
 */
get_header(); ?>

<?php while (have_posts()) : the_post(); 

 /* Featured Image/Post Thumbnail  */ 
if ( has_post_thumbnail() ) {
	$header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');		
};	

?>
	<div class="jt-wrap"><div id="featureImage" class="jumbotron" style=" height: 0px; background-image:url(<?php echo $header_img[0]; ?>); no-repeat center center fixed; -webkit-background-size: cover;   -moz-background-size: cover;  -o-background-size: cover;  background-size: cover; background-position: center;">
      <div class="container">
        <h1 class='entry-title homeTitle'><?php /* echo html_entity_decode(get_bloginfo('description')); */ the_title('') ?></h1>

        	




        </button></div></div>
      </div>
    </div>
	<div class="container" style="margin-top: 40px;">
		<div class="row">
			<div class="col-md-12">
				

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Landing Page') ) : ?>  
      <?php endif; ?>  
				
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