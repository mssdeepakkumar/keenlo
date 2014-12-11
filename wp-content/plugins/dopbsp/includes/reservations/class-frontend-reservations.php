<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/reservations/class-reservations-extras.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO front end reservations PHP class.
*/

    if (!class_exists('DOPBSPFrontEndReservations')){
        class DOPBSPFrontEndReservations extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function DOPBSPFrontEndReservations(){
            }
            
            /*
             * Get order data.
             */
            function get(){
                global $DOPBSP;
                
                return array('data' => array(),
                             'text' => array('price' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_PRICE'),
                                             'priceTotal' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_TOTAL_PRICE'),   
                                             'selectDays' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_SELECT_DAYS'),
                                             'selectHours' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_SELECT_HOURS'),
                                             'title' => $DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_TITLE')));
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
             * @post payment_method (string): selected payment method
             */
            function book(){
                global $wpdb;
                global $DOPBSP;
                    
// HOOK (dopbsp_action_book_before) *************************************** Add action before booking request.
                do_action('dopbsp_action_book_before');

                $calendar_id = $_POST['calendar_id'];
                $language = $_POST['language'];
                $currency = $_POST['currency'];
                $currency_code = $_POST['currency_code'];
                $cart = $_POST['cart_data'];
                $form = $_POST['form'];
                $payment_method = $_POST['payment_method'];
                
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
                        // $coupon = json_decode($reservation['coupon']);
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
                if ($payment_method != 'default'){
                    $token = $DOPBSP->classes->prototypes->getRandomString(32);
                }
                else{
                    $token = '';
                }
                $DOPBSP->vars->payment_token = $token;
                
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
                                                                                 $token);
                    
                    if ($payment_method == 'default'
                            || $payment_method == 'none'){
                        if ($settings_payment->arrival_with_approval_enabled == 'true'){
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_with_approval_admin');
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_with_approval_user');
                        }
                        else{
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_admin');
                            $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                                      'book_user');
                        }
                    }
                }
                
// HOOK (dopbsp_action_book_payment) *************************************** Add action for payment gateways.
                do_action('dopbsp_action_book_payment');
                
// HOOK (dopbsp_action_book_after) *************************************** Add action after booking request.
                do_action('dopbsp_action_book_after');
                           
                die();
            }
        }
    }