<?php
/**
 * WooCommerce Points and Rewards
 *
 * @package     WC-Points-Rewards/Classes
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Discount class
 *
 * Handles generating the coupon code and data that allows the user to redeem their points for a discount
 *
 * @since 1.0
 */
class WC_Points_Rewards_Discount {


	/**
	 * Add coupon-related filters to help generate the custom coupon
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// set our custom coupon data
		add_filter( 'woocommerce_get_shop_coupon_data', array( $this, 'get_discount_data' ), 10, 2 );

		// filter the "coupon applied successfully" message
		add_filter( 'woocommerce_coupon_message', array( $this, 'get_discount_applied_message' ), 10, 3 );
	}


	/**
	 * Generate the coupon data required for the discount
	 *
	 * @since 1.0
	 * @param array $data the coupon data
	 * @param string $code the coupon code
	 * @return array the custom coupon data
	 */
	public function get_discount_data( $data, $code ) {

		if ( strtolower( $code ) != $this->get_discount_code() )
			return $data;

		// note: we make our points discount "greedy" so as many points as possible are
		//   applied to the order.  However we also want to play nice with other discounts
		//   so if another coupon is applied we want to use less points than otherwise.
		//   The solution is to make this discount apply post-tax so that both pre-tax
		//   and post-tax discounts can be considered.  At the same time we use the cart
		//   subtotal excluding tax to calculate the maximum points discount, so it
		//   functions like a pre-tax discount in that sense.
		$data = array(
			'id'                         => true,
			'type'                       => 'fixed_cart',
			'amount'                     => WC_Points_Rewards_Cart_Checkout::get_discount_for_redeeming_points( true ),
			'individual_use'             => 'no',
			'product_ids'                => '',
			'exclude_product_ids'        => '',
			'usage_limit'                => '',
			'usage_count'                => '',
			'expiry_date'                => '',
			'apply_before_tax'           => 'yes',
			'free_shipping'              => 'no',
			'product_categories'         => array(),
			'exclude_product_categories' => array(),
			'exclude_sale_items'         => 'no',
			'minimum_amount'             => '',
			'customer_email'             => array()
		);
		
		return $data;
	}


	/**
	 * Change the "Coupon applied successfully" message to "Discount Applied Successfully"
	 *
	 * @since 1.0
	 * @param string $message the message text
	 * @param string $message_code the message code
	 * @param object $coupon the WC_Coupon instance
	 * @return string the modified messages
	 */
	public function get_discount_applied_message( $message, $message_code, $coupon ) {
		if ( $message_code === WC_Coupon::WC_COUPON_SUCCESS && $coupon->code === $this->get_discount_code() )
			return __( 'Discount Applied Successfully', 'wc_points_rewards' );
		else
			return $message;
	}


	/**
	 * Generates a unique discount code tied to the current user ID and timestamp
	 *
	 * @since 1.0
	 */
	public static function generate_discount_code() {
		global $woocommerce;

		// set the discount code to the current user ID + the current time in YYYY_MM_DD_H_M format
		$discount_code = sprintf( 'wc_points_redemption_%s_%s', get_current_user_id(), date( 'Y_m_d_h_i', current_time( 'timestamp' ) ) );

		return $woocommerce->session->wc_points_rewards_discount_code = $discount_code;
	}


	/**
	 * Returns the unique discount code generated for the applied discount if set
	 *
	 * @since 1.0
	 */
	public static function get_discount_code() {
		global $woocommerce;

		if ( isset( $woocommerce->session->wc_points_rewards_discount_code ) )
			return $woocommerce->session->wc_points_rewards_discount_code;
	}


} // end \WC_Points_Rewards_Discount class
