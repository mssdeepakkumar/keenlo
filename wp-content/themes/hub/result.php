<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
Template Name: Result
 */
include_once 'wp-config.php';
global $wpdb;
 get_header();
 global $woo_options;
?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/result_layout.css" type="text/css" />

<div id="content" class="col-full">
<div class = "layout-full">
    	<div class="wrapper">
    		<?php woo_main_before(); ?>
			<section id="main" class="col-left">
				
				<!-- home page data -->
				<!--form action="" name="myForm" method="POST"-->
				<script type="text/javascript">
						jQuery(function () {
							jQuery("#dropdown_product_cat").selectbox();
							jQuery("#dropdown_location").selectbox();
							jQuery("#week_days").selectbox();
							jQuery("#home_activity").selectbox();

						});
				</script>
				<!-- First drop down -->
				<?php $args = array(
				    'number'     => $number,
				    'orderby'    => $orderby,
				    'order'      => $order,
				    'hide_empty' => $hide_empty,
				    'include'    => $ids
				);

				$product_categories = get_terms( 'product_cat', $args );
				echo "<select id='dropdown_product_cat' class='select' name='product_cat'>" ;
				//echo "<option value=''>Yoga</option>";
				foreach( $product_categories as $cat ) {
				echo "<option value=".$cat->term_id.">$cat->name</option>";
				}
				echo "</select>";
				/*--Second drop down--*/
				$terms_id = array();
				global $wpdb;
				$resul = $wpdb->get_results( 'SELECT * FROM wp_term_taxonomy WHERE taxonomy = "pa_location"', OBJECT );
				foreach($resul as $res){
				$term_id[] = $res->term_id;
				}
				$locate = array();
				foreach ($term_id as $val) {
					$locate[] = $wpdb->get_results( 'SELECT * FROM wp_terms WHERE term_id ='.$val);	
				}
				echo "<select id='dropdown_location' class='select' name='location'>" ;
				//echo "<option value=''>Bondi</option>";
				foreach( $locate as $locat ) {
					$loc_name = $locat[0]->name;
					echo "<option value=".$locat[0]->term_id.">$loc_name</option>";
				}
				echo "</select>";
				?>
				<!-- Third drop down -->
											<select id="week_days">						
												<?php
													$paymentDate = "";
													// set current date
													$date = date('m/d/Y l');
													// parse about any English textual datetime description into a Unix timestamp
													$ts = strtotime($date);
													// calculate the number of days since Monday
													$dow = date('w', $ts);
													$offset = $dow - 1;
													if ($offset < 0) {
													    $offset = 6;
													}
													// calculate timestamp for the Monday
													$ts = $ts - $offset*86400;
													$date = date("Y-m-d");
													$date_c = date("D d", strtotime('+1 day', strtotime($date)));
													$date_d = date("Y-m-d", strtotime($date));
													echo '<option id = "date0" value="'.$date_d.'" >'.date("D d", strtotime($date))."th </option>";
													//echo $date = "2014-10-17";
													$n = 7;
													for ($i=1; $i<=$n ; $i++) { 		
														if($i == 1){   
														 	$date_c = date("D d", strtotime('+1 day', strtotime($date)));
														 	$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
														 echo '<option id = "date1" value="'.$date_d.'">'.$date_c."th </option>";
														 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
														}
														if($i == 2){   
															$date_c = date("D d", strtotime('+1 day', strtotime($date)));
															$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
														 echo '<option id = "date2" value="'.$date_d.'" >'.$date_c."th </option>";
														 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
														}
														if($i == 3){   
															$date_c = date("D d", strtotime('+1 day', strtotime($date)));
															$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
														 echo '<option id = "date3" value="'.$date_d.'" >'.$date_c."th </option>";
														 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
														}
														if($i == 4){   
															$date_c = date("D d", strtotime('+1 day', strtotime($date)));
															$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
														 echo '<option id = "date4" value="'.$date_d.'" >'.$date_c."th </option>";
														 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
														}
														if($i == 5){   
															$date_c = date("D d", strtotime('+1 day', strtotime($date)));
															$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
														 echo '<option id = "date5" value="'.$date_d.'" >'.$date_c."th </option>";
														 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
														}
														if($i == 6){   
															$date_c = date("D d", strtotime('+1 day', strtotime($date)));
															$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
														 echo '<option id = "date6" value="'.$date_d.'" >'.$date_c."th </option>";
														 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
														}											
													}
													?>					
												</select>

					<select id="home_activity">
						<option value="pa_morning">Morning</option>
						<option value="pa_afternoon">Afternoon</option>
						<option value="pa_evening">Evening</option>
					</select>


				<input type="hidden" value="product" name="post_type">
				<input type="button" class="button sbmt-srch" id = "submit_frm" value="GO">
				</form>
				<div id="sltt"></div>
				<script>
				  jQuery('#submit_frm').click(function(){

				var prdct =   jQuery('#dropdown_product_cat').val();
				var loc =   jQuery('#dropdown_location').val();
				var day =   jQuery('#week_days').val();
				var act =   jQuery('#home_activity').val();
				var url = " <?php get_template_directory_uri(); ?>/result.php";
				                    jQuery.ajax(
				             {
				                url : url,
				                type: "POST",
				                data : { prdct:prdct, loc:loc, act:act, day:day },
				                success:function(data) {
							        //jQuery("#sltt").html(data); 
									var urll = "/result/"+data;
									window.location = urll;
				               },
				                failure: function( data ) {
				                alert( "fail: ");
				                   }
				                });
				 });
				</script>

				<!-- end home page -->


				<header class="archive-header">
					<h1><?php echo "Search results: $caty $locy " ; ?></h1>
					<div class="for_admin">
						<?php
						if ( is_user_logged_in() ) { $current_user = wp_get_current_user();	?>
							<div class="p-user-hoder">							
								<?php 
								$filename = '/wp-content/uploads/vendore_images/'.$current_user->ID.'/profileimage.jpg';
								if (file_exists($filename)) {?>							
									<img src ="<?php echo '/wp-content/uploads/vendore_images/'.$current_user->ID.'/profileimage.jpg'; ?>" >
								<?php }else{
									echo get_avatar( $current_user->ID);								
								} ?>
							</div>
						<?php } 
						if (is_super_admin()){
							?>
							<div class="pay_vendor2">
								<div class="pay_vendor_inner2">
									<select id="payvendor2">
										<option value="0">Is Payed Vendor</option>
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
							</div>
							<?php
								
						}else{
							
						}
						?>
					</div>
				</header>
				<div class="fix"></div>
							  

				<?php
					/*--get search values--*/
					$product_cat = $_GET['cat'];
					$location = $_GET['loc'];
					$day = $_GET['day'];
					$day = str_replace("d", "", $day);
					$act = $_GET['act'];

					$catt = $wpdb->get_results( 'SELECT name FROM wp_terms WHERE term_id = '.$product_cat );
					$locc = $wpdb->get_results( 'SELECT name FROM wp_terms WHERE term_id = '.$location );
				 	$caty = $catt[0]->name;
				 	$locy = $locc[0]->name;

				/*--for product_cat--*/
				if(!empty($product_cat)){
					$merg = $wpdb->get_results( 'SELECT * FROM wp_term_taxonomy WHERE term_id = '.$product_cat );
					$term_tax_id = array();					
					foreach($merg as $single_merg){
					$term_tax_id[] =$single_merg->term_taxonomy_id;
						}
					$object_id = array();
					foreach ($term_tax_id as $klue) {	
						$last = $wpdb->get_results( 'SELECT * FROM wp_term_relationships WHERE term_taxonomy_id = '.$klue );	
						foreach ($last as $keue) {
							$object_id[] = $keue->object_id;
						}
					}
					$resultt = $object_id;
					$asdf = array();					
					foreach ($resultt as $vlue) {
					$is_sngl = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_status = "publish" AND post_type = "product" AND id ='.$vlue);
							foreach ($is_sngl as $alue) {
								$asdf[] = $alue->ID;
							}
					}
				}					
				//print_r($asdf);
				
				/*--for location--*/
				if(!empty($location)){	
					$merg2 = $wpdb->get_results( 'SELECT * FROM wp_term_taxonomy WHERE term_id = '.$location );
					$term_tax_id2 = array();
					foreach($merg2 as $single_merg){
					$term_tax_id2[] =$single_merg->term_taxonomy_id;
					}
					$object_id2 = array();
					foreach ($term_tax_id2 as $klue) {
						$last = $wpdb->get_results( 'SELECT * FROM wp_term_relationships WHERE term_taxonomy_id = '.$klue );	
						foreach ($last as $keue) {
							$object_id2[] = $keue->object_id;
						}
					}
					$resultt2 = $object_id2;
					$asdf2 = array();
					foreach ($resultt2 as $vlue) {
					$is_sngl = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_status = "publish" AND post_type = "product" AND id ='.$vlue);
							foreach ($is_sngl as $alue) {
								$asdf2[] = $alue->ID;
							}
					}
				}
				//print_r($asdf2);

				/*--for activity--*/
				if(!empty($act)){	
					$merg2 = $wpdb->get_results( 'SELECT `term_taxonomy_id` FROM wp_term_taxonomy WHERE taxonomy = "'.$act.'"' );
					$klue = $merg2[0]->term_taxonomy_id;							
					$last = $wpdb->get_results( 'SELECT `object_id` FROM wp_term_relationships WHERE term_taxonomy_id = '.$klue );											
					$asdf3 = array();
					foreach ($last as $vlue) {
						$asdf3[] = $vlue->object_id;
					}
				}
				//print_r($asdf3);

				/*--for day--*/
				$curent_date = $day;				
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
				$asdf4 = array();
				foreach ($myposts as $key => $value) {
					$post_id = $value->ID;
					$meta_value = $wpdb->get_results( "SELECT `meta_value` FROM `wp_postmeta` WHERE `meta_key` = '_wc_booking_availability' && `post_id` = ".$value->ID, OBJECT );
					$meta_val = unserialize($meta_value[0]->meta_value);
					$feed_list = $wpdb->get_results( "SELECT * FROM `wp_term_relationships` WHERE `term_taxonomy_id` = '147' && `object_id` = ".$value->ID, OBJECT );	
					foreach ($meta_val as $key => $value) {
							if($value['bookable'] == "yes"){			
								if ($curent_date >= $value['from'] && $curent_date <= $value['to']){
									if(!empty($feed_list)){					  	
									  	$asdf4[] = $feed_list[0]->object_id;									  	
								}
							}
						}
					}
				}
				//print_r($asdf4);
				/*--end--*/

				$result = array_intersect($asdf, $asdf2, $asdf3, $asdf4);
				//print_r($result);


				if(!empty($location) && !empty($product_cat)) {
/*---------------11--------------*/
				$aal = array();
				foreach ($result as $vlue) {
					$is_sngl = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_status = "publish" AND post_type = "product" AND id ='.$vlue);
					foreach($is_sngl as $as){
					$aal[] = $as;		
					}	
				}
					$is_sngl = $aal;					
					$cont = count($is_sngl);
					echo "<p class='woocommerce-result-count'> Showing all $cont results</p>";
					?>
					<!-- New Search Start -->
				 	<div class="prdct-tab">
	    				<div class="prdt-lst-tab">
							<div class="woocommerce-tabs list-tab">
								<div class="head_top">
								<div class="tabs_maintop2">
									<div class="tabs_maintop_inner2">
									<select id="maintop_result2">						
									<?php
									$paymentDate = "";
									// set current date
									$date = date('m/d/Y l');
									// parse about any English textual datetime description into a Unix timestamp
									$ts = strtotime($date);
									// calculate the number of days since Monday
									$dow = date('w', $ts);
									$offset = $dow - 1;
									if ($offset < 0) {
									    $offset = 6;
									}
									// calculate timestamp for the Monday
									$ts = $ts - $offset*86400;
									$date = date("Y-m-d");
									$date_c = date("D d", strtotime('+1 day', strtotime($date)));
									$date_d = date("Y-m-d", strtotime($date));
									echo '<option id = "date0" value="'.$date_d.'" >'.date("D d", strtotime($date))."th </option>";
									//echo $date = "2014-10-17";
									$n = 7;
									for ($i=1; $i<=$n ; $i++) { 		
										if($i == 1){   
										 	$date_c = date("D d", strtotime('+1 day', strtotime($date)));
										 	$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
										 echo '<option id = "date1" value="'.$date_d.'">'.$date_c."th </option>";
										 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
										}
										if($i == 2){   
											$date_c = date("D d", strtotime('+1 day', strtotime($date)));
											$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
										 echo '<option id = "date2" value="'.$date_d.'" >'.$date_c."th </option>";
										 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
										}
										if($i == 3){   
											$date_c = date("D d", strtotime('+1 day', strtotime($date)));
											$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
										 echo '<option id = "date3" value="'.$date_d.'" >'.$date_c."th </option>";
										 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
										}
										if($i == 4){   
											$date_c = date("D d", strtotime('+1 day', strtotime($date)));
											$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
										 echo '<option id = "date4" value="'.$date_d.'" >'.$date_c."th </option>";
										 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
										}
										if($i == 5){   
											$date_c = date("D d", strtotime('+1 day', strtotime($date)));
											$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
										 echo '<option id = "date5" value="'.$date_d.'" >'.$date_c."th </option>";
										 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
										}
										if($i == 6){   
											$date_c = date("D d", strtotime('+1 day', strtotime($date)));
											$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
										 echo '<option id = "date6" value="'.$date_d.'" >'.$date_c."th </option>";
										 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
										}											
									}
									?>					
								</select>
							</div>
							</div>
							<div class="location_drop_down2">
								<?php
								global $wpdb;
									$resul = $wpdb->get_results( 'SELECT * FROM wp_term_taxonomy WHERE taxonomy = "pa_location"', OBJECT );
									foreach($resul as $res){
									$term_id[] = $res->term_id;
									}
									$locate = array();
									foreach ($term_id as $val) {
										$locate[] = $wpdb->get_results( 'SELECT * FROM wp_terms WHERE term_id ='.$val);	
									}
									echo "<form action='/result/' method='GET'><select id='mySelect2'>" ;
									//echo "<option value=''>Bondi</option>";
									foreach( $locate as $locat ) {
										$loc_name = $locat[0]->name;
										echo "<option value=".$locat[0]->term_id.">$loc_name</option>";
									}
									echo "</select></form>"
								?>
							</div>
						
							</div>
				<div class="panel entry-content" id="pt-tab-vendor">
					<div class="woocommerce-tabs sub-tab-list">
						<div class="head_top">
							<ul class="tabs daylisting">
								<li>
									<a id="pa_morning" href="#"> Morning</a>
								</li>
								<li >
									<a id="pa_afternoon" href="#">Afternoon</a>
								</li>
								<li>
									<a id="pa_evening" href="#">Evening</a>
								</li>
							</ul>							
						</div>
						<div class="panel entry-content" id="ap-pt-tab-vendor">
							<div id="results" class = "table-responsive"></div>
							<div class="panel entry-content" id="ap-pt-tab-vendor">
								
						<table id="result">
							<?php
							$count = 0;
							foreach ($is_sngl as $key => $value) {	
								//print_r($value);		
								$meta_value = $wpdb->get_results( "SELECT `meta_value` FROM `wp_postmeta` WHERE `meta_key` = '_wc_booking_availability' && `post_id` = ".$value->ID, OBJECT );
								//print_r($meta_value);
								$meta_val = unserialize($meta_value[0]->meta_value);
								$product = get_post($value->ID);
								$vendors = get_product_vendors( $product->ID );
								$meta_values = get_post_meta( $value->ID );
								$price = $meta_values['_price'][0];
								$attr = unserialize($meta_values['_product_attributes'][0]);				
							
								?>
									<tr>
										<td width="5%"><div class="prdct-tbl-td"><h4><?php foreach($meta_val as $meta){
												 if($meta['bookable'] == 'yes'){ 	
													echo $meta['from']."<br>";
													//echo $meta['to'];
													 }
												 } ?></h4></div>
										</td>
										<td width="9%"><div class="prdct-tbl-td"><h3><a href="<?php echo $vendors[0]->url; ?>" target="_blank"><?php echo $vendors[0]->title; ?></a></h3></div></td>
										<td width="7%" class="td_img"><div class="p-user-hoder"><a href="<?php echo $vendors[0]->url; ?>" target="_blank"><img src ="<?php echo '/wp-content/uploads/vendore_images/'.$vendors[0]->ID.'/profileimage.jpg'; ?>" ></a></div></td>
										<td width="23%"><div class="prdct-tbl-td"><p><strong><?php echo $product->post_title."</strong> ";			
											/*--get location--*/
											$term_taxonomy_id = $wpdb->get_results( "SELECT `term_taxonomy_id` FROM `wp_term_relationships` WHERE `object_id` = ".$value->ID, OBJECT );
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
											<?php if (has_post_thumbnail( $value->ID ) ): ?>
											  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $value->ID ), 'single-post-thumbnail' ); ?>
											  <img src="<?php echo $image[0]; ?>">
											  </div>
											<?php endif; ?>
										</td>
										<td style="vertical-align: middle;" width="8%"><div class="prdct-tbl-td">
										<?php $koostis = array_shift( wc_get_product_terms( $value->ID, 'pa_payed-vendors', array( 'fields' => 'names' ) ) );
										if($koostis != "No"){ ?>
											<form id="form<?php echo $count; ?>" class="cart" enctype="multipart/form-data" method="post" action="/sport-bag-cart/">
											<input id="wc_bookings_field_persons" type="hidden" name="wc_bookings_field_persons" max="1" min="1" step="1" value="1">
											<input id="wc_bookings_field_start_date" type="hidden" name="wc_bookings_field_start_date_yearmonth" value="2014-12">
											<input type="hidden" value="<?php echo $value->ID; ?>" name="add-to-cart">
											<a class="button add_to_cart_button product_type_booking" onclick="document.getElementById('form<?php echo $count; ?>').submit();">Add Class</a>
											<!--a href="<?php// echo do_shortcode( '[add_to_cart_url id="'.$value.'"]' ); ?>">Add Class</a-->
											</form></div>
										<?php } ?>						
										</td>				
									</tr>
							<?php $count++; } ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
		<?php
				}else{
/*--------------00--------------*/					
				echo "<p class='woocommerce-info'>No products were found matching your selection.</p>";
				}
				?>
		        <?php woo_loop_after(); ?>
				<?php woo_pagenav(); ?>
	        	</section><!-- /#main -->
	        	<?php woo_main_after(); ?>
            	<?php// get_sidebar(); ?>
        	</div><!-- /.wrapper -->
		</div>
    </div><!-- /#content -->

	  						<script type="text/javascript">
							      // jQuery("#mySelect").selectbox();	
							       $("#mySelect2").change(function(){					       	
									    var x = $(this).val();
	    								console.log(x);
											$.ajax({				
							                url : '<?php bloginfo('template_url'); ?>/data_locations.php',
							                type: "POST",
							                data : { plan_id:x },
							                success:function(data){
							                   $("#result").html(data);
							               	},
							                failure: function( data ) {
							                alert( "fail: ");
							            	}
										});
									});
							</script>

    						<script>
								$(document).ready(function(){
								// for clicked events								
									$("#maintop_result2").change(function(){
										var click_date = $(this).val();
										console.log(click_date);
										$.ajax({				
							                url : '<?php bloginfo('template_url'); ?>/data.php',
							                type: "POST",
							                data : { plan_id:click_date },
							                success:function(data){
							                   $("#result").html(data);
							               	},
							                failure: function( data ) {
							                	alert( "fail: ");
							            	}
										});
									});	
								});

							$(document).ready(function(){
								// for pay vendor
								$("#payvendor2").change(function(){
										var pay_vendor = $(this).val();
										console.log(pay_vendor);
										$.ajax({				
							                url : '<?php bloginfo('template_url'); ?>/data.php',
							                type: "POST",
							                data : { pay_vendor:pay_vendor },
							                success:function(data){
							                   $("#result").html(data);
							               	},
							                failure: function( data ) {
							                alert( "fail: ");
							            	}
										});
								});
							});


						</script>
						
						<script>
						$(document).ready(function(){
							$("#pa_morning, #pa_evening, #pa_afternoon").click(function(){
								var click_id = $(this).attr("id");							
									$("tr").addClass("tabletr");								
									$(".tabletr").each(function(){
										$(this).hide();
										var asd = $(this).attr("class");									
										if($(this).find('.'+click_id).length != 0){										
											$(this).css("display","block");
										}else{
											
										}
									});
								});
							});
						</script>

						<script>
						$(document).ready(function(){
							$(".tabs > li:first-child").addClass("active");
							$(".tabs.maintop > li").click(function(){
								$(".tabs.maintop > li").removeClass("active");						
								$(this).addClass("active");
							});
							$(".tabs.daylisting > li").click(function(){
								$(".tabs.daylisting > li").removeClass("active");						
								$(this).addClass("active");
							});
						});
						</script>
						<script>
						 $(document).ready(function () {
						    $("#mySelect option").mouseover(function () {
						      //$(this).css({ "color": "black"});
						    });
						    
						 });
						 </script>
						 <script type="text/javascript">
								jQuery(function () {									
									jQuery("#maintop_result2").selectbox();
									jQuery("#mySelect2").selectbox();
									jQuery("#payvendor2").selectbox();

								});
						</script>

						 <style>
								.sbHolder{
									border: 2px solid #38BCB6;
								}
								a.sbSelector:hover{
									color: #38BCB6;
								}

								.pay_vendor2 .sbOptions li:nth-child(1){
								    display: none;
								}
								.sbOptions {
									border: 2px solid #f8d1d4;
									border-radius: 3px;

								}
								.pay_vendor2 .sbHolder{
									margin-top: 23px;
								}
								.tabs_maintop2, .location_drop_down2 {
								    display: inline-block;
								    margin: 0 auto;
								    width: auto;
								}

								.pay_vendor2 {
								    display: inline-block;
								}
								.archive-header > h1, .head_top{
									display: none;
								}
						</style>
<?php get_footer(); ?>
