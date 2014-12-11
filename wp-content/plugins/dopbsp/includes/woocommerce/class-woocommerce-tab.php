<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/woocommerce/class-woocommerce-tab.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO WooCommerce back end tab PHP class.
*/

    if (!class_exists('DOPBSPWooCommerceTab')){
        class DOPBSPWooCommerceTab extends DOPBSPWooCommerce{
            /*
             * Constructor.
             */
            function DOPBSPWooCommerceTab(){
                /*
                 * Add tab.
                 */
                add_action('woocommerce_product_write_panel_tabs', array(&$this, 'add'));
                
                /*
                 * Add content to tab.
                 */
                add_action('woocommerce_product_write_panels', array(&$this, 'display'));
                
                /*
                 * Save tab data.
                 */
                add_action('woocommerce_process_product_meta', array(&$this, 'set'));
            }
            
            /*
             * Add booking system in product tabs list.
             * 
             * @return HTML tab button
             */
            function add(){
                global $DOPBSP;
      
                echo '<li class="dopbsp_tab"><a href="#dopbsp_tab_data">'.$DOPBSP->text('WOOCOMMERCE_TAB').'</a></li>';
            }
            
            /*
             * Display tab content.
             * 
             * @return HTML form
             */
            function display(){
                global $post;
                global $DOPBSP;
	
                $dopbsp_woocommerce_options = array('calendar' => get_post_meta($post->ID, 'dopbsp_woocommerce_calendar', true),
                                                    'language' => get_post_meta($post->ID, 'dopbsp_woocommerce_language', true) == '' ? DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE:get_post_meta($post->ID, 'dopbsp_woocommerce_language', true),
                                                    'position' => get_post_meta($post->ID, 'dopbsp_woocommerce_position', true) == '' ? 'summary':get_post_meta($post->ID, 'dopbsp_woocommerce_position', true));	
?>
    <div id="dopbsp_tab_data" class="panel woocommerce_options_panel">
        <div class="options_group">
            <p class="form-field">
<?php 
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_calendar',
                                            'options' => $this->getCalendars(),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_HELP')));
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_language',
                                            'options' => $this->getLanguages(),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_LANGUAGE'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_LANGUAGE_HELP'),
                                            'value' => $dopbsp_woocommerce_options['language']));
                woocommerce_wp_select(array('id' => 'dopbsp_woocommerce_position',
                                            'options' => array('summary' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_SUMMARY'),
                                                               'tabs' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_TABS'),
                                                               'summary-tabs' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_SUMMARY_AND_TABS')),
                                            'label' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION'),
                                            'description' => $DOPBSP->text('WOOCOMMERCE_TAB_POSITION_HELP'),
                                            'value' => $dopbsp_woocommerce_options['position']));
?>
            </p>
        </div>	
    </div>
<?php
            }
            
            /*
             * Set booking system options for selected product.
             * 
             * @param post_id (integer): product ID
             * 
             * @post dopbsp_woocommerce_calendar (integer): calendar ID
             * @post dopbsp_woocommerce_language (string): calendar language
             * @post dopbsp_woocommerce_position (integer): calendar position
             */
            function set($post_id){
                update_post_meta($post_id, 'dopbsp_woocommerce_calendar', $_POST['dopbsp_woocommerce_calendar']);
                update_post_meta($post_id, 'dopbsp_woocommerce_language', $_POST['dopbsp_woocommerce_language']);
                update_post_meta($post_id, 'dopbsp_woocommerce_position', $_POST['dopbsp_woocommerce_position']);
            }
            
            /*
             * Get calendars list.
             * 
             * @return calendars list
             */
            function getCalendars(){
                global $wpdb;
                global $DOPBSP;
                                    
                $calendars_list = array();
                $no_calendars = 0;
                
                /*
                 * If curent user is an administrator and can view all calendars get all calendars.
                 */
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id DESC');
                    $no_calendars = $wpdb->num_rows;
                }
                else{
                    /*
                     * If current user can use the booking system get the calendars he created.
                     */
                    if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                        $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE user_id='.wp_get_current_user()->ID.' ORDER BY id DESC');
                    }

                    /*
                     * If current user has been allowed to use only some calendars.
                     */
                    if (get_user_meta(wp_get_current_user()->ID, 'DOPBSP_permissions_calendars', true) != ''){
                        $calendar_ids = explode(',', get_user_meta(wp_get_current_user()->ID, 'DOPBSP_permissions_calendars', true));
                        $calendar_list = '';
                        $calendars_found = array();
                        $i=0;

                        foreach($calendar_ids as $calendar_id){
                            if ($i < 1){
                                $calendar_list .= $calendar_id;
                            }
                            else{
                              $calendar_list .= ", ".$calendar_id;  
                            }

                            array_push($calendars_found, $calendar_id);
                            $i++;
                        }

                        if ($calendar_list){
                           $calendars_assigned = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id IN ('.$calendar_list.') ORDER BY id DESC');   
                        }
                    }
                    else{
                        $calendars_assigned = $calendars;
                    }
                }
                
                /* 
                 * Create calendars list.
                 */
                if ($no_calendars != 0 
                        || (isset($calendars_assigned) 
                                && count($calendars_assigned) != 0)){
                    $calendars_list[0] = $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_SELECT');
                    
                    if ($calendars){
                        foreach ($calendars as $calendar){
                            if (isset($calendars_found)){
                                if (!in_array($calendar->id, $calendars_found)){
                                    $calendars_list[$calendar->id] = $calendar->name;
                                }
                            }
                            
                            if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                                $calendars_list[$calendar->id] = $calendar->name;
                            }
                        }
                    }
                    
                    if (isset($calendars_assigned)){
                        foreach ($calendars_assigned as $calendar) {
                            $calendars_list[$calendar->id] = $calendar->name;
                        }
                    }
                }
                else{
                    $calendars_list[0] = $DOPBSP->text('WOOCOMMERCE_TAB_CALENDAR_NO_CALENDARS');
                }
                
                return $calendars_list;
            }
            
            /*
             * Get languages list.
             * 
             * @return enabled languages 
             */
            function getLanguages(){
                global $wpdb;
                global $DOPBSP;
                
                $languages_list = array();
                
                $languages = $DOPBSP->classes->translation->languages;
                $languages_enabled = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');
                
                foreach ($languages_enabled as $language_enabled){
                    for ($i=0; $i<count($languages); $i++){
                        if ($language_enabled->code == $languages[$i]['code']){
                            $languages_list[$languages[$i]['code']] = $languages[$i]['name'];
                        }
                    }
                }
                
                return $languages_list;
            }
        }
    }