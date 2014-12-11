<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/reservations/class-backend-reservation.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations PHP class.
*/

    if (!class_exists('DOPBSPBackEndReservation')){
        class DOPBSPBackEndReservation extends DOPBSPBackEndReservations{
            /*
             * Constructor
             */
            function DOPBSPBackEndReservation(){
            }
            
            /*
             * Add reservation.
             * 
             * @param calendar_id (integer): calendar ID
             * @param language (string): selected language
             * @param currency (string): currency sign
             * @param currency_code (string): currency code
             * @param reservation (array): reservation details
             * @param form (array): form details
             * @param payment_method (string): payment method
             * @param token (string): payment token
             * @param transaction_id (string): transaction ID
             * @param status (string): reservation status
             * 
             * @return reservation ID
             */
            function add($calendar_id,
                         $language,
                         $currency,
                         $currency_code,
                         $reservation,
                         $form,
                         $payment_method,
                         $token,
                         $transaction_id = '',
                         $status = ''){
                global $wpdb;
                global $DOPBSP;
                
                $settings_payment = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings_payment.' WHERE calendar_id='.$calendar_id);
                
                /*
                 * Set status
                 */
                $status = $status != '' ? $status:
                                          ((($payment_method == 'none' || $payment_method == 'default') && $settings_payment->arrival_with_approval_enabled == 'false') || ($payment_method != 'none' && $payment_method != 'default' && $payment_method != 'woocommerce') ? 'pending':'approved');
                
                /*
                 * Get user email.
                 */
                $email = '';
                
                if (isset($form)
                        && $form != ''){
                    foreach ($form as $field){
                        if ($field['is_email'] == 'true'){
                            $email = $field['value'];
                            break;
                        }
                    }
                }
                
                $wpdb->insert($DOPBSP->tables->reservations, array('calendar_id' => $calendar_id,
                                                                   'language' => $language,
                                                                   'currency' => $currency,
                                                                   'currency_code' => $currency_code,
                                                                   'check_in' => $reservation['check_in'],
                                                                   'check_out' => $reservation['check_out'],
                                                                   'start_hour' => $reservation['start_hour'],
                                                                   'end_hour' => $reservation['end_hour'],
                                                                   'no_items' => $reservation['no_items'],
                                                                   'price' => $reservation['price'],
                                                                   'price_total' => $reservation['price_total'],
                                                                   'extras' => isset($reservation['extras']) ? json_encode($reservation['extras']):'',
                                                                   'extras_price' => $reservation['extras_price'],
                                                                   'discount' => isset($reservation['discount']) ? json_encode($reservation['discount']):'',
                                                                   'discount_price' => $reservation['discount_price'],
                                                                   'coupon' => isset($reservation['coupon']) ? json_encode($reservation['coupon']):'',
                                                                   'coupon_price' => $reservation['coupon_price'],
                                                                   'fees' => isset($reservation['fees']) && $reservation['fees'] != '' ? json_encode($reservation['fees']):'',
                                                                   'fees_price' => $reservation['fees_price'],
                                                                   'deposit' => isset($reservation['deposit']) ? json_encode($reservation['deposit']):'',
                                                                   'deposit_price' => $reservation['deposit_price'],
                                                                   'days_hours_history' => isset($reservation['days_hours_history']) ? json_encode($reservation['days_hours_history']):'',
                                                                   'form' => isset($form) && $form != '' ? json_encode($form):'',
                                                                   'email' => $email,
                                                                   'status' => $status,
                                                                   'payment_method' => $payment_method,
                                                                   'token' => $token,
                                                                   'transaction_id' => $transaction_id != '' ? $transaction_id:''));
                $reservation_id = $wpdb->insert_id;
                
                /*
                 * Update schedule.
                 */
                if ($status == 'approved'
                        || ($status == '' 
                                && ($settings_payment->arrival_with_approval_enabled == 'true'
                                        || ($payment_method != 'none'
                                                && $payment_method != 'default')))){
                    $DOPBSP->classes->backend_calendar_schedule->setApproved($reservation_id);
                    
                    /*
                     * Update coupons.
                     */
                    $coupon = $reservation['coupon'];
                        
                    if ($coupon['id'] != 0){
                        $DOPBSP->classes->backend_coupon->update($coupon['id'],
                                                                 'use');
                    }
                }
                
                return $reservation_id;
            }
            
            /*
             * Approve reservation.
             * 
             * @post reservation_id (integer): reservation ID
             */
            function approve(){
                global $wpdb;
                global $DOPBSP;
                
                $reservation_id = $_POST['reservation_id'];
                
                /*
                 * Verify reservations availability.
                 */
                $reservation = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE id='.$reservation_id);
                
                if ($reservation->start_hour == ''){
                    if (!$DOPBSP->classes->backend_calendar_schedule->validateDays($reservation->calendar_id, $reservation->check_in, $reservation->check_out, $reservation->no_items)){
                        echo 'unavailable';
                        die();
                    }
                }
                else{
                    if (!$DOPBSP->classes->backend_calendar_schedule->validateHours($reservation->calendar_id, $reservation->check_in, $reservation->start_hour, $reservation->end_hour, $reservation->no_items)){
                        echo 'unavailable';
                        die();
                    }
                }
                
                /*
                 * Verify coupon.
                 */
                $coupon = json_decode($reservation->coupon);

                if ($coupon->id != 0){
                    if (!$DOPBSP->classes->backend_coupon->validate($coupon->id)){
                        echo 'unavailable-coupon';
                        die();
                    }
                    else{
                        /*
                         * If coupon is valid update.
                         */
                        $DOPBSP->classes->backend_coupon->update($coupon->id,
                                                                 'use');
                    }
                }
                
                /*
                 * Update if period is available.
                 */
                $wpdb->update($DOPBSP->tables->reservations, array('status' => 'approved'), 
                                                             array('id' => $reservation_id));
                
                $DOPBSP->classes->backend_calendar_schedule->setApproved($reservation_id);
                
                $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                          'approved');

                die();
            }
            
            /*
             * Cancel reservation.
             * 
             * @post reservation_id (integer): reservation ID
             */
            function cancel(){
                global $wpdb;
                global $DOPBSP;
                
                $reservation_id = $_POST['reservation_id'];

                $wpdb->update($DOPBSP->tables->reservations, array('status' => 'canceled'), 
                                                             array('id' => $reservation_id));
                
                $reservation = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE id='.$reservation_id);
                $coupon = json_decode($reservation->coupon);
                
                if ($coupon->id != 0){
                    $DOPBSP->classes->backend_coupon->update($coupon->id,
                                                             'restore');
                }

                $DOPBSP->classes->backend_calendar_schedule->setCanceled($reservation_id);
                    
                $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                          'canceled');

                die();
            }
            
            /*
             * Delete reservation.
             * 
             * @post reservation_id (integer): reservation ID
             */
            function delete(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->delete($DOPBSP->tables->reservations, array('id' => $_POST['reservation_id']));
                
                die();
            }
            
            /*
             * Reject reservation.
             * 
             * @post reservation_id (integer): reservation ID
             */
            function reject(){
                global $wpdb;
                global $DOPBSP;
                
                $reservation_id = $_POST['reservation_id'];
                
                $wpdb->update($DOPBSP->tables->reservations, array('status' => 'rejected'), 
                                                             array('id' => $reservation_id));
                
                $DOPBSP->classes->backend_reservation_notifications->send($reservation_id,
                                                                          'rejected');
                
                die();
            }
        }
    }