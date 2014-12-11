<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/reservations/views-backend-reservation.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservation views class.
*/

    if (!class_exists('DOPBSPViewsReservation')){
        class DOPBSPViewsReservation extends DOPBSPViewsReservations{
            /*
             * Constructor
             */
            function DOPBSPViewsReservation(){
            }
            
            /*
             * Reservation template.
             * 
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $reservation = $args['reservation'];
               
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id=%d', 
                                                          $reservation->calendar_id));
                $settings = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id=%d', 
                                                          $reservation->calendar_id));
                
                $display_approve_button = false;
                $display_reject_button = false;
                $display_cancel_button = false;
                $display_delete_button = false;
                        
                switch ($reservation->status){
                    case 'pending':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_PENDING');
                        $display_approve_button = true;
                        $display_reject_button = true;
                        break;
                    case 'approved':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_APPROVED');
                        $display_cancel_button = true;
                        break;
                    case 'rejected':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_REJECTED');
                        $display_approve_button = true;
                        $display_delete_button = true;
                        break;
                    case 'canceled':
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_CANCELED');
                        $display_approve_button = true;
                        $display_delete_button = true;
                        break;
                    default:
                        $reservation_status_label = $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS_EXPIRED');
                        $display_delete_button = true;
                }

                switch ($reservation->payment_method){
                    case 'default':
                        $reservation_payment_method = $DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_ARRIVAL');
                        break;
                    case 'paypal':
                        $reservation_payment_method = $DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PAYPAL');
                        break;
                    default:
                        $reservation_payment_method = $DOPBSP->text('RESERVATIONS_RESERVATIONS_PAYMENT_NONE');
                }

                $dc_hour = substr($reservation->date_created, 11, 5);
                $dc_date = substr($reservation->date_created, 0, 10);
                $reservation_date_created = $DOPBSP->classes->prototypes->setDateToFormat($dc_date, 
                                                                                          $settings->date_type.' '.($settings->hours_ampm == 'true' ? $DOPBSP->classes->prototypes->getAMPM($dc_hour):$dc_hour),
                                                                                          array($DOPBSP->text('MONTH_JANUARY'), 
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
                                                                                                $DOPBSP->text('MONTH_DECEMBER')));
?>
                    <li id="DOPBSP-reservation<?php echo $reservation->id; ?>">
                        <div class="reservation-head">
                            <div class="icon <?php echo $reservation->status; ?>"></div>
                            <div class="title">
                                <strong>ID: </strong><?php echo $reservation->id; ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS'); ?>: </strong><span class="status-info <?php echo $reservation->status; ?>"><?php echo $reservation_status_label; ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_DATE_CREATED'); ?>: </strong><?php echo $reservation_date_created; ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
<?php
                if ($reservation->check_in >= date('Y-m-d')){
?>
                            <div class="buttons-wrapper">
                                <a href="javascript:DOPBSP.confirmation('RESERVATIONS_RESERVATION_APPROVE_CONFIRMATION', 'DOPBSPReservation.approve(<?php echo $reservation->id; ?>)')" class="button-approve" style="display: <?php echo $display_approve_button ? 'block':'none'; ?>"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_APPROVE'); ?></a>
                                <a href="javascript:DOPBSP.confirmation('RESERVATIONS_RESERVATION_REJECT_CONFIRMATION', 'DOPBSPReservation.reject(<?php echo $reservation->id; ?>)')" class="button-reject" style="display: <?php echo $display_reject_button ? 'block':'none'; ?>"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_REJECT'); ?></a>
                                <a href="javascript:DOPBSP.confirmation('RESERVATIONS_RESERVATION_CANCEL_CONFIRMATION', 'DOPBSPReservation.cancel(<?php echo $reservation->id; ?>)')" class="button-cancel" style="display: <?php echo $display_cancel_button ? 'block':'none'; ?>"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_CANCEL'); ?></a>
                                <a href="javascript:DOPBSP.confirmation('RESERVATIONS_RESERVATION_DELETE_CONFIRMATION', 'DOPBSPReservation.delete(<?php echo $reservation->id; ?>)')" class="button-delete" style="display: <?php echo $display_delete_button ? 'block':'none'; ?>"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_DELETE'); ?></a>
                            </div>
<?php
                }
?>
                        </div>
                        <div class="reservation-body">
<?php
                /*
                 * Display details.
                 */
                $DOPBSP->views->reservation_details->template(array('reservation' => $reservation,
                                                                    'calendar' => $calendar,
                                                                    'settings' => $settings));
                
                /*
                 * Display form data.
                 */
                $DOPBSP->views->reservation_form->template(array('reservation' => $reservation));
                
                /*
                 * Display extras data.
                 */
                if ($settings->extra != 0){
                    $DOPBSP->views->reservation_extras->template(array('reservation' => $reservation,
                                                                       'settings' => $settings));
                }
                
                /*
                 * Display discount data.
                 */
                if ($settings->discount != 0){
                    $DOPBSP->views->reservation_discount->template(array('reservation' => $reservation,
                                                                         'settings' => $settings));
                }
                
                /*
                 * Display fees data.
                 */
                if ($settings->fees != ''){
                    $DOPBSP->views->reservation_fees->template(array('reservation' => $reservation,
                                                                     'settings' => $settings));
                }
                
                /*
                 * Display coupon data.
                 */
                if ($settings->coupon != 0){
                    $DOPBSP->views->reservation_coupon->template(array('reservation' => $reservation,
                                                                       'settings' => $settings));
                }
?>
                        </div>
                    </li> 
<?php                
            }
            
            /*
             * Create a reservation data field.
             * 
             * @param label (string):  data label
             * @param value (string):  data value
             * @param class (string):  data class
             * 
             * @return calendars list
             */
            function displayData($label = '',
                                 $value = '',
                                 $class = ''){
                $html = array();
                
                $label = stripslashes($label);
                $value = stripslashes($value);
                
                array_push($html, '<div class="data-field '.$class.'">');
                array_push($html, ' <label>'.$label.'</label>');
                array_push($html, ' <div class="data-value">'.$value.'</div>');
                array_push($html, '</div>');
                
                echo implode('', $html);
            }
        }
    }