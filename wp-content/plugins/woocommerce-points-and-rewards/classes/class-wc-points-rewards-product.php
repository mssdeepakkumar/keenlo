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
 * Product class
 *
 * Handle messages for the single product page, and calculations for how many points are earned for a product purchase,
 * along with the discount available for a specific product
 *
 * @since 1.0
 */
class WC_Points_Rewards_Product {


	/**
	 * Add product-related hooks / filters
	 *
	 * @since 1.0
	 */
	public function __construct() {

		// add single product message immediately after product excerpt
		add_action( 'woocommerce_single_product_summary', array( $this, 'render_product_message' ) );

		// add variation message before the price is displayed
		add_action( 'woocommerce_single_product_summary', array( $this, 'add_variation_message_to_product_summary' ), 15 );

		// add the points message just before the variation price.
		add_filter( 'woocommerce_variation_price_html', array( $this, 'render_variation_message' ), 10, 2 );
		add_filter( 'woocommerce_variation_sale_price_html', array( $this, 'render_variation_message' ), 10, 2 );

		// delete transients
		add_action( 'woocommerce_delete_product_transients', array( $this, 'delete_transients' ) );
	}


	/**
	 * Add "Earn X Points when you purchase" message to the single product page for simple products
	 *
	 * @since 1.0
	 */
	public function render_product_message() {
		global $product;

		// only display on single product page
		if ( ! is_product() )
			return;

		$message = get_option( 'wc_points_rewards_single_product_message' );

		$points_earned = self::get_points_earned_for_product_purchase( $product );

		// bail if none available
		if ( ! $message || ! $points_earned ) {

			$message = '';

		} else {

			// replace message variables
			$message = $this->replace_message_variables( $message, $product, $points_earned );
		}

		echo apply_filters( 'wc_points_rewards_single_product_message', $message, $this );
	}


	/**
	 * Add a message about the points to the product summary
	 *
	 * @since 1.2.6
	 */
	public function add_variation_message_to_product_summary( ) {
		global $product;

		// make sure the product has variations (otherwise it's probably a simple product)
		if ( method_exists( $product, 'get_available_variations' ) ) {
			// get variations
			$variations = $product->get_available_variations();

			// find the variation with the most points
			$points = $this->get_highest_points_variation( $variations, $product->post->ID );

			$message = '';
			// if we have a points value let's create a message; other wise don't print anything
			if ( $points ) {
				$message = $this->create_variation_message_to_product_summary( $points );
			}

			echo $message;
		}
	}


	/**
	 * Get the variation with the highest points and return the points value
	 *
	 * @since 1.2.6
	 */
	public function get_highest_points_variation( $variations, $product_id ) {

		// get transient name
		$transient_name = $this->transient_highest_point_variation( $product_id );

		// see if we already have this data saved
		$points = get_transient( $transient_name );

		// if we don't have anything saved we'll have to figure it out
		if ( $points === false ) {
			// find the variation with the most points
			$highest = array( 'key' => 0, 'points' => 0 );
			foreach ( $variations as $key => $variation ) {
				// get points
				$points = self::get_points_earned_for_product_purchase( $variation['variation_id'] );

				// if this is the highest points value save it
				if ( $points > $highest['points'] ) {
					$highest = array ( 'key' => $key, 'points' => $points );
				}
			}
			$points = $highest['points'];

			// save this for future use
			set_transient( $transient_name, $points, YEAR_IN_SECONDS );
		}

		return $points;
	}


	/**
	 * Create the "Earn up to X" message
	 *
	 * @since 1.2.6
	 */
	public function create_variation_message_to_product_summary( $points ) {
		global $wc_points_rewards;

		// write the message
		$message = sprintf(
			__( 'Earn up to <strong>%d</strong> %s.', 'wc_points_rewards' ),
			$points,
			$wc_points_rewards->get_points_label( $points )
		);

		// wrap it
		$message = "<p class='points'>" . $message . "</p>";

		return $message;
	}


	/**
	 * Create the "Earn more than X" message
	 *
	 * @since 1.2.6
	 */
	public function create_at_least_message_to_product_summary( $points ) {
		// write the message
		$message = sprintf(
			__( 'Earn at least <strong>%d</strong> points by purchasing this product.', 'wc_points_rewards' ),
			$points
		);

		// wrap it
		$message = "<p class='points'>" . $message . "</p>";

		return $message;
	}


	/**
	 * Add "Earn X Points when you purchase" message to the single product page for variable products
	 *
	 * @since 1.0
	 */
	public function render_variation_message( $price_html, $product ) {

		if ( ! is_product() ) {
			return $price_html;
		}

		$message = get_option( 'wc_points_rewards_single_product_message' );

		$points_earned = self::get_points_earned_for_product_purchase( $product );

		// bail if none available
		if ( ! $message || ! $points_earned ) {
			return $price_html;
		}

		// replace message variables
		$price_html = $this->replace_message_variables( $message, $product ) . $price_html;

		return $price_html;
	}


