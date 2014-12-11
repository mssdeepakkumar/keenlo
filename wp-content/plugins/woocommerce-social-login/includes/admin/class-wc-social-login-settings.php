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

if ( ! class_exists( 'WC_Settings_Social_Login' ) ) :

/**
 * Settings class
 *
 * @since 1.0
 */
class WC_Settings_Social_Login extends WC_Settings_Page {

	/** @var string page tab ID */
	public $tab_id = 'social_login';

	/**
	 * Setup admin class
	 *
	 * @since  1.0
	 */
	public function __construct() {

		$this->id    = 'social_login';
		$this->label = __( 'Social Login', WC_Social_Login::TEXT_DOMAIN );

		add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
		add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'woocommerce_admin_field_social_login_providers', array( $this, 'social_login_providers_setting' ) );
		add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
	}


	/**
	 * Get sections
	 *
	 * @return array
	 */
	public function get_sections() {
		$sections = array(
			'' => __( 'Settings', WC_Social_Login::TEXT_DOMAIN )
		);

		// Load shipping providers so we can show any global options they may have
		$providers = $GLOBALS['wc_social_login']->get_providers();

		foreach ( $providers as $provider ) {

			$title = empty( $provider->provider_title ) ? ucfirst( $provider->get_id() ) : $provider->provider_title;

			$sections[ strtolower( get_class( $provider ) ) ] = esc_html( $title );
		}

		return $sections;
	}


	/**
	 * Get settings array
	 *
	 * @since  1.0
	 * @return array settings
	 */
	public function get_settings() {

		/**
		 * Filter social login settings.
		 *
		 * @since 1.0
		 * @param array $settings
		 */
		return apply_filters('woocommerce_social_login_settings', array(

			array(
				'name' => __( 'Settings', WC_Social_Login::TEXT_DOMAIN ),
				'type' => 'title',
			),

			array(
				'name'     => __( 'Display Social Login on:', WC_Social_Login::TEXT_DOMAIN ),
				'desc_tip' => __( 'Control where Social Login options are displayed.', WC_Social_Login::TEXT_DOMAIN ),
				'id'       => 'wc_social_login_display',
				'default'  => 'checkout,my_account',
				'type'     => 'select',
				'options'  => array(
					'checkout,my_account' => __( 'Checkout & My Account', WC_Social_Login::TEXT_DOMAIN ),
					'checkout'            => __( 'Checkout Only', WC_Social_Login::TEXT_DOMAIN ),
					'my_account'          => __( 'My Account Only', WC_Social_Login::TEXT_DOMAIN ),
				),
			),

			array(
				'name'     => __( 'Social Login Display Text', WC_Social_Login::TEXT_DOMAIN ),
				'desc_tip' => __( 'This option controls the text for the frontend section where the login providers are shown.', WC_Social_Login::TEXT_DOMAIN ),
				'id'       => 'wc_social_login_text',
				'default'  => __( 'For faster checkout, login or register using your social account.', WC_Social_Login::TEXT_DOMAIN ),
				'type'     => 'textarea',
				'css'      => 'width:100%; height: 75px;',
			),

			array( 'type' => 'social_login_providers' ), // @see WC_Settings_Social_Login::social_login_providers_setting()

			array( 'type' => 'sectionend' ),

		) );
	}


	/**
	 * Output the settings
	 *
	 * @since 1.0
	 */
	public function output() {
		global $current_section;

		// Load providers so we can show any global options they may have
		$providers = $GLOBALS['wc_social_login']->get_providers();

		if ( $current_section ) {

			foreach ( $providers as $provider ) {

				if ( strtolower( get_class( $provider ) ) == strtolower( $current_section ) ) {

					$provider->admin_options();
					break;
				}
			}

		} else {

			$settings = $this->get_settings();

			WC_Admin_Settings::output_fields( $settings );
		}
	}


	/**
	 * Output login providers settings.
	 *
	 * @since 1.0
	 */
	public function social_login_providers_setting() {
		global $wc_social_login;
		?>
		<tr valign="top">
			<th scope="row" class="titledesc"><?php _e( 'Providers', WC_Social_Login::TEXT_DOMAIN ) ?></th>
				<td class="forminp">
				<table class="wc_social_login widefat" cellspacing="0">
					<thead>
						<tr>
							<th class="name"><?php _e( 'Provider', WC_Social_Login::TEXT_DOMAIN ); ?></th>
							<th class="status"><?php _e( 'Status', WC_Social_Login::TEXT_DOMAIN ); ?></th>
							<th class="settings">&nbsp;</th>
						</tr>
					</thead>
					<tbody>
							<?php
							foreach ( $wc_social_login->load_providers() as $key => $provider ) :
								echo '<tr>
									<td class="name">
										' . $provider->get_title() . '
										<input type="hidden" name="provider_order[]" value="' . esc_attr( $provider->get_id() ) . '" />
									</td>
									<td class="status">';

								if ( $provider->is_available() ) :
										echo '<span class="status-enabled tips" data-tip="' . __ ( 'Enabled', WC_Social_Login::TEXT_DOMAIN ) . '">' . __ ( 'Enabled', WC_Social_Login::TEXT_DOMAIN ) . '</span>';
								else:
									echo '-';
								endif;

								echo '</td>
									<td class="settings">';

									echo '<a class="button" href="' . admin_url( 'admin.php?page=wc-settings&tab=social_login&section=' . strtolower( get_class( $provider ) ) ) . '">' . __( 'Settings', WC_Social_Login::TEXT_DOMAIN ) . '</a>';

								echo '</td>
								</tr>';
							endforeach;
							?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3">
								<span class="description"><?php _e( 'Drag and drop the above providers to control their display order.', WC_Social_Login::TEXT_DOMAIN ); ?></span>
							</th>
						</tr>
					</tfoot>
				</table>
			</td>
		</tr>
		<?php
	}


	/**
	 * Save settings
	 *
	 * @since 1.0
	 */
	public function save() {
		global $current_section, $wc_social_login;

		if ( ! $current_section ) {

			$settings = $this->get_settings();
			WC_Admin_Settings::save_fields( $settings );
			$wc_social_login->admin->process_admin_options();

		} elseif ( class_exists( $current_section ) ) {

			$current_section_class = new $current_section( null );

			do_action( 'woocommerce_update_options_' . $this->id . '_' . $current_section_class->id );
		}
	}

} // end \WC_Settings_Social_Login class

endif;

return new WC_Settings_Social_Login();
