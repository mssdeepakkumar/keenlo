<?php
/**
 * The front end user interface for the plugin
 *
 * @package  WooCommerce Waitlist
 */
class Pie_WCWL_Frontend_UI {

	/**
	 * WP_User object representing the currently logged in user
	 *
	 * @var object
	 * @access private
	 */
	private $User;

	/**
	 * WC_Product object currently being viewed
	 *
	 * @var object
	 * @access private
	 */
	private $Product;

	/**
	 * the string used by this plugin for passing product_ids around in $_REQUEST variables
	 *
	 * @var string
	 * @access private
	 */
	private $product_id_slug;

	/**
	 * woocommerce global, used in this plugin for holding user notifications and error messages
	 *
	 * @var object
	 * @access private
	 */
	private $messages;

	/**
	 * hooks up the frontend initialisation and any functions that need to run before the 'init' hook
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		add_action ( 'init', array( &$this, 'remove_woocommerce_add_to_cart_action_if_not_required' ), 5 );
		add_action ( 'wp', array( &$this, 'frontend_init' ) );
	}



	/**
	 * initialises the frontend UI, hooking up required functions and setting up required objects
	 *
	 * If we're not viewing a product in the frontend, the whole thing just exits. Otherwise we populate the Class
	 * parameters (including adding our Waitlist object to the WC_Product) and hook up any required functions.
	 *
	 * Currently we're also doing a little waitlist management for children of grouped products and variable products
	 * in this function which could really do with being refactored out in a future release
	 *
	 * @hooked action init
	 * @todo refactor the registration into own function
	 * @access public
	 * @return void
	 * @since 1.0
	 */
	public function frontend_init() {


		require_once WooCommerce_Waitlist_Plugin::$path . '/shortcodes.php';

		global $post;
		$this->User = is_user_logged_in() ? wp_get_current_user() : false ;

		if ( 'product' !== get_post_type( $post ) ) return;

		global $woocommerce;

		$this->messages = $woocommerce;

		$this->Product = WooCommerce_Waitlist_Plugin::get_product( $post->ID );


		$this->product_id_slug = WCWL_SLUG . '_product_id';
		$this->setup_text_strings();

		add_filter( 'woocommerce_add_to_cart_url', array( &$this, 'remove_waitlist_parameters_from_query_string' ) );


		$this->Product->Waitlist = new Pie_WCWL_Waitlist( $this->Product );


		if ( $this->Product->is_type( 'simple' ) && ! $this->Product->is_in_stock() ) {



			if ( isset ( $_REQUEST[ WCWL_SLUG ] ) ) $this->toggle_waitlist_action();
			add_filter( 'woocommerce_stock_html', array( &$this, 'append_waitlist_control' ), 20 );
			add_filter( 'woocommerce_get_availability', array( &$this, 'append_waitlist_message' ), 20, 2 );


		}

		if ( $this->Product->is_type( 'variable' ) ) {


			if ( isset ( $_REQUEST[ WCWL_SLUG ] ) && is_numeric( $_REQUEST[ WCWL_SLUG ] ) &&  ! isset( $_REQUEST['added-to-cart'] ) ) {
				if ( function_exists( 'get_product' ) )
					$changed_product = get_product( $_REQUEST[ WCWL_SLUG ] );
				else
					$changed_product = new WC_Product_Variation( $_REQUEST[ WCWL_SLUG ] );

				$changed_product->Waitlist = new Pie_WCWL_Waitlist ( $changed_product );
				$this->toggle_waitlist_action( $changed_product );
			}
			foreach ( $this->Product->get_children() as $key => $child_id ) {

				if ( isset( $changed_product ) && $child_id == $changed_product->variation_id  ) {
					$this->Product->children[ $child_id ] = $changed_product;
				} else {
					$this->Product->children[ $child_id ] = $this->Product->get_child( $child_id );
					$this->Product->children[ $child_id ]->Waitlist = new Pie_WCWL_Waitlist( $this->Product->children[ $child_id ] );

				}

				unset( $this->Product->children[ $key ] );



				add_filter( 'woocommerce_get_availability', array( &$this, 'append_waitlist_message' ), 20, 2 );
				add_filter( 'woocommerce_get_availability', array( &$this, 'append_waitlist_control_to_availability_message' ), 21, 2 );

			}

		}


		if ( $this->Product->is_type( 'grouped' ) ) {

			$out_of_stock = false;
			$updated = false;
			foreach ( $this->Product->get_children() as $child_id ) {

				$this->Product->children[ $child_id ] = $this->Product->get_child( $child_id );

				if ( $this->Product->children[ $child_id ]->is_in_stock() ) continue;

				$out_of_stock = true;

				$this->Product->children[ $child_id ]->Waitlist = new Pie_WCWL_Waitlist( $this->Product->children[ $child_id ] );
				if ( isset( $_REQUEST[ WCWL_SLUG ] ) ) {
					$updated = true;
					if ( isset ( $_REQUEST[ $this->product_id_slug ] ) && in_array( $child_id, $_REQUEST[ $this->product_id_slug ] ) ) {
						$this->Product->children[ $child_id ]->Waitlist->register_user( $this->User ) ;
					} else {
						$this->Product->children[ $child_id ]->Waitlist->unregister_user( $this->User );
					}


				}

			}

			if ( $out_of_stock ) {
				add_filter( 'woocommerce_get_availability', array( &$this, 'append_waitlist_control_for_children_of_grouped_products' ), 20, 2 );
				add_action( 'woocommerce_after_add_to_cart_button', array( &$this, 'output_waitlist_control' ), 20 );
				add_action( 'woocommerce_after_add_to_cart_button', array( &$this, 'output_grouped_product_waitlist_message' ) );
				add_action( 'wp_print_styles', array( &$this, 'print_grouped_product_style_block' ) ) ;
			}
			if ( $updated ) {
				WooCommerce_Waitlist_Plugin::add_notice( apply_filters( 'wcwl_update_waitlist_success_message_text', $this->update_waitlist_success_message_text ) );
			}
		}
	}

