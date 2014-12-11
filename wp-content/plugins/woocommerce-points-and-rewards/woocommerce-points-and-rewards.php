<?php
/**
 * Plugin Name: WooCommerce Points and Rewards
 * Plugin URI: http://www.woothemes.com/products/woocommerce-points-and-rewards/
 * Description: Reward customers for purchases and other actions with points which can be redeemed for discounts
 * Author: WooThemes
 * Author URI: http://www.woothemes.com
 * Version: 1.3.0
 * Text Domain: wc_points_rewards
 * Domain Path: /languages/
 *
 * Copyright: (c) 2013 WooThemes
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package   WC-Points-Rewards
 * @author    WooThemes
 * @category  Marketing
 * @copyright Copyright (c) 2013, WooThemes
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Required functions
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

// Plugin updates
woothemes_queue_update( plugin_basename( __FILE__ ), '1649b6cca5da8b923b01ca56b5cdd246', 210259 );

// Check if WooCommerce is active
if ( ! is_woocommerce_active() )
	return;

/**
 * The WC_Points_Rewards global object
 * @name $wc_points_rewards
 * @global WC_Points_Rewards $GLOBALS['wc_points_rewards']
 */
$GLOBALS['wc_points_rewards'] = new WC_Points_Rewards();


/**
 * # WooCommerce Points and Rewards Main Plugin Class
 *
 * ## Plugin Overview
 *
 * This plugin lets customers earn points for purchases and actions (such as writing a review) and then redeem those
 * points for a discount on a purchase. Points earned per monetary value spent is defined in the settings along with
 * the amount of points that provides a discount. Points earned can be overridden at both the product category, and
 * product level using either a fixed amount of points earned, or by setting a percentage which modifies the amount of points
 * that would typically be earned.
 *
 * When points are redeemed for a discount, a coupon code is dynamically created and the discount amount is set as the
 * value of the coupon. Immediately upon checkout, the points are deducted from the customer's account. Any points earned
 * for the purchases are not added to the customer's account *until* payment is received for the order. If an order where
 * points were redeemed for a discount is cancelled or refunded, the points are credited back to the customer's account.
 *
 * ## Admin Considerations
 *
 * General Settings are added to WooCommerce > Settings > Points & Rewards. A sub-menu page "Points & Rewards" is also
 * added under "WooCommerce" that displays the Manage Points list table, and the Points Log list table. Fields
 * are added to simple/variable products, and also to the create/edit/view product category view.
 *
 * ## Frontend Considerations
 *
 * Messages are displayed on the single product page (both for simple and variable products). Messages are also displayed
 * on the cart/checkout page indicating how many points the customer will earn for the purchase, and whether there is a discount
 * available to redeem points for. A "My Points" section is added to the "My Account" page that lists the current amount of points
 * the user has, as well as a listing of the 5 most recent point events
 *
 * ## Database
 *
 * ### Global Settings
 *
 * + `wc_points_rewards_default_points_earned` - the default points earned for a purchase, can be either fixed amount or percentage
 * + `wc_points_rewards_display_monetary_value` - whether to display the monetary value for points or not
 * + `wc_points_rewards_points_label` - the label for "Points" on the frontend
 * + `wc_points_rewards_single_product_message` - the call to action to display on the single product page
 * + `wc_points_rewards_earn_points_message` - the message to display on the cart/checkout page when points will be earned for the purchase
 * + `wc_points_rewards_earn_points_message` - the message to display on the cart/checkout page when points are available for redemption
 *
 * ### Options table
 *
 * + `wc_points_rewards_version` - the current plugin version, set on install/upgrade
 *
 * ### Product meta
 *
 * + `_wc_points_earned` - the points earned when this product is purchased, this can be set at both the variable/variation level
 *
 *
 * ### User meta
 *
 * + `wc_points_balance` - the users total points balance.  This is the summation
 *   of all the user points records, and used solely for the purposes of sorting
 *   records in the manage user points table.
 *
 * ### Custom Table wc_points_rewards_user_points
 *
 * This table represents awarded user points and records are created each time
 * the balance of points for a customer increases due to them placing an order
 * or performing another point-generating event.
 *
 * + user_id: references the customer user record
 * + points: the total points earned for the associated event
 * + points_balance: the balance of points available for use (can be positive or negative)
 * + order_id: optional order identifier, if this event was associated with an order
 * + date: the date the points were awarded
 *
 * ### Custom Table wc_points_rewards_user_points_log
 *
 * This table tracks changes in the balance of points for users
 *
 * + user_id: references the customer user record
 * + points: the total change in points (can be positive or negative)
 * + type: optional slug identifying the type of event being logged; this is used for grouping events of the same type
 * + user_points_id: optional, references the wc_points_rewards_user_points table when the log entry refers to a points record
 * + order_id: optional, references the order if this event was associated with an order
 * + admin_user_id: optional, references an admin user if one was responsible for the change in points for this event
 * + data: optional serialized associative array of arbitrary data which can be provided by third party point events
 * + date: the event date
 */
