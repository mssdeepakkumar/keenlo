<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/calendars/class-frontend-calendar.php
* File Version            : 1.0
* Created / Last Modified : 13 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO front end calendar PHP class.
*/

    if (!class_exists('DOPBSPFrontEndCalendar')){
        class DOPBSPFrontEndCalendar extends DOPBSPFrontEndCalendars{
            /*
             * Constructor.
             */
            function DOPBSPFrontEndCalendar(){
            }
            
            /*
             * Get calendar options in JSON format.
             * 
             * @param atts (array): shortcode attributes
             * 
             * @return options JSON
             */
            function getJSON($atts){
                global $wpdb;
                global $DOPBSP;
                
                $data = array();
                
                $id = $atts['id'];
                $language = $atts['lang'];
                $woocommerce = $atts['woocommerce'];
                $woocommerce_product_id = $atts['woocommerce_product_id'];
                $woocommerce_position = $atts['woocommerce_position'];
                
                $DOPBSP->classes->translation->setTranslation($language);
                
                $settings = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id=%d',
                                                          $id));
                $settings_payment = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->settings_payment.' WHERE calendar_id=%d',
                                                                  $id));
                
                /*
                 * JSON
                 */
                $data = array('calendar' => array('data' => array('bookingStop' => (int)$settings->booking_stop,
                                                                  'dateType' => (int)$settings->date_type,
                                                                  'language' => $language,
                                                                  'pluginURL' => $DOPBSP->paths->url,
                                                                  'maxYear' => (int)$settings->max_year,
                                                                  'reinitialize' => false,
                                                                  'view' => $settings->view_only == 'true' ? true:false),
                                                  'text' => array('addMonth' => $DOPBSP->text('CALENDARS_CALENDAR_ADD_MONTH_VIEW'),
                                                                  'available' => $DOPBSP->text('CALENDARS_CALENDAR_AVAILABLE_ONE_TEXT'),
                                                                  'availableMultiple' => $DOPBSP->text('CALENDARS_CALENDAR_AVAILABLE_TEXT'),
                                                                  'booked' => $DOPBSP->text('CALENDARS_CALENDAR_BOOKED_TEXT'),
                                                                  'nextMonth' => $DOPBSP->text('CALENDARS_CALENDAR_NEXT_MONTH'),
                                                                  'previousMonth' => $DOPBSP->text('CALENDARS_CALENDAR_PREVIOUS_MONTH'),
                                                                  'removeMonth' => $DOPBSP->text('CALENDARS_CALENDAR_REMOVE_MONTH_VIEW'),
                                                                  'unavailable' => $DOPBSP->text('CALENDARS_CALENDAR_UNAVAILABLE_TEXT'))), 
                              'cart' => array('data' => array('enabled' => $settings->cart_enabled == 'true' ? true:false),
                                              'text' => array('isEmpty' => $DOPBSP->text('CART_IS_EMPTY'),
                                                              'title' => $DOPBSP->text('CART_TITLE'))),
                              'coupons' => $DOPBSP->classes->frontend_coupons->get($settings->coupon,
                                                                                   $language),
                              'currency' => array('data' => array('code' => $settings->currency,
                                                                  'position' => $settings->currency_position,
                                                                  'sign' => $DOPBSP->classes->currencies->get($settings->currency),
                                                  'text' => array())),
                              'days' => array('data' => array('available' => $this->getAvailableDays($settings->days_available),
                                                              'first' => (int)$settings->days_first,
                                                              'morningCheckOut' => $settings->days_multiple_select == 'false' || $settings->hours_enabled == 'true' ? false:($settings->days_morning_check_out == 'true' ? true:false),
                                                              'multipleSelect' => $settings->hours_enabled == 'true' ? false:($settings->days_multiple_select == 'true' ? true:false)),
                                              'text' => array('names' => array($DOPBSP->text('DAY_SUNDAY'), 
                                                                               $DOPBSP->text('DAY_MONDAY'), 
                                                                               $DOPBSP->text('DAY_TUESDAY'), 
                                                                               $DOPBSP->text('DAY_WEDNESDAY'), 
                                                                               $DOPBSP->text('DAY_THURSDAY'), 
                                                                               $DOPBSP->text('DAY_FRIDAY'), 
                                                                               $DOPBSP->text('DAY_SATURDAY')),
                                                              'shortNames' => array($DOPBSP->text('SHORT_DAY_SUNDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_MONDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_TUESDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_WEDNESDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_THURSDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_FRIDAY'), 
                                                                                    $DOPBSP->text('SHORT_DAY_SATURDAY')))),
                              'deposit' => array('data' => array('deposit' => (int)$settings->deposit,
                                                                 'type' => $settings->deposit_type),
                                                 'text' => array('title' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT'))), 
                              'discounts' => $DOPBSP->classes->frontend_discounts->get($settings->discount,
                                                                                       $language),
                              'extras' => $DOPBSP->classes->frontend_extras->get($settings->extra,
                                                                                 $language),
                              'fees' => $DOPBSP->classes->frontend_fees->get($settings->fees,
                                                                             $language),
                              'form' => $DOPBSP->classes->frontend_forms->get($settings->form,
                                                                              $language),
                              'hours' => array('data' => array('addLastHourToTotalPrice' => $settings->hours_multiple_select == 'false' ? true:($settings->hours_add_last_hour_to_total_price == 'true' && $settings->hours_interval_enabled == 'false' ? true:false),
                                                               'ampm' => $settings->hours_ampm == 'true' ? true:false,
                                                               'definitions' => json_decode($settings->hours_definitions),
                                                               'enabled' => $settings->hours_enabled == 'true' ? true:false,
                                                               'info' => $settings->hours_info_enabled == 'true' ? true:false,
                                                               'interval' => $settings->hours_multiple_select == 'false' ? false:($settings->hours_interval_enabled == 'true' ? true:false),
                                                               'multipleSelect' => $settings->hours_multiple_select == 'true' ? true:false),
                                               'text' => array()),
                              'ID' => $id,
                              'months' => array('data' => array('no' => $settings->months_no == 0 || is_nan($settings->months_no) ? 1:($settings->months_no > 6 ? 6:$settings->months_no)),
                                                'text' => array('names' => array($DOPBSP->text('MONTH_JANUARY'), 
                                                                                 $DOPBSP->text('MONTH_FEBRUARY'),  
                                                                                 $DOPBSP->text('MONTH_MARCH'),
                                                                                 $DOPBSP->text('MONTH_APRIL'),  
                                                                                 $DOPBSP->text('MONTH_MAY'),  
                                                                                 $DOPBSP->text('MONTH_JUNE'),  
                                                                                 $DOPBSP->text('MONTH_JULY'),  
                                                                                 $DOPBSP->text('MONTH_AUGUST'),  
                                                                                 $DOPBSP->text('MONTH_SEPTEMBER'),  
                                                                                 $DOPBSP->text('MONTH_OCTOBER'),  
                                                                                 $DOPBSP->text('MONTH_NOVEMBER'),  
                                                                                 $DOPBSP->text('MONTH_DECEMBER')),
                                                                'shortNames' => array($DOPBSP->text('SHORT_MONTH_JANUARY'),  
                                                                                      $DOPBSP->text('SHORT_MONTH_FEBRUARY'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_MARCH'),
                                                                                      $DOPBSP->text('SHORT_MONTH_APRIL'),
                                                                                      $DOPBSP->text('SHORT_MONTH_MAY'),
                                                                                      $DOPBSP->text('SHORT_MONTH_JUNE'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_JULY'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_AUGUST'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_SEPTEMBER'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_OCTOBER'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_NOVEMBER'), 
                                                                                      $DOPBSP->text('SHORT_MONTH_DECEMBER')))),
                              'order' => $DOPBSP->classes->frontend_order->get($settings,
                                                                               $settings_payment),
                              'reservation' => $DOPBSP->classes->frontend_reservations->get(),
                              'rules' => $DOPBSP->classes->frontend_rules->get($settings->rule,
                                                                               $language),
                              'search' => $DOPBSP->classes->frontend_search->get(),
                              'sidebar' => $DOPBSP->classes->frontend_calendar_sidebar->get($settings,
                                                                                            $woocommerce,
                                                                                            $woocommerce_position),
                              'woocommerce' => array('data' => array('enabled' => $woocommerce == 'true' ? true:false,
                                                                     'product_id' => $woocommerce_product_id),
                                                     'text' => array('none' => $DOPBSP->text('WOOCOMMERCE_PRODUCT_NONE'),
                                                                     'reservation' => $DOPBSP->text('WOOCOMMERCE_PRODUCT_RESERVATION'))));
                
                return json_encode($data);
            }
 
            /*
             * Get available days.
             * 
             * @param available_days (string): available days data
             * 
             * @return available days array
             */
            function getAvailableDays($available_days){
                $days = explode(',', $available_days);
                
                for ($i=0; $i<count($days); $i++){
                    $days[$i] = $days[$i] == 'true' ? true:false;
                }
                
                return $days;
            }
 
            /*
             * Get calendar template.
             * 
             * @param id (integer): calendar ID
             * 
             * @return template name
             */
            function getTemplate($id){
                global $wpdb;
                global $DOPBSP;
                
                $settings = $wpdb->get_row('SELECT template FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$id);
                
                return $settings->template;
            }
        }
    }