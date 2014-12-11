<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooSlider "Instagram" Widget Class
 *
 * Widget class for the "Instagram" widget for WooSlider.
 *
 * @package WordPress
 * @subpackage Wooslider_Instagram
 * @category Widgets
 * @author WooThemes
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * - __construct()
 * - generate_slideshow()
 */
class Wooslider_Instagram_Widget extends WooSlider_Widget_Base {
	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct () {
		/* Widget variable settings. */
		$this->slider_type = 'instagram';
		$this->woo_widget_cssclass = 'widget_wooslider_slideshow_instagram';
		$this->woo_widget_description = __( 'A slideshow of your Instagram feed', 'wooslider-instagram' );
		$this->woo_widget_idbase = 'wooslider_slideshow_instagram';
		$this->woo_widget_title = __('Instagram Slideshow (WooSlider)', 'wooslider-instagram' );

		$this->init();

		$this->defaults = array(
						'title' => __( 'Instagram Feed', 'wooslider-instagram' )
					);
	} // End Constructor

	/**
	 * Generate the HTML for this slideshow.
	 * @since  1.0.0
	 * @return string The generated HTML.
	 */
	protected function generate_slideshow ( $instance ) {
		global $wooslider;
		$settings = $wooslider->settings->get_settings();
		$settings['slider_type'] = $this->slider_type;

		$extra_args = array();

		foreach ( $instance as $k => $v ) {
			if ( ! in_array( $k, array_keys( $settings ) ) ) {
				$extra_args[$k] = esc_attr( $v );
			}
		}

		// Make sure the various settings are applied.
		if ( isset( $instance['show_advanced_settings'] ) && ( $instance['show_advanced_settings'] == true ) ) {
			foreach ( $settings as $k => $v ) {
				if ( isset( $instance[$k] ) && ( $instance[$k] != $settings[$k] ) ) {
					$settings[$k] = esc_attr( $instance[$k] );
				}
			}
		}

		$html = wooslider( $settings, $extra_args, false );

		return $html;
	} // End generate_slideshow()
} // End Class
?>