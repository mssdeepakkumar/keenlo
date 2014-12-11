<?php
/**
 * Plugin Name: WooCommerce Instagram
 * Plugin URI: http://woothemes.com/products/woocommerce-instagram/
 * Description: Hi, I'm here to connect your Instagram account with WooCommerce. Together, we can showcase Instagrams from all over the world, showing visitors how your customers are showcasing your products.
 * Author: WooThemes
 * Author URI: http://woothemes.com/
 * Version: 1.0.3
 * Stable tag: 1.0.3
 * License: GPL v3 or later - http://www.gnu.org/licenses/old-licenses/gpl-3.0.html
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Required functions
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

// Plugin updates
woothemes_queue_update( plugin_basename( __FILE__ ), 'ecaa2080668997daf396b8f8a50d891a', 260061 );

global $woocommerce_instagram;
require_once( 'classes/class-woocommerce-instagram.php' );
$woocommerce_instagram = new Woocommerce_Instagram( __FILE__ );
$woocommerce_instagram->version = '1.0.3';
?>