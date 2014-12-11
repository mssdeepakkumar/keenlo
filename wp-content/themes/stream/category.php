<?php
/**
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
get_header(); ?>
<?php


	$header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');	
	$categories = get_the_category();
	$separator = ' ';
	$output = '';
	if($categories){


	$thisCat = get_the_category('name');
	//$catImg = 	z_taxonomy_image_url($categories->term_id);

	$catImg = 	z_taxonomy_image_url();	

		if($catImg != ''){
	    	if($thisCat != 'Featured'){
	    		?>
			 	<div class="jumbotron cat-title" style="background-image:url(<?php echo  $catImg ?>); ">
		      <div class="container">
		      	<div class="cat-title-wrap">
			      	<p class="small">Posted in</p>
					<?php
					echo  single_cat_title();	
					?>
		   		</div>
			  </div>
			</div>
			  <?php
	   	 	} 
	   	}else{ 
		?>
		<div class="jumbotron cat-title" style="background-image:url(<?php echo $header_img[0]; ?>); ">
	      <div class="container">
		      	<div class="cat-title-wrap">	      	
	      	<p class="small">Posted in</p>
	        <h1 class="entry-title">
	        	<?php
					echo  single_cat_title();		
				?>
			</h1>
			</div>
		  </div>
	    </div>	<?php
   	}
  




}?>

	<div class="container" style=" padding: 0 15px 0 15px; ">
		<div class="row" style="position:relative;">
			<div style="width: 85%;"><?php echo category_description(); ?></div>
			<hr class="blog-title-rule" style="margin-bottom: 0px;"/>
		</div>
	</div>
	<div class="container" style="margin-top: 40px;">
		<div class="row">

	
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