	/**
	 * This function currently returns HTML for a list table of all the product a user is on the waitlist for, with a
	 * link through to the product to remove themselves. I would suggest this can
	 * be refactored and possibly moved to the Waitlist Object. The HTML output could be removed also and placed within
	 * filters
	 *
	 * @return string The HTML for the waitlist table
	 * @since 1.1.3
	 */
	public function current_user_waitlist() {
		if ( ! $this->User ) return;

		$waitlist_products = WooCommerce_Waitlist_Plugin::get_waitlist_products_by_user_id( $this->User->ID );

		$content = '<h2 class="my_account_titles">Your Waitlist</h2>';

		if ( is_array( $waitlist_products ) && ! empty( $waitlist_products ) ) {

			$cached_product = $this->Product;
			$content .= '<p>You are currently on the waitlist for the following products.</p>';
			$content .= '<table class="shop_table"><tbody>';

			foreach ( $waitlist_products as $post ) {

				$this->Product = WooCommerce_Waitlist_Plugin::get_product( $post->ID );
				$this->Product->Waitlist = new Pie_WCWL_Waitlist( $this->Product );
				$content .= '<tr><td>';

				if ( has_post_thumbnail($post->ID) ) $content .= get_the_post_thumbnail( $post->ID, 'shop_thumbnail' );
				$content .= '</td><td><a href="' . get_permalink($post->ID) . '"  >' . esc_html( get_the_title($post->ID) ) . '</a></td></tr>';

			}
			wp_reset_postdata();
			$this->Product = $cached_product;
			$content .= '</tbody></table>';

		}else {
			$content .= '<p>You have not yet joined the waitlist for any products.</p>';
		}

		return $content;


	}

	/**
	 * Catches the $_REQUEST parameter for waitlist toggling
	 *
	 * This function catches the input from a simple or variable product type, performs some validation and then
	 * either sets the appropriate response message if invalid or calls the toggle_waitlist function if valid
	 *
	 * @access public
	 * @return void
	 * @since 1.0
	 */

