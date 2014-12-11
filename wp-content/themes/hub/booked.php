<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
Template Name: Booked
*/
global $woo_options;
?>
		 			
	 				<?php
		 				if(isset($_POST['order_id']) && ($_POST['user_id'])){
			 				$booked_id = $_POST['booking_id'];
			 				//print_r($_POST);
			 				global $wpdb;
								$results = $wpdb->get_results( 'SELECT * FROM wp_pass_section WHERE order_id = "'.$_POST['order_id'].'"', OBJECT );
							//print_r($results);
							if(!empty($results)){

							}else{
								$wpdb->insert(
								$wpdb->prefix . "pass_section",
								array(						
									'order_id' 		=> $_POST[order_id], 
									'product_id' 	=> $_POST['product_id'],
									'user_id' 		=> $_POST['user_id'],
									'pass_used' 	=> $_POST['pass_used'],
									'max_pass' 		=> $_POST['max_pass']
								)
							);
							
							}
		 					$order_id = $_POST['order_id'];
		 					$pass_used = $_POST['pass_used'];
		 					$user_id = $_POST['user_id'];
		 					$product_id = $_POST['product_id'];
		 					$product_name = $_POST['product_name'];
		 					$max_pass = $_POST['max_pass'];
							$user_info = get_userdata($_POST['user_id']);
							$user_name = $user_info->user_login; 				
		 					echo "<div class='pass_details'><p>".$user_name." payed for a ".$max_pass." classes on ".$product_name." product</p><br>"; 			
		 			?> 
		 					 				
		 				<div class="passes"><?php echo $pass_used; ?>/<?php echo $max_pass; ?></div>		 				
							<?php echo '<input class="edit_pass2" type="button" value="+" form="form2" order_id = "'.$order_id.'" product_id = "'.$product_id.'" product_name = "'.$product_name.'" user_id = "'.$user_id.'" pass_used = "'.$pass_used.'" max_pass = "'.$max_pass.'" />';?>
			            </div>
		 			<?php } ?> 		
		 		

    <script type="text/javascript" class="init">
		$(document).ready(function() {			
			$('.edit_pass2').click(function(){       		
       		var order_id = $(this).attr("order_id");
       		var product_id = $(this).attr("product_id");
       		var product_name =$(this).attr("product_name");
       		var user_id =$(this).attr("user_id");
       		var pass_used =$(this).attr("pass_used");
       		var max_pass =$(this).attr("max_pass");
       		var form =$(this).attr("form");
       		$.ajax({
                url : '<?php echo get_site_url() ?>'+"/woocommerce-search/booked2",
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
    width: 10%;
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
</style>

