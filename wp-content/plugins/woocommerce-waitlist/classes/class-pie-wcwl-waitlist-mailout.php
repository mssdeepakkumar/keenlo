<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Waitlist Mailout
 *
 * An email sent to the admin when a new order is received/paid for.
 *
 * @class   Pie_WCWL_Waitlist_Mailout
 * @extends  WC_Email
 */

if ( ! class_exists( 'Pie_WCWL_Waitlist_Mailout' ) ) {
	class Pie_WCWL_Waitlist_Mailout extends WC_Email {

		/**
		 * Constructor
		 */
		function __construct() {

			$this->id     = WCWL_SLUG . '_mailout';
			$this->title    = __( 'Waitlist Mailout', 'woocommerce-waitlist' );
			$this->description  = __( 'When a product changes from being Out-of-Stock to being In-Stock, this email is sent to all users registered on the waitlist for that product.', 'woocommerce-waitlist' );

			$this->heading    = __( '{product_title} is now back in stock at {blogname}', 'woocommerce-waitlist' );
			$this->subject       = __( 'A product you are waiting for is back in stock', 'woocommerce-waitlist' );

			$this->template_base = WooCommerce_Waitlist_Plugin::$path . 'templates/emails/';
			$this->template_html  = 'waitlist-mailout.php';
			$this->template_plain  = 'plain/waitlist-mailout.php';

			// Triggers for this email
			add_action( 'woocommerce_waitlist_mailout_send_email', array( $this, 'trigger' ), 10, 2 );

			// Call parent constructor
			parent::__construct();
		}

		/**
		 * trigger function.
		 *
		 * @access public
		 * @return void
		 */
		function trigger( $user_id, $product_id ) {
			if ( is_numeric( $user_id ) && is_numeric( $product_id ) ) {

				$user = get_user_by( 'id', $user_id );
				$this->object = get_product( $product_id );
				$this->recipient = $user->user_email;

				$this->find[] = '{product_title}';
				$this->replace[] = $this->object->get_title();

			}

			if ( ! $this->is_enabled() || ! $this->get_recipient() )
				return;

			$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
		}

		/**
		 * get_content_html function.
		 *
		 * @access public
		 * @return string
		 */
		function get_content_html() {
			ob_start();
			wc_get_template( $this->template_html, array(
				'product_title'   => $this->object->get_title(),
					'product_link'  => get_permalink( $this->object->id ),
					'email_heading' => $this->get_heading()
				), false, $this->template_base

			);
			return ob_get_clean();
		}

		/**
		 * get_content_plain function.
		 *
		 * @access public
		 * @return string
		 */
		function get_content_plain() {
			ob_start();
			wc_get_template( $this->template_plain, array(
					'product_title'   => $this->object->get_title(),
					'product_link'  => get_permalink( $this->object->id ),
					'email_heading' => $this->get_heading()
				), false, $this->template_base
				 );
			return ob_get_clean();
		}
	}

}

return new Pie_WCWL_Waitlist_Mailout();
