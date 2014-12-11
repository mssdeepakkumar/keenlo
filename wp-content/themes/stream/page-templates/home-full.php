<?php
/**
 * Template Name: Home - Fullwidth
 * The template used for displaying page content in page.php
 *
 * @author Heath Taskis | http://f-d.com.au
 * @package FD 0.1
 */
get_header(); 
/*
**
**
**
        Featured Slider
**
**
**
*/ 
?>
<!-- masterslider -->
<?php

  $feat_post = new WP_Query();
  $feat_post->query('category_name=Featured&orderby=rand'); 

  if ( $feat_post->have_posts() ) {
  echo '<div class="master-slider ms-skin-default " id="masterslider">';
  while ($feat_post->have_posts()) : $feat_post->the_post();

  $header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); 

  
  ?>
    <!-- new slide -->
    <div class="ms-slide" data-delay="5">
        <!-- slide background -->
        <img src="<?php echo get_template_directory_uri() ?>/ico/blank.gif" data-src="<?php echo $header_img[0]; ?>" alt="lorem ipsum dolor sit"/>     
        <!-- slide text layer -->
        <div class="ms-layer ms-caption">
        	<span class="readtime"> 
           	<?php 
					if( function_exists( 'post_read_time' ) ) {
						echo '<i class="icon-bookmark" style="margin-right: 5px;"></i>';
						post_read_time();
					} 
			?></span>
        	<h2 class="rounded">FEATURED</h2>

        	<a href="<?php echo the_permalink(); ?>" style="text-decoration:none;">
           	<h1 style="" class="ms-h1"><?php echo the_title(); ?></h1></a>
           	<div class="lead">
           		<?php echo the_excerpt(); ?>
           	</div>
			<a href="<?php echo the_permalink(); ?>" target="_self"><button class="homeCta">Read More</button></a>
        </div>
    </div>
    <!-- end of slide -->
<?php	

$do_not_duplicate = $post->ID;
endwhile; 

//If slider boxed or fullwidth
$slider_toggle =  get_theme_mod('themeslug_slider'); 
if($slider_toggle != 'value1'){ 
	echo '</div>'; //row
	echo '</div>';//container;
	echo '</div>';//marquee wrap;		
}; 

echo '
	</div>
	<!-- end of masterslider -->
	 ';
};


wp_enqueue_script( 'masterslider-settings-js', get_template_directory_uri().'/js/masterslider.settings.js',array(),'20131031',true);    
?>
	<div class="container" >
	<div class="row">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Above Content')) : ?>

		<?php endif; ?>	
		<div  class="tab-content home-tabs">
			<?php
	        echo '<div class="col-md-12 col-lg-12">
				  	<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">';


	

									 if ( have_posts() ) : ?>
									
											<?php 
											if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
											elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
											else { $paged = 1; }

											query_posts('posts_per_page=8&paged=' . $paged); 
											?>

        									<?php while (have_posts()) : the_post(); ?>  
											
											<?php  // if( $post->ID == $do_not_duplicate ) continue;
												/* Include the Post-Format-specific template for the content.
												 * If you want to override this in a child theme, then include a file
												 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
												 */
												get_template_part('content', 'full');												
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
		</div><!-- .row -->
	</div><!-- .container -->
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Below Blog/Index')) : ?>


		<?php endif; ?>	
<?php get_footer(); ?>