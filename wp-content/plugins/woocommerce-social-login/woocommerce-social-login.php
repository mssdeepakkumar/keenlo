<?php
/**
 * Plugin Name: WooCommerce Social Login
 * Plugin URI: http://www.woothemes.com/products/wc-social-login/
 * Description: One-click registration and login via social networks like Facebook, Google, Twitter and Amazon
 * Author: SkyVerge
 * Author URI: http://www.skyverge.com
 * Version: 1.0.2
 * Text Domain: woocommerce-social-login
 * Domain Path: /i18n/languages/
 *
 * Copyright: (c) 2014 SkyVerge, Inc. (info@skyverge.com)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package   WC-Social-Login
 * @author    SkyVerge
 * @category  Integration
 * @copyright Copyright (c) 2014, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Required functions
if ( ! function_exists( 'woothemes_queue_update' ) ) {
	require_once( 'woo-includes/woo-functions.php' );
}

// Plugin updates
woothemes_queue_update( plugin_basename( __FILE__ ), 'b231cd6367a79cc8a53b7d992d77525d', '473617' );

// WC active check
if ( ! is_woocommerce_active() ) {
	return;
}

// Required library class
if ( ! class_exists( 'SV_WC_Framework_Bootstrap' ) ) {
	require_once( 'lib/skyverge/woocommerce/class-sv-wc-framework-bootstrap.php' );
}

SV_WC_Framework_Bootstrap::instance()->register_plugin( '2.1', __( 'WooCommerce Social Login', 'woocommerce-social-login' ), __FILE__, 'init_woocommerce_social_login' );

function init_woocommerce_social_login() {


/**
 * # WooCommerce Social Login Main Plugin Class
 *
 * ## Plugin Overview
 *
 * This plugin allows customers to login and register via social login providers
 * like Facebook, Google, Twitter, etc. The login/register options are presented
 * to customers at checkout and my account page.
 *
 * ## Features
 *
 * + Pick & Choose social login providers you want to support on your site
 * + Customize each provider's icon and button text
 * + Customers do not need to create and remember another password
 * + View social login statistics
 *
 * ## Frontend Considerations
 *
 * On the frontend the social login buttons are rendered on the checkout page
 * and my account, if the customer is not already logged in.
 * A customer can associate their account with multiple social login providers.
 *
 * ### Widget
 *
 * The plugin adds a social login widget that can be added to pages via the
 * standard WordPress Widget admin
 *
 * ### Shortcode
 *
 * The plugin adds a social login shortcode which can be used like:
 *
 * [woocommerce_social_login_buttons return_url='https://www.example.com/my-account']
 *
 * ### Template Function
 *
 * The plugin defines an overrideable "template" function for displaying the
 * social login buttons, and can be used to provide enhanced theme integration,
 * etc.  Example usage:
 *
 * woocommerce_social_login_buttons('https://www.example.com/my-account')
 *
 * ## Admin Considerations
 *
 * Adds a tab to WooCommerce settings page, which lets store managers
 * enable/disable and configure different providers.
 *
 * ## Database
 *
 * ### Options table
 *
 * + `wc_social_login_provider_order` - array of provider id to numerical order
 * + `wc_social_login_opauth_salt` - Randomly generated Opauth salt value
 * + `wc_social_login_version` - the current plugin version, set on install/upgrade
 *
 * ### User Meta
 * + `_wc_social_login_{provider id}_profile` - array of social profile values (email, nickname, name, etc)
 * + `_wc_social_login_{provider id}_uid` -
 *
 * @since 1.0
 */
class WC_Social_Login extends SV_WC_Plugin {


	/** plugin version number */
	const VERSION = '1.0.2';

	/** plugin id */
	const PLUGIN_ID = 'social_login';

	/** plugin meta prefix */
	const PLUGIN_PREFIX = 'wc_social_login_';

	/** plugin text domain */
	const TEXT_DOMAIN = 'woocommerce-social-login';

	/** @var \WC_Social_Login_Admin instance */
	public $admin;

	/** @var \WC_Social_Login_Frontend instance */
	public $frontend;


