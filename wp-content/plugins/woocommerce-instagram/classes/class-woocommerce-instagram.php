<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooCommerce Instagram Class
 *
 * @package WordPress
 * @subpackage Woocommerce_Instagram
 * @category Core
 * @author WooThemes
 * @since 1.0.0
 */
class Woocommerce_Instagram {
    private $_token;
	private $_file;
	public $context;
	public $api;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file ) {
        $this->_token = 'woocommerce-instagram';
		$this->_file = $file;
        $this->_has_video = false;
		add_action( 'plugins_loaded', array( $this, 'init' ), 0 );
	} // End __construct()

	/**
     * Initialize the plugin, check the environment and make sure we can act.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function init () {
        // Make sure WooCommerce is active.
        $active_plugins = apply_filters( 'active_plugins', get_option('active_plugins' ) );
        if ( ! in_array( 'woocommerce/woocommerce.php', $active_plugins ) ) return;

        // Setup the API object.
        require_once( 'class-woocommerce-instagram-api.php' );
        $this->api = new Woocommerce_Instagram_API( $this->_file );
        // Setup the context, based on admin/frontend.
        if ( is_admin() ) {
        	require_once( 'class-woocommerce-instagram-admin.php' );
        	$this->context = new Woocommerce_Instagram_Admin( $this->_file, $this->api );
        } else {
            require_once( 'class-woocommerce-instagram-frontend.php' );
            $this->context = new Woocommerce_Instagram_Frontend( $this->_file, $this->api );
        }
    } // End init()
} // End Class
?>