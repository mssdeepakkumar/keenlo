<?php
/**
 * Pie_WCWL_Waitlist
 *
 * @package WooCommerce Waitlist
 */
class Pie_WCWL_Waitlist {

	private $waitlist;
	public $product_id;
	public $parent_id;

	/**
	 * constructor function to hook up actions and filters and class properties
	 *
	 * @param object  $Product WC_Product or derivative thereof
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function __construct( $Product ) {

		if ( get_class( $Product ) == 'WC_Product_Variation' ) {
			$this->product_id = $Product->variation_id;
			$this->parent_id = $Product->id;

		} else {
			$this->product_id = $Product->id;
			$this->parent_id = false;
		}


		$this->setup_text_strings();

		$this->waitlist = get_post_meta( $this->product_id, WCWL_SLUG, true );
		if ( ! is_array( $this->waitlist ) ) $this->waitlist = array();

		add_action( 'shutdown', array( &$this, 'save_waitlist' ) ) ;

		add_action( 'woocommerce_waitlist_mailout_send_email', array( $this, 'pre_2_0_mailout' ), 10, 2 );

		if ( ! WooCommerce_Waitlist_Plugin::automatic_mailouts_are_disabled() ) {
			add_action( 'pre_post_update', array( &$this, 'set_pre_update_stock_status' ) );
			add_action( 'wp_insert_post', array( &$this, 'stock_status_post_update_check' ) );

			add_action( 'wc_bulk_stock_before_process_qty', array( &$this, 'set_pre_update_stock_status' ) );
			add_action( 'wc_bulk_stock_after_process_qty', array( &$this, 'stock_status_post_update_check' ) );


		}

	}

	public function append_parent_id_to_array( $product_ids ) {
		$product_ids[] = $this->parent_id;
		return $product_ids;
	}

	public function save_waitlist( ) {
		update_post_meta( $this->product_id, WCWL_SLUG, $this->waitlist );
		if ( $this->parent_id ) add_filter( 'wcwl_updated_variable_products', array( &$this, 'append_parent_id_to_array' ) );

	}

	/**
	 * for some bizarre reason around 1.2.0, this funciton has started emitting notices. It is caused by the original
	 * assignment of WCWL_Frontend_UI->User being set to false when a user is not logged in. All around the application,
	 * this is now being called on as an object.
	 *
	 * @param [object] $User WP_User Object
	 * @return [boolean]      Whether or not the User is registered to this waitlist, if they are a valid user
	 */
	public function user_is_registered( $User ) {
		return $User && in_array( $User->ID, $this->waitlist );
	}

	public function unregister_user( $User ) {

		if ( $this->user_is_registered( $User ) ) {

			do_action( 'wcwl_before_remove_user_from_waitlist' , $this->product_id , $User );
			$this->waitlist = array_diff( $this->waitlist, array ( $User->ID ) );
			do_action( 'wcwl_after_remove_user_from_waitlist' , $this->product_id, $User );

			return true;
		}

		return false;

	}


	/**
	 * for some bizarre reason around 1.2.0, this funciton has started emitting notices. It is caused by the original
	 * assignment of WCWL_Frontend_UI->User being set to false when a user is not logged in. All around the application,
	 * this is now being called on as an object.
	 *
	 * @param type    $User
	 * @return boolean
	 */
	public function register_user( $User ) {
		if ( false === $User ) return false;
		if ( $this->user_is_registered( $User ) ) return false;
		do_action( 'wcwl_before_add_user_to_waitlist' , $this->product_id, $User );
		$this->waitlist[] = $User->ID;
		do_action( 'wcwl_after_add_user_to_waitlist' , $this->product_id, $User );

		return true;

	}

	public function get_number_of_registrations() {
		return count( $this->waitlist );
	}
	public static function get_number_of_registrations_by_product_id($product_id){
		$waitlist = get_post_meta( $product_id, WCWL_SLUG, true );
		return count( $waitlist );
	}
	public function get_registered_users() {
		$registered_users = array();
		foreach ( $this->waitlist as $user_id ) $registered_users[] = get_user_by( 'id', $user_id );
		return $registered_users;
	}
	/**
	 *
	 *
	 * @since 1.0.2
	 */

	public function get_registered_users_email_addresses() {
		return wp_list_pluck( $this->get_registered_users(), 'user_email' );
	}
	/**
	 * Sets $pre_update_stock_status to the stock status of a product
	 *
	 * @hooked action pre_post_update
	 * @param integer $post_id ID of the post for which to get the status
	 * @access public
	 * @return void
	 */
	public function set_pre_update_stock_status() {

		$Product = WooCommerce_Waitlist_Plugin::get_product( $this->product_id, ( get_post_type( $this->product_id ) == 'product_variation' ) );
		$this->pre_update_stock_status = $Product->is_in_stock() ? 'instock' : 'outofstock' ;
	}

	/**
	 * Calls waitlist_mailout function when a product stock status is set to 'instock' and $pre_update_stock_status = 'outofstock'
	 *
	 * @hooked action wp_insert_post
	 * @param integer $post_id ID of the post for which to get the status
	 * @access public
	 * @return void
	 */
	public function stock_status_post_update_check( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )        return;