	public function toggle_waitlist_action( $product = false ) {

		if ( ! wp_verify_nonce( $_REQUEST[ WCWL_SLUG . '_nonce'], __FILE__ ) )
			return WooCommerce_Waitlist_Plugin::add_notice( apply_filters( 'wcwl_toggle_waitlist_ambiguous_error_message_text', $this->toggle_waitlist_ambiguous_error_message_text ), 'error' );

		if ( false === $this->User || 0 === $this->User->ID && WooCommerce_Waitlist_Plugin::users_must_be_logged_in_to_join_waitlist() )
			return WooCommerce_Waitlist_Plugin::add_notice( $this->get_toggle_waitlist_no_user_message(), 'error' );

		if ( ! $product ) {
			$product = $this->Product;
		}
		return $this->toggle_waitlist( $product->Waitlist );

	}

	/**
	 * Toggles the Frontend User waitlist status for the passed in waitlist, setting the appropriate response message.
	 *
	 * @param object  $Waitlist Pie_WCWL_Waitlist
	 * @access public
	 * @return void
	 * @since 1.0
	 */
	public function toggle_waitlist( $Waitlist ) {

		if ( $Waitlist->user_is_registered( $this->User ) && $Waitlist->unregister_user( $this->User ) )
			return WooCommerce_Waitlist_Plugin::add_notice( apply_filters( 'wcwl_leave_waitlist_success_message_text', $this->leave_waitlist_success_message_text ) );
		if ( ! $Waitlist->user_is_registered( $this->User ) && $Waitlist->register_user( $this->User ) )
			return WooCommerce_Waitlist_Plugin::add_notice( apply_filters( 'wcwl_join_waitlist_success_message_text', $this->join_waitlist_success_message_text ) );

		return WooCommerce_Waitlist_Plugin::add_notice( apply_filters( 'wcwl_toggle_waitlist_ambiguous_error_message_text', $this->toggle_waitlist_ambiguous_error_message_text ), 'error' );
	}

	public function toggle_waitlist_without_message( $Waitlist ) {
		if ( $Waitlist->user_is_registered( $this->User ) && $Waitlist->unregister_user( $this->User ) )
			return ;
		if ( ! $Waitlist->user_is_registered( $this->User ) && $Waitlist->register_user( $this->User ) )
			return ;

		return WooCommerce_Waitlist_Plugin::add_notice( apply_filters( 'wcwl_toggle_waitlist_ambiguous_error_message_text', $this->toggle_waitlist_ambiguous_error_message_text ), 'error' );

	}

	/**
	 * Appends the waitlist button HTML to text string
	 *
	 * @hooked filter woocommerce_stock_html
	 * @param string  $string HTML for Out of Stock message
	 * @access private
	 * @return string HTML with Waitlist button appended if product is out of stock
	 * @todo hook up logged out registration
	 * @since 1.0
	 */
	public function append_waitlist_control( $string = '' ) {
		$string .= '<div>';
		if ( false === $this->User || 0 === $this->User->ID  ) {
			if ( WooCommerce_Waitlist_Plugin::users_must_be_logged_in_to_join_waitlist() ) {

				$string .=  $this->get_waitlist_control( 'dummy' );
			}
			// there will never be an 'else' here until logged out registration is possible

		} else {

			if ( $this->Product->is_type( 'grouped' ) ) {
				$string .= $this->get_waitlist_control( 'update', 'submit' );

			}elseif ( $this->Product->Waitlist->user_is_registered( $this->User )  ) {

				$string .=  $this->get_waitlist_control( 'leave' );

			} else {

				$string .=  $this->get_waitlist_control( 'join' );
			}

		}
		$string .= '</div>';

		return $string;
	}

	public function output_waitlist_control() {
		echo $this->append_waitlist_control();

	}

