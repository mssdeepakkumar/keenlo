<?php
/**
 * WooCommerce Points and Rewards
 *
 * @package     WC-Points-Rewards/Classes
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * # Manager Class
 *
 * ## Points Increase/Reduce Algorithm
 *
 * For simplicity we reduce points from the oldest records while increasing
 * points in a brand new record.  This means that some minor gaming of the
 * system could be possible if points expiration were supported: for instance a
 * customer with soon-to-expire points could place a new order to earn points,
 * then cancel it to cycle out their old points, thus artifically increasing the
 * life of their points.  Trying to account for this would add a significant
 * amount of complexity (maybe) and in any event expiring points aren't supported
 * for version 1.0 and so this algorithm could be revisited when/if that feature
 * is implemented.
 *
 * ## Potential User Points Table Cleanup
 *
 * Technically, as soon as a user_points record reaches a balance of zero it
 * can be removed from this table as it no longer has any real value.  The log
 * record will still exist, and granted it will point to a missing record, but
 * this would help the user_points table from growing at the nearly the same
 * speed as the log table.
 *
 * ## User Points Query Implementation
 *
 * For better or for worse I decided to make use of the very limited
 * WP_User_Query class to pull the user points records.  This allowed me on the
 * one hand to write a very efficient query to pull only the current page of
 * user records, rather than pulling all user records and sorting in memory.
 * The drawbacks: I had to do my best to ensure that all customers have the
 * wc_user_points meta (initializing to 0), and we're quite limited to the
 * amount of searching possible (currently search is disabled, though it seems
 * like it would be nice search over billing email or user display name or
 * something).
 *
 * @since 1.0
 */
class WC_Points_Rewards_Manager {


	/** @var int records the number of users found during the get_user_points() method */
	public static $found_users;


	/**
	 * Returns the description to display for the given event type
	 *
	 * @since 1.0
	 * @param string $event_type the event type
	 * @param object $event optional event log object
	 * @return string the description for $event_type
	 */
	public static function event_type_description( $event_type, $event = null ) {

		global $wc_points_rewards;

		$event_description = '';

		$points_label = $wc_points_rewards->get_points_label( $event ? $event->points : null );

		switch ( $event_type ) {
			case 'admin-adjustment': $event_description = sprintf( __( '%s adjusted by "admin"',          'wc_points_rewards' ), $points_label ); break;
			case 'order-placed':     $event_description = sprintf( __( '%s earned for purchase',          'wc_points_rewards' ), $points_label ); break;
			case 'order-cancelled':  $event_description = sprintf( __( '%s adjusted for cancelled order', 'wc_points_rewards' ), $points_label ); break;
			case 'order-redeem':     $event_description = sprintf( __( '%s redeemed towards purchase',    'wc_points_rewards' ), $points_label ); break;
		}

		// allow other plugins to define their own event types/descriptions
		return apply_filters( 'wc_points_rewards_event_description', $event_description, $event_type, $event );
	}