		if ( get_post_type( $this->product_id ) != 'product_variation' && get_post_type( $this->product_id ) != 'product' ) return;

		$Product = WooCommerce_Waitlist_Plugin::get_product( $this->product_id, ( get_post_type( $this->product_id ) == 'product_variation' ) );


		$post_update_stock_status = $Product->is_in_stock() ? 'instock' : 'outofstock' ;

		if ( 'outofstock' == $this->pre_update_stock_status && 'instock' == $post_update_stock_status )
			$this->waitlist_mailout( $this->product_id );


	}







	/**
	 * Check if user is on waitlist for product
	 *
	 * @param mixed   $product_id
	 * @param mixed   $user_id    Optional - defaults to current user
	 * @access public
	 * @return bool True if user is on waitlist, false if not
	 */
	private function user_is_on_waitlist_for_product( $product_id, $user_id = false ) {


		if ( false === $user_id ) {
			$current_user = wp_get_current_user(); $user_id = $current_user->ID;
		}

		return in_array( $user_id , get_post_meta( $product_id,  WCWL_SLUG ) );

	}


	/**
	 * Triggers instock notification email to each user on the waitlist for a product, then deletes the waitlist
	 *
	 * @param integer $post_id
	 * @access public
	 * @return void
	 */
	public function waitlist_mailout( $post_id ) {

		if ( ! empty( $this->waitlist ) ) {

			global $woocommerce ;
			$woocommerce->mailer();

			foreach ( $this->waitlist as $user_id ) {
				$user = get_user_by( 'id', $user_id );
				do_action( 'woocommerce_waitlist_mailout_send_email', $user_id, $post_id );

				if ( WooCommerce_Waitlist_Plugin::persistent_waitlists_are_disabled() ){
					$this->unregister_user( $user );
				}

			}

		}
	}

	/**
	 * fallback function for pre WC 2.0 to send email. Newer versions of WC use the WC_Email classes. THe filters here
	 * are required for backwards compatability but have no function in WC 2+
	 *
	 * @param [int]   $user_id ID of the user we are sending to
	 * @param [int]   $post_id ID of the product that is now back in stock
	 * @return [void]
	 */
	public function pre_2_0_mailout( $user_id, $post_id ) {
		global $woocommerce;
		if ( version_compare( $woocommerce->version, '2.0', ">=" ) )
			return;

		if ( get_post_type( $post_id ) == 'product_variation' ) {
			$post = get_post( $post_id );
			$permalink_id = $post->post_parent;
		}
				$user = get_user_by( 'id', $user_id );

		$product_title = get_the_title( $post_id ) ;
		$product_link =  get_permalink( isset( $permalink_id ) ? $permalink_id : $post_id ) ;
		$username = $user->display_name;
		$message = '<p>' . apply_filters( 'wcwl_email_salutation' , sprintf( $this->email_salutation, $username ) ) . '</p><p>';
		$message .= apply_filters( 'wcwl_email_product_back_in_stock_text', sprintf( $this->specific_product_back_in_stock_text, $product_title, get_bloginfo( 'title' ) ) ) . '. ';
		$message .= apply_filters( 'wcwl_email_mailout_disclaimer_text', $this->mailout_disclaimer_text ) . '. ';
		$message .= apply_filters( 'wcwl_email_visit_this_link_to_purchase_text', sprintf( $this->visit_this_link_to_purchase_text, $product_title, $product_link, $product_link ) );
		$message .= '</p><p>' . apply_filters( 'wcwl_email_mailout_signoff',  $this->mailout_signoff ) . get_bloginfo( 'title' )  . '</p>';

		$message = apply_filters( 'wcwl_mailout_html', $message ) ;
		if ( woocommerce_mail( $user->user_email, apply_filters( 'wcwl_mailout_subject', $this->generic_product_back_in_stock_text ), $message ) )
			if ( WooCommerce_Waitlist_Plugin::persistent_waitlists_are_disabled() )
				$this->unregister_user( $user );


	}
	/**
	 * Sets up the text strings used by the plugin
	 *
	 * @hooked action plugins_loaded
	 * @access public
	 * @return void
	 */
	private function setup_text_strings() {
		$this->mailout_signoff = _x( 'Regards,<br>', 'Email signoff', 'woocommerce-waitlist' ) ;
		$this->mailout_disclaimer_text = __( 'You have been sent this email because your email address was registered on a waitlist for this product', 'woocommerce-waitlist' );
		$this->visit_this_link_to_purchase_text = __( 'If you would like to purchase %1$s please visit the following link: <a href="%2$s">%3$s</a>', 'woocommerce-waitlist' );
		$this->specific_product_back_in_stock_text = __( '%1$s is now back in stock at %2$s', 'woocommerce-waitlist' ) ;
		$this->email_salutation = _x( 'Hi %s,', 'Email Salutation', 'woocommerce-waitlist' );
		$this->generic_product_back_in_stock_text = __( 'A product you are waiting for is back in stock', 'woocommerce-waitlist' );
		$this->join_waitlist_button_text = __( 'Join waitlist', 'woocommerce-waitlist' );

	}
}
