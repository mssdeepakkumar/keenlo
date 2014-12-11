<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Start WooThemes Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

// WooFramework init
require_once ( get_template_directory() . '/functions/admin-init.php' );

/*-----------------------------------------------------------------------------------*/
/* Load the theme-specific files, with support for overriding via a child theme.
/*-----------------------------------------------------------------------------------*/

$includes = array(
				'includes/theme-options.php', 				// Options panel settings and custom settings
				'includes/theme-functions.php', 			// Custom theme functions
				'includes/theme-actions.php', 				// Theme actions & user defined hooks
				'includes/theme-comments.php', 				// Custom comments/pingback loop
				'includes/theme-js.php', 					// Load JavaScript via wp_enqueue_script
				'includes/sidebar-init.php', 				// Initialize widgetized areas
				'includes/theme-widgets.php',				// Theme widgets
				'includes/theme-plugin-integrations.php'	// Plugin integrations
				);

// Allow child themes/plugins to add widgets to be loaded.
$includes = apply_filters( 'woo_includes', $includes );

foreach ( $includes as $i ) {
	locate_template( $i, true );
}

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/



add_filter( 'product_vendors_vendor_slug', 'change_vendor_url_slug' );
function change_vendor_url_slug( $slug ) {
  $slug = 'store';
  return $slug;
}




add_filter( 'product_enquiry_send_to', 'wc_product_enquiry_to_vendor', 10, 2 );
function wc_product_enquiry_to_vendor( $email, $product_id ) {
  	$vendors = get_product_vendors( $product_id );
	if ( ! empty( $vendors ) ) {
		$emails = array();
		foreach( $vendors as $vendor ) {
			foreach( $vendor->admins as $admin ) {
				$emails[] = $admin->data->user_email;
			}
		}
		return $emails;
	}
	return $email;
}

// Creating the widget 
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'wpb_widget', 

// Widget name will appear in UI
__('Vendor Additional Info Widget', 'wpb_widget_domain'), 

// Widget description
array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$uri = $_SERVER["REQUEST_URI"];
$ex_plode =explode("/",$uri);
if($ex_plode[1] == "store"){
		$u_name = $ex_plode[2];
	
		global $wpdb;
		$results2 = $wpdb->get_results( 'SELECT name FROM wp_terms WHERE slug = "'.$u_name.'"');
		$v_name = $results2[0]->name;
		$results = $wpdb->get_results( 'SELECT term_id FROM wp_terms WHERE slug = "'.$u_name.'"');
		$v_id = $results[0]->term_id;
		$results2 = $wpdb->get_results( 'SELECT option_value FROM wp_options WHERE option_name = "shop_vendor_'.$v_id.'"');
$aa = unserialize($results2[0]->option_value);

}
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
//echo __( 'Hello, World!', 'wpb_widget_domain' );
echo stripslashes($aa['desc2']);
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 

<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
	register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );



/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/
?>