class WC_Points_Rewards {

	/** plugin version number */
	const VERSION = '1.3.0';

	/** @var string the plugin path */
	private $plugin_path;

	/** @var string the plugin url */
	private $plugin_url;

	/** @var \WC_Logger instance */
	private $logger;

	/** @var \WC_Points_Rewards_Admin admin class */
	private $admin;

	/** @var \WC_Points_Rewards_Admin product admin class */
	private $product_admin;

	/** @var WP_Admin_Message_Handler admin message handler class */
	public $admin_message_handler;

	/** @var string the user points log database tablename */
	public $user_points_log_db_tablename;

	/** @var string the user points database tablename */
	public $user_points_db_tablename;

	/** @var WC_Points_Rewards_Actions the core actions integration */
	public $actions;

	/**
	 * Initializes the plugin
	 *
	 * @since 1.0
	 */
	public function __construct() {

		global $wpdb;

		// initialize the custom table names
		$this->user_points_log_db_tablename = $wpdb->prefix . 'wc_points_rewards_user_points_log';
		$this->user_points_db_tablename     = $wpdb->prefix . 'wc_points_rewards_user_points';

		// include required files
		$this->includes();

		// called just before the woocommerce template functions are included
		add_action( 'init', array( $this, 'load_translation' ) );
		add_action( 'init', array( $this, 'include_template_functions' ), 25 );

		// initialize user point balance on user create/update, and remove the user points record on user delete
		add_action( 'user_register',  array( $this, 'refresh_user_points_balance' ) );
		add_action( 'profile_update', array( $this, 'refresh_user_points_balance' ) );
		add_action( 'delete_user',    array( $this, 'delete_user_points' ) );

		// admin
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {

			// add a 'Configure' link to the plugin action links
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'add_plugin_configure_link' ) );

