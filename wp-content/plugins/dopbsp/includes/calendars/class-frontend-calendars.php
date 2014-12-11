<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/calendars/class-frontend-calendar.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO front end calendar PHP class.
*/

    if (!class_exists('DOPBSPFrontEndCalendars')){
        class DOPBSPFrontEndCalendars extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function DOPBSPFrontEndCalendars(){
                add_action('init', array(&$this, 'init'));
            }

            /*
             * Initialize calendars.
             */
            function init(){
                add_shortcode('dopbsp', array(&$this, 'shortcode'));
            }

            /*
             * Initialize calendars shortcode.
             * 
             * @param atts (array): shortcode attributes
             */
            function shortcode($atts){
                global $wpdb;
                global $DOPBSP;
                
                $data = array();
                
                extract(shortcode_atts(array('class' => 'dopbsp'), $atts));
                                
                if (!array_key_exists('id', $atts)){
                    $atts['id'] = 1;
                }
                                
                if (!array_key_exists('lang', $atts)){
                    $atts['lang'] = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE;
                }
                                
                if (!array_key_exists('woocommerce', $atts)){
                    $atts['woocommerce'] = 'false';
                }
                                
                if (!array_key_exists('woocommerce_product_id', $atts)){
                    $atts['woocommerce_product_id'] = 0;
                }
                                
                if (!array_key_exists('woocommerce_position', $atts)){
                    $atts['woocommerce_position'] = 'summary';
                }
                
                $id = $atts['id'];
                
                /*
                 * Do not display anything if the shortcode is invalid.
                 */
                $calendars = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d',
                                                           $id));
                
                if ($wpdb->num_rows == 0){
                    return false;
                }
                
// HOOK (dopbsp_action_calendar_init_before) ********************************* Add action before calendar init.
                do_action('dopbsp_action_calendar_init_before');
                
// HOOK (dopbsp_frontend_content_before_calendar) ****************************** Add content before calendar.
                ob_start();
                    do_action('dopbsp_frontend_content_before_calendar');
                    $dopbsp_frontend_before_calendar = ob_get_contents();
                ob_end_clean();
                array_push($data, $dopbsp_frontend_before_calendar);
                
                /*
                 * Calendar HTML.
                 */
                array_push($data, '<link rel="stylesheet" type="text/css" href="'.$DOPBSP->paths->url.'templates/'.$DOPBSP->classes->frontend_calendar->getTemplate($id).'/css/jquery.dop.frontend.BSPCalendar.css" />');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, '    jQuery(document).ready(function(){');
                array_push($data, '        jQuery("#DOPBSPCalendar'.$id.'").DOPBSPCalendar('.$DOPBSP->classes->frontend_calendar->getJSON($atts).');');
                array_push($data, '    });');
                array_push($data, '</script>');
                
                array_push($data, '<div class="DOPBSPCalendar-info-message" id="DOPBSPCalendar-info-message'.$id.'">');
                array_push($data, ' <div class="dopbsp-icon"></div>');
                array_push($data, ' <div class="dopbsp-text"></div>');
                array_push($data, ' <div class="dopbsp-timer"></div>');
                array_push($data, ' <a href="javascript:void(0)" onclick="jQuery(\'#DOPBSPCalendar-info-message'.$id.'\').stop(true, true).fadeOut(300)" class="dopbsp-close"></a>');
                array_push($data, '</div>');
                array_push($data, '<div class="DOPBSPCalendar-wrapper notranslate" id="DOPBSPCalendar'.$id.'"><a href="'.admin_url('admin-ajax.php').'"></a></div>');
                
// HOOK (dopbsp_frontend_content_after_calendar) ******************************* Add content after calendar.
                ob_start();
                    do_action('dopbsp_frontend_content_after_calendar');
                    $dopbsp_frontend_after_calendar = ob_get_contents();
                ob_end_clean();
                array_push($data, $dopbsp_frontend_after_calendar);
                
                return implode("\n", $data);
            }
        }
    }