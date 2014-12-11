<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * Override this template by copying it to yourtheme/woocommerce/loop/no-products-found.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
echo "<p class='woocommerce-info'>No products were found matching your selection.></p>";
?>

<!--style>
ul.products li.product:before{
position :relative;
}
</style>
<?php
die("asda");
if(isset($_GET['product_cat']) || isset($_GET['location']) ) {
	
	 $product_cat = $_GET['product_cat'];
	 $location = $_GET['location'];	

global $wpdb;
echo "<pre>";

$product_cat_1 = $wpdb->get_results( 'SELECT * FROM wp_term_taxonomy WHERE term_id = '.$product_cat );
//print_r($product_cat_1);
$location_1 = $wpdb->get_results( 'SELECT * FROM wp_term_taxonomy WHERE term_id = '.$location );
//print_r($location_1);
}
$merg = array();
$merg = array_merge($product_cat_1,$location_1);
print_r($merg); 
$term_tax_id = array();
foreach($merg as $single_merg){
$term_tax_id[] =$single_merg->term_taxonomy_id;
}

$object_id = array();
foreach ($term_tax_id as $klue) {
	//echo $klue;
	$last = $wpdb->get_results( 'SELECT * FROM wp_term_relationships WHERE term_taxonomy_id = '.$klue );	
	/*print_r($last);*/		
	foreach ($last as $keue) {
		$object_id[] = $keue->object_id;
	}
}
//print_r($object_id);
$resultt = array_intersect($post_table, $object_id);
//print_r($resultt);
//echo "<pre>";
$asdf = array();
if (!empty($resultt)) {
	//print_r($resultt);
foreach ($resultt as $vlue) {
	$is_sngl = $wpdb->get_results( 'SELECT * FROM wp_posts WHERE post_status = "publish" AND post_type = "product" AND id ='.$vlue);
	foreach ($is_sngl as $alue) {
		$asdf[] = $alue;
	}
}
$cont = count($asdf);
echo "<p class='woocommerce-result-count'> Showing all $cont results</p>";

//print_r($asdf);
echo "<ul class='products'>";
foreach ($asdf as $kealue) {
	echo "<li class='post-32 product'><a  class = 'sngl_img' href='$kealue->guid'>";
	echo get_the_post_thumbnail($kealue->ID, 'thumbnail'); 	
	echo "</a></li>";
}	
echo "</div>";



}else{
	echo "<p class='woocommerce-info'>No products were found matching your selection.></p>";
}
echo "</pre>";
?-->
