<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooSlider Instagram API Class
 *
 * @package WordPress
 * @subpackage Wooslider_Instagram
 * @category API
 * @author WooThemes
 * @since 1.0.0
 */
class Wooslider_Instagram_API {
	protected $_transient_expire_time;
	private $_client_id;
	private $_client_secret;
	private $_api_url = 'https://api.instagram.com/';
	private $_token = 'wooslider-instagram';
	private $_username;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file ) {
		$this->_file = $file;
		$this->_transient_expire_time = 60 * 60 * 24; // 1 day.
		$this->_client_id = '79a1ad0924854bad93558757ff86c7f7';
		$this->_client_secret = '2feefd865b5643909395d81135af7840';
	} // End __construct()

	/**
	 * Retrieve stored self/media/recent images.
	 * @access  public
	 * @since   1.0.0
	 * @param   array $args
	 * @return  array
	 */
	public function get_self_media_recent ( $args ) {
		$settings = $this->_get_settings();
		if ( isset( $settings['user']->username ) ) {
			$this->_username = 'wooslider-' . $settings['user']->username;
		} else {
			$this->_username = 'wooslider-instagram';
		}
		$data = '';
		$transient_key = $this->_username . '-self-media-recent';

		if ( isset( $args['count'] ) ) $transient_key .= '-' . intval( $args['count'] ); // Unique transient each time we change the count.

// delete_transient( $transient_key ); // DEBUG

		if ( false === ( $data = get_transient( $transient_key ) ) ) {
			$response = $this->request_self_media_recent( $args );

			if ( isset( $response->data ) ) {
				$data = json_encode( $response );
				set_transient( $transient_key, $data, $this->_transient_expire_time );
			}
		}

		return json_decode( $data );
	} // End get_self_media_recent()

	/**
	 * Retrieve recent photos for the specified user.
	 * @access  public
	 * @since   1.0.0
	 * @param   array $args
	 * @return  array
	 */
	public function request_self_media_recent ( $args ) {
		$data = array();
		$settings = $this->_get_settings();
		if ( ! isset( $settings['access_token'] ) || '' == $settings['access_token'] ) return false;
		$args['access_token'] = $settings['access_token'];
		$response = $this->_request( 'v1/users/self/media/recent/', $args, 'get' );

		if( is_wp_error( $response ) ) {
		   $data = new StdClass;
		} else {
		   if ( isset( $response->meta->code ) && ( $response->meta->code == 200 ) ) {
		   		$data = $response;
		   }
		}

		return $data;
	} // End request_self_media_recent()

	/**
	 * Make a request to the API.
	 * @access  private
	 * @since   1.0.0
	 * @param   string $endpoint The endpoint of the API to be called.
	 * @param   array  $params   Array of parameters to pass to the API.
	 * @return  object           The response from the API.
	 */
	private function _request ( $endpoint, $params = array(), $method = 'post' ) {
		$return = '';

		if ( $method == 'get' ) {
			$url = $this->_api_url . $endpoint;

			if ( count( $params ) > 0 ) {
				$url .= '?';
				$count = 0;
				foreach ( $params as $k => $v ) {
					$count++;

					if ( $count > 1 ) {
						$url .= '&';
					}

					$url .= $k . '=' . $v;
				}
			}

			$response = wp_remote_get( $url,
				array(
					'sslverify' => apply_filters( 'https_local_ssl_verify', false )
				)
			);
		} else {
			$response = wp_remote_post( $this->_api_url . $endpoint,
				array(
					'body' => $params,
					'sslverify' => apply_filters( 'https_local_ssl_verify', false )
				)
			);
		}

		if ( ! is_wp_error( $response ) ) {
			$return = json_decode( $response['body'] );
		}

		return $return;
	} // End request()

	/**
	 * Request an access token from the API.
	 * @access  public
	 * @since   1.0.0
	 * @param   string $username The username.
	 * @param   string $password The password.
	 * @return  string           Access token.
	 */
	public function get_access_token ( $username, $password ) {
		$args = array(
				'username' => $username,
				'password' => $password,
				'grant_type' => 'password',
				'client_id' => $this->_client_id,
				'client_secret' => $this->_client_secret
			);

		$response = $this->_request( 'oauth/access_token', $args );

		return $response;
	} // End get_access_token()

	/**
	 * If the parameter is an object with our expected properties, display an error notice.
	 * @access  private
	 * @since   1.0.0
	 * @param   object/string $obj Object if an error, empty string if not.
	 * @return  boolean/string     String if an error, boolean if not.
	 */
	private function _maybe_display_error ( $obj ) {
		if ( ! is_object( $obj ) || ! isset( $obj->code ) || ! isset( $obj->error_message ) ) return;
		return '<p class="wooslider-instagram-error error">' . esc_html( $obj->error_message ) . '</p>' . "\n";
	} // End _maybe_display_error()

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