	/**
	 * Replace product page message variables :
	 *
	 * {points} - the points earned for purchasing the product
	 * {points_value} - the monetary value of the points earned
	 * {points_label} - the label used for points
	 *
	 * @since 1.0
	 * @param string $message the message set in the admin settings
	 * @param object $product the product
	 * @return string the message with variables replaced
	 */
	private function replace_message_variables( $message, $product ) {

		global $wc_points_rewards;

		$points_earned = self::get_points_earned_for_product_purchase( $product );

		// the min/max points earned for variable products can't be determined reliably, so the 'earn X points...' message
		// is not shown until a variation is selected, unless the prices for the variations are all the same
		// in which case, treat it like a simple product and show the message
		if ( method_exists( $product, 'get_variation_price' ) && $product->min_variation_price != $product->max_variation_price ) {
			return '';
		}

		// points earned
		$message = str_replace( '{points}', number_format_i18n( $points_earned ), $message );

		// points label
		$message = str_replace( '{points_label}', $wc_points_rewards->get_points_label( $points_earned ), $message );

		if ( method_exists( $product, 'get_variation_price' ) ) {
			$message = '<span class="wc-points-rewards-product-variation-message">' . $message . '</span><br/>';
		} else {
			$message = '<span class="wc-points-rewards-product-message">' . $message . '</span>';
		}
		return $message;
	}


	/**
	 * Return the points earned when purchasing a product. If points are set at both the product and category level,
	 * the product points are used. If points are not set at the product or category level, the points are calculated
	 * using the default points per currency and the price of the product
	 *
	 * @since 1.0
	 * @param object $product the product to get the points earned for
	 * @return int the points earned
	 */
	public static function get_points_earned_for_product_purchase( $product ) {

		// if we don't have a product object let's try to make one (hopefully they gave us the ID)
		if ( ! is_object( $product ) ) {
			$product = get_product( $product );
		}

		// check if earned points are set at product-level
		$points = self::get_product_points( $product );

		if ( is_numeric( $points ) ) {
			return $points;
		}

		// check if earned points are set at category-level
		$points = self::get_category_points( $product );

		if ( is_numeric( $points ) ) {
			return $points;
		}

		// otherwise, show the default points set for the price of the product
		return WC_Points_Rewards_Manager::calculate_points( $product->get_price() );
	}


	/**
	 * Return the points earned at the product level if set. If a percentage multiplier is set (e.g. 200%), the points are
	 * calculated based on the price of the product then multiplied by the percentage
	 *
	 * @since 1.0
	 * @param object $product the product to get the points earned for
	 * @return int the points earned
	 */
	public static function get_product_points( $product ) {

		if ( empty( $product->variation_id ) ) {
			// simple or variable product, for variable product return the maximum possible points earned
			if ( method_exists( $product, 'get_variation_price' ) ) {
				$points = ( isset( $product->wc_max_points_earned ) ) ? $product->wc_max_points_earned : '';
			} else {
				$points = ( isset( $product->wc_points_earned ) ) ? $product->wc_points_earned : '';
			}
		} else {
			// variation product
			$points = get_post_meta( $product->variation_id, '_wc_points_earned', true );

			// if points aren't set at variation level, use them if they're set at the product level
			if ( '' === $points ) {
				$points = ( isset( $product->parent->wc_points_earned ) ) ? $product->parent->wc_points_earned : '';
			}
		}

		// if a percentage modifier is set, adjust the points for the product by the percentage
		if ( false !== strpos( $points, '%' ) ) {
			$points = self::calculate_points_multiplier( $points, $product );
		}

		return $points;
	}


	/**
	 * Return the points earned at the category level if set. If a percentage multiplier is set (e.g. 200%), the points are
	 * calculated based on the price of the product then multiplied by the percentage
	 *
	 * @since 1.0
	 * @param object $product the product to get the points earned for
	 * @return int the points earned
	 */
	private static function get_category_points( $product ) {

		$category_ids = woocommerce_get_product_terms( $product->id, 'product_cat', 'ids' );

		$category_points = '';

		foreach ( $category_ids as $category_id ) {

			$points = get_woocommerce_term_meta( $category_id, '_wc_points_earned', true );

			// if a percentage modifier is set, adjust the default points earned for the category by the percentage
			if ( false !== strpos( $points, '%' ) )
				$points = self::calculate_points_multiplier( $points, $product );

			if ( ! is_numeric( $points ) )
				continue;

			// in the case of a product being assigned to multiple categories with differing points earned, we want to return the biggest one
			if ( $points >= (int) $category_points )
				$category_points = $points;
		}

		return $category_points;
	}


