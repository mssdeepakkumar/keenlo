<?php
/*
Template Name: get location products
*/
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Page Template
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
<?php
    print_r($_POST);
    //$term_taxonomy_id = $wpdb->get_results( "SELECT `term_taxonomy_id` FROM `wp_term_relationships` WHERE ".$value, OBJECT );
    //print_r($term_taxonomy_id);
?>
    </div><!-- /#content -->

<?php get_footer(); ?>
