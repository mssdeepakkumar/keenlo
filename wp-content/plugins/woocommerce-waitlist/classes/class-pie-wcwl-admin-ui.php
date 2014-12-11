<?php
/**
 * The Admin User Interface
 *
 * @package WooCommerce Waitlist
 */
class Pie_WCWL_Admin_UI {


	/**
	 * hooks up the functions for the admin UI
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		add_action( 'plugins_loaded', array( &$this, 'setup_text_strings' ), 15 );
		add_action( 'init', array( &$this, 'load_waitlist' ) );
		add_action( 'wc_bulk_stock_before_process_qty', array( &$this, 'load_waitlist_from_product_id' ), 5 );
		add_action( 'admin_notices', array( &$this, 'set_up_hide_out_of_stock_products_nag' ), 15 );
		add_action( 'admin_init', array( &$this, 'ignore_hide_out_of_stock_products_nag' ) );

		add_filter( 'manage_edit-product_columns', array( &$this, 'add_column_headers' ), 11 );
		add_action( 'manage_product_posts_custom_column', array( &$this, 'add_column_content' ), 10, 2 );
		add_filter( 'manage_edit-product_sortable_columns', array( &$this, 'price_column_register_sortable' ) );
		add_filter( 'request', array( &$this, 'price_column_orderby' ) );
		add_filter( 'posts_orderby', array( &$this, 'price_column_orderby2' ) );

	}

    /**
     * checks if we need to display the 'hide out of stock products' nag and displays if true
     *
     * The plugin has a small issue when viewing out-of-stock products in the front end when 'hide out of stock products
     * from the catalogue' is set to true. This function outputs a nag (if necessary) reminding the user to switch it
     * off.
     *
     * @hooked action admin_notices
     * @access public
     *
     * @return void
     * @since 1.1.0
     */
	public function set_up_hide_out_of_stock_products_nag() {

		if ( get_option( 'woocommerce_hide_out_of_stock_items' ) == 'no' ) return;

		global $current_user ;
		if ( ! current_user_can( 'manage_woocommerce' ) ) return;
		$usermeta = get_user_meta( $current_user->ID, WCWL_SLUG , true );
		if ( ! isset( $usermeta['ignore_hide_out_of_stock_products_nag'] ) || ! $usermeta['ignore_hide_out_of_stock_products_nag'] ) {
			echo '<div class="updated"><p>';
			echo apply_filters( 'wcwl_hide_out_of_stock_products_nag_text', sprintf( $this->hide_out_of_stock_products_nag_text , $this->get_inventory_settings_url() ) ) .' | <a href="'. add_query_arg( 'ignore_hide_out_of_stock_products_nag', true ) . '">'. apply_filters( 'wcwl_dismiss_nag_text', $this->dismiss_nag_text ) .'</a>' ;
			echo "</p></div>";
		}
	}

	/**
	 * function to get the URL of of the inventory settings page. Settings URLs were refactored in 2.1 with no API
	 * provided to retrieve them
	 *
	 * @return string
	 * @since  1.1.7
	 */
	public function get_inventory_settings_url(){
		global $woocommerce;
		if ( version_compare( $woocommerce->version, '2.1.0' ) < 0 )
			return admin_url( 'admin.php?page=woocommerce_settings&tab=inventory' );
		return admin_url( 'admin.php?page=wc-settings&tab=products&section=inventory' );
	}

    /**
     * checks for $_GET variable for hiding out of stock products and sets user meta
     *
     * @hooked action admin_init
     * @access public
     *
     * @return void
     * @since 1.1.0
     */
	public function ignore_hide_out_of_stock_products_nag() {

		global $current_user;
		if ( ! current_user_can( 'manage_woocommerce' ) ) return;

		if ( isset( $_GET['ignore_hide_out_of_stock_products_nag'] ) &&  $_GET['ignore_hide_out_of_stock_products_nag'] ) {

			$usermeta = get_user_meta( $current_user->ID, WCWL_SLUG, true );
			$usermeta['ignore_hide_out_of_stock_products_nag'] = true;
			add_user_meta( $current_user->ID, WCWL_SLUG, $usermeta, true );
		}
	}



	/**
	 * appends the element needed to create a custom admin column to an array
	 *
	 * @hooked filter manage_edit-product_columns
	 * @param array   $defaults the array to append
	 * @access public
	 *
	 * @return array The $defaults array with custom column values appended
	 * @since 1.0
	 */
	public function add_column_headers( $defaults ) {

		$defaults[ WCWL_SLUG . '_count' ] = $this->column_title;
		return $defaults;

	}

