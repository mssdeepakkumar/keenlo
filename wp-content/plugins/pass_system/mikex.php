<?php/*Plugin Name: Woocomerces Pass DetailsPlugin URI: http://www.mastersoftwaresolutions.com/Description: Plugin for listing all the users passes with their purchased itemsVersion: 1.0Author:  Author URI: http://www.mastersoftwaresolutions.com/License: GPl2*//* We need to make sure our functions can be seen! */include_once dirname(__FILE__) . '/functions.php';/* The following events are not saved and must be executed on each page load */register_activation_hook( __FILE__, "mikex_activated2");register_deactivation_hook( __FILE__, "mikex_deactivated2");/* This action will call the function to create a menu button */add_action('admin_menu', 'mikex_add_menu_page2');/* This will load our admin panel javascript and CSS */add_action('admin_enqueue_scripts', 'mikex_admin_scripts2');/* This will load the scripts on the client side for interaction */add_action('wp_enqueue_scripts', 'mikex_client_scripts2');/* This shortcode allows us to run a function on the content of each post   before it is displayed */$options = get_option('mikex_opts');add_shortcode($options['search'], 'mikex_replace_keyword2');	?>