	/**
	 * Initializes the plugin
	 *
	 * @since 1.0
	 * @return \WC_social_login
	 */
	public function __construct() {

		parent::__construct(
			self::PLUGIN_ID,
			self::VERSION,
			self::TEXT_DOMAIN
		);

		// autoload classes
		spl_autoload_register( array( $this, 'autoload' ) );

		// Initialize
		$this->init();
	}


	/**
	 * Autoload Opauth, Strategies, and Provider classes
	 *
	 * @since 1.0.2
	 * @param string $class class name to load
	 */
	public function autoload( $class ) {

		$class = strtolower( $class );

		if ( 0 === strpos( $class, 'opauth' ) ) {

			// Opauth classes, note that Opauth handles loading strategies internally
			$path = $this->get_plugin_path() . '/lib/opauth/lib/Opauth/';

			$file = $class . '.php';

			if ( is_readable( $path . $file ) ) {
				require_once( $path . $file );
			}

		} elseif ( 0 === strpos( $class, 'wc_social_login_provider_' ) ) {

			// Provider classes
			$path = $this->get_plugin_path() . '/includes/providers/';
			$file = 'class-' . str_replace( '_', '-', $class ) . '.php';

			if ( is_readable( $path . $file ) ) {
				require_once( $path . $file );
			}
		}
	}


	/**
	 * Initialize Social Login
	 *
	 * @since 1.0
	 */
	public function init() {

		// Base social login provider & profile
		require_once( 'includes/abstract-wc-social-login-provider.php' );
		require_once( 'includes/class-wc-social-login-provider-profile.php' );

		// Load providers
		$this->load_providers();

		// Frontend includes
		if ( ! is_admin() ) {
			$this->frontend_includes();
		}

		// Admin includes
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			$this->admin_includes();
		}

