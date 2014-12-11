<?php
/**
 * Plugin Name: rpwe_side
 * Plugin URI: http://fdthemes.com/
 * Description: Recent posts for the sidebar.
 * Version: 1.0
 * Author: Heath Taskis
 * Author URI: http://www.fdthemes.com/
 * Tags: custom post types, post types, latest posts, sidebar widget, plugin
 * License: GPL
 */
class rpwe_side_widget extends WP_Widget {

	/**
	 * Widget setup
	 */
	function __construct() {

		$widget_ops = array(
			'classname'		=> 'rpwe_side_widget recent-posts-extended',
			'description'	=> __( 'Advanced recent posts widget for sidebar.', 'rpwe_side' )
		);

		$control_ops = array(
			'width'		=> 300,
			'height'	=> 350,
			'id_base'	=> 'rpwe_side_widget'
		);

		parent::__construct( 'rpwe_side_widget', __( '&raquo; Recent Posts Widget - Sidebar', 'rpwe_side' ), $widget_ops, $control_ops );

	}

	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$title 			= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$title_url		= $instance['title_url'];
		$cssID 			= $instance['cssID'];
		$limit 			= (int)( $instance['limit'] );
		$offset 		= (int)( $instance['offset'] );
		$gutter = $instance['gutter'];	
		$order 			= $instance['order'];
		$excerpt 		= $instance['excerpt'];
		$length 		= (int)( $instance['length'] );
		$thumb 			= $instance['thumb'];
		//$thumb_height 	= (int)( $instance['thumb_height'] );
		//$thumb_width 	= (int)( $instance['thumb_width'] );
		$thumb_default 	= esc_url( $instance['thumb_default'] );
		//$thumb_align 	= $instance['thumb_align'];
		$cat 			= $instance['cat'];
		$tag 			= $instance['tag'];
		$post_type 		= $instance['post_type'];
		$date 			= $instance['date'];
		$date_format 	= strip_tags( $instance['date_format'] );
		$readmore 		= $instance['readmore'];
		$readmore_text 	= strip_tags( $instance['readmore_text'] );
		$styles_default = $instance['styles_default'];
		$css 			= $instance['css'];

		echo $before_widget;

		if ( $styles_default == true )
			rpwe_side_custom_styles();

		if ( $styles_default == false && ! empty( $css ) )
			echo '<style>' . $css . '</style>';

		if ( ! empty( $title_url ) && ! empty( $title ) )
			echo $before_title . '<a href="' . esc_url( $title_url ) . '" title="' . $title . '">' . $title . '</a>' . $after_title;
		elseif ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		global $post;

			$args = array(
				'numberposts'	=> $limit,
				'category__in'	=> $cat,
				'tag__in'		=> $tag,
				'post_type'		=> $post_type,
				'offset'		=> $offset,
				'order'			=> $order
			);

			$default_args 		= apply_filters( 'rpwe_side_default_query_arguments', $args ); // Allow developer to filter the query.
			$rpwe_sidewidget 		= get_posts( $default_args );

			$offset = ""; 
			$offcss = "";
			if ($gutter == 0){
				$offset = "offset-0";
				$offcss = "width: 80%; padding-left: 2%;";				
			}else{
				$offset = "offset";
				$offcss = "width: 100%; padding-left: 0;";				
			}
		?>

		<div <?php echo( ! empty( $cssID ) ? 'id="' . $cssID . '"' : '' ); ?> class="rpwe-block">

			<div class="row">

				<?php foreach ( $rpwe_sidewidget as $post ) : setup_postdata( $post ); ?>


						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 rpwe-clearfix clearfix cl <?php echo $offset; ?>">

						<?php if ( $thumb == true ) { ?>
							<?php if(function_exists('taqyeem_get_score')) { 			taqyeem_get_score();  		} ?>
							<?php if ( has_post_thumbnail() ) { 
							$rpwe_side_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');	
							?>
							<a href="<?php echo the_permalink(); ?>" target="_self">
								<div style=" width: 100%; height: auto; background-image: url(<?php echo $rpwe_side_img[0] ?>); background-repeat: no-repeat; background-size: cover; -webkit-background-size: cover;"><div class="popular-img" style="padding-top: 75% !important"></div></div></a>
							<?php
							 } else { ?>				
								<?php if ( $thumb_default ) echo '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark"><img class="' . $thumb_align . ' rpwe_side-thumb" src="' . $thumb_default . '" alt="' . esc_attr( get_the_title() ) . '"></a>'; ?>
							<?php } ?>

						<?php } ?>

