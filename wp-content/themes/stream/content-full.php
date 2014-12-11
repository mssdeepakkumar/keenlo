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
	<?php  
        $slider_toggle =  get_theme_mod('themeslug_postslide'); 
        if($slider_toggle != 'value2'){ 
        echo	
        '	<div class="article-wrap preview-post effect-slide-left" data-effect="slide-left">';
		}else{
		echo '<div class="article-wrap preview-post"> ';
		}; 
	?>	
	<div class="row">
		<?php
		$toggle_postviews =  get_theme_mod('themeslug_postviews'); 
		if($toggle_postviews != 'value2'){?>
			<div class="post-views-counter-tag"><i class="icon-eye-open"></i><?php echo getPostViews(get_the_ID()); ?></div>
		<?php
		}?>
		<div class="col-md-5 entry-tn" style="background-image: url('<?php echo $header_img[0]; ?>');background-repeat:no-repeat; background-size: cover; -webkit-background-size: cover;">
			 <a href="<?php echo the_permalink(); ?>" target="_self"><?php if(function_exists('taqyeem_get_score')) { 			taqyeem_get_score();  		} ?><div class="pad-blog-tn" style=""></div></a>
		</div>
		<div class="col-md-7  art-ent" >
			<div class=" article-entry">
			<header class="entry-header">
				<!-- .entry-meta -->
				<span class="readtime">
					<?php 
					if( function_exists( 'post_read_time' ) ) {
						echo '<i class="icon-bookmark" style="margin-right: 5px;"></i>';
						post_read_time();
					} ?>					        		
				</span><p class="article-post-date"><?php echo get_the_date(); ?></p>
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

				<?php if ( 'post' == get_post_type() ) : ?>

				<?php endif; ?>
			</header><!-- .entry-header -->

			<div class="entry-summary">
				<p class="excerpt"><?php the_excerpt(); ?></p>
				<a href="<?php echo the_permalink(); ?>" target="_self"><button class="moreCta">Read More</button></a>
				<!-- <i class="icon-comments post-comm-link" style=""></i> -->
			</div><!-- .entry-summary -->
	<?php	
	} else { 		?>

	<?php  
        $slider_toggle =  get_theme_mod('themeslug_postslide'); 
        if($slider_toggle != 'value2'){ 
        echo	
        '	<div class="article-wrap preview-post effect-slide-left" data-effect="slide-left">';
		}else{
		echo '<div class="article-wrap preview-post"> ';
		}; 
	?>	
	<div class="row">
		<?php
		$toggle_postviews =  get_theme_mod('themeslug_postviews'); 
		if($toggle_postviews != 'value2'){?>
			<div class="post-views-counter-tag"><i class="icon-eye-open"></i><?php echo getPostViews(get_the_ID()); ?></div>
		<?php
		}?>		
		<div class="col-md-12  art-ent" >
			<div class=" article-entry">
			<header class="entry-header">
				<!-- .entry-meta -->
				<span class="readtime">
					<?php 
					if( function_exists( 'post_read_time' ) ) {
						echo '<i class="icon-bookmark" style="margin-right: 5px;"></i>';
						post_read_time();
					} ?>			
				</span><p class="article-post-date"><?php echo get_the_date(); ?></p>
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>


			</header><!-- .entry-header -->

			<div class="entry-summary">
				<p class="excerpt"><?php the_excerpt(); ?></p>
				<a href="<?php echo the_permalink(); ?>" target="_self"><button class="moreCta">Read More</button></a>
				<!-- <i class="icon-comments post-comm-link" style=""></i> -->
			</div><!-- .entry-summary -->
	<?php }; ?>				



	


	<footer class="entry-meta">


		<?php // if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php // comments_popup_link( __( 'Leave a comment', 'upbootwp' ), __( '1 Comment', 'upbootwp' ), __( '% Comments', 'upbootwp' ) ); ?></span>
		<?php //endif; ?>

		<?php // edit_post_link( __( 'Edit', 'upbootwp' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>

	</div><!-- /div row -->

	</div><!-- /article wrap -->

</article><!-- #post-## -->
