<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/reservations/views-backend-reservation-discount.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservation discount views class.
*/

    if (!class_exists('DOPBSPViewsReservationDiscount')){
        class DOPBSPViewsReservationDiscount extends DOPBSPViewsReservation{
            /*
             * Constructor
             */
            function DOPBSPViewsReservationDiscount(){
            }
            
            /*
             * @param args (array): function arguments
             *                      * reservation (object): reservation data
             *                      * settings (object): settings data
             */
            function template($args = array()){
                global $DOPBSP;
                
                $reservation = $args['reservation'];
                $settings = $args['settings'];
                
                $discount = json_decode(utf8_decode($reservation->discount));
?>
                <div class="data-module">
                    <div class="data-head"> 
                        <h3><?php echo $DOPBSP->text('DISCOUNTS_FRONT_END_TITLE'); ?></h3>
                    </div>
                    <div class="data-body"> 
<?php
                if ($discount->id != 0){
                    $value = array();

                    array_push($value, '<span class="info-rule">&#9632;&nbsp;');

                    if ($discount->price_type == 'fixed'){
                        array_push($value, $discount->operation.'&nbsp;'.($settings->currency_position == 'before' ? $reservation->currency.abs($discount->price):abs($discount->price).$reservation->currency));
                    }
                    else{
                        array_push($value, $discount->operation.'&nbsp;'.$discount->price.'%');
                    }

                    if ($discount->price_by != 'once'){
                        array_push($value, '/'.($settings->hours_enabled == 'true' ? $DOPBSP->text('DISCOUNTS_FRONT_END_BY_HOUR'):$DOPBSP->text('DISCOUNTS_FRONT_END_BY_DAY')));
                    }
                    array_push($value, '</span>');

                    $this->displayData($discount->translation,
                                       implode('', $value));

                    if ($reservation->discount_price != 0){
                        echo '<br />';
                        $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE'),
                                           ($reservation->discount_price > 0 ? '+':'-').
                                                '&nbsp;'.
                                                ($settings->currency_position == 'before' ? $reservation->currency.abs($reservation->discount_price):abs($reservation->discount_price).$reservation->currency),
                                           'price');
                    }
                }
                else{
                    echo '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_DISCOUNT').'</em>';
                }
?>
                    </div>
                </div>
<?php
            }
        }
    }