<?php
/*
 * Plugin Name: WooCommerce Product Vendors
 * Version: 1.1.5
 * Plugin URI: https://www.woothemes.com/products/product-vendors/
 * Description: Set up a multi-vendor marketplace that allows vendors to manage their own products and earn commissions, or simply assign commissions from sales.
 * Author: WooThemes
 * Author URI: http://www.woothemes.com/
 * Requires at least: 3.9
 * Tested up to: 4.0
 *
 * @package WordPress
 * @author WooThemes
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), 'a97d99fccd651bbdd728f4d67d492c31', '219982' );

if ( is_woocommerce_active() ) {

	// Include plugin files
	require_once( 'woocommerce-product-vendors-functions.php' );
	require_once( 'woocommerce-product-vendors-reports.php' );
	require_once( 'classes/class-woocommerce-product-vendors.php' );
	require_once( 'classes/class-woocommerce-product-vendors-commissions.php' );
	require_once( 'classes/class-woocommerce-product-vendors-widget.php' );
	require_once( 'classes/class-woocommerce-product-vendors-export-handler.php' );

	// Instantiate classes
	global $wc_product_vendors;
	$wc_product_vendors = new WooCommerce_Product_Vendors( __FILE__ );
	$wc_product_vendors->commissions = new WooCommerce_Product_Vendors_Commissions( __FILE__ );
	$wc_product_vendors->export_handler = new WooCommerce_Product_Vendors_Export_Handler();

}
