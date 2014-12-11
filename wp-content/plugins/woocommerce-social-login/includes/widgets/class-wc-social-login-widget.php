<?php
/**
 * WooCommerce Social Login
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Social Login to newer
 * versions in the future. If you wish to customize WooCommerce Social Login for your
 * needs please refer to http://docs.woothemes.com/document/woocommerce-social-login/ for more information.
 *
 * @package     WC-Social-Login/Widget
 * @author      SkyVerge
 * @copyright   Copyright (c) 2014, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *
 * @since 1.0
 */
class WC_Social_Login_Widget extends WP_Widget {


	/**
	 * Setup the widget options
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// set widget options
		$options = array(
			'classname'   => 'widget_wc_social_login',
			'description' => __( 'Display social login buttons.', WC_Social_Login::TEXT_DOMAIN ),
		);

		// instantiate the widget
		parent::__construct( 'WC_Social_Login_Widget', __( 'WooCommerce Social Login', WC_Social_Login::TEXT_DOMAIN ), $options );

	}


	/**
	 * Render the social login widget
	 *
	 * @since 1.3.2-1
	 * @see WP_Widget::widget()
	 * @param array $args widget arguments
	 * @param array $instance saved values from database
	 */
	public function widget( $args, $instance ) {

		$providers = $GLOBALS['wc_social_login']->get_available_providers();

		// Bail if no providers are available
		if ( empty( $providers ) ) {
			return;
		}

		// get the widget configuration
		$title = $instance['title'];

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		woocommerce_social_login_buttons( $instance['return_url'] );

		echo $args['after_widget'];
	}


	/**
	 * Update the widget title & selected product
	 *
	 * @since 1.3.2-1
	 * @see WP_Widget::update()
	 * @param array $new_instance new widget settings
	 * @param array $old_instance old widget settings
	 * @return array updated widget settings
	 */
	public function update( $new_instance, $old_instance ) {

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['return_url'] = strip_tags( $new_instance['return_url'] );

		return $instance;
	}


	/**
	 * Render the admin form for the widget
	 *
	 * @since 1.3.2-1
	 * @see WP_Widget::form()
	 * @param array $instance the widget settings
	 * @return string|void
	 */
	public function form( $instance ) {

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', WC_Social_Login::TEXT_DOMAIN ) ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( isset( $instance['title'] ) ? $instance['title'] : '' ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'return_url' ) ); ?>"><?php _e( 'Return URL', WC_Social_Login::TEXT_DOMAIN ) ?>:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'return_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'return_url' ) ); ?>" value="<?php echo esc_attr( isset( $instance['title'] ) ? $instance['return_url'] : '' ); ?>" />
		</p>
		<?php
	}


} // end \WC_Social_Login_Widget class
