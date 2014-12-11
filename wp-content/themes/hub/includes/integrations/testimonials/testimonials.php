<?php
/**
 * Integrates this theme with the Testimonials by WooThemes plugin
 * http://wordpress.org/plugins/testimonials-by-woothemes/
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Styles
 */
function woo_testimonials_scripts() {
	wp_register_style( 'woo-testimonials-css', get_template_directory_uri() . '/includes/integrations/testimonials/css/testimonials.css' );
	wp_enqueue_style( 'woo-testimonials-css' );
}
add_action( 'wp_enqueue_scripts', 'woo_testimonials_scripts' );


/**
 * Customise Testimonials
 * Change the default testimonials columns to 3. Change the Gravatar size to 100.
 * @param  integer $args['per_row'] Number of columns to display
 * @param  integer $args['size'] Gravatar size
 * @return array Testimonials args
 */
function woo_customise_testimonials( $args ) {
	$args['per_row'] 	= 3;
	$args['size']		= 100;
	return $args;
}
//add_filter( 'woothemes_testimonials_args', 'woo_customise_testimonials', 10 );

function woo_homepage_testimonials_slider_nav( $limit ) {

	// Output Slider Navigation
	$args = array(
		'limit' =>	$limit,
		'size' 	=>	65
	);

	$testimonials = woothemes_get_testimonials( $args );

	if ( 1 < count( $testimonials ) ) {
		echo '<div class="slide-nav"><div class="testimonials component effect-fade"><div class="testimonials-list">';
		foreach ( $testimonials as $testimonial ) {
			echo '<div><a href="#" class="avatar-link">' . $testimonial->image . '</a></div>';
		}
		echo '</div></div></div>';
	} else {
		echo do_shortcode( '[box type="alert"]' . __( 'Setup this section by adding <strong>Testimonials</strong> in <em>Testimonials > Add New</em>.', 'woothemes' ) . '[/box]' );
	}
}

function woo_homepage_testimonials_slider_content( $tpl ) {
	$tpl = '<div><div class="testimonial">%%TEXT%% %%AUTHOR%%</div></div>';
	return $tpl;
}