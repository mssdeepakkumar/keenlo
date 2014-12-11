<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Instagram Integration
 *
 * Enables Instagram integration.
 *
 * @class 		Woocommerce_Instagram_Integration
 * @extends		WC_Integration
 * @version		1.6.4
 * @package		WooCommerce/Classes/Integrations
 * @author 		WooThemes
 */
class Woocommerce_Instagram_Integration extends WC_Integration {
	/**
	 * Init and hook in the integration.
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function __construct() {
        $this->id					= 'instagram';
        $this->_token				= 'woocommerce-instagram';
        $this->method_title     	= __( 'Instagram', 'woocommerce-instagram' );
        $this->method_description	= __( 'Connect to your Instagram account, to display product-related Instagrams on each individual product screen.', 'woocommerce-instagram' );

		// Actions
		add_action( 'woocommerce_update_options_integration_instagram', array( $this, 'admin_screen_logic' ) );

		add_action( 'init', array( $this, 'maybe_start_output_buffer' ) );
    } // End __construct()

    /**
	 * Admin Options
	 * Override from the WC_Integration abstract.
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function admin_options () {
?>
		<h3><?php echo isset( $this->method_title ) ? $this->method_title : __( 'Settings', 'woocommerce-instagram' ) ; ?></h3>
		<?php echo isset( $this->method_description ) ? wpautop( $this->method_description ) : ''; ?>
		<?php $this->generate_settings_html(); ?>
		<!-- Section -->
		<div><input type="hidden" name="section" value="<?php echo esc_attr( $this->id ); ?>" /></div>
<?php
	} // End admin_options()

    public function generate_settings_html () {
    	$GLOBALS['hide_save_button'] = true;
    	$this->admin_screen();
    	$GLOBALS['hide_save_button'] = false;
    } // End generate_settings_html()

    /**
	 * Start the output buffer, so we can do a safe redirect.
	 * @access  public
	 * @since   1.0.3
	 * @return  void
	 */
    public function maybe_start_output_buffer () {
    	if ( is_admin() && isset( $_GET['tab'] ) && isset( $_GET['section'] ) && 'integration' == $_GET['tab'] && 'instagram' == $_GET['section'] ) {
    		ob_start();
    	}
    } // End maybe_start_output_buffer()