	/**
	 * Sets the points balance for the user identified by $user_id
	 *
	 * @since 1.0
	 * @param int $user_id user identifier
	 * @param int $points_balance the new points balance
	 * @param string $event_type the event type slug
	 * @return boolean true if successfully updated, false otherwise
	 */
	public static function set_points_balance( $user_id, $points_balance, $event_type ) {

		global $wc_points_rewards, $wpdb;

		$points_change = 0;

		// ensure the user exists
		$user = get_userdata( $user_id );
		if ( false === $user ) return false;

		$points_balance = apply_filters( 'wc_points_rewards_set_points_balance', $points_balance, $user_id, $event_type );

		// get any existing points records
		// OK: the one drawback to the current algorithm would be the case of a positive point differnce and the most recent record(s) being
		//     zero, with some older non-zero records, the positive point difference would be applied older records than strictly necessary
		//     could be revisited when/if expiring points are implemented
		$query = "SELECT * FROM {$wc_points_rewards->user_points_db_tablename} WHERE user_id = %d AND points_balance != 0 ORDER BY date ASC";
		$points = $wpdb->get_results( $wpdb->prepare( $query, $user_id ) );

		// no non-zero records, so create a new one
		if ( empty( $points ) && 0 != $points_balance ) {

			$points_change = $points_balance;

			$wpdb->insert(
				$wc_points_rewards->user_points_db_tablename,
				array(
					'user_id'        => $user_id,
					'points'         => $points_balance,
					'points_balance' => $points_balance,
					'date'           => current_time( 'mysql', 1 ),
				),
				array(
					'%d',
					'%d',
					'%d',
					'%s',
				)
			);

		} elseif ( count( $points ) > 0 ) {  // existing non-zero points records

			$total_points_balance = 0;

			// total up the existing points balance
			foreach ( $points as $_points ) {
				$total_points_balance += $_points->points_balance;
			}

			if ( $total_points_balance != $points_balance ) {

				// get the difference (the amount required to make the users points balance equal to the new balance)
				$points_change = $points_difference = $points_balance - $total_points_balance;

				// the goal is to get each existing record as close to zero as possible, oldest to newest
				foreach ( $points as $index => &$_points ) {

					if ( $_points->points_balance < 0 && $points_difference > 0 ) {

						$_points->points_balance += $points_difference;

						if ( $_points->points_balance <= 0 || count( $points ) - 1 == $index ) {
							// used up all of points_difference, or reached the newest user points record which therefore receives the remaining balance
							$points_difference = 0;
							break;
						} else {
							// still have more points balance to distribute
							$points_difference = $_points->points_balance;
							$_points->points_balance = 0;
						}

					} elseif ( $_points->points_balance > 0 && $points_difference < 0 ) {

						$_points->points_balance += $points_difference;

						if ( $_points->points_balance >= 0 || count( $points ) - 1 == $index ) {
							// used up all of points_difference, or reached the newest user points record which therefore receives the remaining balance
							$points_difference = 0;
							break;
						} else {
							// still have more points balance to distribute
							$points_difference = $_points->points_balance;
							$_points->points_balance = 0;
						}

					} elseif ( count( $points ) - 1 == $index && 0 != $points_difference ) {
						// if we made it here, assign all remaining points to the final record and we're done
						$_points->points_balance += $points_difference;
						$points_difference = 0;
					}
				}

				// update any affected rows
				for ( $i = 0; $i <= $index; $i++ ) {
					$wpdb->update(
						$wc_points_rewards->user_points_db_tablename,
						array(
							'points_balance' => $points[ $i ]->points_balance,
						),
						array(
							'id' => $points[ $i ]->id,
						),
						array( '%d' ),
						array( '%d' )
					);
				}
			}
		}

		// always make sure the user points balance meta is up to date
		update_user_meta( $user_id, 'wc_points_balance', $points_balance );

		// if there was a points change, log it
		if ( $points_change ) {

			$args = array(
				'user_id'    => $user_id,
				'points'     => $points_change,
				'event_type' => $event_type,
			);

			// log the event
			WC_Points_Rewards_Points_Log::add_log_entry( $args );

			do_action( 'wc_points_rewards_after_set_points_balance', $user_id, $points_balance );
		}

		// for now always return success
		return true;
	}


	/**
	 * Adds points to the balance for the user identified by $user_id
	 *
	 * @since 1.0
	 * @param int $user_id the user identifier
	 * @param int $points the points to add
	 * @param string $event_type the type of event responsible
	 * @param mixed $data optional arbitrary data to associate with the log for this action
	 * @param int $order_id optional order identifier, if this action is associated with a particular order
	 * @return boolean true if the points are successfully added to the user's balance
	 */
	public static function increase_points( $user_id, $points, $event_type, $data = null, $order_id = null ) {

		global $wc_points_rewards, $wpdb;

		// ensure the user exists
		$user = get_userdata( $user_id );
		if ( false === $user ) return false;

		$points = apply_filters( 'wc_points_rewards_increase_points', $points, $user_id, $event_type, $data, $order_id );

		$_data = array(
			'user_id'        => $user_id,
			'points'         => $points,
			'points_balance' => $points,
			'date'           => current_time( 'mysql', 1 ),
		);

		$format = array(
			'%d',
			'%d',
			'%d',
			'%s',
		);

		if ( $order_id ) {
			$_data['order_id'] = $order_id;
			$format[] = '%d';
		}

		// create the new user points record
		$success = $wpdb->insert(
			$wc_points_rewards->user_points_db_tablename,
			$_data,
			$format
		);

		// failed to insert the user points record
		if ( 1 != $success ) return false;

		// required log parameters
		$args = array(
			'user_id'        => $user_id,
			'points'         => $points,
			'event_type'     => $event_type,
			'user_points_id' => $wpdb->insert_id,
		);

		// optional associated order
		if ( $order_id )
			$args['order_id'] = $order_id;

		// optional associated data
		if ( $data )
			$args['data'] = $data;

		// log the event
		WC_Points_Rewards_Points_Log::add_log_entry( $args );

		// update the current points balance user meta
		$points_balance = (int) get_user_meta( $user_id, 'wc_points_balance' );
		update_user_meta( $user_id, 'wc_points_balance', $points_balance + $points );

		do_action( 'wc_points_rewards_after_increase_points', $user_id, $points, $event_type, $data, $order_id );

		// success
		return true;
	}


