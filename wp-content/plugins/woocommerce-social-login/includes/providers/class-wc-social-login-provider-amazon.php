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
 * @package     WC-Social-Login/Providers
 * @author      SkyVerge
 * @copyright   Copyright (c) 2014, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Social_Login_Provider_Amazon extends WC_Social_Login_Provider {


	/**
	 * Constructor for the provider.
	 *
	 * @param string $base_auth_path base authentication path
	 */
	public function __construct( $base_auth_path ) {

		$this->id                = 'amazon';
		$this->title             = __( 'Amazon', WC_Social_Login::TEXT_DOMAIN );
		$this->strategy_class    = 'Amazon';
		$this->color             = '#FF9900';
		$this->internal_callback = 'oauth2callback';
		$this->require_ssl       = true;

		$this->notices = array(
			'account_linked'         => __( 'Your Amazon account is now linked to your account.', WC_Social_Login::TEXT_DOMAIN ),
			'account_unlinked'       => __( 'Amazon account was successfully unlinked from your account.', WC_Social_Login::TEXT_DOMAIN ),
			'account_already_linked' => __( 'This Amazon account is already linked to another user account.', WC_Social_Login::TEXT_DOMAIN ),
		);

		parent::__construct( $base_auth_path );

		// Update customer's postcode from Amazon
		add_action( 'wc_social_login_' . $this->id . '_update_customer_billing_profile', array( $this, 'update_customer_postcode' ), 10, 2 );
	}


	/**
	 * Get the description, overridden to display the callback URL
	 * as a convenience since Amazon requires the admin to enter it for the app
	 *
	 * @since 1.0
	 * @see WC_Social_Login_Provider::get_description()
	 * @return string
	 */
	public function get_description() {

		return sprintf( __( 'Need help setting up and configuring Amazon? %sRead the docs%s', WC_Social_Login::TEXT_DOMAIN ), '<a href="http://docs.woothemes.com/document/woocommerce-social-login-create-social-apps#amazon">', '</a>' ) . '<br/><br/>' . sprintf( __( 'The allowed return URL is %s', WC_Social_Login::TEXT_DOMAIN ), '<code>' . $this->get_callback_url() . '</code>' );
	}


	/**
	 * Override parent check to ensure SSL is available, as Amazon requires it
	 *
	 * @since 1.0
	 * @see WC_Social_Login_Provider::is_available()
	 * @return bool
	 */
	public function is_available() {

		return parent::is_available() && 'yes' === get_option( 'woocommerce_force_ssl_checkout' );
	}


	/**
	 * Return the providers opAuth config
	 *
	 * @since 1.0
	 * @return array
	 */
	public function get_opauth_config() {

		/**
		 * Filter provider's Opauth configuration.
		 *
		 * @since 1.0
		 * @param array $config See https://github.com/opauth/opauth/wiki/Opauth-configuration - Strategy
		 */
		return apply_filters( 'wc_social_login_' . $this->get_id() . '_opauth_config', array(
			'strategy_class'    => $this->get_strategy_class(),
			'strategy_url_name' => $this->get_id(),
			'client_id'         => $this->get_client_id(),
			'client_secret'     => $this->get_client_secret(),
			'scope'             => 'profile postal_code',
			'response_type'     => 'code',
		) );
	}


	/**
	 * Return the default login button text
	 *
	 * @since 1.0
	 * @see WC_Social_Login_Provider::get_default_login_button_text()
	 * @return string
	 */
	public function get_default_login_button_text() {

		return __( 'Log in with Amazon', WC_Social_Login::TEXT_DOMAIN );
	}


	/**
	 * Return the default login button text
	 *
	 * @since 1.0
	 * @see WC_Social_Login_Provider::get_default_login_button_text()
	 * @return string
	 */
	public function get_default_link_button_text() {

		return __( 'Link your account to Amazon', WC_Social_Login::TEXT_DOMAIN );
	}


	/**
	 * Update customer's billing postcode based on Amazon profile
	 *
	 * @param int $customer_id
	 * @param \WC_Social_Login_Provider_Profile $profile
	 */
	public function update_customer_postcode( $customer_id, WC_Social_Login_Provider_Profile $profile ) {

		$amazon_profile = $profile->get_raw_profile();

		if ( isset( $amazon_profile['raw']['postal_code'] ) && $amazon_profile['raw']['postal_code'] && ! get_user_meta( $customer_id, 'billing_postcode', true ) ) {
			update_user_meta( $customer_id, 'billing_postcode', $amazon_profile['raw']['postal_code'] );
		}
	}


}
