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
 * @package     WC-Social-Login/Includes
 * @author      SkyVerge
 * @copyright   Copyright (c) 2014, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Social_Login_Opauth {


	/** @var string base authentication path */
	private $base_auth_path;

	/** @var array configuration */
	private $config;


	/**
	 * Constructor
	 *
	 * @param string $base_auth_path base authentication path
	 */
	public function __construct( $base_auth_path ) {

		$this->base_auth_path = $base_auth_path;

		add_action( 'init', array( $this, 'init_config' ) );
		add_action( 'woocommerce_api_' . $base_auth_path . '/callback', array( $this, 'callback' ) );
	}


	/**
	 * Initialize Opauth configuration
	 *
	 * Initializes Opauth configuration with the configured
	 * strategies. Opauth will be instanciated separately
	 * in the authentication and callback methods, because Opauth
	 * will try to create authentication request instantly when
	 * instanciated.
	 *
	 * @since 1.0
	 */
	public function init_config() {

		global $wc_social_login;

		$config = array(
			'host'               => site_url(),
			'path'               => '/wc-api/' . $this->base_auth_path . '/',
			'callback_transport' => 'post',
			'security_salt'      => get_option( 'wc_social_login_opauth_salt' ),
			'Strategy'           => array(),
			'debug'              => true,
		);

		// Loop over available providers and add their configuration
		foreach ( $wc_social_login->get_available_providers() as $provider ) {

			if ( ! $provider->uses_opauth() ) continue;

			$config['Strategy'][ $provider->get_id() ] = $provider->get_opauth_config();
		}

		$this->config = $config;
	}


	/**
	 * Authenticate using Opauth
	 *
	 * Creates an instance of Opauth - this will instantly
	 * create an authentication request based on the current
	 * url route. Excpects a url route with the schema {$path}/{$strategy}.
	 *
	 * Providers using Opauth should call this method in their authentication routes
	 *
	 * @since 1.0
	 */
	public function authenticate() {
		new Opauth( $this->config );
		exit;
	}


	/**
	 * Authentication callback
	 *
	 * This method handles the `final` callback from Opauth
	 * to verify the response, handle errors and pass handling
	 * of user profile to the Provider class.
	 *
	 * @since 1.0
	 */
	public function callback() {

		// Create a new Opauth instance without triggering authentication
		$opauth = new Opauth( $this->config, false );

		try {

			// only GET/POST supported
			switch ( $opauth->env['callback_transport'] ) {

				case 'post':
					$response = maybe_unserialize( base64_decode( $_POST['opauth'] ) );
					break;

				case 'get':
					$response = maybe_unserialize( base64_decode( $_GET['opauth'] ) );
					break;

				default:
					throw new Exception( 'Opauth unsupported transport callback' );
			}

			$validation_reason = null;

			// check for error response
			if ( array_key_exists( 'error', $response ) ) {

				throw new Exception( 'Response error' );

			} elseif ( empty( $response['auth'] ) || empty( $response['timestamp'] ) || empty( $response['signature'] ) || empty( $response['auth']['provider'] ) || empty( $response['auth']['uid'] ) ) {

				// ensure required data
				throw new Exception( 'Invalid auth response - missing required components' );

			} elseif ( ! $opauth->validate( sha1( print_r( $response['auth'], true ) ), $response['timestamp'], $response['signature'], $validation_reason ) ) {

				// validate response has not been modified
				throw new Exception( sprintf( 'Invalid auth response - %s', $validation_reason ) );
			}

		} catch ( Exception $e ) {

			wc_add_notice( sprintf( __( 'Provider Authentication error', WC_Social_Login::TEXT_DOMAIN ), 'error' ) );

			// log error messages and response data
			$GLOBALS['wc_social_login']->log( sprintf( 'Error: %s, Response: %s', $e->getMessage(), print_r( $response, true ) ) );

			$this->redirect();
		}


		// valid response, get provider
		$provider = $GLOBALS['wc_social_login']->get_provider( strtolower( $response['auth']['provider'] ) );

		$profile = new WC_Social_Login_Provider_Profile( $response['auth'] );

		// Let the provider handle processing user profile and logging in
		$provider->process_profile( $profile );

		// Redirect back to where we came from
		$this->redirect();
	}


	/**
	 * Redirect back to the provided return_url
	 *
	 * @since 1.0
	 */
	public function redirect() {

		$return_url = isset( WC()->session->social_login_return ) ? esc_url( urldecode( WC()->session->social_login_return ) ) : get_permalink( wc_get_page_id( 'myaccount' ) );
		unset( WC()->session->social_login_return );
		wp_redirect( $return_url );
		exit;
	}

} // end \WC_Social_Login_Opauth class
