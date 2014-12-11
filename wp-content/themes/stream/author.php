<?php
/**
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
get_header(); ?>

<?php 

	$header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');	?>

	<div class="jumbotron auth-head" style=" background-image:url(<?php echo $header_img[0]; ?>); no-repeat center center fixed; -webkit-background-size: cover;   -moz-background-size: cover;  -o-background-size: cover;  background-size: cover; background-position: center; ">
      <div class="container">

		</div>
    </div>

    <div class="container auth-desc" style="margin-top: -90px; z-index: 5000;">
    	<div class="row auth-wrap">
          	<div class="auth-thumb" ><?php echo get_avatar( get_the_author_meta('user_email'), $size = '100'); ?></div>
        <div class="by">Articles by</div><h1 class="author-title"> <?php   the_author_meta('display_name');?></h1>
        <p class="auth-desc"><?php the_author_meta( 'description' ); ?></p>
        <div class="auth-social">
        <?php

				 $auth_email = get_the_author_meta('email');
				 $auth_website = get_the_author_meta('website'); 
				 $auth_fb = get_the_author_meta('facebook');
				 $auth_twitter = get_the_author_meta('twitter');
				 $auth_googleplus = get_the_author_meta('googleplus');
				 $auth_linkedin = get_the_author_meta('linkedin');
				 $auth_flickr =  get_the_author_meta('flickr') ;
				 $auth_myspace = get_the_author_meta('myspace');    
				 $auth_digg = get_the_author_meta('digg');      
				 $auth_dribbble = get_the_author_meta('dribbble'); 
				 $auth_youtube = get_the_author_meta('youtube');
				 $auth_tumblr = get_the_author_meta('tumblr');
				 $auth_instagram = get_the_author_meta('instagram');	
				 $auth_posterous = get_the_author_meta('posterous');	
        

			if ($auth_email != ""){ 
				?> 
        		<a href="mailto:<?php echo the_author_meta('email')  ?> "><i class="icon-envelope"></i></a>
        	<?php } 
			if ($auth_twitter != ""){ 
				?>         	
        	<a href="<?php echo the_author_meta('twitter')  ?> "><i class="icon-twitter"></i></a> 
        	<?php } 
			if ($auth_fb != ""){ 
				?>         	
        	<a href="<?php echo the_author_meta('facebook')  ?> "><i class="icon-facebook"></i></a> 
			<?php }
			if ($auth_linkedin != ""){ 
				?>           	        	
        	<a href="<?php echo the_author_meta('linkedin')  ?> "><i class="icon-linkedin"></i></a>   
			<?php }
			if ($auth_googleplus != ""){ 
				?>             	
			<a href="<?php echo the_author_meta('googleplus')  ?> "><i class="icon-google-plus"></i></a>   
			<?php }
			if ($auth_instagram != ""){ 
				?>     			
			<a href="<?php echo the_author_meta('instagram')  ?> "><i class="icon-instagram"></i></a>   
			<?php }
			if ($auth_youtube != ""){ 
				?> 
			<a href="<?php echo the_author_meta('youtube')  ?> "><i class="icon-youtube"></i></a>  
			<?php }
			if ($auth_digg != ""){ 
				?> 
			<a href="<?php echo the_author_meta('digg')  ?> "><i class="icon-digg"></i></a>  
			<?php }
			if ($auth_youtube != ""){ 
				?> 
			<a href="<?php echo the_author_meta('youtube')  ?> "><i class="icon-dribbble"></i></a>  
			<?php }
			if ($auth_tumblr != ""){ 
				?> 
			<a href="<?php echo the_author_meta('tumblr')  ?> "><i class="icon-tumblr"></i></a>  	
			<?php }
			if ($auth_flickr != ""){ 
				?> 
			<a href="<?php echo the_author_meta('flickr')  ?> "><i class="icon-flickr"></i></a>  	
			<?php }		?>			
        </div>
</div>
</div>



	<div class="container" style="margin-top: 40px;">
		<div class="row">

<hr class="auth-title-rule"/>





			
			<div class="col-md-8">
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
					
					<?php if ( have_posts() ) : ?>
					
						<?php while ( have_posts() ) : the_post(); ?>

			
							<?php
								/* Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part('content', get_post_format());
							?>
			
						<?php endwhile; ?>
			
						<?php upbootwp_content_nav('nav-below'); ?>
			
					<?php else : ?>
						<?php get_template_part( 'no-results', 'index' ); ?>
					<?php endif; ?>
			
					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- .col-md-8 -->
			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div><!-- .col-md-4 -->				
		</div><!-- .row -->
	</div><!-- .container -->
<?php get_footer(); ?>