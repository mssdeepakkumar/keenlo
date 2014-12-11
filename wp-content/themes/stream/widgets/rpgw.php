<?php
/**
 * Plugin Name: RPW Gallery
 * Plugin URI: http://mikemattner.com/custom-post-type-widget/
 * Description: Multi-widget for displaying recent posts of custom post types.
 * Version: 1.0
 * Author: Heath Taskis
 * Author URI: http://www.byheath.com/
 * Tags: custom post types, post types, latest posts, sidebar widget, plugin
 * License: GPL
 */
class rpwg_widget extends WP_Widget {

	/**
	 * Widget setup
	 */
	function __construct() {

		$widget_ops = array(
			'classname'		=> 'rpwg_widget recent-posts-gallery',
			'description'	=> __( 'Advanced recent posts widget.', 'rpwg' )
		);

		$control_ops = array(
			'width'		=> 300,
			'height'	=> 350,
			'id_base'	=> 'rpwg_widget'
		);

		parent::__construct( 'rpwg_widget', __( '&raquo; Recent Posts Gallery Widget', 'rpwg' ), $widget_ops, $control_ops );

	}

	/**
	 * Display widget
	 */
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$title 			= apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$title_url		= $instance['title_url'];
		$msg			= $instance['msg'];
		$limit 			= (int)( $instance['limit'] );
		$offset 		= (int)( $instance['offset'] );
		$gutter 		= $instance['gutter'];	
		$order 			= $instance['order'];
		$excerpt 		= $instance['excerpt'];
		$length 		= (int)( $instance['length'] );
		$thumb_default 	= esc_url( $instance['thumb_default'] );
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









		global $post;

			$args = array(
				'numberposts'	=> $limit,
				'category__in'	=> $cat,
				'tag__in'		=> $tag,
				'msg'		=> $msg,				
				'post_type'		=> $post_type,
				'offset'		=> $offset,
				'order'			=> $order
			);

			$default_args 		= apply_filters( 'rpwg_default_query_arguments', $args ); // Allow developer to filter the query.
			$rpwgwidget 		= get_posts( $default_args );

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

		<div <?php echo( ! empty( $cssID ) ? 'id="' . $cssID . '"' : '' ); ?> class="rpwg-block">

			<div class="row">
<?php 

  echo '<div class="row recent-gallery-wrapper">';
  echo '<div class="col-lg-7 col-md-7 carousel slide recent-gallery" id="myCarousel" >';
  echo '<div class="master-slider ms-skin-default " id="masterslider2">';


foreach ( $rpwgwidget as $post ) : setup_postdata( $post ); ?>

<?php 
if ( has_post_thumbnail() ) { 
	$rpwg_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');	
?>
  	<div class="ms-slide">
	<img src="<?php echo get_template_directory_uri() ?>/ico/blank.gif" data-src="<?php echo $rpwg_img[0] ?>" alt="<?php echo esc_attr( get_the_title() ) ?>" />   
	<div class="ms-layer ms-caption" style="bottom: 65px !important; left:20px;">
		<h3><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'rpwe' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="rpgw-link"><?php the_title(); ?></a></h3>
		<?php 
		if ( $date == true ) { ?>
			<time class="rpwg-time published" style="<?php echo $offcss; ?>" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" pubdate><?php echo esc_html( get_the_date( $date_format ) ); ?></time>
		<?php 
		} // end if date?> 
		<?php if ( $excerpt == true ) { ?>
			<div class="rpwe-summary" style="<?php echo $offcss; ?>"><?php echo rpwe_excerpt( $length ); ?> <?php if ( $readmore == true ) { echo '<div class="reply"><a href="' . esc_url( get_permalink() ) . '" class="rpwe-reply">' . $readmore_text . '</a></div>'; } ?></div>
		<?php } ?>
    </div> 
    </div><!-- ms slide -->
    <?php
} //has post thumb

?>
					<?php endforeach; wp_reset_postdata(); ?>

			

		</div><!-- master-slider  -->
</div>
		<?php
    echo '<div class="col-lg-5 col-md-5 recent-gallery-meta">';
        // WIDGET TITLE
    // 
    if (!empty($title))
    echo '<h2>' . $title . '</h2>';;
    echo '<div class=" ">';

    echo '<p>'.$msg.'</p>';
     
