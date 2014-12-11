<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Product Vendors Import/Export Handler
 *
 * Adds support for:
 *
 * + Customer / Order CSV Export
 *
 * @since 1.1.5
 */
class WooCommerce_Product_Vendors_Export_Handler {


	/**
	 * Setup class
	 *
	 * @since 1.1.5
	 */
	public function __construct() {

		// Customer / Order CSV Export column headers/data
		add_filter( 'wc_customer_order_csv_export_order_headers',              array( $this, 'add_vendors_to_csv_export_column_headers' ), 10, 2 );
		add_filter( 'wc_customer_order_csv_export_order_row_one_row_per_item', array( $this, 'add_vendors_to_csv_export_column_data' ), 10, 4 );

		// Customer / Order CSV Export line item data
		add_filter( 'wc_customer_order_csv_export_order_line_item', array( $this, 'csv_export_line_item_data' ), 10, 5 );
	}


	/**
	 * Adds support for Customer/Order CSV Export by adding a vendor column
	 * header
	 *
	 * @since 1.1.5
	 * @param array $headers existing array of header key/names for the CSV export
	 * @return array
	 */
	public function add_vendors_to_csv_export_column_headers( $headers, $csv_generator ) {

		$headers['vendors'] = 'vendors';

		return $headers;
	}


	/**
	 * Adds support for Customer/Order CSV Export by adding product vendor data
	 * for each order item row
	 *
	 * @since 1.1.5
	 * @param array $order_data generated order data matching the column keys in the header
	 * @param WC_Order $order order being exported
	 * @param \WC_Customer_Order_CSV_Export_Generator $csv_generator instance
	 * @return array
	 */
	public function add_vendors_to_csv_export_column_data( $order_data, $item, $order, $csv_generator ) {

		$vendors = array();

		if ( isset( $item['id'] ) && $product_id = $item['id'] ) {

			if ( $product_vendors = get_product_vendors( $product_id ) ) {

				foreach ( (array) $product_vendors as $vendor ) {
					$vendors[] = $vendor->title;
				}
			}
		}

		$order_data['vendors'] = implode( ', ', $vendors );

		return $order_data;
	}


	/**
	 * Filter the individual line item entry to add product id for older versions
	 * of Customer/Order CSV Export
	 *
	 * @since 1.1.5
	 * @param array $line_item line item data in key => value format
	 * @param array $item WC order item data
	 * @param WC_Product $product the product
	 * @param WC_Order $order the order
	 * @param \WC_Customer_Order_CSV_Export_Generator $csv_generator instance
	 * @return array
	 */
	public function csv_export_line_item_data( $line_item, $item, $product, $order, $csv_generator ) {

		if ( isset( $csv_generator->order_format ) && ( 'default_one_row_per_item' == $csv_generator->order_format || 'legacy_one_row_per_item' == $csv_generator->order_format ) ) {
			$line_item['id'] = $product->id;
		}

		return $line_item;
	}

} // end WooCommerce_Product_Vendors_Export_Handler