	/**
	 * outputs total waitlist members for a given post ID if $column_name is our custom column
	 *
	 * @hooked action manage_product_posts_custom_column
	 * @param string  $column_name name of the column for which we are outputting data
	 * @param mixed   $post_ID     ID of the post for which we are outputting data
	 * @access public
	 * @return void
	 *
	 * @since 1.0
	 */
	public function add_column_content( $column_name, $post_ID ) {

		$Product = WooCommerce_Waitlist_Plugin::get_product( $post_ID );


		if ( WCWL_SLUG . '_count' != $column_name ) return;
		$content = '';

		$content = Pie_WCWL_Waitlist::get_number_of_registrations_by_product_id($Product->id);

		echo  empty( $content ) ? '<span class="na">–</span>' : $content ;

	}

	/**
	 * appends our column ID to an array
	 *
	 * @hooked filter manage_edit-product_sortable_columns
	 * @param array   $columns The WP admin sortable columns array.
	 * @access public
	 * @return array
	 * @since 1.0
	 */
	function price_column_register_sortable( $columns ) {
		$columns[WCWL_SLUG . '_count'] = WCWL_SLUG . '_count';

		return $columns;
	}

	/**
	 * adds a meta_value sort to the request array if our custom column sort is the orderby parameter
	 *
	 * This function is part one of our two-part custom sorting function. Adding the meta value sort ensures that this
	 * column is available in the main query to be ordered. In the context we are using it, this field contains a
	 * serialized string of our waitlist
	 *
	 * @hooked filter request
	 * @param array   $vars The request variables
	 * @access public
	 * @return array
	 * @since 1.0
	 */
	function price_column_orderby( $vars ) {
		if ( isset( $vars['orderby'] ) && WCWL_SLUG . '_count' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
					'meta_key' => WCWL_SLUG,
					'orderby'  => 'meta_value'
				) );
		}
		return $vars;
	}

	/**
	 * returns a custom SQL clause if our custom column sort is the orderby $_REQUEST parameter
	 *
	 * This function is part two of our custom sorting function. Having ensured that the meta value column is available
	 * to the query in the price_column_orderby function and the REQUEST order parameter is one of our two expected
	 * values, we then replace the orderby SQL with an SQL clause that sorts the results according to the length of that
	 * string. In the context of this plugin, the length of the string relates to the number of users on the waitlist.
	 *
	 * @hooked filter posts_orderby
	 * @param string  $orderby the original orderby SQL clause
	 * @access public
	 * @return string
	 * @since 1.0
	 */
	function price_column_orderby2( $orderby ) {
		if ( isset( $_REQUEST['orderby'] ) && WCWL_SLUG . '_count' == $_REQUEST['orderby'] && in_array( strtolower( $_REQUEST['order'] ), array( 'asc','desc') ) ) {
			global $wpdb;
			return 'LENGTH(' . $wpdb->prefix . 'postmeta.meta_value) ' . $_REQUEST['order'];
		}
		return $orderby;
	}

	/**
	 * Sets up the waitlist and calls meta-box function if required
	 *
	 * @hooked action init
	 * @access public
	 * @return void
	 * @since 1.0.1
	 */
	public function load_waitlist() {
		if ( ! isset ( $_REQUEST['post'] ) && ! isset ( $_REQUEST['post_ID'] ) ) return;

		$post_id = isset ( $_REQUEST['post'] ) ? $_REQUEST['post'] : $_REQUEST['post_ID'] ;
		if ( 'product' !== get_post_type( $post_id ) ) return;

		$this->load_waitlist_from_product_id( $post_id );
	}
	public function load_waitlist_from_product_id( $post_id ){
		$Product = WooCommerce_Waitlist_Plugin::get_product( $post_id );


		if ( $Product->is_type( 'variable' ) ) {

			foreach ( $Product->get_children() as $key => $child_id ) {

				if ( function_exists( 'get_product' ) ) $Product->children[ $child_id ] = get_product( $child_id );
				else $Product->children[ $child_id ] = new WC_Product_Variation( $child_id );
				$Product->children[ $child_id ]->Waitlist = new Pie_WCWL_Waitlist( $Product->children[ $child_id ] );

				unset( $Product->children[ $key ] );
				//var_dump($Product->children[ $child_id ]->is_in_stock());
				if ( ! $Product->children[ $child_id ]->is_in_stock() ) {
					$this->add_meta_box( $Product->children[ $child_id ]->Waitlist );
				}
			}
		} else {
			$Product->waitlist = new Pie_WCWL_Waitlist( $Product );

			if ( ! $Product->is_in_stock() ) {
				$this->add_meta_box( $Product->waitlist );
			}
		}

	}

	/**
	 * creates Pie_WCWL_Meta_Box for a given Pie_WCWL_Waitlist
	 *
	 * @param object  $waitlist Pie_WCWL_Waitlist
	 * @access public
	 * @return mixed Value.
	 * @since 1.0.1
	 */
	public function add_meta_box( $waitlist ) {
		$Pie_WCWL_Meta_Box = new Pie_WCWL_Meta_Box( $waitlist );

	}

	public function alert_user_of_moved_waitlists_at_1_0_4_upgrade() {
		$options = get_option( WCWL_SLUG, true );
		if ( isset( $options['moved_waitlists_at_1_0_4_upgrade'] ) && is_array( $options['moved_waitlists_at_1_0_4_upgrade'] ) && ! empty( $options['moved_waitlists_at_1_0_4_upgrade'] ) ) {
			echo '<div class="updated"><p>';
			echo apply_filters( 'wcwl_moved_waitlists_at_1_0_4_upgrade_text',  sprintf( $this->moved_waitlists_at_1_0_4_upgrade_text , WCWL_VERSION ) ) ;
			echo '</p><ul>';
			foreach ( $options['moved_waitlists_at_1_0_4_upgrade'] as $waitlist ) {
				echo '<li>Waitlist for product <strong>' . get_the_title( $waitlist['origin'] ) . '</strong> has been moved to <strong>'  . get_the_title ( $waitlist['target'] ) . '</strong> (User IDs: ' . implode( ', ', $waitlist['user_ids'] ) .') - <a href="' . admin_url( 'post.php?post=' . $waitlist['origin'] . '&action=edit' ) . '">Edit Product</a></li>';
			}
			echo "</ul></div>";

		}
	}
	/**
	 * Inserts the options required for the plugin into an array after general_options, or at the end if general_options not found
	 *
	 * @hooked filter woocommerce general settings
	 * @param array   $general_settings The 'general_settings' element of the $woocommerce_settings array
	 * @access public
	 * @return array The passed in array with our options spliced / appeneded
	 * @since 1.0
	 */
	public function add_plugin_options_to_general_settings_array( $general_settings ) {

		$key = array_search( array( 'type' => 'sectionend' , 'id' => 'general_options' ) , $general_settings );
		$key = $key ? $key : count( $general_settings ) ;

		$splice = array(
			array(
				"name" => $this->general_settings_option_group_title ,
				"type" => "title",
				"desc" => $this->general_settings_option_group_description ,
				"id" => WCWL_SLUG . "_options"
			),
			array(
				"name" => $this->general_settings_registration_option_heading,
				"desc" => $this->general_settings_registration_option_one_label,
				"id"=> WCWL_SLUG . "_enable_guest_registration",
				"std"=> "no",
				"type"=> "checkbox",
				"checkboxgroup"=>"start"
			),
			array(
				"type"=>"sectionend",
				"id"=>"waitlist_account_options"
			)

		);
		array_splice( $general_settings, $key+1, 0 , $splice );

		return $general_settings;
	}

	/**
	 * Sets up the text strings required by the admin UI
	 *
	 * @access public
	 * @return void
	 * @since 1.0
	 */
	public function setup_text_strings() {

		$this->column_title = __( 'Waitlist', 'woocommerce-waitlist' );
		$this->general_settings_option_group_title = __( "Out-of-stock Waitlist", 'woocommerce-waitlist' );
		$this->general_settings_option_group_description = __( "The following options control the behaviour of the waitlist for out-of-stock products.", 'woocommerce-waitlist' );
		$this->general_settings_registration_option_heading = __( "Registration", 'woocommerce-waitlist' );
		$this->general_settings_registration_option_one_label = __( "Enable guest waitlist registration (no account required)" , 'woocommerce-waitlist' ) ;
		$this->hide_out_of_stock_products_nag_text = __( 'The WooCommerce Waitlist extension is active but you have the <em>Hide out of stock items from the catalog</em> option switched on. Please <a href="%s">change your settings</a> for WooCommerce Waitlist to function correctly.' );
		$this->dismiss_nag_text = __( "Stop nagging me", 'woocommerce-waitlist' );
		$this->moved_waitlists_at_1_0_4_upgrade_text = __( 'In order to support waitlists for product variations in WooCommerce Waitlist version %s, the waitlists for the following variable products have been moved to the corresponding product variations:', 'woocommerce-waitlist' );
		$this->original_variable_product = __( 'Original variable product', 'woocommerce-waitlist' );
		$this->new_product_variation = __( 'New product variation', 'woocommerce-waitlist' );
		$this->list_of_user_ids = __( 'List of user IDs' );



	}
}