	/**
	 * append_waitlist_message
	 *
	 * @param mixed   $array   Description.
	 * @param mixed   $product Description.
	 *
	 * @access public
	 *
	 * @return mixed Value.
	 * @since 1.1.0
	 */
	public function append_waitlist_message( $array, $product ) {

		if ( $this->Product->is_type( 'variable' ) ) {
			$product = $this->Product->children[ $product->variation_id ];
		} else {
			$product = $this->Product;
		}

		if ( ! $product->is_in_stock() ) {
			if ( false === $this->User || 0 === $this->User->ID || ! $product->Waitlist->user_is_registered( $this->User ) ) {
				$array['availability'] .= apply_filters( 'wcwl_join_waitlist_message_text', ' - ' . $this->join_waitlist_message_text );
			} else {
				$array['availability'] .= apply_filters( 'wcwl_leave_waitlist_message_text', ' - ' . $this->leave_waitlist_message_text );
			}
		}
		return $array;
	}
	/**
	 * Appends the waitlist message HTML to the 'availability' member of an array
	 *
	 * @hooked filter woocommerce_get_availability
	 * @param array   $array        'availability'=>availability string,'class'=>class for availability element
	 * @param object  $this_product WC_Product
	 * @access public
	 * @return array The $array parameter with appropriate message text appended to $array['availability']
	 * @since 1.0
	 */
	public function append_waitlist_control_to_availability_message( $array, $product ) {

		if ( $this->Product->is_type( 'variable' ) ) {
			$product = $this->Product->children[ $product->variation_id ];
		} else {
			$product = $this->Product;
		}
		if ( $product->is_in_stock() ) return $array;

		if ( false === $this->User || 0 === $this->User->ID || ! $product->Waitlist->user_is_registered( $this->User ) ) {
			$array['availability'] .= '<div>' . $this->get_variable_product_control( 'join', $product ) . '</div>';
		} else {
			$array['availability'] .= '<div>' . $this->get_variable_product_control( 'leave', $product ) . '</div>';
		}

		return $array;
	}

	/**
	 * Appends the waitlist control HTML for child products of a grouped product to the 'availability' member of an array
	 *
	 * @hooked filter woocommerce_get_availability
	 * @param array   $array        'availability'=>availability string,'class'=>class for availability element
	 * @param object  $this_product WC_Product
	 * @access public
	 * @return array The $array parameter with appropriate button HTML appended to $array['availability']
	 * @since 1.0
	 */
	public function append_waitlist_control_for_children_of_grouped_products( $array, $child_product ) {
		if ( ! $child_product->is_in_stock() ) {

			$child_product_waitlist = $this->Product->children[ $child_product->id ]->Waitlist ;

			$context = 'dummy';
			if ( false === $this->User || 0 !== $this->User->ID )
				$context = $child_product_waitlist->user_is_registered( $this->User ) ? 'leave' : 'join'  ;

			$array['availability'] .=  $this->get_grouped_product_control( $context, $this->Product->children[ $child_product->id ] )  ;

		}

		return $array;

	}


	/**
	 * outputs the appropriate Grouped Product message HTML
	 *
	 * @hooked action woocommerce_after_add_to_cart_form
	 * @access public
	 * @return void
	 * @since 1.0
	 */
	public function output_grouped_product_waitlist_message() {

		$classes = implode( ' ', apply_filters( 'wcwl_grouped_product_message_classes', array( 'out-of-stock', WCWL_SLUG ) ) );
		$text = apply_filters( WCWL_SLUG . '_grouped_product_message_text', $this->grouped_product_message_text );
		echo apply_filters( WCWL_SLUG . '_grouped_product_message_html', '<p class="' . esc_attr( $classes ) . '">' . $text . '</p>' );

	}



	/**
	 * get_grouped_product_control
	 *
	 * @param mixed   $context       Description.
	 * @param mixed   $child_product Description.
	 *
	 * @access public
	 *
	 * @return mixed Value.
	 * @since 1.1.0
	 */
	public function get_grouped_product_control( $context, $child_product ) {
		return $this->get_waitlist_control( $context, 'checkbox' , $child_product );
	}

	/**
	 * get_variable_product_control
	 *
	 * @param mixed   $context       Description.
	 * @param mixed   $child_product Description.
	 *
	 * @access public
	 *
	 * @return mixed Value.
	 * @since 1.1.0
	 */
	public function get_variable_product_control( $context, $child_product ) {
		return $this->get_waitlist_control( $context, 'anchor', $child_product );
	}

