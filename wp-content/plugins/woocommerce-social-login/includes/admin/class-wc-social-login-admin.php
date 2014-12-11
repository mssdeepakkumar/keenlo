<?php
/**
 * WooCommerce Social Login
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Social Login to newer
 * versions in the future. If you wish to customize WooCommerce Social Login for your
 * needs please refer to http://docs.woothemes.com/document/woocommerce-social-login/ for more information.
 *
 * @package     WC-Social-Login/Classes
 * @author      SkyVerge
 * @copyright   Copyright (c) 2014, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Admin class
 *
 * @since 1.0
 */
class WC_Social_Login_Admin {


	/**
	 * Setup admin class
	 *
	 * @since  1.0
	 */
	public function __construct() {

		// add social login settings page
		add_filter( 'woocommerce_get_settings_pages', array( $this, 'add_settings_page' ) );

		// add social login admin report
		add_filter( 'woocommerce_admin_reports', array( $this, 'add_admin_report' ) );

		// load styles/scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'load_styles_scripts' ) );
	}


	/**
	 * Add social login settings page
	 *
	 * @since 1.0
	 * @param array $settings
	 * @return array
	 */
	public function add_settings_page( $settings ) {

		$settings[] = include( 'class-wc-social-login-settings.php' );
		return $settings;
	}


	/**
	 * Add social login report
	 *
	 * @since 1.0
	 * @param array $reports
	 * @return array
	 */
	public function add_admin_report( $reports ) {

		if ( isset( $reports['customers'] ) ) {

			$reports['customers']['reports']['social_login'] = array(
				'title'       => __( 'Social Registration', WC_Social_Login::TEXT_DOMAIN ),
				'description' => '',
				'hide_title'  => true,
				'callback'    => array( $this, 'get_admin_report' ),
			);
		}

		return $reports;
	}


	/**
	 * Load the report class and output it
	 */
	public static function get_admin_report() {

		include_once( 'class-wc-social-login-report.php' );

		$report = new WC_Report_Social_Login();
		$report->output_report();
	}


	/**
	 * Load admin styles and scripts
	 *
	 * @since 1.0
	 * @param string $hook_suffix the current URL filename, ie edit.php, post.php, etc
	 */
	public function load_styles_scripts( $hook_suffix ) {
		global $wc_social_login;

		$is_settings_page = 'woocommerce_page_wc-settings' === $hook_suffix && isset( $_GET['tab'] )    && 'social_login' === $_GET['tab'];
		$is_report_page   = 'woocommerce_page_wc-reports'  === $hook_suffix && isset( $_GET['report'] ) && 'social_login' === $_GET['report'];

		// load admin css only on woocommerce settings or admin report screen
		if ( $is_settings_page || $is_report_page ) {

			// admin CSS
			wp_enqueue_style( 'wc-social-login-admin', $wc_social_login->get_plugin_url() . '/assets/css/admin/wc-social-login-admin.min.css', array( 'woocommerce_admin_styles' ), WC_Social_Login::VERSION );

			// admin JS
			wp_enqueue_script( 'wc-social-login-admin', $wc_social_login->get_plugin_url() . '/assets/js/admin/wc-social-login-admin.min.js', array( 'jquery', 'jquery-ui-sortable', 'woocommerce_admin' ), WC_Social_Login::VERSION );
		}
	}


	/**
	 * Save options in admin.
	 *
	 * @since 1.0
	 */
	function process_admin_options() {

		$provider_order = ( isset( $_POST['provider_order'] ) ) ? $_POST['provider_order'] : '';

		$order = array();

		if ( is_array( $provider_order ) && sizeof( $provider_order ) > 0 ) {

			$loop = 0;

			foreach ( $provider_order as $provider_id ) {

				$order[ esc_attr( $provider_id ) ] = $loop;
				$loop++;
			}
		}

		update_option( 'wc_social_login_provider_order', $order );
	}

} // end \WC_Social_Login_Admin class
