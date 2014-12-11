<div class="wrap woocommerce">
	<div class="icon32 icon32-woocommerce-settings" id="icon-woocommerce"><br /></div>
	<h2>Pass Section</h2>	
<?php
if(isset($_POST['form'])){
	print_r($_POST);
}
global $wpdb;
$bookings = WC_Bookings_Controller::get_bookings_for_user( get_current_user_id() );
global $current_user; 
get_currentuserinfo();
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
						<table id="example" cellspacing="0" width="100%" class="display shop_table my_account_bookings">
							<thead>
								<tr>
									<th scope="col"><?php _e( 'ID', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Booked', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Order', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Client', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Start Date', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'End Date', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Manage Pass', 'woocommerce-bookings' ); ?></th>
									<th scope="col"><?php _e( 'Status', 'woocommerce-bookings' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$count = 1;
								foreach ( $bookings as $booking ) :
								$order_prdct_id = $booking->get_id();
								$results = $wpdb->get_results( 'SELECT * FROM wp_pass_section WHERE order_id = "'.$order_prdct_id.'"', OBJECT );
																
								$pass_used 	= $results[0]->pass_used;
								$max_pass 	= $results[0]->max_pass;
								

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
										<td><?php 
											$user_info = get_userdata($booking->customer_id);
											echo $user_name = $user_info->user_login; ?></td>
										<td><?php echo $booking->get_start_date(); ?></td>
										<td><?php echo $booking->get_end_date(); ?></td>
										<td style="width: 12%;"><div class="passes" style="float: left;"><?php echo $pass_used."/".$max_pass."</div>";					         								         				
			         										         							
			         							/*echo '<input type="hidden" name="form_1_'.$count.'" value="'.$booking->id.'">';
			         							echo '<input type="hidden" name="order_id_'.$count.'" value="'.$booking->id.'">';
			         							echo '<input type="hidden" name="product_id_'.$count.'" value="'.$booking->get_product()->id.'">';
			         							echo '<input type="hidden" name="product_name_'.$count.'" value="'.$booking->post->post_title.'">';
			         							echo '<input type="hidden" name="user_id_'.$count.'" value="'.$booking->customer_id.'">';
			         							echo '<input type="hidden" name="pass_used_'.$count.'" value="'.$pass_used.'">';
			         							echo '<input type="hidden" name="max_pass_'.$count.'" value="'.$authorvalues2[0]->name.'">';
			         							*/
			         							echo ' <input  style="float: right;" class="edit_pass button-primary" type="button" value="Edit" formsa = "form_'.$count.'" order_id = "'.$booking->id.'" product_id = "'.$booking->get_product()->id.'" product_name = "'.$booking->post->post_title.'" user_id = "'.$booking->customer_id.'" pass_used = "'.$pass_used.'" max_pass = "'.$max_pass.'" />';
			         							
			         							
			         						?>
			         					</td>
										<td><?php echo $booking->get_status( false ); ?></td>
									</tr>
								<?php $count++; endforeach; ?>
							</tbody>
						</table>
					</div>
				</section>				
	</div>
</div>
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script> 
	<script type="text/javascript" class="init">
		$(document).ready(function() {
			$('#example').dataTable();
			
			$('.edit_pass').click(function(){       		
       		var order_id = $(this).attr("order_id");
       		var product_id = $(this).attr("product_id");
       		var product_name =$(this).attr("product_name");
       		var user_id =$(this).attr("user_id");
       		var pass_used =$(this).attr("pass_used");
       		var max_pass =$(this).attr("max_pass");
       		var form =$(this).attr("form");
       		$.ajax({
                url : '<?php echo get_site_url() ?>'+"/booked",
                type: "POST",
                data : { order_id:order_id, product_id:product_id, product_name:product_name, user_id:user_id, pass_used:pass_used, max_pass:max_pass, form:form },
                success:function(data){                   
                    $(".hentry").html(data);
               	},
                failure: function( data ){
                alert( "fail: ");
                }
                });
 			});

		} );
</script>
<style>
td {
    text-align: center;
    border: 1px solid #ccc;
    padding: 5px;
}

.hentry {
    background: none repeat scroll 0 0 #fff;
    border-radius: 3px;
    padding: 20px 20px 40px;
}
.pass_details{
	text-align: center;
}
.pass_details input[type="submit"] {
    display: inline-block;
    text-align: left;
    width: auto;
}
.passes {
    background: none repeat scroll 0 0 #cdcdcd;
    border-radius: 5px;
    display: inline-block;
    font-size: 20px;
    font-weight: bold;
    padding: 7px 5px;
    
}
.pass_details {
    text-align: center;
}

.pass_details > p {
    font-weight: normal;
    text-transform: capitalize;
}

.edit_pass2 {
    background: none repeat scroll 0 0 #000;
    border: 1px solid;
    color: #fff;
    font-size: 24px;
    padding: 6px;
}

.dataTables_paginate.paging_simple_numbers {
    display: inline-block;
    float: right;
}

.dataTables_info {
    display: inline-block;
    float: left;
}

.dataTables_filter {
    display: inline-block;
    float: right;
}

.dataTables_length {
    display: inline-block;
}

#example_paginate a {
    border: 1px solid;
    border-radius: 4px;
    margin: 5px;
    padding: 2px 5px;
}
#example {
    margin-bottom: 10px;
}
</style>

