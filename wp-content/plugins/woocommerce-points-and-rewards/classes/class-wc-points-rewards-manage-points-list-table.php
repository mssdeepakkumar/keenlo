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
 * Points and Rewards Manage Points List Table class
 *
 * Extends WP_List_Table to display customer reward points
 *
 * @since 1.0
 * @extends \WP_List_Table
 */
class WC_Points_Rewards_Manage_Points_List_Table extends WP_List_Table {


	/**
	 * Setup list table
	 *
	 * @see WP_List_Table::__construct()
	 * @since 1.0
	 * @return \WC_Points_Rewards_Manage_Points_List_Table
	 */
	public function __construct() {

		parent::__construct(
			array(
				'singular' => __( 'Point', 'wc_points_rewards' ),
				'plural'   => __( 'Points', 'wc_points_rewards' ),
				'ajax'     => false,
				'screen'   => 'woocommerce_page_wc_points_rewards_manage_points',
			)
		);
	}


	/**
	 * Gets the bulk action available for user points: update
	 *
	 * @see WP_List_Table::get_bulk_actions()
	 * @since 1.0
	 * @return array associative array of action_slug => action_title
	 */
	public function get_bulk_actions() {

		$actions = array(
			'update' => __( 'Update', 'wc_points_rewards' ),
		);

		return $actions;
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
			'cb'       => '<input type="checkbox" />',
			'customer' => __( 'Customer', 'wc_points_rewards' ),
			'points'   => __( 'Points', 'wc_points_rewards' ),
			'update'   => __( 'Update', 'wc_points_rewards' ),
		);