	/**
	 * Logic for the admin screen.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_screen_logic () {
		if ( ! empty( $_POST ) && check_admin_referer( 'woocommerce-instagram', 'woocommerce-instagram-nonce' ) ) {
			global $woocommerce_instagram; // Load in the global so we can use the API instance.
			$disconnected = '';
			if ( isset( $_POST['disconnect-instagram'] ) && 'true' == $_POST['disconnect-instagram'] ) {
				// Disconnect the account, if need be.
				$updated = 'true';
				$saved = (bool)$this->_save_settings( array( 'access_token' => '', 'user' => new StdClass() ) );
				$disconnected = '&disconnected=true';
				// Look into clearing transients, here.
			} else {
				$updated = 'false';
				// Get access token and user data.
				$access_data = $woocommerce_instagram->api->get_access_token( esc_html( $_POST['instagram-username'] ), esc_html( $_POST['instagram-password'] ) );

				if ( isset( $access_data->error_type ) ) {
					$this->_log_error( $access_data );
				} else {
					$updated = 'true';
					// Save settings.
					$saved = (bool)$this->_save_settings( array( 'access_token' => (string)$access_data->access_token, 'user' => (object)$access_data->user ) );
				}
			}

			if ( version_compare( '2.1', WOOCOMMERCE_VERSION, '>' ) ) {
				$page = 'woocommerce_settings';
			} else {
				$page = 'wc-settings';
			}
			$url = add_query_arg( 'page', $page, admin_url( 'admin.php' ) );
			$url = add_query_arg( 'tab', 'integration', $url );
			$url = add_query_arg( 'section', 'instagram', $url );

			$url = add_query_arg( 'updated', urlencode( $updated ), $url );
			$url .= $disconnected;

			wp_safe_redirect( $url );
			exit;
		}
	} // End admin_screen_logic()

	/**
	 * The contents of the WordPress admin screen.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_screen () {
		$html = '';
		$html .= $this->_maybe_display_error();
		$html .= wp_nonce_field( 'woocommerce-instagram', 'woocommerce-instagram-nonce', true, false );
		$html .= '<table class="form-table">' . "\n";
		$html .= '<tr>' . "\n";
		$html .= $this->_get_instagram_connect_html() . "\n";
		$html .= '</tr>' . "\n";
		$html .= '</table>' . "\n";
		echo $html;
	} // End admin_screen()

	/**
	 * Return HTML for connecting or disconnecting the access token.
	 * @access  private
	 * @since   1.0.0
	 * @return  string HTML.
	 */
	private function _get_instagram_connect_html () {
		$settings = $this->_get_settings();
		if ( '' == $settings['access_token'] ) {
			$html = '';
			// If we don't have an access token, provide a form to connect.
			$html .= '<th scope="row" class="titledesc"><label for="instagram-username">' . __( 'Instagram Username:' , 'woocommerce-instagram' ) . '</th><td class="forminp"><input type="text" size="20" name="instagram-username" class="regular-text regular-input" value="" /></td>' . "\n";
			// Close and open a new row.
			$html .= '</tr><tr>' . "\n";
			$html .= '<th scope="row" class="titledesc"><label for="instagram-password">' . __( 'Instagram Password:' , 'woocommerce-instagram' ) . '</th><td class="forminp"><input type="password" size="20" name="instagram-password" class="regular-text regular-input" value="" /></label></td>' . "\n";
			// Close and open a new row.
			$html .= '</tr><tr>' . "\n";
			$html .= '<th scope="row"></th><td>' . get_submit_button( __( 'Connect Instagram Account', 'woocommerce-instagram' ), 'primary', 'submit', false ) . '</td>' . "\n";
		} else {
			// Otherwise, provide a form to disconnect.
			$html = '';
			$html .= '<th scope="row">' . sprintf( __( 'Currently connected as %s.', 'woocommerce-instagram' ), '<strong>' . $settings['user']->username . '</strong>' ) . '</th><td valign="top">' . get_submit_button( __( 'Disconnect Instagram Account', 'woocommerce-instagram' ), 'primary', 'submit', false ) . '<input type="hidden" name="disconnect-instagram" value="true" />' . '</td>' . "\n";
		}

		return $html;
	} // End _get_instagram_connect_html()

	/**
	 * Display the error, if one is logged.
	 * @access  private
	 * @since   1.0.0
	 * @return  string Formatted HTML markup.
	 */
	private function _maybe_display_error () {
		$transient_key = $this->_token . '-request-error';
		if ( false !== ( $data = get_transient( $transient_key ) ) ) {
			$html = '<div class="error fade"><p><strong>' . sprintf( __( 'Error code %s', 'woocommerce-instagram' ), $data->code ) . '</strong> - ' . esc_html( $data->error_message ) . '</p></div>' . "\n";
			delete_transient( $transient_key );
			return $html;
		}
	} // End _log_error()

	/**
	 * Log an error, for display on the settings screen.
	 * @access  private
	 * @since   1.0.0
	 * @param   object $error_obj An error object containing code, error_type and error_message.
	 * @return  void
	 */
	private function _log_error ( $error_obj ) {
		set_transient( $this->_token . '-request-error', (object)$error_obj, 10 );
	} // End _log_error()

	/**
	 * Save settings.
	 * @access  private
	 * @since   1.0.0
	 * @return  boolean
	 */
	private function _save_settings ( $settings = array() ) {
		$current_settings = $this->_get_settings();
		$settings = wp_parse_args( $settings, $current_settings );
		return (bool) update_option( $this->_token . '-settings', (array)$settings );
	} // End _save_settings()

	/**
	 * Retrieve stored settings.
	 * @access  private
	 * @since   1.0.0
	 * @return  array Stored settings.
	 */
	private function _get_settings () {
		return wp_parse_args( (array)get_option( $this->_token . '-settings', array( 'access_token' => '', 'user' => new StdClass() ) ), array( 'access_token' => '', 'user' => new StdClass() ) );
	} // End _get_settings()
} // End Class
?>