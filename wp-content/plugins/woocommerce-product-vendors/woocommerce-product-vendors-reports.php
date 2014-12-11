<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Vendor sales overview report
 * @return void
 */
function woocommerce_product_vendors_report_overview() {
	global $start_date, $end_date, $woocommerce, $wp_locale;

	$args = array(
		'post_type' => 'shop_order',
		'meta_query' => array(
			array(
				'key' => '_commissions_processed',
				'value' => 'yes',
				'compare' => '='
			)
		),
		'posts_per_page' => -1
	);

	if( version_compare( WC()->version, 2.2, ">=" ) ) {
    	$args['post_status'] = array_keys( wc_get_order_statuses() );
    }

	$orders = get_posts( $args );

	$total_sales = $total_orders = $total_earnings = $total_vendor_earnings = 0;
	foreach( $orders as $order ) {

		$order_obj = new WC_Order( $order->ID );

	    $items = $order_obj->get_items( 'line_item' );

	    $product_vendor_earnings = 0;
	    foreach( $items as $item_id => $item ) {
	        $product_id = $order_obj->get_item_meta( $item_id, '_product_id', true );
	        $line_total = $order_obj->get_item_meta( $item_id, '_line_total', true );
	        if( $product_id && $line_total ) {
	        	$product_vendors = get_product_vendors( $product_id );
	            if( $product_vendors ) {
	            	$total_sales += $line_total;
	            	foreach( $product_vendors as $vendor ) {
	            		$comm_percent = get_commission_percent( $product_id, $vendor->ID );
	            		if( $comm_percent && $comm_percent > 0 ) {
	                        $comm_amount = (int) $line_total * ( $comm_percent / 100 );
	                        $product_vendor_earnings += $comm_amount;
	                        $total_vendor_earnings += $comm_amount;
	                    }
	            	}
	            	$earnings = ( $line_total - $total_vendor_earnings );
	            	$total_earnings += $earnings;
	            }
	        }
	    }
	    ++$total_orders;
	}

	?>
	<div id="poststuff" class="woocommerce-reports-wrap">
		<div class="woocommerce-reports-sidebar">
			<div class="postbox">
				<h3><span><?php _e( 'Total sales', 'woocommerce' ); ?></span></h3>
				<div class="inside">
					<p class="stat"><?php if ( $total_sales > 0 ) echo woocommerce_price( $total_sales ); else _e( 'n/a', 'woocommerce' ); ?></p>
				</div>
			</div>
			<div class="postbox">
				<h3><span><?php _e( 'Total orders', 'woocommerce' ); ?></span></h3>
				<div class="inside">
					<p class="stat"><?php if ( $total_orders > 0 ) echo $total_orders; else _e( 'n/a', 'woocommerce' ); ?></p>
				</div>
			</div>
			<div class="postbox">
				<h3><span><?php _e( 'Average order total', 'woocommerce' ); ?></span></h3>
				<div class="inside">
					<p class="stat"><?php if ( $total_orders > 0 ) echo woocommerce_price( $total_sales / $total_orders ); else _e( 'n/a', 'woocommerce' ); ?></p>
				</div>
			</div>
			<div class="postbox">
				<h3><span><?php _e( 'Total earned', 'wc_product_vendors' ); ?></span></h3>
				<div class="inside">
					<p class="stat"><?php if ( $total_earnings > 0 ) echo woocommerce_price( $total_earnings ); else _e( 'n/a', 'woocommerce' ); ?></p>
				</div>
			</div>
			<div class="postbox">
				<h3><span><?php _e( 'Total earned by vendors', 'wc_product_vendors' ); ?></span></h3>
				<div class="inside">
					<p class="stat"><?php if ( $total_vendor_earnings > 0 ) echo woocommerce_price( $total_vendor_earnings ); else _e( 'n/a', 'woocommerce' ); ?></p>
				</div>
			</div>
		</div>
		<div class="woocommerce-reports-main">
			<div class="postbox">
				<h3><span><?php _e( 'This month\'s sales', 'woocommerce' ); ?></span></h3>
				<div class="inside chart">
					<div id="placeholder" style="width:100%; overflow:hidden; height:568px; position:relative;"></div>
					<div id="cart_legend"></div>
				</div>
			</div>
		</div>
	</div>
	<?php

	$chart_data = array();

	$start_date = strtotime( date('Ymd', strtotime( date('Ym', current_time('timestamp') ) . '01' ) ) );
	$end_date = strtotime( date('Ymd', current_time( 'timestamp' ) ) );

	for( $date = $start_date; $date <= $end_date; $date = strtotime( '+1 day', $date ) ) {

		$year = date( 'Y', $date );
		$month = date( 'n', $date );
		$day = date( 'j', $date );
		$total_vendor_earnings = $total_earnings = $order_count = $day_total_vendors = $day_total = 0;

		$args = array(
			'post_type' => 'shop_order',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => '_commissions_processed',
					'value' => 'yes',
					'compare' => '='
				)
			),
			'year' => $year,
			'monthnum' => $month,
			'day' => $day,
			'orderby' => 'date',
			'order' => 'ASC'
		);

		if( version_compare( WC()->version, 2.2, ">=" ) ) {
	    	$args['post_status'] = array_keys( wc_get_order_statuses() );
	    }

		$qry = new WP_Query( $args );

		$total_vendor_earnings = $total_earnings = 0;
		if ( $qry->have_posts() ) {
			while ( $qry->have_posts() ) { $qry->the_post();
				$order = new WC_Order( get_the_ID() );
				$items = $order_obj->get_items( 'line_item' );
				foreach( $items as $item_id => $item ) {
			        $product_id = $order_obj->get_item_meta( $item_id, '_product_id', true );
			        $line_total = $order_obj->get_item_meta( $item_id, '_line_total', true );
			        if( $product_id && $line_total ) {
			        	$product_vendors = get_product_vendors( $product_id );
			            if( $product_vendors ) {
			            	foreach( $product_vendors as $vendor ) {
			            		$comm_percent = get_commission_percent( $product_id, $vendor->ID );
			            		if( $comm_percent && $comm_percent > 0 ) {
			                        $comm_amount = (int) $line_total * ( $comm_percent / 100 );
			                        $total_vendor_earnings += $comm_amount;
			                    }
			            	}
			            	$earnings = ( $line_total - $total_vendor_earnings );
	            			$total_earnings += $earnings;
			            }
			        }
			    }
			    $day_total += $total_earnings;
				$day_total_vendors += $total_vendor_earnings;
				++$order_count;
			}
		}
		wp_reset_postdata();

		$chart_data[ __( 'Total earned', 'wc_product_vendors' ) ][] = array(
			$date . '000',
			$day_total
		);

		$chart_data[ __( 'Total earned by vendors', 'wc_product_vendors' ) ][] = array(
			$date . '000',
			$day_total_vendors
		);

		$chart_data[ __( 'Number of orders', 'wc_product_vendors' ) ][] = array(
			$date . '000',
			$order_count
		);
	}

	?>
	<script type="text/javascript">
		jQuery(function(){

			<?php
				// Variables
				foreach ( $chart_data as $name => $data ) {
					$varname = str_replace( '-', '_', sanitize_title( $name ) ) . '_data';
					echo 'var ' . $varname . ' = jQuery.parseJSON( \'' . json_encode( $data ) . '\' );';
				}
			?>

			var placeholder = jQuery("#placeholder");

			var plot = jQuery.plot(placeholder, [
				<?php
				$labels = array();

				foreach ( $chart_data as $name => $data ) {
					if( $name == 'Number of orders' ) {
						$labels[] = '{ label: "' . esc_js( $name ) . '", data: ' . str_replace( '-', '_', sanitize_title( $name ) ) . '_data, yaxis: 2 }';
					} else {
						$labels[] = '{ label: "' . esc_js( $name ) . '", data: ' . str_replace( '-', '_', sanitize_title( $name ) ) . '_data }';
					}
				}

				echo implode( ',', $labels );
				?>
			], {
				legend: {
					container: jQuery('#cart_legend'),
					noColumns: 2
				},
				series: {
					lines: { show: true, fill: true },
					points: { show: true }
				},
				grid: {
					show: true,
					aboveData: false,
					color: '#aaa',
					backgroundColor: '#fff',
					borderWidth: 2,
					borderColor: '#aaa',
					clickable: false,
					hoverable: true
				},
				xaxis: {
					mode: "time",
					timeformat: "%d %b %y",
					monthNames: <?php echo json_encode( array_values( $wp_locale->month_abbrev ) ) ?>,
					tickLength: 1,
					minTickSize: [1, "day"]
				},
				yaxes: [ { min: 0, tickSize: 10, tickDecimals: 2 }, { position: "right", min: 0, tickDecimals: 2 } ]
		 	});

		 	placeholder.resize();

		 	<?php if( version_compare( $woocommerce->version, '2.1-beta-1', "<" ) && function_exists( 'woocommerce_tooltip_js' ) ) { woocommerce_tooltip_js(); } ?>
		});
	</script>
	<?php
}