		return $columns;
	}


	/**
	 * Returns the sortable columns and initial direction
	 *
	 * @see WP_List_Table::get_sortable_columns()
	 * @since 1.0
	 * @return array of sortable column slug => array( 'orderby', boolean )
	 *         where true indicates the initial sort is descending
	 */
	public function get_sortable_columns() {

		// really the only thing that makes sense to sort is the points column
		return array(
			'points' => array( 'points', false ),  // false because the inital sort direction is DESC so we want the first column click to sort ASC
		);
	}


	/**
	 * Get content for the special checkbox column
	 *
	 * @see WP_List_Table::single_row_columns()
	 * @since 1.0
	 * @param object $row one row (item) in the table
	 * @return string the checkbox column content
	 */
	public function column_cb( $row ) {
		return '<input type="checkbox" name="user_id[]" value="' . $row->user_id . '" />';
	}


	/**
	 * Get column content, this is called once per column, per row item ($user_points)
	 * returns the content to be rendered within that cell.
	 *
	 * @see WP_List_Table::single_row_columns()
	 * @since 1.0
	 * @param object $user_points one row (item) in the table
	 * @param string $column_name the column slug
	 * @return string the column content
	 */
	public function column_default( $user_points, $column_name ) {

		switch ( $column_name ) {

			case 'customer':

				$customer_email = null;
				if ( $user_points->user_id ) {
					$customer_email = get_user_meta( $user_points->user_id, 'billing_email', true );
				}

				if ( $customer_email ) {

					$column_content = sprintf( '<a href="%s">%s</a>', get_edit_user_link( $user_points->user_id ), $customer_email );

				} else {

					$user = get_user_by( 'id', $user_points->user_id );

					$column_content = sprintf( '<a href="%s">%s</a>', get_edit_user_link( $user_points->user_id ), ( $user ) ? $user->user_login : __( 'Unknown', 'wc_points_rewards' ) );
				}

			break;

			case 'points':
				$column_content = $user_points->points_balance;
			break;

			case 'update':
				$column_content = '<input type="text" class="points_balance" name="points_balance[' . $user_points->user_id . ']" value="' . $user_points->points_balance . '" />' .
					' <a class="button update_points" href="' . wp_nonce_url( remove_query_arg( 'points_balance', add_query_arg( array( 'action' => 'update', 'user_id' => $user_points->user_id ) ) ), 'wc_points_rewards_update' ) . '">' . __( 'Update', 'wc_points_rewards' ) . '</a>';
			break;

			default:
				$column_content = '';
			break;
		}

		return $column_content;
	}


	/**
	 * Get the current action selected from the bulk actions dropdown, verifying
	 * that it's a valid action to perform
	 *
	 * @see WP_List_Table::current_action()
	 * @since 1.0
	 * @return string|bool The action name or False if no action was selected
	 */
	public function current_action() {

		$current_action = parent::current_action();

		if ( $current_action && ! array_key_exists( $current_action, $this->get_bulk_actions() ) ) return false;

		return $current_action;
	}


	/**
	 * Handle actions for both individual items and bulk update
	 *
	 * @since 1.0
	 */
	public function process_actions() {
		global $wc_points_rewards;

		// get the current action (if any)
		$action = $this->current_action();

		// get the set of users to operate on
		$user_ids = isset( $_REQUEST['user_id'] ) ? array_map( 'absint', (array) $_REQUEST['user_id'] ): array();

		// no action, or invalid action
		if ( false === $action || empty( $user_ids ) || ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wc_points_rewards_update' ) && ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-points' ) ) ) {
			return;
		}

		$success_count = $error_count = 0;

		// process the users
		foreach ( $user_ids as $user_id ) {

			// perform the action
			switch ( $action ) {
				case 'update':
					if ( WC_Points_Rewards_Manager::set_points_balance( $user_id, $_REQUEST['points_balance'][ $user_id ], 'admin-adjustment' ) ) {
						$success_count++;
					} else {
						$error_count++;
					}
				break;
			}
		}

		// build the result message(s)
		switch ( $action ) {
			case 'update':
				if ( $success_count > 0 ) {
					$wc_points_rewards->admin_message_handler->add_message( sprintf( _n( '%d customer updated.', '%s customers updated.', $success_count, 'wc_points_rewards' ), $success_count ) );
				}
				if ( $error_count > 0 ) {
					$wc_points_rewards->admin_message_handler->add_message( sprintf( _n( '%d customer could not be updated.', '%s customers could not be updated.', $error_count, 'wc_points_rewards' ), $error_count ) );
				}
			break;
		}
	}


	/**
	 * Output any messages from the bulk action handling
	 *
	 * @since 1.0
	 */
	public function render_messages() {
		global $wc_points_rewards;

		if ( $wc_points_rewards->admin_message_handler->message_count() > 0 ) {
			echo '<div id="moderated" class="updated"><ul><li><strong>' . implode( '</strong></li><li><strong>', $wc_points_rewards->admin_message_handler->get_messages() ) . '</strong></li></ul></div>';
		}
	}


	/**
	 * Gets the current orderby, defaulting to 'user_id' if none is selected
	 *
	 * @since 1.0
	 */
	private function get_current_orderby() {

		$orderby = ( isset( $_GET['orderby'] ) ) ? $_GET['orderby'] : null;

		// order by points or default of user ID
		switch ( $orderby ) {
			case 'points': return 'points';
			default: return 'ID';
		}
	}


	/**
	 * Gets the current orderby, defaulting to 'DESC' if none is selected
	 *
	 * @since 1.0
	 */
	private function get_current_order() {
		return isset( $_GET['order'] ) ? $_GET['order'] : 'DESC';
	}


	/**
	 * Prepare the list of user points items for display
	 *
	 * @see WP_List_Table::prepare_items()
	 * @since 1.0
	 */
	public function prepare_items() {

		$this->process_actions();

		$per_page = $this->get_items_per_page( 'wc_points_rewards_manage_points_users_per_page' );

		$args = array(
			'orderby'     => $this->get_current_orderby(),
			'order'       => $this->get_current_order(),
			'offset'      => ( $this->get_pagenum() - 1 ) * $per_page,
			'number'      => $per_page,
			'count_total' => true,
		);

		// Filter: by customer
		$args = $this->add_filter_args( $args );

		$this->items = WC_Points_Rewards_Manager::get_all_users_points( $args );

		$this->set_pagination_args(
			array(
				'total_items' => WC_Points_Rewards_Manager::get_found_user_points(),
				'per_page'    => $per_page,
				'total_pages' => ceil( WC_Points_Rewards_Manager::get_found_user_points() / $per_page ),
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

		// filter by customer
		if ( isset( $_GET['_customer_user'] ) && $_GET['_customer_user'] > 0 ) {
			$userdata = get_userdata( $_GET['_customer_user'] );
			$args['search'] = $userdata->user_login;
		}

		return $args;
	}


	/**
	 * The text to display when there are no user pointss
	 *
	 * @see WP_List_Table::no_items()
	 * @since 1.0
	 */
	public function no_items() {
		if ( isset( $_REQUEST['s'] ) ) : ?>
			<p><?php _e( 'No user points found', 'wc_points_rewards' ); ?></p>
		<?php else : ?>
			<p><?php _e( 'User points will appear here for you to view and manage once you have customers.', 'wc_points_rewards' ); ?></p>
		<?php endif;
	}


	/**
	 * Extra controls to be displayed between bulk actions and pagination, which
	 * includes our Filters: Customers, Products, Availability Dates
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
				<option value=""><?php _e( 'Show all customers', 'wc_points_rewards' ) ?></option>
				<?php
					if ( ! empty( $_GET['_customer_user'] ) ) {
						$user = get_user_by( 'id', absint( $_GET['_customer_user'] ) );
						echo '<option value="' . absint( $user->ID ) . '" ';
						selected( 1, 1 );
						echo '>' . esc_html( $user->display_name ) . ' (#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')</option>';
					}
				?>
			</select>
			<?php

			submit_button( __( 'Filter' ), 'button', false, false, array( 'id' => 'post-query-submit' ) );
			echo '</div>';

			// javascript
			$js = "
				// Ajax Chosen Product Selectors

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

				// submit the single-row Update action
				$( 'a.update_points' ).click( function() {
					var \$el = $( this );
					\$el.attr( 'href', \$el.attr( 'href' ) + '&' + \$el.prev().attr('name') + '=' + \$el.prev().val() );
				} );

				// when the focus is on one of the 'points balance' inputs, and the form is submitted, assume we're updating only that one record
				$( 'form#mainform' ).submit( function() {
					var \$focused = $( ':focus' );

					if ( \$focused && \$focused.hasClass( 'points_balance' ) ) {
						location.href = \$focused.next().attr( 'href' ) + '&' + \$focused.attr('name') + '=' + \$focused.val();
						return false;
					}

					return true;
				} );
			";

			if ( function_exists( 'wc_enqueue_js' ) ) {
				wc_enqueue_js( $js );
			} else {
				$woocommerce->add_inline_js( $js );
			}
		}
	}


} // end \WC_Pre_Orders_List_Table class