		// Register widgets
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );
	}


	/**
	 * Include required frontend files
	 *
	 * @since 1.0
	 */
	private function frontend_includes() {

		require_once( 'includes/class-wc-social-login-opauth.php' );
		$this->opauth = new WC_Social_Login_Opauth( $this->get_auth_path() );

		require_once( 'includes/wc-social-login-template-functions.php' );

		require_once( 'includes/frontend/class-wc-social-login-frontend.php' );
		$this->frontend = new WC_Social_Login_Frontend();

	}


	/**
	 * Include required admin files
	 *
	 * @since 1.0
	 */
	private function admin_includes() {

		require_once( 'includes/admin/class-wc-social-login-admin.php' );
		$this->admin = new WC_Social_Login_Admin();
	}


	/**
	 * Load plugin text domain.
	 *
	 * @since 1.0
	 * @see SV_WC_Plugin::load_translation()
	 */
	public function load_translation() {

		load_plugin_textdomain( 'woocommerce-social-login', false, dirname( plugin_basename( $this->get_file() ) ) . '/i18n/languages' );
	}


	/**
	 * load_providers function.
	 *
	 * Loads all social login providers which are hooked in.
	 *
	 * Providers are sorted into their user-defined order after being loaded.
	 *
	 * @access public
	 * @return array
	 */
	public function load_providers() {

		$this->unregister_providers();

		// Providers can register themselves through this hook
		do_action( 'wc_social_login_load_providers' );

		// Register providers through a filter

		/**
		 * Filter the list of providers to load.
		 *
		 * @since 1.0
		 * @param array $providers_to_load list of provider classes to load
		 */
		$providers_to_load = apply_filters( 'wc_social_login_providers', array(
			'WC_Social_Login_Provider_Facebook',
			'WC_Social_Login_Provider_Twitter',
			'WC_Social_Login_Provider_Google',
			'WC_Social_Login_Provider_Amazon',
		) );

		foreach ( $providers_to_load as $provider ) {
			$this->register_provider( $provider );
		}

		$this->sort_providers();

		return $this->providers;
	}


	/**
	 * Register a provider.
	 *
	 * @access public
	 * @param  object|string $provider Either the name of the provider's class, or an instance of the provider's class
	 * @return void
	 */
	public function register_provider( $provider ) {

		if ( ! is_object( $provider ) ) {
			$provider = new $provider( $this->get_auth_path() );
		}

		$id = empty( $provider->instance_id ) ? $provider->get_id() : $provider->instance_id;

		$this->providers[ $id ] = $provider;
	}


	/**
	 * unregister_providers function.
	 *
	 * @access public
	 * @return void
	 */
	public function unregister_providers() {
		unset( $this->providers );
	}


	/**
	 * sort_providers function.
	 *
	 * Sorts providers into the user defined order.
	 *
	 * @access public
	 * @return array
	 */
	public function sort_providers() {

		$sorted_providers = array();

		// Get order option
		$ordering   = (array) get_option( 'wc_social_login_provider_order' );
		$order_end  = 999;

		// Load shipping providers in order
		foreach ( $this->providers as $provider ) {

			if ( isset( $ordering[ $provider->get_id() ] ) && is_numeric( $ordering[ $provider->get_id() ] ) ) {
				// Add in position
				$sorted_providers[ $ordering[ $provider->get_id() ] ][] = $provider;
			} else {
				// Add to end of the array
				$sorted_providers[ $order_end ][] = $provider;
			}
		}

		ksort( $sorted_providers );

		$this->providers = array();

		foreach ( $sorted_providers as $providers ) {
			foreach ( $providers as $provider ) {
				$id = empty( $provider->instance_id ) ? $provider->get_id() : $provider->instance_id;
				$this->providers[ $id ] = $provider;
			}
		}

		return $this->providers;
	}


	/**
	 * get_auth_path function.
	 *
	 * Returns the authentication base path, defaults to `auth`
	 *
	 * e.g.: skyverge.com/wc-api/auth/facebook
	 *
	 * @access public
	 * @return srting
	 */
	public function get_auth_path() {

		/**
		 * Filter the authentication base path.
		 *
		 * @since 1.0
		 * @param string $auth_path the authentication base path
		 */
		return apply_filters( 'wc_social_login_auth_path', 'auth' );
	}


	/**
	 * get_providers function.
	 *
	 * Returns all registered providers for usage.
	 *
	 * @access public
	 * @return array
	 */
	public function get_providers() {
		return $this->providers;
	}


	/**
	 * get_provider function.
	 *
	 * Returns the requested provider, if found.
	 *
	 * @access public
	 * @param string $provider_id
	 * @return array|null
	 */
	public function get_provider( $provider_id ) {
		return isset( $this->providers[ $provider_id ] ) ? $this->providers[ $provider_id ] : null;
	}


	/**
	 * Get available providers.
	 *
	 * @access public
	 * @return array
	 */
	function get_available_providers() {

		$_available_providers = array();

		foreach ( $this->get_providers() as $provider ) {

			if ( $provider->is_available() ) {
				$_available_providers[ $provider->get_id() ] = $provider;
			}

		}

		/**
		 * Filter the available providers
		 *
		 * @since 1.0
		 * @param array $_available_providers the available providers
		 */
		return apply_filters( 'wc_social_login_available_providers', $_available_providers );
	}


	/** Admin providers ******************************************************/


	/**
	 * Render a notice for the user to read the docs before configuring
	 *
	 * @since 1.0
	 * @see SV_WC_Plugin::render_admin_notices()
	 */
	public function render_admin_notices() {

		// show any dependency notices
		parent::render_admin_notices();

		// add notice for selecting export format
		if ( $this->is_plugin_settings() && ! $this->is_message_dismissed( 'read-the-docs' )  ) {

			$dismiss_link = sprintf( '<a href="#" class="js-wc-plugin-framework-%s-message-dismiss" style="float:right;" data-message-id="%s">%s</a>', $this->get_id(), 'read-the-docs', __( 'Dismiss', $this->text_domain ) );

			$this->add_dismissible_notice(
				sprintf( __( 'Thanks for installing Social Login! Before you get started, please take a moment to %sread through the documentation%s.', $this->text_domain ),
					'<a href="' . $this->get_documentation_url() . '">', '</a>' ) . $dismiss_link,
					'read-the-docs'
			);
		}

		$this->render_ssl_admin_notices();
	}


	/**
	 * Checks if SSL is required for any providers and not available and adds a
	 * dismissible admin notice if so. Notice will not be rendered to the admin
	 * user once dismissed unless on the plugin settings page, if any
	 *
	 * @since 1.0
	 * @see SV_WC_Payment_Gateway_Plugin::render_admin_notices()
	 */
	protected function render_ssl_admin_notices() {

		// Get available providers
		foreach ( $this->get_providers() as $provider ) {

			// Check if the provider requires SSL
			if ( $provider->requires_ssl() && ( ! $this->is_message_dismissed( $provider->get_id() . '-ssl-required' ) || $this->is_plugin_settings() ) ) {

				// SSL check if gateway enabled/production mode
				if ( 'no' === get_option( 'woocommerce_force_ssl_checkout' ) ) {

					$message = sprintf( _x( 'WooCommerce Social Login: %s requires SSL for authentication, please force WooCommerce over SSL.', 'Requires SSL', WC_Social_Login::TEXT_DOMAIN ), '<strong>' . $provider->get_title() . '</strong>' );

					$this->add_dismissible_notice( $message, $provider->get_id() . '-ssl-required' );
				}
			}
		}
	}


	/**
	 * Returns conditional dependencies based on the provider selected
	 *
	 * @since 1.0
	 * @see SV_WC_Plugin::get_dependencies()
	 * @return array of dependencies
	 */
	protected function get_dependencies() {

		$dependencies = array();

		foreach ( $this->get_providers() as $provider ) {

			if ( 'twitter' == $provider->get_id() && $provider->is_enabled() ) {
				$dependencies[] = 'curl';
			}
		}

		return array_merge( parent::get_dependencies(), $dependencies );
	}


	/**
	 * Register social login widgets
	 *
	 * @since 1.0
	 */
	public function register_widgets() {

		// load widget
		require_once( 'includes/widgets/class-wc-social-login-widget.php' );

		// register widget
		register_widget( 'WC_Social_Login_Widget' );
	}


	/** Helper providers ******************************************************/


	/**
	 * Returns the plugin name, localized
	 *
	 * @since 1.0
	 * @see SV_WC_Plugin::get_plugin_name()
	 * @return string the plugin name
	 */
	public function get_plugin_name() {

		return __( 'WooCommerce Social Login', $this->text_domain );
	}


	/**
	 * Returns __FILE__
	 *
	 * @since 1.0
	 * @see SV_WC_Plugin::get_file()
	 * @return string the full path and filename of the plugin file
	 */
	protected function get_file() {

		return __FILE__;
	}


	/**
	 * Gets the URL to the settings page
	 *
	 * @since 1.0
	 * @see SV_WC_Plugin::is_plugin_settings()
	 * @param string $_ unused
	 * @return string URL to the settings page
	 */
	public function get_settings_url( $_ = '' ) {

		return admin_url( 'admin.php?page=wc-settings&tab=social_login' );
	}


	/**
	 * Returns true if on the Social Login settings page
	 *
	 * @since 1.0
	 * @see SV_WC_Plugin::is_plugin_settings()
	 * @return boolean true if on the settings page
	 */
	public function is_plugin_settings() {

		return isset( $_GET['page'] ) && 'wc-settings' == $_GET['page'] && isset( $_GET['tab'] ) && 'social_login' == $_GET['tab'];
	}


	/** Lifecycle providers ******************************************************/


	/**
	 * Install default settings
	 *
	 * @since 1.0
	 * @see SV_WC_Plugin::install()
	 */
	protected function install() {

		add_option( 'wc_social_login_opauth_salt', wp_generate_password( 62, true, true ) );

		// settings page defaults.  unfortunately we can't dynamically pull these because the requisite core WC classes aren't loaded
		// a better solution may be to set any defaults within the save method of the social provider settings classes
		add_option( 'wc_social_login_display', 'checkout,my_account' );
		add_option( 'wc_social_login_text', __( 'For faster checkout, login or register using your social account.', WC_Social_Login::TEXT_DOMAIN ) );
	}


} // end \WC_Social_Login class

/**
 * The WC_Social_Login global object
 * @name $wc_social_login
 * @global WC_Social_Login $GLOBALS['wc_social_login']
 */
$GLOBALS['wc_social_login'] = new WC_Social_Login();

} // init_woocommerce_social_login()
