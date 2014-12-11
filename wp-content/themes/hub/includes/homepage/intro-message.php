<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Intro Message Component
 *
 * Display a Intro Message
 *
 * @author Tiago
 * @since 1.0.0
 * @package WooFramework
 * @subpackage Component
 */

$settings = array(
				'homepage_intro_message_heading' => '',
				'homepage_intro_message_content' => '',
				'homepage_intro_message_button_label' => '',				
				'homepage_intro_message_button_url' => ''
			);
					
$settings = woo_get_dynamic_values( $settings );

?>

<section id="intro-message" class="home-section">
<script type="text/javascript">
$(document).ready(function(){
  $('.bxslider').bxSlider({
  auto: true,
  speed:3000,
  autoControls: true
	}); 
});
</script>
<script type="text/javascript" src="https://keenlo.com/wp-content/themes/hub/includes/js/jquery.selectbox-0.2.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://keenlo.com/wp-content/themes/hub/includes/js/jquery.bxslider.js"></script>
<script>
// A $( document ).ready() block.
$( document ).ready(function() {	
	$("#dropdown_product_cat").val(13).find("option[value=13]").attr('selected', true);
	$("#dropdown_location").val(66).find("option[value=66]").attr('selected', true);
});
</script>
<style>
.sliderr .bxslider{
height:410px;
overflow:hidden;
}
.wrapper {
    z-index: 9999;
}
.bxslider li{
width:100%; list-style-type:none;
}
#intro-message{
padding:0;
background : none;
}
.bx-viewport{
height:auto !important;
}
.bx-pager.bx-default-pager,
.bx-controls-auto{
display:none;
}
.bxslider{
margin:0;
}

.bx-next {
    float: right;
    right: 0px;
    position: absolute;
    top: 170px;
	padding:30px;
	border-radius: 5px 0 0 5px;
	-webkit-border-radius: 5px 0 0 5px;
	-ms-border-radius: 5px 0 0 5px;
	text-indent:-200px;
	overflow:hidden;
}

.bx-controls-direction {
    display: none;
}

.bx-prev {
    float: left;
    left: 0px;
	border-radius: 0 5px 5px 0;
	-webkit-border-radius: 0 5px 5px 0;
	-ms-border-radius: 0 5px 5px 0;
    position: absolute;
    top: 170px;
	padding:30px;
	text-indent:-200px;
	overflow:hidden;
}

#content .wrapper .sbHolder:nth-child(9),
#content .wrapper .sbHolder:nth-child(11) {
    width: 145px;
}

</style>

<div class="sliderr">
<ul class="bxslider">


<?php
global $wpdb;
$slide = $wpdb->get_results( 'SELECT `post_content` FROM wp_posts WHERE  `post_type` = "slide" && `post_status` = "publish"', OBJECT );
$count =1;
foreach($slide as $slid){
echo "<li class = 'bxslid".$count."'>$slid->post_content</li>";
$count++;
}
?>
  </ul>
</div>
	<div class="wrapper" style="position: absolute; top: 40px; left: 0px; right: 0px; text-align:center;">

		<?php if ( '' != $settings['homepage_intro_message_heading'] ): ?>
			<h2 class="infointro"><?php echo esc_attr( $settings['homepage_intro_message_heading'] ); ?></h2>
		<?php endif; ?>

		<?php if ( '' != $settings['homepage_intro_message_content'] ): ?>
			<?php echo wpautop( esc_attr( $settings['homepage_intro_message_content'] ) ); ?>
		<?php endif; ?>		

		<?php if ( ( '' != $settings['homepage_intro_message_button_label'] ) && ( '' != $settings['homepage_intro_message_button_url'] ) ): ?>

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


<?php endif; ?> 


	
</div><!-- /.wrapper -->

</section><!-- /#intro-message -->
