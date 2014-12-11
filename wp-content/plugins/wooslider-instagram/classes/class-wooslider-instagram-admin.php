<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooSlider Instagram Admin Class
 *
 * @package WordPress
 * @subpackage Wooslider_Instagram
 * @category Admin
 * @author WooThemes
 * @since 1.0.0
 */
class Wooslider_Instagram_Admin {
	private $_hook;
	private $_file;
	private $_token;
	private $_api;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file, $api_obj ) {
		$this->_file = $file;
		$this->_token = 'wooslider-instagram';
		$this->_api = $api_obj;

		add_action( 'admin_menu', array( $this, 'register_screen' ) );

		// Maybe display admin notices.
        add_action( 'admin_notices', array( $this, 'maybe_display_admin_notices' ) );
	} // End __construct()

	public function maybe_display_admin_notices () {
		if ( isset( $_GET['page'] ) && $this->_token == $_GET['page'] ) return; // Don't show these notices on our admin screen.

		$settings = $this->_get_settings();
		if ( ! isset( $settings['access_token'] ) || '' == $settings['access_token'] ) {
			echo '<div class="updated fade"><p>' . sprintf( __( '%sWooSlider Instagram is almost ready.%s To get started, %sconnect your Instagram account%s.', 'wooslider-instagram' ), '<strong>', '</strong>', '<a href="' . esc_url( admin_url( 'edit.php?post_type=slide&page=wooslider-instagram' ) ) . '">', '</a>' ) . '</p></div>' . "\n";
		}
	} // End maybe_display_admin_notices()

	/**
	 * Register the admin screen within WordPress.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function register_screen () {
		$this->_hook = add_submenu_page( 'edit.php?post_type=slide', __( 'Instagram', 'wooslider-instagram' ), __( 'Instagram', 'wooslider-instagram' ), 'manage_options', $this->_token, array( $this, 'admin_screen' ) );

		add_action( 'load-' . $this->_hook, array( $this, 'admin_screen_logic' ) );
	} // End register_screen()

	/**
	 * Logic for the admin screen.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function admin_screen_logic () {
		if ( ! empty( $_POST ) && check_admin_referer( 'wooslider-instagram', 'wooslider-instagram-nonce' ) ) {
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
				$access_data = $this->_api->get_access_token( esc_html( $_POST['instagram-username'] ), esc_html( $_POST['instagram-password'] ) );

				if ( isset( $access_data->error_type ) ) {
					$this->_log_error( $access_data );
				} else {
					$updated = 'true';
					// Save settings.
					$saved = (bool)$this->_save_settings( array( 'access_token' => (string)$access_data->access_token, 'user' => (object)$access_data->user ) );
				}
			}

			wp_safe_redirect( admin_url( 'edit.php?post_type=slide&page=' . urlencode( $this->_token ) . '&updated=' . urlencode( $updated ) . $disconnected ) );
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
		global $title;
		$html = '<div id="wooslider-instagram-settings" class="wrap">' . "\n";
		$html .= get_screen_icon( 'wooslider' );
		$html .= '<h2>' . sprintf( __( '%s Settings', 'wooslider-instagram-nonce' ), $title ) . '</h2>' . "\n";
		$html .= $this->_maybe_display_error();
		$html .= '<table class="form-table">' . "\n";
		$html .= '<tr>' . "\n";
		$html .= $this->_get_instagram_connect_html() . "\n";
		$html .= '</tr>' . "\n";
		$html .= '</table>' . "\n";
		$html .= '</div><!--/.wrap-->' . "\n";
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
		$html = '<form method="post">' . "\n";
		$html .= wp_nonce_field( 'wooslider-instagram', 'wooslider-instagram-nonce', true, false );
		if ( '' == $settings['access_token'] ) {
			$html .= '<h3>' . __( 'Connect your Instagram Account', 'wooslider-instagram' ) . '</h3>' . "\n";
			// If we don't have an access token, provide a form to connect.
			$html .= '<th scope="row"><label for="instagram-username">' . __( 'Instagram Username:' , 'wooslider-instagram' ) . '</th><td><input type="text" size="20" name="instagram-username" class="regular-text" value="" /></td>' . "\n";
			// Close and open a new row.
			$html .= '</tr><tr>' . "\n";
			$html .= '<th scope="row"><label for="instagram-password">' . __( 'Instagram Password:' , 'wooslider-instagram' ) . '</th><td><input type="password" size="20" name="instagram-password" class="regular-text" value="" /></label></td>' . "\n";
			// Close and open a new row.
			$html .= '</tr><tr>' . "\n";
			$html .= '<th scope="row"></th><td>' . get_submit_button( __( 'Connect Instagram Account', 'wooslider-instagram' ), 'primary', 'submit', false ) . '</td>' . "\n";
		} else {
			// Otherwise, provide a form to disconnect.
			$html .= '<h3>' . __( 'Disconnect your Instagram Account', 'wooslider-instagram' ) . '</h3>' . "\n";
			$html .= '<th scope="row">' . sprintf( __( 'Currently connected as %s.', 'wooslider-instagram' ), '<strong>' . $settings['user']->username . '</strong>' ) . '</th><td valign="top">' . get_submit_button( __( 'Disconnect Instagram Account', 'wooslider-instagram' ), 'primary', 'submit', false ) . '<input type="hidden" name="disconnect-instagram" value="true" />' . '</td>' . "\n";
		}
		$html .= '</form>' . "\n";

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
			$html = '<div class="error fade"><p><strong>' . sprintf( __( 'Error code %s', 'wooslider-instagram' ), $data->code ) . '</strong> - ' . esc_html( $data->error_message ) . '</p></div>' . "\n";
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