	/**
	 * Calculate the points earned when a product or category is set to a percentage. This modifies the default points
	 * earned based on the global "Earn Points Conversion Rate" setting and products price by the given $percentage.
	 * e.g. a 200% multiplier will change 5 points to 10.
	 *
	 * @since 1.0
	 * @param string $percentage the percentage to multiply the default points earned by
	 * @param object $product the product to get the points earned for
	 * @return int the points earned after adjusting for the multiplier
	 */
	private static function calculate_points_multiplier( $percentage, $product ) {

		$percentage = str_replace( '%', '', $percentage ) / 100;

		return $percentage * WC_Points_Rewards_Manager::calculate_points( $product->get_price() );
	}


	/**
	 * Return the maximum discount available for redeeming points. If a max discount is set at both the product and
	 * category level, the product max discount is used. A global max discount can be set which is used as a fallback if
	 * no other max discounts are set
	 *
	 * @since 1.0
	 * @param object $product the product to get the maximum discount for
	 * @return float|string the maximum discount or an empty string which means a maximum discount is not set for the given product
	 */
	public static function get_maximum_points_discount_for_product( $product ) {

		if ( ! is_object( $product ) )
			$product = get_product( $product );

		// check if max discount is set at product-level
		$max_discount = self::get_product_max_discount( $product );

		if ( is_numeric( $max_discount ) )
			return $max_discount;

		// check if max discount is are set at category-level
		$max_discount = self::get_category_max_discount( $product );

		if ( is_numeric( $max_discount ) )
			return $max_discount;

		// limit the discount available by the global maximum discount if set
		$max_discount = get_option( 'wc_points_rewards_max_discount' );

		// if the global max discount is a percentage, calculate it by multiplying the percentage by the product price
		if ( false !== strpos( $max_discount, '%' ) )
			$max_discount = self::calculate_discount_modifier( $max_discount, $product );

		if ( is_numeric( $max_discount ) )
			return $max_discount;

		// otherwise, there is no maximum discount set
		return '';
	}


	/**
	 * Return the maximum point discount at the product level if set. If a percentage multiplier is set (e.g. 35%),
	 * the maximum discount is equal to the product's price times the percentage
	 *
	 * @since 1.0
	 * @param object $product the product to get the maximum discount for
	 * @return float|string the maximum discount
	 */
	private static function get_product_max_discount( $product ) {

		if ( empty( $product->variation_id ) ) {

			// simple product
			$max_discount = ( isset( $product->wc_points_max_discount ) ) ? $product->wc_points_max_discount : '';

		} else {
			// variable product
			$max_discount = ( isset( $product->product_custom_fields['_wc_points_max_discount'][0] ) ) ? $product->product_custom_fields['_wc_points_max_discount'][0] : '';
		}

		// if a percentage modifier is set, set the maximum discount using the price of the product
		if ( false !== strpos( $max_discount, '%' ) )
			$max_discount = self::calculate_discount_modifier( $max_discount, $product );

		return $max_discount;
	}


	/**
	 * Return the maximum points discount at the category level if set. If a percentage multiplier is set (e.g. 35%),
	 * the maximum discount is equal to the product's price times the percentage
	 *
	 * @since 1.0
	 * @param object $product the product to get the maximum discount for
	 * @return float|string the maximum discount
	 */
	private static function get_category_max_discount( $product ) {

		$category_ids = woocommerce_get_product_terms( $product->id, 'product_cat', 'ids' );

		$category_max_discount = '';

		foreach ( $category_ids as $category_id ) {

			$max_discount = get_woocommerce_term_meta( $category_id, '_wc_points_max_discount', true );

			// if a percentage modifier is set, set the maximum discount using the price of the product
			if ( false !== strpos( $max_discount, '%' ) )
				$max_discount = self::calculate_discount_modifier( $max_discount, $product );

			// get the minimum discount if the product belongs to multiple categories with differing maximum discounts
			if ( ! is_numeric( $category_max_discount ) || $max_discount < $category_max_discount )
				$category_max_discount = $max_discount;
		}

		return $category_max_discount;
	}


	/**
	 * Calculate the maximum points discount when it's set to a percentage by multiplying the percentage times the product's
	 * price
	 *
	 * @since 1.0
	 * @param string $percentage the percentage to multiply the price by
	 * @param object $product the product to get the maximum discount for
	 * @return float the maximum discount after adjusting for the percentage
	 */
	private static function calculate_discount_modifier( $percentage, $product ) {

		$percentage = str_replace( '%', '', $percentage ) / 100;

		return $percentage * $product->get_price();
	}


	/**
	 * Get highest point variation transient name
	 *
	 * @since 1.2.6
	 */
	public function transient_highest_point_variation( $product_id ) {
		return 'wc_points_rewards_highest_point_variation_' . $product_id;
	}


	/**
	 * Delete transients
	 *
	 * @since 1.2.6
	 */
	public function delete_transients( $product_id ) {
		delete_transient( $this->transient_highest_point_variation( $product_id ) );
	}


} // end \WC_Points_Rewards_Product class