						<h4 class="rpwe-title" style="<?php echo $offcss; ?>">
							<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'rpwe_side' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h4>

						<?php if ( $date == true ) { ?>
							<time class="rpwe-time published" style="<?php echo $offcss; ?>" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" pubdate><?php echo esc_html( get_the_date( $date_format ) ); ?></time>
						<?php } ?>

						<?php if ( $excerpt == true ) { ?>
							<div class="rpwe-summary" style="<?php echo $offcss; ?>"><?php echo rpwe_side_excerpt( $length ); ?> <?php if ( $readmore == true ) { echo '<div class="reply"><a href="' . esc_url( get_permalink() ) . '" class="rpwe-reply">' . $readmore_text . '</a></div>'; } ?></div>
						<?php } ?>

					</div>

				<?php endforeach; wp_reset_postdata(); ?>

			</div>

		</div><!-- .rpwe_side-block - http://wordpress.org/extend/plugins/recent-posts-widget-extended/ -->

		<?php

		echo $after_widget;

	}

	/**
	 * Update widget
	 */
	function update( $new_instance, $old_instance ) {

		$instance 					= $old_instance;
		$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['title_url'] 		= esc_url_raw( $new_instance['title_url'] );
		$instance['cssID'] 			= sanitize_html_class( $new_instance['cssID'] );
		$instance['limit'] 			= (int)( $new_instance['limit'] );
		$instance['offset'] 		= (int)( $new_instance['offset'] );
		$instance['gutter'] = $new_instance['gutter'];	
		$instance['order'] 			= $new_instance['order'];
		$instance['excerpt'] 		= $new_instance['excerpt'];
		$instance['length'] 		= (int)( $new_instance['length'] );
		$instance['thumb'] 			= $new_instance['thumb'];
		//$instance['thumb_height'] 	= (int)( $new_instance['thumb_height'] );
		//$instance['thumb_width'] 	= (int)( $new_instance['thumb_width'] );
		$instance['thumb_default'] 	= esc_url_raw( $new_instance['thumb_default'] );
		//$instance['thumb_align'] 	= $new_instance['thumb_align'];
		$instance['cat'] 			= $new_instance['cat'];
		$instance['tag'] 			= $new_instance['tag'];
		$instance['post_type'] 		= $new_instance['post_type'];
		$instance['date'] 			= $new_instance['date'];
		$instance['date_format'] 	= strip_tags( $new_instance['date_format'] );
		$instance['readmore'] 		= $new_instance['readmore'];
		$instance['readmore_text'] 	= strip_tags( $new_instance['readmore_text'] );
		$instance['styles_default'] = $new_instance['styles_default'];
		$instance['css'] 			= $new_instance['css'];

		return $instance;

	}

	/**
	 * Widget setting
	 */
	function form( $instance ) {

		$css_defaults = ".rpwe_side-block ul{\n}\n\n.rpwe_side-block li{\n}\n\n.rpwe_side-block a{\n}\n\n.rpwe_side-block h3{\n}\n\n.rpwe_side-thumb{\n}\n\n.rpwe_side-summary{\n}\n\n.rpwe_side-time{\n}\n\n.rpwe_side-alignleft{\n}\n\n.rpwe_side-alignright{\n}\n\n.rpwe_side-alignnone{\n}\n\n.rpwe_side-clearfix:before,\n.rpwe_side-clearfix:after{\ncontent: \"\";\ndisplay: table;\n}\n\n.rpwe_side-clearfix:after{\nclear:both;\n}\n\n.rpwe_side-clearfix{\nzoom: 1;\n}";

		/* Set up some default widget settings. */
		$defaults = array(
			'title' 		=> '',
			'title_url' 	=> '',
			'cssID' 		=> '',
			'limit' 		=> 5,
			'offset' 		=> 0,
			'gutter' 		=> true,			
			'order' 		=> 'DESC',
			'excerpt' 		=> false,
			'length' 		=> 10,
			'thumb' 		=> true,
			//'thumb_height' 	=> 200,
			//'thumb_width' 	=> 200,
			'thumb_default' => 'http://placehold.it/45x45/f0f0f0/ccc',
			//'thumb_align' 	=> 'rpwe_side-alignleft',
			'cat' 			=> '',
			'tag' 			=> '',
			'post_type' 	=> '',
			'date' 			=> true,
			'date_format' 	=> 'F, Y',
			'readmore' 		=> false,
			'readmore_text'	=> __( 'Read More &raquo;', 'rpwe_side' ),
			'styles_default'=> true,
			'css' 			=> $css_defaults
		);

		$instance 		= wp_parse_args( (array)$instance, $defaults );
		$title 			= strip_tags( $instance['title'] );
		$title_url 		= esc_url( $instance['title_url'] );
		$cssID 			= sanitize_html_class( $instance['cssID'] );
		$limit 			= (int)( $instance['limit'] );
		$offset 		= (int)( $instance['offset'] );

		$gutter	= $instance['gutter'];			
		$order 			= $instance['order'];
		$excerpt 		= $instance['excerpt'];
		$length 		= (int)($instance['length']);
		$thumb 			= $instance['thumb'];
		//$thumb_height 	= (int)( $instance['thumb_height'] );
		//$thumb_width 	= (int)( $instance['thumb_width'] );
		$thumb_default 	= $instance['thumb_default'];
		//$thumb_align 	= $instance['thumb_align'];
		$cat 			= $instance['cat'];
		$tag 			= $instance['tag'];
		$post_type 		= $instance['post_type'];
		$date 			= $instance['date'];
		$date_format 	= strip_tags( $instance['date_format'] );
		$readmore 		= $instance['readmore'];
		$readmore_text 	= strip_tags( $instance['readmore_text'] );
		$styles_default	= $instance['styles_default'];
		$css 			= $instance['css'];

		?>

		<div class="rpwe_side-columns-3">

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'rpwe_side' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title_url' ) ); ?>"><?php _e( 'Title URL:', 'rpwe_side' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_url' ) ); ?>" type="text" value="<?php echo $title_url; ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cssID' ) ); ?>"><?php _e( 'CSS ID:', 'rpwe_side' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('cssID')); ?>" name="<?php echo esc_attr($this->get_field_name('cssID')); ?>" type="text" value="<?php echo $cssID; ?>"/>
			</p>
			<p>
				<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'styles_default' ) ); ?>"><?php _e( 'Use Default Styles', 'rpwe_side' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'styles_default' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'styles_default' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $styles_default ); ?> />&nbsp;
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'css' ) ); ?>"><?php _e( 'CSS:', 'rpwe_side' ); ?></label>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'css' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'css' ) ); ?>" style="height:100px;"><?php echo $css; ?></textarea>
				<small><?php _e( 'If you turn off the default styles, please create your own style.', 'rpwe_side' ); ?></small>
			</p>

		</div>
		
		<div class="rpwe_side-columns-3">
			<p>
				<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'gutter' ) ); ?>"><?php _e( 'Show Gutter', 'rpwe_side' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'gutter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gutter' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $gutter ); ?> />&nbsp;
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Limit:', 'rpwe_side' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo $limit; ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php _e( 'Offset (the number of posts to skip):', 'rpwe_side' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="text" value="<?php echo $offset; ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Order:', 'rpwe_side' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" style="width:100%;">
					<option value="DESC" <?php selected( $order, 'DESC' ); ?>><?php _e( 'DESC', 'rpwe_side' ) ?></option>
					<option value="ASC" <?php selected( $order, 'ASC' ); ?>><?php _e( 'ASC', 'rpwe_side' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php _e( 'Limit to Category: ', 'rpwe_side' ); ?></label>
			   	<select class="widefat" multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat' ) ); ?>[]" style="width:100%;">
					<optgroup label="Categories">
						<?php $categories = get_terms( 'category' ); ?>
						<?php foreach( $categories as $category ) { ?>
							<option value="<?php echo $category->term_id; ?>" <?php if ( is_array( $cat ) && in_array( $category->term_id, $cat ) ) echo ' selected="selected"'; ?>><?php echo $category->name; ?></option>
						<?php } ?>
					</optgroup>
   			    </select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php _e( 'Limit to Tag: ', 'rpwe_side' ); ?></label>
			   	<select class="widefat" multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tag' ) ); ?>[]" style="width:100%;">
					<optgroup label="Tags">
						<?php $tags = get_terms( 'post_tag' ); ?>
						<?php foreach( $tags as $post_tag ) { ?>
							<option value="<?php echo $post_tag->term_id; ?>" <?php if ( is_array( $tag ) && in_array( $post_tag->term_id, $tag ) ) echo ' selected="selected"'; ?>><?php echo $post_tag->name; ?></option>
						<?php } ?>
					</optgroup>
   			    </select>

			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php _e( 'Choose the Post Type: ', 'rpwe_side' ); ?></label>
				<?php /* pros Justin Tadlock - http://themehybrid.com/ */ ?>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>">
					<?php foreach ( get_post_types( '', 'objects' ) as $post_type ) { ?>
						<option value="<?php echo esc_attr( $post_type->name ); ?>" <?php selected( $instance['post_type'], $post_type->name ); ?>><?php echo esc_html( $post_type->labels->singular_name ); ?></option>
					<?php } ?>
				</select>
			</p>

		</div>

		<div class="rpwe_side-columns-3 rpwe_side-column-last">

			<?php if ( current_theme_supports( 'post-thumbnails' ) ) { ?>

				<p>
					<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>"><?php _e( 'Display Thumbnail', 'rpwe_side' ); ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'thumb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $thumb ); ?> />&nbsp;
				</p>
				<!--<p>
					<label class="rpwe_side-block" for="<?php echo esc_attr( $this->get_field_id( 'thumb_height' ) ); ?>"><?php _e( 'Thumbnail (height, width, align):', 'rpwe_side' ); ?></label>
					<input class= "small-input" id="<?php echo esc_attr( $this->get_field_id( 'thumb_height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_height' ) ); ?>" type="text" value="<?php echo $thumb_height; ?>"/>
					<input class="small-input" id="<?php echo esc_attr( $this->get_field_id( 'thumb_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_width' ) ); ?>" type="text" value="<?php echo $thumb_width; ?>"/>
					<select class="small-input" id="<?php echo esc_attr( $this->get_field_id( 'thumb_align' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_align' ) ); ?>">
						<option value="rpwe_side-alignleft" <?php selected( $thumb_align, 'rpwe_side-alignleft' ); ?>><?php _e( 'Left', 'rpwe_side' ) ?></option>
						<option value="rpwe_side-alignright" <?php selected( $thumb_align, 'rpwe_side-alignright' ); ?>><?php _e( 'Right', 'rpwe_side' ) ?></option>
						<option value="rpwe_side-alignnone" <?php selected( $thumb_align, 'rpwe_side-alignnone' ); ?>><?php _e( 'Center', 'rpwe_side' ) ?></option>
					</select>
				</p> -->
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'thumb_default' ) ); ?>"><?php _e( 'Default Thumbnail:', 'rpwe_side' ); ?></label>
					<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'thumb_default' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'thumb_default' ) ); ?>" type="text" value="<?php echo $thumb_default; ?>"/>
					<small><?php _e( 'Leave it blank to disable.', 'rpwe_side' ); ?></small>
				</p>

			<?php } ?>

			<p>
				<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>"><?php _e( 'Display Excerpt', 'rpwe_side' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $excerpt ); ?> />&nbsp;
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>"><?php _e( 'Excerpt Length:', 'rpwe_side' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length' ) ); ?>" type="text" value="<?php echo $length; ?>"/>
			</p>
			<p>
				<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'readmore' ) ); ?>"><?php _e( 'Display Readmore', 'rpwe_side' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'readmore' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'readmore' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $readmore ); ?> />&nbsp;
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'readmore_text' ) ); ?>"><?php _e( 'Readmore Text:', 'rpwe_side' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'readmore_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'readmore_text' ) ); ?>" type="text" value="<?php echo $readmore_text; ?>"/>
			</p>
			<p>
				<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php _e( 'Display Date', 'rpwe_side' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $date ); ?> />&nbsp;
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>"><?php _e( 'Date Format:', 'rpwe_side' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_format' ) ); ?>" type="text" value="<?php echo $date_format; ?>"/>
				<small><?php _e( '<a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Date reference</a>', 'rpwe_side' ) ?></small>
			</p>

		</div>

		<div class="clear"></div>

	<?php
	}

}

/**
 * Register widget.
 *
 * @since 0.1
 */
function rpwe_side_register_widget() {
	register_widget( 'rpwe_side_widget' );
}
add_action( 'widgets_init', 'rpwe_side_register_widget' );

/**
 * Print a custom excerpt.
 * http://bavotasan.com/2009/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
 *
 * @since 0.1
 */
function rpwe_side_excerpt( $length ) {

	$excerpt = explode( ' ', get_the_excerpt(), $length );
	if ( count( $excerpt ) >= $length ) {
		array_pop( $excerpt );
		$excerpt = implode( " ", $excerpt );
	} else {
		$excerpt = implode( " ", $excerpt );
	}
	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

	return $excerpt;

}

/**
 * Custom Styles.
 *
 * @since 0.8
 */
function rpwe_side_custom_styles() {
	?>
<style>


</style>
	<?php
}
?>