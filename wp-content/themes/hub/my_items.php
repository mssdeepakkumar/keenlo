<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
Template Name: My Items
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$bookings = WC_Bookings_Controller::get_bookings_for_user( get_current_user_id() );


global $current_user; 
get_currentuserinfo();
if ( user_can( $current_user, "subscriber" ) ){ 
?>
<div class="wrapper">
	<section id="main" class="fullwidth">
				<div class="hentry">

			<h2><?php echo apply_filters( 'woocommerce_my_account_bookings_title', __( 'My Classes', 'woocommerce-bookings' ) ); ?></h2>
			<table class="shop_table my_account_bookings">
				<thead>
					<tr>
						<th scope="col"><?php _e( 'Class ID', 'woocommerce-bookings' ); ?></th>
						<th scope="col"><?php _e( 'Booked Class', 'woocommerce-bookings' ); ?></th>
						<th scope="col"><?php _e( 'Order ID', 'woocommerce-bookings' ); ?></th>
						<th scope="col"><?php _e( 'PRO', 'woocommerce-bookings' ); ?></th>
						<th scope="col"><?php _e( 'Start Date', 'woocommerce-bookings' ); ?></th>
						<th scope="col"><?php _e( 'End Date', 'woocommerce-bookings' ); ?></th>
						<th scope="col"><?php _e( 'Pass', 'woocommerce-bookings' ); ?></th>
						<th scope="col"><?php _e( 'Status', 'woocommerce-bookings' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $bookings as $booking ) : 
							$order_prdct_id = $booking->get_id();
							$results = $wpdb->get_results( 'SELECT `pass_used` FROM wp_pass_section WHERE order_id = "'.$order_prdct_id.'"', OBJECT );
							$pass_used = $results[0]->pass_used;

						if ( $booking->get_product() ) :?>
						<tr>
							<td><?php echo $booking->get_id(); ?></td>
							<td>
								<?php if ( $booking->get_product() ) : ?>
								<a href="<?php echo get_permalink( $booking->get_product()->id ); ?>">
									<?php echo $booking->get_product()->get_title(); ?>
								</a>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $booking->get_order() ) : ?>
								<a href="<?php echo $booking->get_order()->get_view_order_url(); ?>">
									<?php echo $booking->get_order()->get_order_number(); ?>
								</a>
								<?php endif; ?>
							</td>
							<td><?php $vendors = get_product_vendors( $booking->get_product()->id  ); ?>
								<a href="<?php echo $vendors['0']->url; ?>"><?php echo $vendors['0']->title; ?></a>
							</td>				
							<td><?php echo $booking->get_start_date(); ?></td>
							<td><?php echo $booking->get_end_date(); ?></td>
							<td><?php 						
								$authorvalues2 = get_the_terms( $booking->get_product()->id, 'pa_maxpass');
								echo $pass_used."/".$authorvalues2[0]->name;         				
		         				?>
		         				
		         			</td>
							<td><?php echo $booking->get_status( false ); ?></td>
						</tr>
					<?php endif; endforeach; ?>
				</tbody>
			</table>
		</div>
	</section>
</div>
<?php 
}elseif (user_can( $current_user, "shop_manager" )) {
	$login_id = get_current_user_id();
	$vendor_id = get_user_meta( $login_id);
	$numberitems = -1;
	$offset = 0;
	$booking_ids = get_posts( array(
			'numberposts' => $numberitems,
			'offset'      => $offset,
			'orderby'     => 'post_date',
			'post_author' => $vendor_id,
			'order'       => 'DESC',
			'post_type'   => 'wc_booking',
			'post_status' => array( 'unpaid', 'pending', 'confirmed', 'paid', 'cancelled' ),
			'fields'      => 'ids',
		) );

		$bookings = array();


		$vendor_id = $vendor_id['product_vendor']['0'];
		foreach ( $booking_ids as $booking_id ) {
			$vendorid = get_wc_booking( $booking_id )->custom_fields['_booking_vendor']['0'];
			if($vendorid == $vendor_id){
				$bookings[] = get_wc_booking( $booking_id );
			}
			
		}


 ?>
	<div class="wrapper">
		<section id="main" class="fullwidth">
				<div class="hentry">
					<h2><?php echo apply_filters( 'woocommerce_my_account_bookings_title', __( 'My Passes', 'woocommerce-bookings' ) ); ?></h2>
					
						<table class="shop_table my_account_bookings">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Booked', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Order', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Start Date', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'End Date', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Manage Pass', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Status', 'woocommerce-bookings' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ( $bookings as $booking ) :
								$order_prdct_id = $booking->get_id();
								$results = $wpdb->get_results( 'SELECT `pass_used` FROM wp_pass_section WHERE order_id = "'.$order_prdct_id.'"', OBJECT );
								$pass_used = $results[0]->pass_used;

			 ?>
									<tr>
										<td><?php echo $booking->get_id(); ?></td>
										<td>
											<?php if ( $booking->get_product() ) : ?>
											<a href="<?php echo get_permalink( $booking->get_product()->id ); ?>">
												<?php echo $booking->get_product()->get_title(); ?>
											</a>
											<?php endif; ?>
										</td>
										<td>
											<?php if ( $booking->get_order() ) : ?>
											<a href="<?php echo $booking->get_order()->get_view_order_url(); ?>">
												<?php echo $booking->get_order()->get_order_number(); ?>
											</a>
											<?php endif; ?>
										</td>
										<td><?php echo $booking->get_start_date(); ?></td>
										<td><?php echo $booking->get_end_date(); ?></td>
										<td><?php 									
												$authorvalues2 = get_the_terms( $booking->get_product()->id, 'pa_maxpass');
												echo $pass_used."/".$authorvalues2[0]->name;
						         				$product_id = $booking->get_product()->id;
						         				
			         							echo '<form method="POST" action="'.get_site_url().'/booked">';
			         							echo '<input type="hidden" name="order_id" value="'.$booking->id.'">';
			         							echo '<input type="hidden" name="product_id" value="'.$booking->get_product()->id.'">';
			         							echo '<input type="hidden" name="product_name" value="'.$booking->post->post_title.'">';
			         							echo '<input type="hidden" name="user_id" value="'.$booking->customer_id.'">';
			         							echo '<input type="hidden" name="pass_used" value="'.$pass_used.'">';
			         							echo '<input type="hidden" name="max_pass" value="'.$authorvalues2[0]->name.'">';
			         							echo '<input type="submit" value="Edit" />';
			         							echo '</form>';
			         						?>
			         					</td>
										<td><?php echo $booking->get_status( false ); ?></td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</section>				
	</div>
<?php } get_footer(); ?>
