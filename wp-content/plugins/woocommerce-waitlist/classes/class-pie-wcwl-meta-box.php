<?php
/**
 * Pie_WCWL_Meta_Box
 *
 * @package WooCommerce Waitlist
 */
class Pie_WCWL_Meta_Box {

	private $waitlist;

	/**
	 * Assigns the settings that have been passed in to the appropriate parameters
	 *
	 * @param array   $meta_box_settings
	 * @access protected
	 * @return void
	 */
	function __construct( $waitlist ) {

		$this->waitlist = $waitlist;
		$this->setup_text_strings();
		add_action( 'add_meta_boxes', array ( &$this, 'add_meta_box' ) );
		add_action( 'save_post' , array ( &$this, 'remove_users_from_waitlist' ) );

	}

	/**
	 * wrapper for WordPress add_meta_box function
	 *
	 * @access public
	 * @return void
	 */
	function add_meta_box() {
		$meta_box_title = get_post_type( $this->waitlist->product_id ) == 'product' ?
			sprintf( $this->meta_box_title, $this->waitlist->get_number_of_registrations() ) :
			sprintf( $this->variation_meta_box_title, $this->waitlist->product_id, $this->waitlist->get_number_of_registrations() ) ;

		add_meta_box(
			WCWL_SLUG . $this->waitlist->product_id,
			apply_filters(
				'wcwl_meta_box_title' ,
				$meta_box_title
			),
			array( &$this, 'build_meta_box' ),
			'product',
			'side'
		);
	}

	/**
	 * Callback function used by add_meta_box to output the HTML for the meta-box
	 *
	 * @access public
	 * @uses get_post_meta
	 * @uses get_user_by
	 * @uses admin_url
	 * @return void
	 */
	public function build_meta_box( ) {

		$users = $this->waitlist->get_registered_users();
		if (  ! empty( $users ) ) {
			echo wp_nonce_field( plugin_basename( __FILE__ ), WCWL_SLUG . '_nonce' );
			echo '<p>' . esc_html( apply_filters( 'wcwl_waitlist_introduction' , $this->wailist_introduction ) ) . '</p>';
			echo '<table class="widefat">';

			foreach ( $users as $user ) {
				echo '<tr>
							<td ><strong><a title="'. esc_attr( $this->view_user_profile_text ) .'" href="' . admin_url( 'user-edit.php?user_id=' . $user->ID ) . '">' . $user->display_name . '</a></strong></td>
							<td><a href="mailto:' . $user->user_email . '" title="' . esc_attr( $this->email_user_text ) . '" ><img alt="' . esc_attr( $this->email_user_text ) . '" src="' . plugins_url( 'assets/icons/email-user.png' , dirname( __FILE__ ) ) . '" /></a></td>
							<td style="text-align:right;"><label title="' . esc_attr( $this->remove_user_from_waitlist_text ) . '">' . esc_html( $this->remove_text ) . ' </label><input type="checkbox" name="' . WCWL_SLUG . '_unregister[]" value="' . $user->ID . '" /></td>
						</tr>';

			}

			echo '</table>';
			echo '<p><img style="position:relative;top:4px;margin-left:4px;" src="' . plugins_url( 'assets/icons/mails-stack.png' , dirname( __FILE__ ) ) . '" /> <a href="' .  esc_url_raw( $this->get_mailto_link_content() ) . '" >' . esc_html( $this->email_all_users_on_list_text ) .'</a></p>';
		} else {
			echo '<p>' . esc_html( apply_filters( 'wcwl_empty_waitlist_introduction' , $this->empty_waitlist_introduction ) ) . '</p>';
		}


	}

	/**
	 * removes all Users in $_REQUEST from wailist
	 *
	 * @hooked action save_post
	 * @param int     $post_id used only for verifying authority
	 * @access public
	 * @return void
	 */
	public function remove_users_from_waitlist( $post_id ) {
		if (
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ||
			! isset( $_POST[ WCWL_SLUG . '_unregister'] ) ||
			empty( $_POST[ WCWL_SLUG . '_unregister'] ) ||
			! array( $_POST[ WCWL_SLUG . '_unregister'] ) ||
			! wp_verify_nonce( $_POST[ WCWL_SLUG . '_nonce'], plugin_basename( __FILE__ ) ) ||
			!current_user_can( 'edit_post', $post_id )

		) return;


		foreach ( $_POST[ WCWL_SLUG . '_unregister'] as $value ) {

			$this->waitlist->unregister_user( get_user_by( 'id', $value ) );

		}



	}

	/**
	 * Sets up text strings used by the Waitlist Meta Box UI
	 *
	 * @access public
	 * @return void
	 * 
	 * @since 1.0
	 */
	public function setup_text_strings() {

		$this->meta_box_title = __( 'Users on waitlist: %d' , 'woocommerce-waitlist' );
		$this->variation_meta_box_title = __( 'Waitlist for variation #%1$d: %2$d' , 'woocommerce-waitlist' );
		$this->wailist_introduction = __( 'The following users are currently on the waiting list for this product:', 'woocommerce-waitlist' );
		$this->empty_waitlist_introduction = __( 'There are no users on the waiting list for this product.', 'woocommerce-waitlist' );
		$this->email_user_text = __( 'Email User', 'woocommerce-waitlist' );
		$this->view_user_profile_text = __( 'View User Profile', 'woocommerce-waitlist' );
		$this->email_all_users_on_list_text = __( 'Email all users on list', 'woocommerce-waitlist' );
		$this->remove_user_from_waitlist_text = __( 'Remove user from waitlist', 'woocommerce-waitlist' );
		$this->remove_text = __( 'Remove:', 'woocommerce-waitlist' );

	}

	/**
	 *
	 *
	 * @since 1.0.2
	 */

	private function get_mailto_link_content() {
		$current_user = wp_get_current_user();

		return 'mailto:' . get_option( 'woocommerce_email_from_address' ) . '?bcc=' . implode( ',', $this->waitlist->get_registered_users_email_addresses() ) ;



	}


}
