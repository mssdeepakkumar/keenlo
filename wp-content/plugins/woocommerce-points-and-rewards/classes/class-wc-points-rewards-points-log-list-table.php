<?php
/**
 * WooCommerce Points and Rewards
 *
 * @package     WC-Points-Rewards/List-Table
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WP_List_Table' ) )
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

/**
 * Points Log List Table class
 *
 * Extends WP_List_Table to display points history and related information
 *
 * @since 1.0
 * @extends \WP_List_Table
 */
class WC_Points_Rewards_Points_Log_List_Table extends WP_List_Table {


	/**
	 * Setup list table
	 *
	 * @see WP_List_Table::__construct()
	 * @since 1.0
	 * @return \WC_Points_Rewards_Points_Log_List_Table
	 */
	public function __construct() {

		parent::__construct(
			array(
				'singular' => __( 'Point', 'wc_points_rewards' ),
				'plural'   => __( 'Points', 'wc_points_rewards' ),
				'ajax'     => false,
				'screen'   => 'woocommerce_page_wc_points_rewards_points_log',
			)
		);
	}


	/**
	 * Returns the column slugs and titles
	 *
	 * @see WP_List_Table::get_columns()
	 * @since 1.0
	 * @return array of column slug => title
	 */
	public function get_columns() {

		$columns = array(
			'customer' => __( 'Customer', 'wc_points_rewards' ),
			'points'   => __( 'Points', 'wc_points_rewards' ),
			'event'    => __( 'Event', 'wc_points_rewards' ),
			'date'     => __( 'Date', 'wc_points_rewards' ),
		);

		return $columns;
	}


	/**
	 * Returns the sortable columns and initial direction
	 *
	 * @see WP_List_Table::get_sortable_columns()
	 * @since 1.0
	 * @return array of sortable column slug => array( orderby, boolean )
	 *         where true indicates the initial sort is descending
	 */
	public function get_sortable_columns() {

		return array(
			'points' => array( 'points', false ),  // false because the inital sort direction is DESC so we want the first column click to sort ASC
			'date'   => array( 'date', false ),    // same logic as order_date
		);
	}


	/**
	 * Get column content, this is called once per column, per row item ($order)
	 * returns the content to be rendered within that cell.
	 *
	 * @see WP_List_Table::single_row_columns()
	 * @since 1.0
	 * @param object $log_entry one row (item) in the table
	 * @param string $column_name the column slug
	 * @return string the column content
	 */
	public function column_default( $log_entry, $column_name ) {

		switch ( $column_name ) {

			case 'customer':

				$customer_email = null;
				if ( $log_entry->user_id ) {
					$customer_email = get_user_meta( $log_entry->user_id, 'billing_email', true );
				}

				if ( $customer_email ) {

					$column_content = sprintf( '<a href="%s">%s</a>', get_edit_user_link( $log_entry->user_id ), $customer_email );

				} else {

					$user = get_user_by( 'id', $log_entry->user_id );

					$column_content = sprintf( '<a href="%s">%s</a>', get_edit_user_link( $log_entry->user_id ), ( $user ) ? $user->user_login : __( 'Unknown', 'wc_points_rewards' ) );
				}

			break;

			case 'points':
				// add a '+' sign when needed
				$column_content = ( $log_entry->points > 0 ? '+' : '' ) . $log_entry->points;
			break;

			case 'event':
				$column_content = $log_entry->description;
			break;

			case 'date':
				$column_content =  '<abbr title="' . esc_attr( $log_entry->date_display ) . '">' . esc_html( $log_entry->date_display_human ) . '</abbr>';
			break;

			default:
				$column_content = '';
			break;
		}

		return $column_content;
	}


	/**
	 * Gets the current orderby, defaulting to 'date' if none is selected
	 */
	private function get_current_orderby() {
		return isset( $_GET['orderby'] ) ? $_GET['orderby'] : 'date';
	}


	/**
	 * Gets the current orderby, defaulting to 'DESC' if none is selected
	 */
	private function get_current_order() {
		return isset( $_GET['order'] ) ? $_GET['order'] : 'DESC';
	}


	/**
	 * Prepare the list of points history items for display
	 *
	 * @see WP_List_Table::prepare_items()
	 * @since 1.0
	 */
	public function prepare_items() {
		global $wc_points_rewards, $wpdb;
                        
		$per_page = $this->get_items_per_page( 'wc_points_rewards_points_log_events_per_page' );

		// main query args
		$args = array(
			'orderby' => array(
				'field' => $this->get_current_orderby(),
				'order' => $this->get_current_order(),
			),
			'per_page'         => $per_page,
			'paged'            => $this->get_pagenum(),
			'calc_found_rows' => true,
		);

		// Filter: points event log by customer, event type or event date
		$args = $this->add_filter_args( $args );

		// items as array
		$this->items = WC_Points_Rewards_Points_Log::get_points_log_entries( $args );

		// total number of items for pagination purposes
		$found_items = WC_Points_Rewards_Points_Log::$found_rows;

		$this->set_pagination_args(
			array(
				'total_items' => $found_items,
				'per_page'    => $per_page,
				'total_pages' => ceil( $found_items / $per_page ),
			)
		);
	}


