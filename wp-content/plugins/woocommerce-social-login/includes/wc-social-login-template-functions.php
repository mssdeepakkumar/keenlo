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
 * @package     WC-Social-Login/Template
 * @author      SkyVerge
 * @copyright   Copyright (c) 2014, SkyVerge, Inc.
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

/**
 * Template Function Overrides
 *
 * @version 3.0
 * @since 3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! function_exists( 'woocommerce_social_login_buttons' ) ) {

/**
 * Pluggable function to render social login buttons
 *
 * @since 3.0
 * @param string $return_url Return url, defaults to the current url
 */
function woocommerce_social_login_buttons( $return_url = null ) {

	// If no return_url, use the current URL
	if ( ! $return_url ) {
		$return_url = home_url( add_query_arg( array() ) );
	}

	// Enqueue styles and scripts
	$GLOBALS['wc_social_login']->frontend->load_styles_scripts();

	// load the template
	wc_get_template(
		'global/social-login.php',
		array(
			'providers'  => $GLOBALS['wc_social_login']->get_available_providers(),
			'return_url' => $return_url,
		),
		'',
		$GLOBALS['wc_social_login']->get_plugin_path() . '/templates/'
	);
}

}
