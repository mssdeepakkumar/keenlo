<?php
/**
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	if ( has_post_thumbnail() ) {

		$header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');	?>
	<?php  

	?>	
	<div class=" preview-post effect-slide-left" data-effect="slide-left">
	<div class="row article-medium">

		<div class="entry-tn-medium" style="background-image: url('<?php echo $header_img[0]; ?>');background-repeat:no-repeat; background-size: cover; -webkit-background-size: cover;">
			 <div class="pad-blog-tn" style=""></div></a>
		</div>	

			<div class="article-entry-medium">
				<header class="entry-header">
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<p class="article-post-date"><?php echo get_the_date(); ?></p>					
				</header><!-- .entry-header -->
				<div class="entry-summary">
					<p class="excerpt"><?php the_excerpt(); ?></p>
<!-- .entry-meta -->
					<span class="readtime">
					<?php 
					if( function_exists( 'post_read_time' ) ) {
						echo '<i class="icon-bookmark" style="margin-right: 5px;"></i>';
						post_read_time();
					} ?>						        		
					</span>				
					<a href="<?php echo the_permalink(); ?>" target="_self"><button class="moreCta">Read More</button></a>
					<!-- <i class="icon-comments post-comm-link" style=""></i> -->
				</div><!-- .entry-summary -->
			</div>


	<?php	
	} else { 		?>
	<?php }; ?>				
	<footer class="entry-meta">
		<span class="comments-link">
		<?php //endif; ?>
	</footer>
	</div><!-- /div row -->
	</div><!-- /article wrap -->
</article><!-- #post-## -->
