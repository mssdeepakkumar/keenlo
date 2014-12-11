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
 * @package     WC-Social-Login/Classes
 * @author      SkyVerge
 * @copyright   Copyright (c) 2014, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Frontend class
 *
 * @since 1.0
 */
class WC_Social_Login_Frontend {


	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	public function __construct() {

		add_action( 'woocommerce_login_form_end', array( $this, 'render_social_login_buttons' ) );
		add_action( 'woocommerce_before_my_account', array( $this, 'render_social_login_profile' ) );

		add_filter( 'woocommerce_add_notice', array( $this, 'checkout_social_login_message' ) );

		add_shortcode( 'woocommerce_social_login_buttons', array( $this, 'social_login_shortcode' ) );
	}


	/**
	 * Whether social login buttons are displayed on the provided page
	 *
	 * @since 1.0
	 * @param string $handle Exampe: `my_account`
	 * @return bool True if displayed, false otherwise
	 */
	public function is_displayed_on( $handle ) {
		/**
		 * Filter where social login buttons should be displayed.
		 *
		 * @since 1.0
		 * @param array $places
		 */
		return in_array( $handle, apply_filters( 'wc_social_login_display', explode( ',', get_option('wc_social_login_display') ) ) );
	}


	/**
	 * Render social login buttons on frontend
	 *
	 * @since 1.0
	 */
	public function render_social_login_buttons() {

		if ( ! is_checkout() && ! is_account_page() ) {
			return;
		}

		if ( is_checkout() && ! $this->is_displayed_on( 'checkout' ) ) {
			return;
		}

		if ( is_account_page() && ! $this->is_displayed_on( 'my_account' ) ) {
			return;
		}

		$return_url = is_checkout() ? WC()->cart->get_checkout_url() : get_permalink( wc_get_page_id( 'myaccount' ) );

		woocommerce_social_login_buttons( $return_url );
	}


	/**
	 * Render social login profile on frontend
	 *
	 * @since 1.0
	 */
	public function render_social_login_profile() {

		// Return URL after successful login
		$return_url = get_permalink( wc_get_page_id( 'myaccount' ) );

		// Enqueue styles and scripts
		$this->load_styles_scripts();

		// load the template
		wc_get_template(
			'myaccount/social-profiles.php',
			array(
				'linked_profiles'     => $this->get_user_social_login_profiles(),
				'available_providers' => $GLOBALS['wc_social_login']->get_available_providers(),
				'return_url'          => $return_url,
			),
			'',
			$GLOBALS['wc_social_login']->get_plugin_path() . '/templates/'
		);
	}


	/**
	 * Get user's social login profiles
	 *
	 * @since 1.0
	 * @param int $user_id optional Default: current user id
	 * @return array|null Array of found profiles or null if none found
	 */
	public function get_user_social_login_profiles( $user_id = null ) {

		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		$linked_social_login_profiles = array();

		foreach ( $GLOBALS['wc_social_login']->get_available_providers() as $provider ) {

			$social_profile = get_user_meta( $user_id, '_wc_social_login_' . $provider->get_id() . '_profile', true );

			if ( $social_profile ) {

				$linked_social_login_profiles[ $provider->id ] = $social_profile;
			}
		}

		return $linked_social_login_profiles;
	}


	/**
	 * Loads frontend styles and scripts on checkout page
	 *
	 * @since 1.0
	 */
	public function load_styles_scripts() {

		// frontend CSS
		wp_enqueue_style( 'wc-social-login-frontend', $GLOBALS['wc_social_login']->get_plugin_url() . '/assets/css/frontend/wc-social-login.min.css', array(), WC_Social_Login::VERSION );

		// frontend scripts
		wp_enqueue_script( 'wc-social-login-frontend', $GLOBALS['wc_social_login']->get_plugin_url() . '/assets/js/frontend/wc-social-login.min.js', array( 'jquery' ), WC_Social_Login::VERSION );

		// customized button colors
		add_action( 'wp_footer', array( $this, 'button_colors_css' ) );
	}


	/**
	 * Filter the woocommerce_checkout_login message and
	 * append the social login message to it
	 *
	 * @since 1.0
	 * @param string $message
	 * @return string
	 */
	public function checkout_social_login_message( $message ) {

		if ( is_checkout() && $this->is_displayed_on( 'checkout' ) && strpos( $message, '<a href="#" class="showlogin">' ) !== false ) {
			$message .= '. <br/>' . get_option( 'wc_social_login_text' ) . ' <a href="#" class="js-show-social-login">' . __( 'Click here to login', WC_Social_Login::TEXT_DOMAIN ) .'</a>';
		}

		return $message;
	}


	/**
	 * Social Login buttons shortcode. Renders the buttons.
	 *
	 * @since 1.0
	 * @param array $atts associative array of shortcode parameters
	 * @return string shortcode content
	 */
	public function social_login_shortcode( $atts ) {

		// Buffer output
		ob_start();

		woocommerce_social_login_buttons( $atts['return_url'] );

		// Return bufferend contents
		return ob_get_clean();
	}


	/**
	 * Social Login buttons shortcode. Renders the buttons.
	 *
	 * @since 1.0
	 * @return string shortcode content
	 */
	public function button_colors_css() {

		echo '<style type="text/css">';
		foreach ( $GLOBALS['wc_social_login']->get_available_providers() as $provider ) :
			?>
				a.button-social-login.button-social-login-<?php echo esc_attr( $provider->get_id() ); ?>,
				.widget-area a.button-social-login.button-social-login-<?php echo esc_attr( $provider->get_id() ); ?>,
				.social-badge.social-badge-<?php echo esc_attr( $provider->get_id() ); ?> {
					background: <?php echo esc_attr( $provider->get_color() ) ?>;
				}

			<?php
		endforeach;
		echo '</style>';
	}


} // end \WC_Social_Login_Frontend class