	/**
	 * Adds in any query arguments based on the current filters
	 *
	 * @since 1.0
	 * @param array $args associative array of WP_Query arguments used to query and populate the list table
	 * @return array associative array of WP_Query arguments used to query and populate the list table
	 */
	private function add_filter_args( $args ) {
		global $wpdb;

		// filter by customer user
		if ( isset( $_GET['_customer_user'] ) && $_GET['_customer_user'] > 0 ) {
			$args['user'] = $_GET['_customer_user'];
		}

		// filter by event type
		if ( isset( $_GET['_event_type'] ) && $_GET['_event_type'] ) {
			$args['event_type'] = $_GET['_event_type'];
		}

		// filter by event log date
		if ( isset( $_GET['date'] ) && $_GET['date'] ) {

			$year = substr( $_GET['date'], 0, 4 );
			$month = ltrim( substr( $_GET['date'], 4, 2 ), '0' );

			$args['where'][] = $wpdb->prepare( 'YEAR( date ) = %s AND MONTH( date ) = %s', $year, $month );
		}

		return $args;
	}


	/**
	 * The text to display when there are no point log entries
	 *
	 * @see WP_List_Table::no_items()
	 * @since 1.0
	 */
	public function no_items() {

		if ( isset( $_REQUEST['s'] ) ) : ?>
			<p><?php _e( 'No log entries found', 'wc_points_rewards' ); ?></p>
		<?php else : ?>
			<p><?php _e( 'Point log entries will appear here for you to view and manage.', 'wc_points_rewards' ); ?></p>
		<?php endif;
	}


	/**
	 * Extra controls to be displayed before pagination, which
	 * includes our Filters: Customers, Event Types, Event Dates
	 *
	 * @see WP_List_Table::extra_tablenav();
	 * @since 1.0
	 * @param string $which the placement, one of 'top' or 'bottom'
	 */
	public function extra_tablenav( $which ) {
		global $woocommerce;

		if ( 'top' == $which ) {
			echo '<div class="alignleft actions">';

			// Customers, products
			?>
			<select id="dropdown_customers" name="_customer_user">
				<option value=""><?php _e( 'Show All Customers', 'wc_points_rewards' ) ?></option>
				<?php
					if ( ! empty( $_GET['_customer_user'] ) ) {
						$user = get_user_by( 'id', absint( $_GET['_customer_user'] ) );
						echo '<option value="' . absint( $user->ID ) . '" ';
						selected( 1, 1 );
						echo '>' . esc_html( $user->display_name ) . ' (#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')</option>';
					}
				?>
			</select>

			<select id="dropdown_event_types" name="_event_type">
				<option value=""><?php _e( 'Show All Event Types', 'wc_points_rewards' ) ?></option>
				<?php
				foreach ( WC_Points_Rewards_Points_Log::get_event_types() as $event_type ) :
					echo '<option value="' . esc_attr( $event_type->type ) . '" ' .
						selected( $event_type->type, isset( $_GET['_event_type'] ) ? $_GET['_event_type'] : null, false ) .
						'>' . esc_html( sprintf( "%s (%d)", $event_type->name, $event_type->count ) ) . '</option>';
				endforeach;
				?>
			</select>
			<?php

			$this->render_dates_dropdown();

			submit_button( __( 'Filter' ), 'button', false, false, array( 'id' => 'post-query-submit' ) );
			echo '</div>';

			// javascript
			$js = "
				// Ajax Chosen Product Selectors
				$('select#dropdown_dates').css('width', '250px').chosen();

				$('select#dropdown_event_types').css('min-width', '190px').chosen();

				$('select#dropdown_customers').css('width', '250px').ajaxChosen({
					method:         'GET',
					url:            '" . admin_url( 'admin-ajax.php' ) . "',
					dataType:       'json',
					afterTypeDelay: 100,
					minTermLength:  1,
					data: {
						action:   'woocommerce_json_search_customers',
						security: '" . wp_create_nonce( "search-customers" ) . "',
						default:  '" . esc_js( __( 'Show All Customers', 'wc_points_rewards' ) ) . "'
					}
				}, function (data) {

					var terms = {};

					$.each(data, function (i, val) {
						terms[i] = val;
					});

					return terms;
				});
			";

			if ( function_exists( 'wc_enqueue_js' ) ) {
				wc_enqueue_js( $js );
			} else {
				$woocommerce->add_inline_js( $js );
			}
		}
	}

	/**
	 * Display a monthly dropdown for filtering items by availability date
	 *
	 * @since 1.0
	 */
	private function render_dates_dropdown() {
		global $wpdb, $wp_locale, $wc_points_rewards;

		// Performance: we could always pull out the database order-by and sort in code to get rid of a 'filesort' from the query
		$months = $wpdb->get_results("
			SELECT DISTINCT YEAR( date ) AS year, MONTH( date ) AS month
			FROM {$wc_points_rewards->user_points_log_db_tablename}
			ORDER BY date DESC
		");

		$month_count = count( $months );

		if ( ! $month_count || ( 1 == $month_count && 0 == $months[0]->month ) )
			return;

		$date = isset( $_GET['date'] ) ? (int) $_GET['date'] : 0;
		?>
		<select id="dropdown_dates" name='date'>
			<option<?php selected( $date, 0 ); ?> value='0'><?php _e( 'Show all Event Dates', 'wc_points_rewards' ); ?></option>
			<?php
			foreach ( $months as $arc_row ) {
				if ( 0 == $arc_row->year )
					continue;

				$month = zeroise( $arc_row->month, 2 );
				$year = $arc_row->year;

				printf( "<option %s value='%s'>%s</option>\n",
					selected( $date, $year . $month, false ),
					esc_attr( $arc_row->year . $month ),
					sprintf( __( '%1$s %2$d', 'wc_points_rewards' ), $wp_locale->get_month( $month ), $year )
				);
			}
			?>
		</select>
		<?php
	}


}