	/**
	 * Get HTML for waitlist button
	 *
	 * @param object  $product WC_Product for which to get button HTML
	 * @param string  $context the context in which the button should be generated (join|leave|dummy)
	 * @param string  $type    optional - the HTML element to generate. anchor|submit. Defaults to anchor
	 * @access public
	 * @return string HTML for join waitlist button
	 * @todo refactor
	 * @since 1.0
	 */
	public function get_waitlist_control( $context, $type = 'anchor', $product = false ) {



		$text_parameter = $context . '_waitlist_button_text' ;
		$classes = implode( ' ', apply_filters( 'wcwl_' . $context . '_waitlist_button_classes', array( 'button', 'alt', WCWL_SLUG, $context ) ) );
		$text = apply_filters( 'wcwl_' . $context . '_waitlist_button_text', $this->$text_parameter );

		switch ( $type ) {

		case 'input':
		case 'submit':

			return apply_filters( 'wcwl_' . $context . '_waitlist_submit_button_html', '<input type="submit" class="' . esc_attr( $classes ) . '" id="' . esc_attr( WCWL_HOOK_PREFIX )  .'-product-'. esc_attr( $this->Product->id ).'" name="' . WCWL_SLUG . '" value="' . esc_attr( $text ) . '" />' );
			break;

		case 'checkbox':

			$product = $product ? $product : $this->Product;
			$checked = $product->Waitlist->user_is_registered( $this->User ) ;

			return apply_filters( 'wcwl_' . $context . '_waitlist_submit_button_html', '<label class="' . WCWL_SLUG . '_label" > - ' . apply_filters( 'wcwl_' . $context . '_waitlist_button_text', $this->join_waitlist_button_text ) . '<input type="checkbox" id="' . esc_attr( WCWL_HOOK_PREFIX )  .'-product-'. esc_attr( $this->Product->id ) .'" name="' . ( 'dummy' == $context ? $context : $this->product_id_slug . '[]' ) .'" value="' . esc_attr( $product ? $product->id : $this->Product->id ) . '" ' . ( $checked ? 'checked' : '' ) . ' /></label>' );
			break; //needed?

		default: //anchor
			if ( $product && $this->Product->is_type( 'variable' ) ) {
				$url = $this->toggle_waitlist_url( $product->variation_id );
			} else {
				$url = $this->toggle_waitlist_url();
			}
			return apply_filters( 'wcwl_' . $context . '_waitlist_button_html', '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $classes ) . '" id="wcwl-product-'. esc_attr( $this->Product->id ).'">' . esc_html( $text ) . '</a>' );
		}

	}


	/**
	 * Get URL to toggle waitlist status
	 *
	 * @param object  $this_product WC_Product for which to get URL
	 * @access public
	 * @return string Toggle Waitlist URL for $this_product
	 * @since 1.0
	 */
	private function toggle_waitlist_url( $product_id = false ) {

		$product_id = $product_id ? $product_id : $this->Product->id;
		$url = add_query_arg( WCWL_SLUG , $product_id, get_permalink( $this->Product->id ) );
		$url = add_query_arg( WCWL_SLUG . '_nonce' , wp_create_nonce( __FILE__ ), $url );
		return apply_filters( 'wcwl_toggle_waitlist_url',  $url );
	}

	/**
	 * Gets the appropriate error message when no user is logged in
	 *
	 * @param integer $product_id the ID of the product being added
	 * @access public
	 * @return string The error message, dependent whether or not account registration is allowed
	 * @since 1.0
	 */
	public function get_toggle_waitlist_no_user_message() {

		$login_url = get_permalink( woocommerce_get_page_id( 'myaccount' ) );

		if ( ! $login_url )
			$login_url = wp_login_url( $this->toggle_waitlist_url() );

		$register_url = add_query_arg( 'action', 'register' , $login_url );

		if ( get_option( 'users_can_register' ) )
			return apply_filters( 'wcwl_users_must_register_and_login_message_text', sprintf( $this->users_must_register_and_login_message_text, $register_url, $login_url  ) , $this->Product )  ;

		return apply_filters( 'wcwl_users_must_login_message_text', sprintf( $this->users_must_login_message_text,  $login_url  ) , $this->Product )  ;

	}

	/**
	 * Sets up the text strings used by the plugin in the front end
	 *
	 * @hooked action plugins_loaded
	 * @access public
	 * @return void
	 * @since 1.0
	 */
	private function setup_text_strings() {

		$this->join_waitlist_button_text = __( 'Join waitlist', 'woocommerce-waitlist' );
		$this->dummy_waitlist_button_text = __( 'Join waitlist', 'woocommerce-waitlist' );
		$this->leave_waitlist_button_text =  __( 'Leave waitlist', 'woocommerce-waitlist' );
		$this->update_waitlist_button_text =  __( 'Update waitlist', 'woocommerce-waitlist' );
		$this->join_waitlist_message_text =  __( "Join the waitlist to be emailed when this booking becomes available", 'woocommerce-waitlist' );
		$this->leave_waitlist_message_text = __( 'You are on the waitlist for this product', 'woocommerce-waitlist' ) ;
		$this->leave_waitlist_success_message_text =  __( 'You have been removed from the waitlist for this product', 'woocommerce-waitlist' ) ;
		$this->join_waitlist_success_message_text =  __( 'You have been added to the waitlist for this product', 'woocommerce-waitlist' ) ;
		$this->update_waitlist_success_message_text =  __( 'You have updated your waitlist for these products', 'woocommerce-waitlist' ) ;
		$this->join_waitlist_invalid_email_message_text =  __( 'You must provide a valid email address to join the waitlist for this product', 'woocommerce-waitlist' ) ;
		$this->toggle_waitlist_no_product_message_text = __( 'You must select a product for which to join the waitlist', 'woocommerce-waitlist' );
		$this->toggle_waitlist_ambiguous_error_message_text = __( 'Something seems to have gone awry. Are you trying to mess with the fabric of the universe?', 'woocommerce-waitlist' ) ;
		$this->users_must_register_and_login_message_text = __( 'You must <a href="%1$s">create an account</a> and be <a href="%2$s">logged in</a> to join the waitlist for this product', 'woocommerce-waitlist' );
		$this->users_must_login_message_text = __( 'You must be <a href="%s">logged in</a> to join the waitlist for this product', 'woocommerce-waitlist' );
		$this->grouped_product_message_text = __( "Check the box alongside any Out of Stock products and update the waitlist to be emailed when they become available", 'woocommerce-waitlist' );
		$this->email_field_placeholder_text = __( "Email address" , 'woocommerce-waitlist' );
	}

	/**
	 * unhooks the woocommerce 'add to cart' action if not required
	 *
	 * This function only unhooks the action in the condition the add-to-cart $_REQUEST is set and we also have our own
	 * $_REQUEST variable. This is necessary because on grouped products our submit button has to share the same form
	 * element as the add-to-cart button. If they have clicked our button, we want to ignore the fact that the
	 * 'add-to-cart' is present.
	 *
	 * @hooked action init
	 * @access public
	 * @return void
	 * @since 1.0
	 */
	public function remove_woocommerce_add_to_cart_action_if_not_required() {
		if ( empty( $_REQUEST['add-to-cart'] ) || empty( $_REQUEST[ WCWL_SLUG ] ) ) return;
		remove_action( 'init', 'woocommerce_add_to_cart_action' );
	}

	public function remove_waitlist_parameters_from_query_string( $query_string ) {
		return remove_query_arg( array( 'woocommerce_waitlist', 'woocommerce_waitlist_nonce' ),  $query_string );
	}

	/**
	 * Output style block for .group_table on Grouped Product
	 *
	 * @hooked action wp_print_styles
	 * @access public
	 * @return void
	 * @since 1.0
	 */
	public function print_grouped_product_style_block() {
		global $post;

		$product = WooCommerce_Waitlist_Plugin::get_product( $post->ID );


		if ( ! $product->is_type( 'grouped' ) ) return;

		$css = apply_filters( WCWL_SLUG . '_grouped_product_style_block_css', 'p.' . WCWL_SLUG . '{padding-top:20px;clear:both;margin-bottom:10px;}' );
		echo apply_filters( WCWL_SLUG . '_grouped_product_style_block', '<style type="text/css">' . $css . '</style>' );

	}

}
