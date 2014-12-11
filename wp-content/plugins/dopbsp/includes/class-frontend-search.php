<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/class-frontend-search.php
* File Version            : 1.0
* Created / Last Modified : 13 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO front end search PHP class.
*/

    if (!class_exists('DOPBSPFrontEndSearch')){
        class DOPBSPFrontEndSearch extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function DOPBSPFrontEndSearch(){
                add_action('init', array(&$this, 'init'));
            }

            /*
             * Initialize search.
             */
            function init(){
                add_shortcode('dopbsps', array(&$this, 'shortcode'));
            }

            /*
             * Initialize calendars shortcode.
             * 
             * @param atts (array): shortcode attributes
             */
            function shortcode($atts){
                global $DOPBSP;
                
                extract(shortcode_atts(array('class' => 'dopbsps'), $atts));
                                
                if (!isset($atts['lang'])){
                    $atts['lang'] = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE;
                }
                
                $calendarsData = $this->getSearch($atts['lang']);
                $settings = $calendarsData['settings'];
                $text = $calendarsData['text'];
                $options = $calendarsData['options'];
                $text = $calendarsData['text'];
                
                $data = array();
                
// HOOK (dopbsp_action_search_init_before) ********************************* Add action before search init.
                do_action('dopbsp_action_search_init_before');
                
// HOOK (dopbsp_frontend_content_before_search) ****************************** Add content before search.
                ob_start();
                    do_action('dopbsp_frontend_content_before_search');
                    $dopbsp_frontend_before_search = ob_get_contents();
                ob_end_clean();
                array_push($data, $dopbsp_frontend_before_search);
                
                /*
                 * Search HTML.
                 */
                array_push($data, '<link rel="stylesheet" type="text/css" href="'.$DOPBSP->paths->url.'templates/'.$DOPBSP->classes->frontend_calendar->getTemplate($settings['template_id']).'/css/jquery.dop.frontend.BSPCalendar.css" />');
                array_push($data, '<link rel="stylesheet" type="text/css" href="'.$DOPBSP->paths->url.'templates/'.$DOPBSP->classes->frontend_calendar->getTemplate($settings['template_id']).'/css/jquery.dop.frontend.BSPSearch.css" />');
                
                array_push($data, '<div class="DOPBSPSearch" id="DOPBSPSearch">');
                array_push($data, ' <div class="DOPBSPSearch-sidebar">');
                array_push($data, '     <div class="DOPBSPSearch-title">'.$text['search'].'</div>');
                array_push($data, '     <input type="text" id="DOPBSP_start_date" class="DOPBSP-date" placeholder="'.$text['checkIn'].'"/>');
                array_push($data, '     <input type="text" id="DOPBSP_end_date" class="DOPBSP-date" placeholder="'.$text['checkOut'].'"/>');
                array_push($data, '     <div class="DOPBSP-hours">');
                array_push($data, '         <div class="DOPBSP-hour">');
                array_push($data, '             <div class="DOPBSP-hour-title">'.$text['hourStart'].'</div>');
                array_push($data, '             <select type="text" id="DOPBSP_start_hour" class="DOPBSP-hour-select">');
                array_push($data,                   $this->getHours());
                array_push($data, '             </select>');
                array_push($data, '         </div>');
                array_push($data, '         <div class="DOPBSP-hour">');
                array_push($data, '             <div class="DOPBSP-hour-title">'.$text['hourEnd'].'</div>');
                array_push($data, '             <select type="text" id="DOPBSP_end_hour" class="DOPBSP-hour-select">');
                array_push($data,                   $this->getHours());
                array_push($data, '             </select>');
                array_push($data, '         </div>');
                array_push($data, '     </div>');
                array_push($data, '     <br class="DOPBSPCalendar-clear">');
                array_push($data, '     <div class="DOPBSP-prices">');
                array_push($data, '         <div class="DOPBSP-price" id="DOPBSP-price"></div>');
                array_push($data, '     </div>');
                array_push($data, ' </div>');
                array_push($data, ' <div class="DOPBSPSearch-container">');
                array_push($data, '     <div class="DOPBSPSearch-title" style="padding-bottom: 14px;">Sort by');
                array_push($data, '         <select type="text" id="DOPBSP_sort_by" class="DOPBSP-sort-select" disabled="disabled">');
                array_push($data, '             <option value="Price">Price</option>');
                array_push($data, '             <option value="Rating">Rating</option>');
                array_push($data, '         </select>');
                array_push($data, '         <input type="hidden" id="DOPBSP_no_calendars_message" value="'.$text['noServices'].'"/>');
                array_push($data, '         <input type="hidden" id="DOPBSP_no_calendars" value="10"/>');
                array_push($data, '         <input type="hidden" id="DOPBSP_curr_page" value="1"/>');
                array_push($data, '     </div>');
                array_push($data, '     <ul class="DOPBSPSearch-Results" id="DOPBSPSearch-Results">');
                array_push($data, '     </ul>');
                array_push($data, '     <ul class="DOPBSPSearch-Pages" id="DOPBSPSearch-Pages">');
                array_push($data, '     </ul>');
                array_push($data, ' </div>');
                array_push($data, '</div>');
                
                array_push($data, '<script type="text/JavaScript">');
                array_push($data, '    jQuery(document).ready(function(){');
                array_push($data, "        jQuery('#DOPBSPSearch').DOPBSPSearch('".$options."','".$settings['min_price']."','".$settings['max_price']."','".$settings['currency']."','".$settings['currency_code']."');");
                array_push($data, '    });');
                array_push($data, '</script>');
                
// HOOK (dopbsp_frontend_content_after_search) ******************************* Add content after search.
                ob_start();
                    do_action('dopbsp_frontend_content_after_search');
                    $dopbsp_frontend_after_search = ob_get_contents();
                ob_end_clean();
                array_push($data, $dopbsp_frontend_after_search);
                
                return implode("\n", $data);
            }
            
            /*
             * Get search.
             * 
             * @param settings (object): calendar settings
             * 
             * @return data array
             */
            function get(){
                global $DOPBSP;
                    
                return array('data' => array(),
                             'text' => array('checkIn' => $DOPBSP->text('SEARCH_CHECK_IN'),
                                             'checkOut' => $DOPBSP->text('SEARCH_CHECK_OUT'),
                                             'hourEnd' => $DOPBSP->text('SEARCH_END_HOUR'),
                                             'hourStart' => $DOPBSP->text('SEARCH_START_HOUR'),
                                             'noItems' => $DOPBSP->text('SEARCH_NO_ITEMS'),
                                             'noServices' => $DOPBSP->text('SEARCH_NO_SERVICES_AVAILABLE'),
                                             'noServicesSplitGroup' => $DOPBSP->text('SEARCH_NO_SERVICES_AVAILABLE_SPLIT_GROUP'),
                                             'title' => $DOPBSP->text('SEARCH_TITLE')));
            }
            
            
            /*
             * Get search.
             * 
             * @param settings (object): calendar settings
             * 
             * @return data array
             */
            function getSearch($language){
                global $wpdb;
                global $DOPBSP;
                
                $data = array();
                
                $DOPBSP->classes->translation->setTranslation($language);
                
                $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars);
                
                $i = 0;
                $calendarData = array();
                $min_all = 0;
                $max_all = 0;
                $currency = 'USD';
                $currency_code = '$';
                $template_id = 1;
                
                foreach ($calendars as $calendar){
                   $settings = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id=%d',
                                                               $calendar->id));
                    
                   if ($min_all < 1) {
                       $min_all = $calendar->min_price;
                       $currency = $settings->currency;
                       $currency_code = $DOPBSP->classes->currencies->get($settings->currency);
                       $template_id = $calendar->id;
                   }
                   
                   if ($calendar->min_price < $min_all) {
                       $min_all = $calendar->min_price;
                   }
                   
                   if ($max_all < 1) {
                       $max_all = $calendar->max_price;
                   }
                   
                   if ($calendar->max_price > $max_all) {
                       $max_all = $calendar->max_price;
                   }
                   
                   $post_id = $DOPBSP->classes->currencies->get($settings->currency);
                   
                   $calendarData[$i]['calendar_id'] = $calendar->id;
                   $calendarData[$i]['user_id'] = $calendar->user_id;
                   $calendarData[$i]['post_id'] = '';
                   $calendarData[$i]['name'] = $calendar->name;
                   $calendarData[$i]['description'] = '';
                   $calendarData[$i]['image'] = '';
                   $calendarData[$i]['link'] = '';
                   $calendarData[$i]['rating'] = $calendar->rating;
                   $calendarData[$i]['availability'] = str_replace('"',';;;',$calendar->availability);
                   $calendarData[$i]['min_price'] = $calendar->min_price;
                   $calendarData[$i]['max_price'] = $calendar->max_price;
                   
                   if (isset($settings->page_id) && $settings->page_id != "") {
                        $calendarData[$i]['post_id'] = $settings->page_id;
                        // GET POST
                        $post_info = get_post($calendarData[$i]['post_id']); 
                        $calendarData[$i]['name'] = $post_info->post_title;
                        $calendarData[$i]['description'] = $post_info->post_excerpt;
                        $post_image = wp_get_attachment_image_src(get_post_thumbnail_id($calendarData[$i]['post_id'], 'thumbnail'));
                        $calendarData[$i]['image'] = $post_image[0];
                        $calendarData[$i]['link'] = get_permalink($calendarData[$i]['post_id']);
                   }
                   
                   $i++;
                }
                
                return array('options' => json_encode($calendarData),
                             'settings' => array('min_price' => $min_all,
                                                 'max_price' => $max_all,
                                                 'currency' => $currency,
                                                 'currency_code' => $currency_code,
                                                 'template_id' => $template_id),
                             'text' => array('search' => $DOPBSP->text('PARENT_SEARCH'),
                                             'checkIn' => $DOPBSP->text('SEARCH_CHECK_IN'),
                                             'checkOut' => $DOPBSP->text('SEARCH_CHECK_OUT'),
                                             'hourEnd' => $DOPBSP->text('SEARCH_END_HOUR'),
                                             'hourStart' => $DOPBSP->text('SEARCH_START_HOUR'),
                                             'noItems' => $DOPBSP->text('SEARCH_NO_ITEMS'),
                                             'noServices' => $DOPBSP->text('SEARCH_NO_SERVICES_AVAILABLE'),
                                             'noServicesSplitGroup' => $DOPBSP->text('SEARCH_NO_SERVICES_AVAILABLE_SPLIT_GROUP')));
            }
            
            function getHours(){
                $hours = array();
                
                for($i=0;$i<24;$i++) { 
                                    
                    if ($i<10) {
                        $value="0".$i.":00";
                    } else{ 
                        $value=$i.":00";
                    }  
                    array_push($hours, '<option value="'.$value.'">'.$value.'</option>');
                }
                
                return implode("",$hours);
            }
        }
    }