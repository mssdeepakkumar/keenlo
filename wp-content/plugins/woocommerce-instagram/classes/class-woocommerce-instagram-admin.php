<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooSlider Instagram Admin Class
 *
 * @package WordPress
 * @subpackage Woocommerce_Instagram
 * @category Admin
 * @author WooThemes
 * @since 1.0.0
 */
class Woocommerce_Instagram_Admin {
	private $_hook;
	private $_file;
	private $_token;
	private $_api;
	public $integration;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file, $api_obj ) {
		$this->_file = $file;
		$this->_token = 'woocommerce-instagram';
		$this->_api = $api_obj;

		// Load WooCommerce Integration.
		require_once( 'class-woocommerce-instagram-integration.php' );

		// Register the integration within WooCommerce.
		add_filter('woocommerce_integrations', array( $this, 'add_woocommerce_integration' ) );

		// Maybe display admin notices.
        add_action( 'admin_notices', array( $this, 'maybe_display_admin_notices' ) );

        if ( version_compare( '2.1', WOOCOMMERCE_VERSION, '>' ) ) {
        	// Add a new tab to the product data meta box.
        	add_filter( 'woocommerce_product_write_panel_tabs', array( $this, 'render_product_data_tab_markup' ) ); // WC 2.0.x
        	// Add markup for our new product data tab.
        	add_action( 'woocommerce_product_write_panels', array( $this, 'product_data_tab_markup' ) ); // WC 2.0.x
        } else {
        	// Add a new tab to the product data meta box.
       		add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_product_data_tab' ) ); // WC 2.1
       		// Add markup for our new product data tab.
        	add_action( 'woocommerce_product_data_panels', array( $this, 'product_data_tab_markup' ) ); // WC 2.1
       	}

        // Sae product data tab fields.
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_data_tab_fields' ) );

        $print_css_on = apply_filters( 'woocommerce_instagram_screen_ids', array( 'post-new.php', 'post.php' ) );

	    foreach ( $print_css_on as $page )
	    	add_action( 'admin_print_styles-'. $page, array( $this, 'enqueue_styles' ) );
	} // End __construct()

	/**
	 * Queue admin CSS.
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_styles () {
		global $woocommerce, $typenow, $post, $wp_scripts;

		if ( $typenow == 'post' && ! empty( $_GET['post'] ) ) {
			$typenow = $post->post_type;
		} elseif ( empty( $typenow ) && ! empty( $_GET['post'] ) ) {
	        $post = get_post( $_GET['post'] );
	        $typenow = $post->post_type;
	    }

		if ( '' == $typenow || 'product' == $typenow ) {
			wp_enqueue_style( $this->_token . '-admin', plugins_url( '/assets/css/admin.css', $this->_file ) );
		}
	} // End enqueue_styles()

	/**
	 * Add a new tab to the product data meta box. Add to an array, for use with WC 2.1.
	 * @access  public
	 * @since   1.0.0
	 * @param   array $tabs Array of existing tabs.
	 * @return  array Modified tabs array.
	 */
	public function add_product_data_tab ( $tabs ) {
		$tabs['instagram'] = array(
						'label'  => __( 'Instagram', 'woocommerce-instagram' ),
						'target' => 'instagram_data',
						'class'  => array(),
						);
		return $tabs;
	} // End add_product_data_tab()

	/**
	 * Add a new tab to the product data meta box. Render HTML markup, for use with WC 2.0.x.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function render_product_data_tab_markup () {
		echo '<li class="instagram_options instagram_data wc-2-0-x"><a href="#instagram_data">' . __( 'Instagram', 'woocommerce-instagram' ) . '</a></li>';
	} // End render_product_data_tab_markup()

	/**
	 * Render fields for our newly added tab.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function product_data_tab_markup () {
		echo '<div id="instagram_data" class="panel woocommerce_options_panel">' . "\n";
		// Instagram hashtag.
		woocommerce_wp_text_input( array(
				'id'                => '_instagram_hashtag',
				'class'             => 'short',
				'label'             => __( 'Hash Tag', 'woocommerce-instagram' ),
				'description'       => __( 'This is the hashtag for which images will be displayed. If no hashtag is entered, no images will display.', 'woocommerce-instagram' ),
				'desc_tip'          => true,
				'type'              => 'text',
			)
		);
		echo '</div>' . "\n";
	} // End product_data_tab_markup()

	/**
	 * Save the simple product points earned / maximum discount fields
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function save_product_data_tab_fields ( $post_id ) {
		if ( '' !== $_POST['_instagram_hashtag'] ) {
			$value = stripslashes( woocommerce_clean( $_POST['_instagram_hashtag'] ) );
			// Strip out spaces.
			$value = str_replace( ' ', '', $value );
			// Strip out the #, if it's at the front.
			$value = str_replace( '#', '', $value );
			update_post_meta( $post_id, '_instagram_hashtag', $value );
		} else {
			delete_post_meta( $post_id, '_instagram_hashtag' );
		}
	} // End save_product_data_tab_fields()

	/**
	 * Add the integration to WooCommerce.
	 * @access public
	 * @since  1.0.0
	 * @param  array $integrations
	 * @return array
	 */
	public function add_woocommerce_integration ( $integrations ) {
		$integrations[] = 'Woocommerce_Instagram_Integration';
		return $integrations;
	} // add_woocommerce_integration()

	/**
	 * Display an admin notice, if not on the integration screen and if the account isn't yet connected.
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function maybe_display_admin_notices () {
		if ( ( isset( $_GET['page'] ) && ( 'woocommerce_settings' == $_GET['page'] || 'wc-settings' == $_GET['page'] ) ) && ( isset( $_GET['section'] ) && 'instagram' == $_GET['section'] ) ) return; // Don't show these notices on our admin screen.

		$settings = $this->_get_settings();
		if ( ! isset( $settings['access_token'] ) || '' == $settings['access_token'] ) {
			$url = admin_url( 'admin.php' );
			if ( version_compare( '2.1', WOOCOMMERCE_VERSION, '>' ) ) {
				$page = 'woocommerce_settings';
			} else {
				$page = 'wc-settings';
			}
			$url = add_query_arg( 'page', $page, $url );
			$url = add_query_arg( 'tab', 'integration', $url );
			$url = add_query_arg( 'section', 'instagram', $url );
			echo '<div class="updated fade"><p>' . sprintf( __( '%sWooCommerce Instagram is almost ready.%s To get started, %sconnect your Instagram account%s.', 'woocommerce-instagram' ), '<strong>', '</strong>', '<a href="' . esc_url( $url ) . '">', '</a>' ) . '</p></div>' . "\n";
		}
	} // End maybe_display_admin_notices()

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