    echo '</div>';
    echo '</div>';   
    echo '</div>';    
    echo '</div>';    
    echo '</div>';
    wp_enqueue_script( 'masterslider-settings-recent-js', get_template_directory_uri().'/js/masterslider-showcase.settings.js',array(),'20131031',true);  
		echo $after_widget;

	}

	/**
	 * Update widget
	 */
	function update( $new_instance, $old_instance ) {

		$instance 					= $old_instance;
		$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['title_url'] 		= esc_url_raw( $new_instance['title_url'] );
		$instance['limit'] 			= (int)( $new_instance['limit'] );
		$instance['offset'] 		= (int)( $new_instance['offset'] );
		$instance['gutter'] = $new_instance['gutter'];	
		$instance['msg'] = $new_instance['msg'];			
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



		return $instance;

	}

	/**
	 * Widget setting
	 */
	function form( $instance ) {

		$css_defaults = ".rpwg-block ul{\n}\n\n.rpwg-block li{\n}\n\n.rpwg-block a{\n}\n\n.rpwg-block h3{\n}\n\n.rpwg-thumb{\n}\n\n.rpwg-summary{\n}\n\n.rpwg-time{\n}\n\n.rpwg-alignleft{\n}\n\n.rpwg-alignright{\n}\n\n.rpwg-alignnone{\n}\n\n.rpwg-clearfix:before,\n.rpwg-clearfix:after{\ncontent: \"\";\ndisplay: table;\n}\n\n.rpwg-clearfix:after{\nclear:both;\n}\n\n.rpwg-clearfix{\nzoom: 1;\n}";

		/* Set up some default widget settings. */
		$defaults = array(
			'title' 		=> '',
			'title_url' 	=> '',
			'msg' 			=> '',
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
			//'thumb_align' 	=> 'rpwg-alignleft',
			'cat' 			=> '',
			'tag' 			=> '',
			'post_type' 	=> '',
			'date' 			=> true,
			'date_format' 	=> 'F, Y',
			'readmore' 		=> false,
			'readmore_text'	=> __( 'Read More &raquo;', 'rpwg' )

		);

		$instance 		= wp_parse_args( (array)$instance, $defaults );
		$title 			= strip_tags( $instance['title'] );
		$title_url 		= esc_url( $instance['title_url'] );
		$limit 			= (int)( $instance['limit'] );
		$offset 		= (int)( $instance['offset'] );
		$msg 			= strip_tags( $instance['msg'] );
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


		?>

		<div class="rpwg-columns-3">

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'rpwg' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title_url' ) ); ?>"><?php _e( 'Title URL:', 'rpwg' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_url' ) ); ?>" type="text" value="<?php echo $title_url; ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'msg' ) ); ?>"><?php _e( 'Message:', 'rpwg' ); ?></label>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'msg' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'msg' ) ); ?>" type="text-area" value="<?php echo $msg; ?>"></textarea>
			</p>


		</div>
		
		<div class="rpwg-columns-3">
			<p>
				<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'gutter' ) ); ?>"><?php _e( 'Show Gutter', 'rpwg' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'gutter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gutter' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $gutter ); ?> />&nbsp;
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Limit:', 'rpwg' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="text" value="<?php echo $limit; ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php _e( 'Offset (the number of posts to skip):', 'rpwg' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="text" value="<?php echo $offset; ?>"/>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Order:', 'rpwg' ); ?></label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>" style="width:100%;">
					<option value="DESC" <?php selected( $order, 'DESC' ); ?>><?php _e( 'DESC', 'rpwg' ) ?></option>
					<option value="ASC" <?php selected( $order, 'ASC' ); ?>><?php _e( 'ASC', 'rpwg' ) ?></option>
				</select>
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'cat' ) ); ?>"><?php _e( 'Limit to Category: ', 'rpwg' ); ?></label>
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'tag' ) ); ?>"><?php _e( 'Limit to Tag: ', 'rpwg' ); ?></label>
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
				<label for="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>"><?php _e( 'Choose the Post Type: ', 'rpwg' ); ?></label>
				<?php /* pros Justin Tadlock - http://themehybrid.com/ */ ?>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'post_type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'post_type' ) ); ?>">
					<?php foreach ( get_post_types( '', 'objects' ) as $post_type ) { ?>
						<option value="<?php echo esc_attr( $post_type->name ); ?>" <?php selected( $instance['post_type'], $post_type->name ); ?>><?php echo esc_html( $post_type->labels->singular_name ); ?></option>
					<?php } ?>
				</select>
			</p>

		</div>

		<div class="rpwg-columns-3 rpwg-column-last">

			<p>
				<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>"><?php _e( 'Display Excerpt', 'rpwg' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $excerpt ); ?> />&nbsp;
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>"><?php _e( 'Excerpt Length:', 'rpwg' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length' ) ); ?>" type="text" value="<?php echo $length; ?>"/>
			</p>
			<p>
				<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'readmore' ) ); ?>"><?php _e( 'Display Readmore', 'rpwg' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'readmore' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'readmore' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $readmore ); ?> />&nbsp;
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'readmore_text' ) ); ?>"><?php _e( 'Readmore Text:', 'rpwg' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'readmore_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'readmore_text' ) ); ?>" type="text" value="<?php echo $readmore_text; ?>"/>
			</p>
			<p>
				<label class="input-checkbox" for="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>"><?php _e( 'Display Date', 'rpwg' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $date ); ?> />&nbsp;
			</p>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>"><?php _e( 'Date Format:', 'rpwg' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'date_format' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_format' ) ); ?>" type="text" value="<?php echo $date_format; ?>"/>
				<small><?php _e( '<a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">Date reference</a>', 'rpwg' ) ?></small>
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
function rpwg_register_widget() {
	register_widget( 'rpwg_widget' );
}
add_action( 'widgets_init', 'rpwg_register_widget' );

/**
 * Print a custom excerpt.
 * http://bavotasan.com/2009/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
 *
 * @since 0.1
 */
function rpwg_excerpt( $length ) {

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
function rpwg_custom_styles() {
	?>
<style>


</style>
	<?php
}
?>