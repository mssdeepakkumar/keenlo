<?php
/**
 * Plugin Name: WooSlider - Instagram Slideshow
 * Plugin URI: http://woothemes.com/products/wooslider-instagram/
 * Description: Hi, I'm here to connect your Instagram account with your WooSlider. Together, we can create beautiful slideshows of your Instagram photographs.
 * Author: WooThemes
 * Author URI: http://woothemes.com/
 * Version: 1.0.0
 * Stable tag: 1.0.0
 * License: GPL v3 or later - http://www.gnu.org/licenses/old-licenses/gpl-3.0.html
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Required functions
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

// Plugin updates
woothemes_queue_update( plugin_basename( __FILE__ ), 'ce9d64dd99c56eb7aed6433618b38ddf', 242128 );

global $wooslider_instagram;
require_once( 'classes/class-wooslider-instagram.php' );
$wooslider_instagram = new Wooslider_Instagram( __FILE__ );
$wooslider_instagram->version = '1.0.0';
?>