	/**
	 * Reduces the points balance for the user identified by $user_id
	 *
	 * @since 1.0
	 * @param int $user_id the user identifier
	 * @param int $points the points to reduce, ie 75
	 * @param string $event_type the type of event responsible
	 * @param mixed $data optional arbitrary data to associate with the log for this action
	 * @param int $order_id optional order identifier, if this action is associated with a particular order
	 * @return boolean true if the points are successfully reduced from the user's balance
	 */
	public static function decrease_points( $user_id, $points, $event_type, $data = null, $order_id = null ) {

		global $wc_points_rewards, $wpdb;

		// ensure the user exists
		$user = get_userdata( $user_id );
		if ( false === $user ) return false;

		$points = apply_filters( 'wc_points_rewards_decrease_points', $points, $user_id, $event_type, $data, $order_id );

		// get any existing points records
		$query = "SELECT * FROM {$wc_points_rewards->user_points_db_tablename} WHERE user_id = %d and points_balance != 0 ORDER BY date ASC";
		$user_points = $wpdb->get_results( $wpdb->prepare( $query, $user_id ) );

		// no non-zero records, so create a new one
		if ( empty( $user_points ) ) {

			$_data = array(
				'user_id'        => $user_id,
				'points'         => -$points,
				'points_balance' => -$points,
				'date'           => current_time( 'mysql', 1 ),
			);

			$format = array(
				'%d',
				'%d',
				'%d',
				'%s',
			);

			if ( $order_id ) {
				$_data['order_id'] = $order_id;
				$format[] = '%d';
			}

			// create the negative-balance user points record
			$wpdb->insert(
				$wc_points_rewards->user_points_db_tablename,
				$_data,
				$format
			);

		} elseif ( count( $user_points ) > 0 ) {  // existing non-zero points records

			$points_difference = -$points;

			// the goal is to get each existing record as close to zero as possible, oldest to newest
			foreach ( $user_points as $index => &$_points ) {

				if ( $_points->points_balance > 0 && $points_difference < 0 ) {

					$_points->points_balance += $points_difference;

					if ( $_points->points_balance >= 0 || count( $user_points ) - 1 == $index ) {
						// used up all of points_difference, or reached the newest user points record which therefore receives the remaining balance
						$points_difference = 0;
						break;
					} else {
						// still have more points balance to distribute
						$points_difference = $_points->points_balance;
						$_points->points_balance = 0;
					}

				} elseif ( count( $user_points ) - 1 == $index && 0 != $points_difference ) {
					// if we made it here, assign all remaining points to the final record and we're done
					$_points->points_balance += $points_difference;
					$points_difference = 0;
				}
			}

			// update any affected rows
			for ( $i = 0; $i <= $index; $i++ ) {
				$wpdb->update(
					$wc_points_rewards->user_points_db_tablename,
					array(
						'points_balance' => $user_points[ $i ]->points_balance,
					),
					array(
						'id' => $user_points[ $i ]->id,
					),
					array( '%d' ),
					array( '%d' )
				);
			}
		}

		// update the current points balance user meta
		$points_balance = (int) get_user_meta( $user_id, 'wc_points_balance' );
		update_user_meta( $user_id, 'wc_points_balance', $points_balance - $points );

		// log the points change
		$args = array(
			'user_id'    => $user_id,
			'points'     => -$points,
			'event_type' => $event_type,
		);

		// optional associated order
		if ( $order_id )
			$args['order_id'] = $order_id;

		// optional associated data
		if ( $data )
			$args['data'] = $data;

		// log the event
		WC_Points_Rewards_Points_Log::add_log_entry( $args );

		do_action( 'wc_points_rewards_after_reduce_points', $user_id, $points_balance );

		// always return true for now
		return true;
	}


	/**
	 * Deletes the user points record associated with $user_id, but leaves the
	 * points log records intact
	 *
	 * @since 1.0
	 * @param $user_id int the user id to delete all user points records for
	 */
	public static function delete_user_points( $user_id ) {

		global $wc_points_rewards, $wpdb;

		$wpdb->delete( $wc_points_rewards->user_points_db_tablename, array( 'user_id' => $user_id ) );
	}


	/**
	 * Returns the current points balance for the identified user
	 *
	 * @since 1.0
	 * @param int $user_id the user identifier
	 * @return int the point balance for the user
	 */
	public static function get_users_points( $user_id ) {

		global $wc_points_rewards, $wpdb;

		$points_balance = 0;

		$query = "SELECT * FROM {$wc_points_rewards->user_points_db_tablename} WHERE user_id = %d AND points_balance != 0";
		$points = $wpdb->get_results( $wpdb->prepare( $query, $user_id ) );

		// total up the existing points balance
		foreach ( $points as $_points ) {
			$points_balance += $_points->points_balance;
		}

		return apply_filters( 'wc_points_rewards_user_points_balance', $points_balance, $user_id );
	}


