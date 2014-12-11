<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
Template Name: Booked2

*/
global $woo_options;
?>

   
		 			<?php
		 				$order_id 		= '';
		 				$pass_used 		= '';
		 				$max_pass 		= '';
		 				$product_name 	= ''; 				
		 				$user_name 		= "";		 			
		 				if(isset($_POST['order_id']) && ($_POST['user_id'])){
		 					//print_r($_POST);		 					
		 					$order_id = $_POST['order_id'];		 					
		 					$pass_used = $_POST['pass_used'];
		 					$max_pass = $_POST['max_pass'];
							$pass_used = $pass_used + 1;
							$user_id = $_POST['user_id'];
		 					$product_id = $_POST['product_id'];
							$user_info = get_userdata($_POST['user_id']);
							$user_name = $user_info->user_login;
							$product_name = $_POST['product_name'];
							$wpdb->query( $wpdb->prepare( "UPDATE wp_pass_section SET pass_used = $pass_used WHERE order_id = $order_id") );
							echo "<div class='pass_details'><p>".$user_name." payed for a ".$max_pass." classes on ".$product_name." product</p><br>"; 			
							?>
			 				<div class="passes"><?php echo $pass_used; ?>/<?php echo $max_pass; ?></div>
		 					<?php echo '<input class="edit_pass3" type="button" value="+" form="form2" order_id = "'.$order_id.'" product_id = "'.$product_id.'" product_name = "'.$product_name.'" user_id = "'.$user_id.'" pass_used = "'.$pass_used.'" max_pass = "'.$max_pass.'" />';?>

		 				<?php } ?>
<script type="text/javascript" class="init">
		$(document).ready(function() {			
			$('.edit_pass3').click(function(){       		
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
.edit_pass3 {
    background: none repeat scroll 0 0 #000;
    border: 1px solid;
    color: #fff;
    font-size: 24px;
    padding: 6px;
}
</style>

