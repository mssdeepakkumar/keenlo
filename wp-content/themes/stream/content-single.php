<?php
/**
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<!-- <h1 class="entry-title"><?php the_title(); ?></h1> -->


	</header><!-- .entry-header -->

	<div class="entry-content">
<?php if ( has_post_thumbnail() ) {
		$header_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');	?>

		<a href="<?php echo the_permalink(); ?>" target="_self"><img src="<?php echo $header_img[0]; ?>" class="post-img" /></a>
		<div class="img-caption-wrapper">
			<?php
			//The Image Caption - Title 
			?> 
			<span class="img-caption-title"><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></span>
			<?php
			//The Image Caption - Description 
			?> 			
			<span class="img-caption-desc"><?php   	echo get_post(get_post_thumbnail_id())->post_content; ?></span>
		</div>
				
		
	<?php }; ?>	
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'upbootwp' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'upbootwp' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'upbootwp' ) );

			if ( ! upbootwp_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( ' %2$s.', 'upbootwp' );
				} else {
					// $meta_text = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'upbootwp' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( 'in %1$s <br><br> %2$s. ', 'upbootwp' );
				} else {
					$meta_text = __( ' in %1$s.', 'upbootwp' );
				}

			} // end check for categories on this blog

			printf(
				//$meta_text,
				$category_list,
				$tag_list,
				get_permalink(),
				the_title_attribute( 'echo=0' )
			);
		?>

		<?php edit_post_link( __( 'Edit', 'upbootwp' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