			// run every time
			$this->install();

		} else {

			// display points on a user's account page
			add_action( 'woocommerce_before_my_account', 'woocommerce_points_rewards_my_points' );
		}
	}


	/**
	 * Refreshes the user points balance.  This is called on user
	 * create, as well as on user update giving the admin an (albeit simple)
	 * means to refresh a users points balance if, for instance a user
	 * was created while after the points & rewards plugin was installed, but
	 * during a time when it was disabled, or the points balance got out of
	 * whack somehow or other.
	 *
	 * @since 1.0
	 * @param int $user_id user identifier
	 */
	public function refresh_user_points_balance( $user_id ) {

		// do nothing if the identified user is not a customer
		if ( ! user_can( $user_id, 'customer' ) ) return;

		// refresh the points balance user meta
		update_user_meta( $user_id, 'wc_points_balance', WC_Points_Rewards_Manager::get_users_points( $user_id ) );

	}


	/**
	 * Deletes the user points for the deleted user identified by $user_id
	 *
	 * @since 1.0
	 * @param int $user_id the identifier of the user being deleted
	 */
	public function delete_user_points( $user_id ) {
		WC_Points_Rewards_Manager::delete_user_points( $user_id );
	}


	/**
	 * Include required files
	 *
	 * @since 1.0
	 */
	private function includes() {

		// product class
		require( 'classes/class-wc-points-rewards-product.php' );
		$this->product = new WC_Points_Rewards_Product();

		// cart / checkout class
		require( 'classes/class-wc-points-rewards-cart-checkout.php' );
		$this->cart = new WC_Points_Rewards_Cart_Checkout();

		// order class
		require( 'classes/class-wc-points-rewards-order.php' );
		$this->order = new WC_Points_Rewards_Order();

		// discount class
		require( 'classes/class-wc-points-rewards-discount.php' );
		$this->discount = new WC_Points_Rewards_Discount();

		// actions class
		require( 'classes/class-wc-points-rewards-actions.php' );
		$this->actions = new WC_Points_Rewards_Actions();

		// manager class
		require( 'classes/class-wc-points-rewards-manager.php' );

		// points log access class
		require( 'classes/class-wc-points-rewards-points-log.php' );

		if ( is_admin() )
			$this->admin_includes();
	}


	/**
	 * Include required admin files
	 *
	 * @since 1.0
	 */
	private function admin_includes() {

		// load admin class
		require( 'classes/class-wc-points-rewards-admin.php' );
		$this->admin = new WC_Points_Rewards_Admin();

		// load product admin class
		require( 'classes/class-wc-points-rewards-product-admin.php' );
		$this->product_admin = new WC_Points_Rewards_Product_Admin();

		// used to provide an admin message handling utility
		require_once( 'classes/class-wp-admin-message-handler.php' );
		$this->admin_message_handler = new WP_Admin_Message_Handler();
	}


	/**
	 * Handle localization, WPML compatible
	 *
	 * @since 1.0
	 */
	public function load_translation() {

		// localization in the init action for WPML support
		load_plugin_textdomain( 'wc_points_rewards', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}


	/**
	 * Function used to init WooCommerce Points & Rewards template functions,
	 * making them pluggable by plugins and themes.
	 *
	 * @since 1.0
	 */
	public function include_template_functions() {
		include_once( 'woocommerce-points-and-rewards-template.php' );
	}


	/** Admin methods ******************************************************/


	/**
	 * Return the plugin action links.  This will only be called if the plugin
	 * is active.
	 *
	 * @since 1.0
	 * @param array $actions associative array of action names to anchor tags
	 * @return array associative array of plugin action links
	 */
	public function add_plugin_configure_link( $actions ) {
		// add the link to the front of the actions list
		return ( array_merge( array( 'configure' => sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=wc-settings&tab=points' ), __( 'Configure', 'wc_points_rewards' ) ) ),
			$actions )
		);
	}


	/** Helper methods ******************************************************/


	/**
	 * Returns the points label, singular or plural form, based on $count
	 *
	 * @since 0.1
	 * @param int $count the count
	 * @return string the points label
	 */
	public function get_points_label( $count ) {

		list( $singular, $plural ) = explode( ':', get_option( 'wc_points_rewards_points_label' ) );

		if ( 1 == $count ) return $singular;
		else return $plural;
	}


	/**
	 * Gets the absolute plugin path without a trailing slash, e.g.
	 * /path/to/wp-content/plugins/plugin-directory
	 *
	 * @since 1.0
	 * @return string plugin path
	 */
	public function get_plugin_path() {

		if ( $this->plugin_path )
			return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}


	/**
	 * Gets the plugin url without a trailing slash
	 *
	 * @since 1.0
	 * @return string the plugin url
	 */
	public function get_plugin_url() {

		if ( $this->plugin_url )
			return $this->plugin_url;

		return $this->plugin_url = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}


	/**
	 * Log errors / messages to WooCommerce error log (/wp-content/woocommerce/logs/)
	 *
	 * @since 1.0
	 * @param string $message
	 */
	public function log( $message ) {
		global $woocommerce;

			if ( ! is_object( $this->logger ) )
				$this->logger = $woocommerce->logger();

			$this->logger->add( 'points-rewards', $message );
	}


	/** Lifecycle methods ******************************************************/


	/**
	 * Run every time.  Used since the activation hook is not executed when updating a plugin
	 *
	 * @since 1.0
	 */
	private function install() {

		// get current version to check for upgrade
		$installed_version = get_option( 'wc_points_rewards_version' );

		// install
		if ( ! $installed_version ) {

			// initial install, add the wc_points_balance user meta (of 0) to all users
			$offset           = (int) get_option( 'wc_points_rewards_install_offset', 0 );
			$records_per_page = 500;
			do {
				// grab a set of user ids
				$user_ids = get_users( array( 'fields' => 'ID', 'offset' => $offset, 'number' => $records_per_page ) );

				// iterate through the results and set the meta
				if ( is_array( $user_ids ) ) {
					foreach ( $user_ids as $user_id ) {

						$wc_points_balance = get_user_meta( $user_id, 'wc_points_balance', true );

						if ( '' === $wc_points_balance ) {
							// need to create an empty balance for this customer
							update_user_meta( $user_id, 'wc_points_balance', 0 );
						}
					}
				}

				// increment offset
				$offset += $records_per_page;
				// and keep track of how far we made it in case we hit a script timeout
				update_option( 'wc_points_rewards_install_offset', $offset );

			} while ( count( $user_ids ) == $records_per_page );  // while full set of results returned  (meaning there may be more results still to retrieve)

			// install default settings, terms, etc
			foreach ( WC_Points_Rewards_Admin::get_settings() as $setting ) {

				if ( isset( $setting['default'] ) )
					add_option( $setting['id'], $setting['default'] );
			}
		}

		// upgrade if installed version lower than plugin version
		if ( -1 === version_compare( $installed_version, self::VERSION ) )
			$this->upgrade( $installed_version );
	}


	/**
	 * Perform any version-related changes. Changes to custom db tables are handled by the migrate() method
	 *
	 * @since 1.0
	 * @param int $installed_version the currently installed version of the plugin
	 */
	private function upgrade( $installed_version ) {

		$this->migrate( $installed_version );

		// update the installed version option
		update_option( 'wc_points_rewards_version', self::VERSION );
	}


	/**
	 * Perform updates to custom db tables using dbDelta()
	 *
	 * @since 1.0
	 */
	private function migrate( $installed_version ) {
		global $wpdb;

		$wpdb->hide_errors();

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		// it's important that this table be indexed-up as it can grow quite large
		$sql =
		"CREATE TABLE {$this->user_points_log_db_tablename} (
		  id bigint(20) NOT NULL AUTO_INCREMENT,
		  user_id bigint(20) NOT NULL,
		  points bigint(20) NOT NULL,
		  type varchar(255) DEFAULT NULL,
		  user_points_id bigint(20) DEFAULT NULL,
		  order_id bigint(20) DEFAULT NULL,
		  admin_user_id bigint(20) DEFAULT NULL,
		  data longtext DEFAULT NULL,
		  date datetime NOT NULL,
		  KEY idx_wc_points_rewards_user_points_log_date (date),
		  KEY idx_wc_points_rewards_user_points_log_type (type),
		  KEY idx_wc_points_rewards_user_points_log_points (points),
		  PRIMARY KEY  (id)
		) " . $this->get_db_collation();
		dbDelta( $sql );

		$sql =
		"CREATE TABLE {$this->user_points_db_tablename} (
		  id bigint(20) NOT NULL AUTO_INCREMENT,
		  user_id bigint(20) NOT NULL,
		  points bigint(20) NOT NULL,
		  points_balance bigint(20) NOT NULL,
		  order_id bigint(20) DEFAULT NULL,
		  date datetime NOT NULL,
		  KEY idx_wc_points_rewards_user_points_user_id_points_balance (user_id,points_balance),
		  PRIMARY KEY  (id)
		) " . $this->get_db_collation();
		dbDelta( $sql );
	}


	/**
	 * Returns the WordPress DB collation clause used when creating tables
	 *
	 * @since 1.0
	 * @return string db collation clause
	 */
	private function get_db_collation() {
		global $wpdb;

		$collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty( $wpdb->charset ) ) $collate .= "DEFAULT CHARACTER SET {$wpdb->charset}";
			if ( ! empty( $wpdb->collate ) ) $collate .= " COLLATE {$wpdb->collate}";
		}

		return $collate;
	}


} // end \WC_Points_Rewards class (note the newline after this line)
