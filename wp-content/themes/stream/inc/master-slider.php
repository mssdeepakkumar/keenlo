<?php

/*
Plugin Name: Master Slider
Plugin URI:  http://f-d.com.au
Description: A simple plugin that integrates Master Slider
Author: Heath Taskis
Version: 1.0
Author URI: http://f-d.com.au
*/
//define('MSTR_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('MSTR_NAME', "Master Slider");
define ("MSTR_VERSION", "1.0");
//JS
    wp_enqueue_script( 'masterslider-js', get_template_directory_uri().'/js/masterslider.min.js',array(),'20131031',true);         
    wp_enqueue_script( 'masterslider-flickr-js', get_template_directory_uri().'/js/masterslider.flickr.min.js',array(),'20131031',true);       

//CSS
    wp_enqueue_style( 'masterslider', get_template_directory_uri().'/css/masterslider.css', array(), '20131002');    
    wp_enqueue_style( 'masterslider-skins', get_template_directory_uri().'/css/skins/default/style.css', array(), '20131002');    
?>