	public static function get_users_points_value( $user_id ) {

		return self::calculate_points_value( self::get_users_points( $user_id ) );
	}


	/**
	 * Returns all user points records
	 *
	 * @since 1.0
	 * @param $args array arguments for the user query
	 * @return array of user_points objects with user_id and points_balance fields
	 */
	public static function get_all_users_points( $args ) {

		if ( ! isset( $args['fields'] ) ) $args['fields'] = 'ID';

		// perform the user query, altering the orderby as needed when ordering by user points
		if ( 'points' === $args['orderby'] ) add_action( 'pre_user_query', array( __CLASS__, 'order_user_by_points' ) );
		$wp_user_query = new WP_User_Query( $args );
		if ( 'points' === $args['orderby'] ) remove_action( 'pre_user_query', array( __CLASS__, 'order_user_by_points' ) );

		// record the total result set (for pagination purposes)
		if ( isset( $args['count_total'] ) && $args['count_total'] ) self::$found_users = $wp_user_query->get_total();

		$results = array();

		// build the expected user points records
		foreach ( $wp_user_query->get_results() as $user_id ) {
			$result = new stdClass();
			$result->user_id        = $user_id;
			$result->points_balance = self::get_users_points( $user_id );

			$results[] = $result;
		}

		return $results;
	}


	/**
	 * Alters the given wordpress user query to sort on the meta field (numerically)
	 *
	 * @since 1.0
	 * @param $wp_user_query WP_User_Query the wordpress user query object
	 */
	public static function order_user_by_points( $wp_user_query ) {
		global $wpdb;

		// determine the sort order
		if ( 'ASC' == $wp_user_query->query_vars['order'] )
			$order = 'ASC';
		else
			$order = 'DESC';

		// we're making the (I think safe) assumption that the points balance meta_value is part of wp_usermeta
		$orderby = $wpdb->usermeta . '.meta_value+0';

		$wp_user_query->query_orderby = "ORDER BY $orderby $order";
	}


	/**
	 * Returns the total user points records as found by the most recent call
	 * to get_user_points()
	 *
	 * @since 1.0
	 * @return int the total user points records found
	 */
	public static function get_found_user_points() {
		return self::$found_users;
	}



	/**
	 * Calculate the points earned for a purchase based on the given amount. This uses the ratio set in the admin settings
	 * (e.g. earn 10 points for every $1 spent). Points are rounded up to the nearest whole integer
	 *
	 * @since 1.0
	 * @param string|float the amount to calculate the points earned for
	 * @return int the points earned
	 */
	public static function calculate_points( $amount ) {

		list( $points, $monetary_value ) = explode( ':', get_option( 'wc_points_rewards_earn_points_ratio', '' ) );

		if ( ! $points )
			return 0;

		switch ( get_option( 'wc_points_rewards_earn_points_rounding' ) ) {
			case 'ceil' :
				return ceil( $amount * ( $points / $monetary_value ) );
			break;
			case 'floor' :
				return floor( $amount * ( $points / $monetary_value ) );
			break;
			default :
				return round( $amount * ( $points / $monetary_value ) );
			break;
		}
	}


	/**
	 * Calculate the value of the points earned for a purchase based on the given amount. This uses the ratio set in the
	 * admin settings (e.g. For every 100 points get a $1 discount). The points value is formatted to 2 decimal places.
	 *
	 * @since 1.0
	 * @param int $amount the amount of points to calculate the monetary value for
	 * @return float the monetary value of the points
	 */
	public static function calculate_points_value( $amount ) {

		list( $points, $monetary_value ) = explode( ':', get_option( 'wc_points_rewards_redeem_points_ratio', '' ) );

		return number_format( $amount * ( $monetary_value / $points ), 2, '.', '' );
	}


	/**
	 * Calculate the amount of points required to redeem for a given discount amount. This uses the ratio set in the
	 * admin settings (e.g. For every 100 points get a $1 discount). The points value ceil up to the nearest whole
	 * integer, so $1.01 discount requires 2 points
	 *
	 * @since 1.0
	 * @param float $discount_amount the discount amount to calculate the amount of points required to redeem
	 * @return int
	 */
	public static function calculate_points_for_discount( $discount_amount ) {

		list( $points, $monetary_value ) = explode( ':', get_option( 'wc_points_rewards_redeem_points_ratio', '' ) );

		$required_points = $discount_amount * ( $points / $monetary_value );

		// to prevent any rounding errors we need to round off any fractions
		// ex. 408.000000001 should require 408 points but 408.50 should require 409
		$required_points = floor( $required_points * 100 );
		$required_points = $required_points / 100;

		return ceil( $required_points );
	}


} // end \WC_Points_Rewards_Manager class
