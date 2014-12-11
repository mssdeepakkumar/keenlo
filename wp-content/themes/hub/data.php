
<?php
if(isset($_POST['plan_id'])){

		require_once('../../../wp-config.php'); 
		$curent_date = $_POST['plan_id'];
		$click_id = $_POST['click_id'];



		$args = array(
			'posts_per_page'   => 100,
			'offset'           => 0,
			'category'         => '',
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'product',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'post_status'      => 'publish',
			'suppress_filters' => true ); 

		$myposts = get_posts( $args );
		global $product;
		global $wpdb;
		$data = array();
		$data_id = array();
		foreach ($myposts as $key => $value) {
			$post_id = $value->ID;
			$meta_value = $wpdb->get_results( "SELECT `meta_value` FROM `wp_postmeta` WHERE `meta_key` = '_wc_booking_availability' && `post_id` = ".$value->ID, OBJECT );
			$meta_val = unserialize($meta_value[0]->meta_value);
			$feed_list = $wpdb->get_results( "SELECT * FROM `wp_term_relationships` WHERE `term_taxonomy_id` = '147' && `object_id` = ".$value->ID, OBJECT );	
			foreach ($meta_val as $key => $value) {
					if($value['bookable'] == "yes"){			
						if ($curent_date >= $value['from'] && $curent_date <= $value['to']){
							if(!empty($feed_list)){					  	
							  	$data_id[] = $feed_list[0]->object_id;
							  	$data['current'] = $curent_date;
								$data['from_date'][] = $value['from'];
								$data['to_date'][] = $value['to'];
						}
					}
				}
			}
		}
		?>
		<div class="panel entry-content" id="ap-pt-tab-vendor">
			<table>
				<?php
				$count = 0;
				foreach ($data_id as $key => $value) {			
					$meta_value = $wpdb->get_results( "SELECT `meta_value` FROM `wp_postmeta` WHERE `meta_key` = '_wc_booking_availability' && `post_id` = ".$value, OBJECT );
					//print_r($meta_value);
					$meta_val = unserialize($meta_value[0]->meta_value);
					$product = get_post($value);
					$vendors = get_product_vendors( $product->ID );
					$meta_values = get_post_meta( $value );
					$price = $meta_values['_price'][0];
					$attr = unserialize($meta_values['_product_attributes'][0]);				
					//print_r($attr);
					?>
						<tr>
							<td width="5%"><div class="prdct-tbl-td"><h4><?php foreach($meta_val as $meta){
									 if($meta['bookable'] == 'yes'){ 	
										echo $meta['from']."<br>";
										//echo $meta['to'];
										 }
									 } ?></h4></div>
							</td>
							<td width="9%"><div class="prdct-tbl-td">
								<h3><a href="<?php echo $vendors[0]->url; ?>" target="_blank"><?php echo $vendors[0]->title; ?></a></h3>
							</div></td>
							<td width="7%" class="td_img"><div class="p-user-hoder">
								<a href="<?php echo $vendors[0]->url; ?>" target="_blank"><img src ="<?php echo '/wp-content/uploads/vendore_images/'.$vendors[0]->ID.'/profileimage.jpg'; ?>" ></a>
							</div></td>
							<td width="23%"><div class="prdct-tbl-td"><p><strong><?php echo $product->post_title."</strong> ";			
								/*--get location--*/
								$term_taxonomy_id = $wpdb->get_results( "SELECT `term_taxonomy_id` FROM `wp_term_relationships` WHERE `object_id` = ".$value, OBJECT );
								//print_r($term_taxonomy_id);
								foreach($term_taxonomy_id as $term_id){
								$terms_id = $wpdb->get_results( "SELECT `term_id` FROM `wp_term_taxonomy` WHERE `taxonomy` = 'pa_location' && `term_taxonomy_id` = ".$term_id->term_taxonomy_id, OBJECT );
								//print_r($terms_id);
								$terms_name = $wpdb->get_results( "SELECT `name` FROM `wp_terms` WHERE `term_id` = ".$terms_id[0]->term_id, OBJECT );
								//print_r($terms_name);
								if(!empty($terms_name[0]->name)){
									echo $terms_name[0]->name."</p>";
								}
								}
								echo "<span class='rvw-hldr'>".$yotpo_div;
								echo "<i>$ ".$price." Per Class</i></div>";
								/*--get location end--*/
								?>
							</td>
							<td width="10%" class="td_img"><div class="prdct-tbl-td">
								<ul><?php foreach($attr as $attribute){
									//print_r($attribute);
								 echo "<li class=".$attribute['name']."></li>"; 
								} ?></ul></div>
							</td>
							<td width="10%" class="td_img"><div class="prdct-tbl-td">
								<?php if (has_post_thumbnail( $value ) ): ?>
								  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $value ), 'single-post-thumbnail' ); ?>
								  <img src="<?php echo $image[0]; ?>">
								  </div>
								<?php endif; ?>
							</td>
				
							<td style="vertical-align: middle;" width="8%"><div class="prdct-tbl-td">
								<form id="form<?php echo $count; ?>" class="cart" enctype="multipart/form-data" method="post" action="/sport-bag-cart/">
								<input id="wc_bookings_field_persons" type="hidden" name="wc_bookings_field_persons" max="1" min="1" step="1" value="1">
								<input id="wc_bookings_field_start_date" type="hidden" name="wc_bookings_field_start_date_yearmonth" value="2014-12">
								<input type="hidden" value="<?php echo $value; ?>" name="add-to-cart">
								<a class="button add_to_cart_button product_type_booking" onclick="document.getElementById('form<?php echo $count; ?>').submit();">Add Class</a>
								<!--a href="<?php// echo do_shortcode( '[add_to_cart_url id="'.$value.'"]' ); ?>">Add Class</a-->
								</form></div>
							</td>
						</tr>
				<?php $count++; } ?>
			</table>
		</div>
		<?php
}

