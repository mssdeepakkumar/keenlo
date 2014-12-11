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
 * @package   WC-Social-Login/Templates
 * @author    SkyVerge
 * @copyright Copyright (c) 2014, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

/**
 * Renders any linked social profiles on my account page.
 *
 * @param array $linked_profiles Profiles that are already linked to the current user's account
 * @param string $available_providers All available social login providers
 * @param string $return_url
 *
 * @version 1.0
 * @since 1.0
 */
?>

<div class="wc-social-login-profile">

	<h2><?php _e( 'My Social Login Accounts', WC_Social_Login::TEXT_DOMAIN ); ?></h2>

	<?php if ( $linked_profiles ) : ?>

		<?php
			$add_more_link = '';
			if ( count( $linked_profiles ) < count( $available_providers ) ) {
				$add_more_link = ' ' . sprintf( __( '%sAdd more...%s', WC_Social_Login::TEXT_DOMAIN ), '<a href="#" class="js-show-available-providers">', '</a>' );
			}
		?>

		<p><?php echo __( 'Your account is connected to the following social login providers.', WC_Social_Login::TEXT_DOMAIN ) . $add_more_link; ?></p>

		<table class="shop_table wc-social-login-linked-profiles">
			<thead>
				<tr>
					<th><?php _e( 'Provider', WC_Social_Login::TEXT_DOMAIN ); ?></th>
					<th><?php _e( 'Account', WC_Social_Login::TEXT_DOMAIN ); ?></th>
					<th colspan="2"><?php _e( 'Last login', WC_Social_Login::TEXT_DOMAIN ); ?></th>
				</tr>
			</thead>

			<?php foreach ( $linked_profiles as $provider_id => $profile ) :
				$provider = $GLOBALS['wc_social_login']->get_provider( $provider_id );
				$login_timestamp = get_user_meta( get_current_user_id(), '_wc_social_login_' . $provider_id . '_login_timestamp', true );
			?>
			<tr>
				<td>
					<?php printf( '<span class="social-badge social-badge-%1$s"><span class="si si-%1$s"></span>%2$s</a> ', esc_attr( $provider->get_id() ), esc_html( $provider->get_title() ) ); ?>
				</td>
				<td>
					<?php
						/**
						 * Filter the profile identifier displayed to the user.
						 *
						 * @since 1.0
						 * @param srting $profile_identifier See https://github.com/opauth/opauth/wiki/Opauth-configuration - Strategy
						 */
						echo apply_filters( 'wc_social_login_profile_identifier', isset( $profile['email'] ) ? $profile['email'] : $profile['screen_name'] );
					?>
				</td>
				<td>
					<?php if ( $login_timestamp ) : ?>
						<?php printf( __( '%s @ %s', WC_Social_Login::TEXT_DOMAIN ), date_i18n( get_option( 'date_format' ), $login_timestamp ), date_i18n( get_option( 'time_format' ), $login_timestamp ) ); ?>
					<?php else : ?>
						<?php echo __( 'Never', WC_Social_Login::TEXT_DOMAIN ); ?>
					<?php endif; ?>
				</td>
				<td class="profile-actions">
					<a href="<?php echo $provider->get_auth_url( $return_url, 'unlink' ); ?>" class="button unlink-social-login-profile">
						<?php _e( 'Unlink', WC_Social_Login::TEXT_DOMAIN ); ?>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>

		</table>

	<?php else : ?>

		<p><?php printf( __( 'You have no social login profiles connected. %sConnect one now%s', WC_Social_Login::TEXT_DOMAIN ), '<a href="#" class="js-show-available-providers">', '</a>' ); ?></p>

	<?php endif; ?>

	<div class="wc-social-login-available-providers" style="display:none;">

		<p><?php _e( 'You can link your account to the following providers:', WC_Social_Login::TEXT_DOMAIN ); ?></p>

		<?php
			foreach ( $GLOBALS['wc_social_login']->get_available_providers() as $provider ) :
				if ( ! array_key_exists( $provider->get_id(), $linked_profiles ) ) :
					printf( '<a href="%1$s" class="button-social-login button-social-login-%2$s"><span class="si si-%2$s"></span>%3$s</a> ', esc_url( $provider->get_auth_url( $return_url ) ), esc_attr( $provider->get_id() ), esc_html( $provider->get_link_button_text() ) );
				endif;
			endforeach;
		?>

	</div>

</div>
