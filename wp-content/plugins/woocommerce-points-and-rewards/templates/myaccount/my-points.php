<?php
/**
 * WooCommerce Points and Rewards
 *
 * @package     WC-Points-Rewards/Templates
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * My Account - My Points
 *
 * @since 1.0
 * @version 1.0
 */
?>

<h2><?php printf( __( 'My %s', 'wc_points_rewards' ), $points_label  ); ?></h2>

<p><?php printf( __( "You have %d %s", 'wc_points_rewards' ), $points_balance, $points_label ); ?></p>

<?php if ( $events ) : ?>
	<table class="shop_table my_account_points_rewards my_account_orders">

		<thead>
			<tr>
				<th class="points-rewards-event-description"><span class="nobr"><?php _e( 'Event', 'wc_points_rewards' ); ?></span></th>
				<th class="points-rewards-event-date"><span class="nobr"><?php _e( 'Date', 'wc_points_rewards' ); ?></span></th>
				<th class="points-rewards-event-points"><span class="nobr"><?php echo esc_html( $points_label ); ?></span></th>
			</tr>
		</thead>

		<tbody>
		<?php foreach ( $events as $event ) : ?>
			<tr class="points-event">
				<td class="points-rewards-event-description">
					<?php echo $event->description; ?>
				</td>
				<td class="points-rewards-event-date">
					<?php echo '<abbr title="' . esc_attr( $event->date_display ) . '">' . esc_html( $event->date_display_human ) . '</abbr>'; ?>
				</td>
				<td class="points-rewards-event-points" width="1%">
					<?php echo ( $event->points > 0 ? '+' : '' ) . $event->points; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>

	</table>

<?php endif;
