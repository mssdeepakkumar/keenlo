<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
Template Name: home result
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
?>

    <div id="content" class="page">

        <div class="wrapper">
 <?php 




?> 

<?php woo_main_before(); ?>


<style>
ul .pa_location,
ul .pa_feed-or-not {
    display: none !important;
}

#main{
width : auto;
margin 0 auto;
float : none;
}

.week_days .menu-item{
    background: #F8C57F;
    display: inline-block;
    height: 35px;
    margin-right: 5px;
    width: 150px;
}

.page-template-homeresult-php .content {
    margin: 0 auto;
    text-align: center;
    width: auto;
}

.prdct-tbl-td a:hover {
     cursor: pointer;
}
.prdct-tab li {
    margin-right: 5px !important;
}
#main .week_days .selected {
    background: none repeat scroll 0 0 #f3931f;
}
#main .prdct-tab #ap-pt-tab-vendor {
    display: block !important;
}
</style>
<script>
$(".week_days .menu-item").click(function(){
	alert('asda');
//$(this).addClass('selected');
});
</script>
<section id="main">	
    <div class="prdct-tab">
	    <div class="prdt-lst-tab">
			<div class="woocommerce-tabs list-tab">
				<ul class="tabs maintop">
					
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
echo '<li><a id = "date0" class="'.$date_d.'" href="#'.$date_d.'">'.date("D d", strtotime($date))."th </a></li>";
//echo $date = "2014-10-17";
$n = 7;
for ($i=1; $i<=$n ; $i++) { 		
	if($i == 1){   
	 	$date_c = date("D d", strtotime('+1 day', strtotime($date)));
	 	$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
	 echo '<li><a id = "date1" class="'.$date_d.'" href="#'.$date_d.'">'.$date_c."th </a></li>";
	 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
	}
	if($i == 2){   
		$date_c = date("D d", strtotime('+1 day', strtotime($date)));
		$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
	 echo '<li><a id = "date2" class="'.$date_d.'" href="#'.$date_d.'">'.$date_c."th </a></li>";
	 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
	}
	if($i == 3){   
		$date_c = date("D d", strtotime('+1 day', strtotime($date)));
		$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
	 echo '<li><a id = "date3" class="'.$date_d.'" href="#'.$date_d.'">'.$date_c."th </a></li>";
	 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
	}
	if($i == 4){   
		$date_c = date("D d", strtotime('+1 day', strtotime($date)));
		$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
	 echo '<li><a id = "date4" class="'.$date_d.'" href="#'.$date_d.'">'.$date_c."th </a></li>";
	 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
	}
	if($i == 5){   
		$date_c = date("D d", strtotime('+1 day', strtotime($date)));
		$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
	 echo '<li><a id = "date5" class="'.$date_d.'" href="#'.$date_d.'">'.$date_c."th </a></li>";
	 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
	}
	if($i == 6){   
		$date_c = date("D d", strtotime('+1 day', strtotime($date)));
		$date_d = date("Y-m-d", strtotime('+1 day', strtotime($date)));
	 echo '<li><a id = "date6" class="'.$date_d.'" href="#'.$date_d.'">'.$date_c."th </a></li>";
	 $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
	}	
	
}


?>
					
				</ul>
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
							<div class="location_drop_down">
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
									echo "<form action='/result/' method='GET'><select id='mySelect' onchange='myFunction()'>" ;
									//echo "<option value=''>Bondi</option>";
									foreach( $locate as $locat ) {
										$loc_name = $locat[0]->name;
										echo "<option value=".$locat[0]->term_id.">$loc_name</option>";
									}
									echo "</select></form>"
								?>
							</div>
						</div>
						  <script type="text/javascript">
						      // jQuery("#mySelect").selectbox();	
						       function myFunction() {
								    var x = document.getElementById("mySelect").value;
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

								}			  
						 </script>
						<div class="panel entry-content" id="ap-pt-tab-vendor">
							<div id="result" class = "table-responsive"></div>		
						</div>
					<?php
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

					?>
					<script>
					$(document).ready(function(){
						$(".list-tab.woocommerce-tabs > ul.tabs > li > a").click(function(){
								var click_date = $(this).attr("class");
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
//for default loading..
						var click_date = $(".tabs > li:first-child a").attr("class");
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

					</div>
				</div>
			</div>

    		</section><!-- /#main -->

    		<?php woo_main_after(); ?>

            <?php// get_sidebar(); ?>

        </div><!-- /.wrapper -->

        <?php // comments_template(); ?>

    </div>
    </div>
    </div><!-- /#content -->

<?php get_footer(); ?>
