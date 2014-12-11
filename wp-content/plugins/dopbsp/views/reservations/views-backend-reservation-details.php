<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/reservations/views-backend-reservation-details.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservation details views class.
*/

    if (!class_exists('DOPBSPViewsReservationDetails')){
        class DOPBSPViewsReservationDetails extends DOPBSPViewsReservation{
            /*
             * Constructor
             */
            function DOPBSPViewsReservationDetails(){
            }
            
            /*
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             *                      * calendar (object): calendar data
             *                      * settings (object): settings data
             */
            function template($args = array()){
                global $DOPBSP;
                
                $reservation = $args['reservation'];
                $calendar = $args['calendar'];
                $settings = $args['settings'];
?>
                <div class="data-module">
                    <div class="data-head"> 
                        <h3><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_DETAILS_TITLE'); ?></h3>
                    </div>
                    <div class="data-body"> 
<?php
                /*
                 * Calendar ID.
                 */
                $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_CALENDAR_ID'),
                                   $reservation->calendar_id);
                
                /*
                 * Calendar name.
                 */
                $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_CALENDAR_NAME'),
                                   $calendar->name);
                
                /*
                 * Selected language.
                 */
                $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_LANGUAGE'),
                                   $DOPBSP->classes->languages->getName($reservation->language));
?>
                        <br />
<?php
                /*
                 * Check in data.
                 */
                $this->displayData($DOPBSP->text('SEARCH_CHECK_IN'),
                                   $DOPBSP->classes->prototypes->setDateToFormat($reservation->check_in, 
                                                                                 $settings->date_type, 
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
                                                                                       $DOPBSP->text('MONTH_DECEMBER'))));
                /*
                 * Check out data.
                 */
                if ($reservation->check_out != ''){
                    $this->displayData($DOPBSP->text('SEARCH_CHECK_OUT'),
                                       $DOPBSP->classes->prototypes->setDateToFormat($reservation->check_out, 
                                                                                     $settings->date_type, 
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
                                                                                           $DOPBSP->text('MONTH_DECEMBER'))));
                }

                /*
                 * Start hour data.
                 */
                if ($reservation->start_hour != ''){
                    $this->displayData($DOPBSP->text('SEARCH_START_HOUR'),
                                       $settings->hours_ampm == 'true' ? $DOPBSP->classes->prototypes->getAMPM($reservation->start_hour):$reservation->start_hour);
                }

                /*
                 * End hour data.
                 */
                if ($reservation->end_hour != ''){
                    $this->displayData($DOPBSP->text('SEARCH_END_HOUR'),
                                       $settings->hours_ampm == 'true' ? $DOPBSP->classes->prototypes->getAMPM($reservation->end_hour):$reservation->end_hour);
                }

                /*
                 * No items data.
                 */
                if ($settings->sidebar_no_items_enabled == 'true'){
                    $this->displayData($DOPBSP->text('SEARCH_NO_ITEMS'),
                                       $reservation->no_items);
                }

                /*
                 * Reservation price.
                 */
                if ($reservation->price > 0){
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_PRICE'),
                                       $settings->currency_position == 'before' ? $reservation->currency.$reservation->price:$reservation->price.$reservation->currency,
                                       'price');
                }
?>
                        <br />
<?php
                /*
                 * Payment method.
                 */
                switch ($reservation->payment_method){
                    case 'none':
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('ORDER_PAYMENT_METHOD_NONE'));
                        break;
                    case 'default':
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('ORDER_PAYMENT_METHOD_ARRIVAL'));
                        break;
                    case 'woocommerce':
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('ORDER_PAYMENT_METHOD_WOOCOMMERCE'));
                        
                        /*
                         * Order ID
                         */
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD_WOOCOMMERCE_ORDER_ID'),
                                           '<a href="'.get_edit_post_link($reservation->transaction_id).'" target="_blank">'.$reservation->transaction_id.'</a>');
                        break;
                    default:
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD'),
                                           $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_'.strtoupper($reservation->payment_method)));
                        
                        /*
                         * Transaction ID
                         */
                        $this->displayData($DOPBSP->text('ORDER_PAYMENT_METHOD_TRANSACTION_ID'),
                                           $reservation->transaction_id);
                }

                /*
                 * Reservation total price.
                 */
                if ($reservation->price_total > 0){
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_TOTAL_PRICE'),
                                       $settings->currency_position == 'before' ? $reservation->currency.$reservation->price_total:$reservation->price_total.$reservation->currency,
                                       'price-total');
                }

                /*
                 * Deposit
                 */
                if ($reservation->deposit_price > 0){
                    $deposit = json_decode(stripslashes($reservation->deposit));
                    
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT'),
                                       ($deposit->price_type = 'percent' ? '<span class="info-rule">&#9632;&nbsp;'.$deposit->price.'%</span><br />':'').
                                       ($settings->currency_position == 'before' ? $reservation->currency.$reservation->deposit_price:$reservation->deposit_price.$reservation->currency),
                                       'price');
                    $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_DEPOSIT_LEFT'),
                                       $settings->currency_position == 'before' ? $reservation->currency.($reservation->price_total-$reservation->deposit_price):
                                                                                  ($reservation->price_total-$reservation->deposit_price).$reservation->currency,
                                       'price-total');
                }
?>
                    </div>
                </div>
<?php
            }
        }
    }