/**
 * Sales report for each vendor
 * @return void
 */
function woocommerce_product_vendors_report_vendor_sales() {
	global $wpdb, $woocommerce;

	$chosen_product_ids = $vendor_id = $vendor = false;
	if( isset( $_POST['vendor'] ) && ! empty( $_POST['vendor'] ) ) {
		$vendor_id = $_POST['vendor'];
		$vendor = get_vendor( $vendor_id );
		$products = get_vendor_products( $vendor_id );
		foreach( $products as $product ) {
			$chosen_product_ids[] = $product->ID;
		}
	}

	if( $vendor_id && $vendor ) {
		$option = '<option value="' . $vendor_id. '" selected="selected">' . $vendor->title . '</option>';
	} else {
		$option = '<option></option>';
	}

	?>
	<form method="post" action="">
		<p><select id="vendor" name="vendor" class="ajax_chosen_select_vendor" data-placeholder="<?php _e( 'Search for a vendor&hellip;', 'wc_product_vendors' ); ?>" style="width: 400px;"><?php echo $option; ?></select> <input type="submit" style="vertical-align: top;" class="button" value="<?php _e( 'Show', 'woocommerce' ); ?>" /></p>
		<script type="text/javascript">
			jQuery(function(){

				// Ajax Chosen Vendor Selectors
				jQuery('select.ajax_chosen_select_vendor').ajaxChosen({
				    method: 		'GET',
				    url: 			'<?php echo admin_url( "admin-ajax.php" ); ?>',
				    dataType: 		'json',
				    afterTypeDelay: 100,
				    minTermLength: 	1,
				    data:		{
				    	action: 	'woocommerce_json_search_vendors',
						security: 	'<?php echo wp_create_nonce( "search-vendors" ); ?>'
				    }
				}, function (data) {

					var terms = {};

				    jQuery.each(data, function (i, val) {
				        terms[i] = val;
				    });

				    return terms;
				});

			});
		</script>
	</form>
	<?php

	if ( $chosen_product_ids && is_array( $chosen_product_ids ) ) {

		$start_date = date( 'Ym', strtotime( '-12 MONTHS', current_time('timestamp') ) ) . '01';
		$end_date 	= date( 'Ymd', current_time( 'timestamp' ) );

		$max_sales = $max_totals = 0;
		$product_sales = $product_totals = array();

		// Get titles and ID's related to product
		$chosen_product_titles = array();
		$children_ids = array();

		foreach ( $chosen_product_ids as $product_id ) {
			$children = (array) get_posts( 'post_parent=' . $product_id . '&fields=ids&post_status=any&numberposts=-1' );
			$children_ids = $children_ids + $children;
			$chosen_product_titles[] = get_the_title( $product_id );
		}

		// Get order items
		if( version_compare( WC()->version, 2.2, ">=" ) ) {

			$order_items = apply_filters( 'woocommerce_reports_product_sales_order_items', $wpdb->get_results( "
				SELECT order_item_meta_2.meta_value as product_id, posts.post_date, SUM( order_item_meta.meta_value ) as item_quantity, SUM( order_item_meta_3.meta_value ) as line_total
				FROM {$wpdb->prefix}woocommerce_order_items as order_items

				LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
				LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta_2 ON order_items.order_item_id = order_item_meta_2.order_item_id
				LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta_3 ON order_items.order_item_id = order_item_meta_3.order_item_id
				LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID

				WHERE 	posts.post_type 	= 'shop_order'
				AND     posts.post_status   IN ( '" . implode( "','", array( 'wc-completed', 'wc-processing', 'wc-on-hold' ) ) . "' )
				AND 	order_item_meta_2.meta_value IN ('" . implode( "','", array_merge( $chosen_product_ids, $children_ids ) ) . "')
				AND 	order_items.order_item_type = 'line_item'
				AND 	order_item_meta.meta_key = '_qty'
				AND 	order_item_meta_2.meta_key = '_product_id'
				AND 	order_item_meta_3.meta_key = '_line_total'
				GROUP BY order_items.order_id
				ORDER BY posts.post_date ASC
			" ), array_merge( $chosen_product_ids, $children_ids ) );

	    } else {

	    	$order_items = apply_filters( 'woocommerce_reports_product_sales_order_items', $wpdb->get_results( "
				SELECT order_item_meta_2.meta_value as product_id, posts.post_date, SUM( order_item_meta.meta_value ) as item_quantity, SUM( order_item_meta_3.meta_value ) as line_total
				FROM {$wpdb->prefix}woocommerce_order_items as order_items

				LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
				LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta_2 ON order_items.order_item_id = order_item_meta_2.order_item_id
				LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta_3 ON order_items.order_item_id = order_item_meta_3.order_item_id
				LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
				LEFT JOIN {$wpdb->term_relationships} AS rel ON posts.ID = rel.object_ID
				LEFT JOIN {$wpdb->term_taxonomy} AS tax USING( term_taxonomy_id )
				LEFT JOIN {$wpdb->terms} AS term USING( term_id )

				WHERE 	posts.post_type 	= 'shop_order'
				AND 	order_item_meta_2.meta_value IN ('" . implode( "','", array_merge( $chosen_product_ids, $children_ids ) ) . "')
				AND 	posts.post_status 	= 'publish'
				AND 	tax.taxonomy		= 'shop_order_status'
				AND		term.slug			IN ('" . implode( "','", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ) ) . "')
				AND 	order_items.order_item_type = 'line_item'
				AND 	order_item_meta.meta_key = '_qty'
				AND 	order_item_meta_2.meta_key = '_product_id'
				AND 	order_item_meta_3.meta_key = '_line_total'
				GROUP BY order_items.order_id
				ORDER BY posts.post_date ASC
			" ), array_merge( $chosen_product_ids, $children_ids ) );

	    }

		$found_products = array();

		if ( $order_items ) {
			foreach ( $order_items as $order_item ) {

				if ( $order_item->line_total == 0 && $order_item->item_quantity == 0 )
					continue;

				// Get date
				$date 	= date( 'Ym', strtotime( $order_item->post_date ) );

				// Calculate vendor earnings from sale
				$comm_percent = get_commission_percent( $order_item->product_id, $vendor_id );
				$vendor_earnings = $order_item->line_total * ( $comm_percent / 100 );

				// Set values
				$product_sales[ $date ] 	= isset( $product_sales[ $date ] ) ? $product_sales[ $date ] + $order_item->item_quantity : $order_item->item_quantity;
				$product_totals[ $date ] 	= isset( $product_totals[ $date ] ) ? $product_totals[ $date ] + $vendor_earnings : $vendor_earnings;

				if ( $product_sales[ $date ] > $max_sales )
					$max_sales = $product_sales[ $date ];

				if ( $product_totals[ $date ] > $max_totals )
					$max_totals = $product_totals[ $date ];
			}
		}
		?>
		<h4><?php printf( __( 'Sales and earnings for %s:', 'wc_product_vendors' ), $vendor->title ); ?></h4>
		<table class="bar_chart">
			<thead>
				<tr>
					<th><?php _e( 'Month', 'woocommerce' ); ?></th>
					<th colspan="2"><?php _e( 'Sales', 'woocommerce' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
					if ( sizeof( $product_sales ) > 0 ) {
						foreach ( $product_sales as $date => $sales ) {
							$width = ($sales>0) ? (round($sales) / round($max_sales)) * 100 : 0;
							$width2 = ($product_totals[$date]>0) ? (round($product_totals[$date]) / round($max_totals)) * 100 : 0;

							$orders_link = admin_url( 'edit.php?s&post_status=all&post_type=shop_order&action=-1&s=' . urlencode( implode( ' ', $chosen_product_titles ) ) . '&m=' . date( 'Ym', strtotime( $date . '01' ) ) . '&shop_order_status=' . implode( ",", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ) ) );
							$orders_link = apply_filters( 'woocommerce_reports_order_link', $orders_link, $chosen_product_ids, $chosen_product_titles );

							echo '<tr><th><a href="' . esc_url( $orders_link ) . '">' . date_i18n( 'F', strtotime( $date . '01' ) ) . '</a></th>
							<td width="1%"><span>' . esc_html( $sales ) . '</span><span class="alt">' . woocommerce_price( $product_totals[ $date ] ) . '</span></td>
							<td class="bars">
								<span style="width:' . esc_attr( $width ) . '%">&nbsp;</span>
								<span class="alt" style="width:' . esc_attr( $width2 ) . '%">&nbsp;</span>
							</td></tr>';
						}
					} else {
						echo '<tr><td colspan="3">' . __( 'No sales', 'woocommerce' ) . '</td></tr>';
					}
				?>
			</tbody>
		</table>
		<?php

	}
}