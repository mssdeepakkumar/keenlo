<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/reservations/class-backend-reservations-add.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations add PHP class.
*/

    if (!class_exists('DOPBSPBackEndReservationsAdd')){
        class DOPBSPBackEndReservationsAdd extends DOPBSPBackEndReservations{
            /*
             * Constructor.
             */
            function DOPBSPBackEndReservationsAdd(){
            }
            
            /*
             * Get calendar options in JSON format.
             * 
             * @post calendar_id (integer): calendar ID
             * 
             * @return options JSON
             */
            function getJSON(){
                global $wpdb;
                global $DOPBSP;
                
                $data = array();
                
                $id = $_POST['calendar_id'];
                $language =  $DOPBSP->classes->translation->get();
                
                $settings = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id=%d',
                                                          $id));
                $settings_payment = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->settings_payment.' WHERE calendar_id=%d',
                                                                  $id));
                
                /*
                 * JSON data.
                 */
                $data = array('calendar' => array('data' => array('bookingStop' => 0,
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
                              'coupons' => $DOPBSP->classes->frontend_coupons->get($settings->coupon,
                                                                                   $language),
                              'currency' => array('data' => array('code' => $settings->currency,
                                                                  'position' => $settings->currency_position,
                                                                  'sign' => $DOPBSP->classes->currencies->get($settings->currency),
                                                  'text' => array())),
                              'days' => array('data' => array('available' => $DOPBSP->classes->frontend_calendar->getAvailableDays($settings->days_available),
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
                              'months' => array('data' => array('no' => 3),
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
                                                                                            'false',
                                                                                            ''));
                
                echo json_encode($data);
                
                die();
            }
            
            /*
             * Book a reservation.
             * 
             * @post calendar_id (integer): calendar ID
             * @post language (string): selected language
             * @post currency (string): selected currency sign
             * @post currency_code (string): selected currency code
             * @post cart_data (array): list of reservations
             * @post form (object): form data
             * @post status (object): reservation status
             * @post payment_method (string): selected payment method
             * @post transaction_id (object): transaction ID
             */
            function book(){
                global $wpdb;
                global $DOPBSP;
                    
                $calendar_id = $_POST['calendar_id'];
                $language = $_POST['language'];
                $currency = $_POST['currency'];
                $currency_code = $_POST['currency_code'];
                $cart = $_POST['cart_data'];
                $form = $_POST['form'];
                $status = $_POST['status'];
                $payment_method = $_POST['payment_method'];
                $transaction_id = $_POST['transaction_id'];
                
                /*
                 * Verify reservations.
                 */
                $settings_payment = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings_payment.' WHERE calendar_id='.$calendar_id);
                
                for ($i=0; $i<count($cart); $i++){
                    $reservation = $cart[$i];
                    
                    if (($payment_method != 'default' 
                                    && $payment_method != 'none')
                            || $settings_payment->arrival_with_approval_enabled == 'true'){
                        /*
                         * Verify reservations availability.
                         */
                        if ($reservation['start_hour'] == ''){
                            if (!$DOPBSP->classes->backend_calendar_schedule->validateDays($calendar_id, $reservation['check_in'], $reservation['check_out'], $reservation['no_items'])){
                                echo 'unavailable';
                                die();
                            }
                        }
                        else{
                            if (!$DOPBSP->classes->backend_calendar_schedule->validateHours($calendar_id, $reservation['check_in'], $reservation['start_hour'], $reservation['end_hour'], $reservation['no_items'])){
                                echo 'unavailable';
                                die();
                            }
                        }
                
                        /*
                         * Verify coupon.
                         */
                        $coupon = $reservation['coupon'];
                        
                        if ($coupon['id'] != 0){
                            if (!$DOPBSP->classes->backend_coupon->validate($coupon['id'])){
                                echo 'unavailable-coupon';
                                die();
                            }
                        }
                    }
                }
                
                /*
                 * Set token.
                 */
                $token = '';
                
                /*
                 * Add reservations.
                 */
                for ($i=0; $i<count($cart); $i++){
                    $reservation = $cart[$i];
                
                    $reservation_id = $DOPBSP->classes->backend_reservation->add($calendar_id,
                                                                                 $language,
                                                                                 $currency,
                                                                                 $currency_code,
                                                                                 $reservation,
                                                                                 $form,
                                                                                 $payment_method,
                                                                                 $token,
                                                                                 $transaction_id,
                                                                                 $status);
                    /*
                     * Send notification emails to client.
                     */
                    if ($payment_method == 'default'
                            || $payment_method == 'none'){
                        if ($status == 'approved'){
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_with_approval_user');
                        }
                        else{
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_user');
                        }
                    }
                    else{
                        $DOPBSP->classes->backend_reservation_notifications->send($reservation->id,
                                                                                  $payment_method.'_user');
                    }
                }
                           
                die();
            }
        }
    }