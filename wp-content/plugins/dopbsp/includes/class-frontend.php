<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/class-frontend.php
* File Version            : 1.0
* Created / Last Modified : 10 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO front end PHP class.
*/

    if (!class_exists('DOPBSPFrontEnd')){
        class DOPBSPFrontEnd{
            /*
             * Constructor
             */
            function DOPBSPFrontEnd(){
                add_action('wp_enqueue_scripts', array(&$this, 'addStyles'));
                add_action('wp_enqueue_scripts', array(&$this, 'addScripts'));
            }
            
            /*
             * Add plugin's CSS files.
             */
            function addStyles(){
                global $DOPBSP;
                
                /*
                 * Register styles.
                 */
                wp_register_style('DOPBSP-css-dopselect', $DOPBSP->paths->url.'libraries/css/jquery.dop.Select.css');

                /*
                 * Enqueue styles.
                 */
                wp_enqueue_style('DOPBSP-css-dopselect');
            }
            
            /*
             * Add plugin's JavaScript files.
             */
            function addScripts(){
                global $DOPBSP;
                
                wp_register_script('DOP-js-jquery-dopselect', $DOPBSP->paths->url.'libraries/js/jquery.dop.Select.js', array('jquery'));
                wp_register_script('DOPBSP-js-frontend-calendar', $DOPBSP->paths->url.'assets/js/jquery.dop.frontend.BSPCalendar.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-frontend-search', $DOPBSP->paths->url.'assets/js/jquery.dop.frontend.BSPSearch.js', array('jquery'), false, true);

                // Enqueue JavaScript.
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                    wp_enqueue_script('jquery-ui-datepicker');
                }
                
                if (!wp_script_is('jquery-ui-slider', 'queue')){
                    wp_enqueue_script('jquery-ui-slider');
                }
                
                wp_enqueue_script('DOP-js-jquery-dopselect');
                wp_enqueue_script('DOPBSP-js-frontend-calendar');
                wp_enqueue_script('DOPBSP-js-frontend-search');
            }
        }
    }