if(isset($_POST['pay_vendor'])){

require_once('../../../wp-config.php'); 
$pay_vendor = $_POST['pay_vendor'];

$args = array(
	'posts_per_page'   => 100,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'product',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true ); 

$myposts = get_posts( $args );
global $product;
global $wpdb;
$data = array();
$data_id = array();
foreach ($myposts as $key => $value) {
	$post_id = $value->ID;
	$koostis = array_shift( wc_get_product_terms( $post_id, 'pa_payed-vendors', array( 'fields' => 'names' ) ) );
		if($koostis == $pay_vendor ){
				$data_id[] = $post_id;				
		}
}

?>
<div class="panel entry-content" id="ap-pt-tab-vendor">
	<table>
		<?php
		$count = 0;
		foreach ($data_id as $key => $value) {			
			$meta_value = $wpdb->get_results( "SELECT `meta_value` FROM `wp_postmeta` WHERE `meta_key` = '_wc_booking_availability' && `post_id` = ".$value, OBJECT );
			//print_r($meta_value);
			$meta_val = unserialize($meta_value[0]->meta_value);
			$product = get_post($value);
			$vendors = get_product_vendors( $product->ID );
			$meta_values = get_post_meta( $value );
			$price = $meta_values['_price'][0];
			$attr = unserialize($meta_values['_product_attributes'][0]);				
			//print_r($attr);
			?>
				<tr>
					<td width="5%"><div class="prdct-tbl-td"><h4><?php foreach($meta_val as $meta){
							 if($meta['bookable'] == 'yes'){ 	
								echo $meta['from']."<br>";
								//echo $meta['to'];
								 }
							 } ?></h4></div>
					</td>
					<td width="9%"><div class="prdct-tbl-td">
						<h3><a href="<?php echo $vendors[0]->url; ?>" target="_blank"><?php echo $vendors[0]->title; ?></a></h3>
					</div></td>
					<td width="7%" class="td_img"><div class="p-user-hoder">
						<a href="<?php echo $vendors[0]->url; ?>" target="_blank"><img src ="<?php echo '/wp-content/uploads/vendore_images/'.$vendors[0]->ID.'/profileimage.jpg'; ?>" >
						</a></div></td>
					<td width="23%"><div class="prdct-tbl-td"><p><strong><?php echo $product->post_title."</strong> ";			
						/*--get location--*/
						$term_taxonomy_id = $wpdb->get_results( "SELECT `term_taxonomy_id` FROM `wp_term_relationships` WHERE `object_id` = ".$value, OBJECT );
						//print_r($term_taxonomy_id);
						foreach($term_taxonomy_id as $term_id){
						$terms_id = $wpdb->get_results( "SELECT `term_id` FROM `wp_term_taxonomy` WHERE `taxonomy` = 'pa_location' && `term_taxonomy_id` = ".$term_id->term_taxonomy_id, OBJECT );
						//print_r($terms_id);
						$terms_name = $wpdb->get_results( "SELECT `name` FROM `wp_terms` WHERE `term_id` = ".$terms_id[0]->term_id, OBJECT );
						//print_r($terms_name);
						if(!empty($terms_name[0]->name)){
							echo $terms_name[0]->name."</p>";
						}
						}
						echo "<span class='rvw-hldr'>".$yotpo_div;
						echo "<i>$ ".$price." Per Class</i></div>";
						/*--get location end--*/
						?>
					</td>
					<td width="10%" class="td_img"><div class="prdct-tbl-td">
						<ul><?php foreach($attr as $attribute){
							//print_r($attribute);
						 echo "<li class=".$attribute['name']."></li>"; 
						} ?></ul></div>
					</td>
					<td width="10%" class="td_img"><div class="prdct-tbl-td">
						<?php if (has_post_thumbnail( $value ) ): ?>
						  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $value ), 'single-post-thumbnail' ); ?>
						  <img src="<?php echo $image[0]; ?>">
						  </div>
						<?php endif; ?>
					</td>
					<td style="vertical-align: middle;" width="8%"><div class="prdct-tbl-td">
					<?php if($pay_vendor != "No"){?>
						<form id="form<?php echo $count; ?>" class="cart" enctype="multipart/form-data" method="post" action="/sport-bag-cart/">
						<input id="wc_bookings_field_persons" type="hidden" name="wc_bookings_field_persons" max="1" min="1" step="1" value="1">
						<input id="wc_bookings_field_start_date" type="hidden" name="wc_bookings_field_start_date_yearmonth" value="2014-12">
						<input type="hidden" value="<?php echo $value; ?>" name="add-to-cart">
						<a class="button add_to_cart_button product_type_booking" onclick="document.getElementById('form<?php echo $count; ?>').submit();">Add Class</a>
						<!--a href="<?php// echo do_shortcode( '[add_to_cart_url id="'.$value.'"]' ); ?>">Add Class</a-->
						</form></div>
					<?php } ?>
					</td>
				</tr>
		<?php $count++; } ?>
	</table>
</div>
<?php
}
?>
