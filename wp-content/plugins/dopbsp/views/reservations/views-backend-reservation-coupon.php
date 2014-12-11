<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/reservations/views-backend-reservation-coupon.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservation coupon views class.
*/

    if (!class_exists('DOPBSPViewsReservationCoupon')){
        class DOPBSPViewsReservationCoupon extends DOPBSPViewsReservation{
            /*
             * Constructor
             */
            function DOPBSPViewsReservationCoupon(){
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
                
                $coupon = json_decode(utf8_decode($reservation->coupon));
?>
                <div class="data-module">
                    <div class="data-head"> 
                        <h3><?php echo $DOPBSP->text('COUPONS_FRONT_END_TITLE'); ?></h3>
                    </div>
                    <div class="data-body"> 
<?php
                if ($coupon->id != 0){
                    $value = array();

                    array_push($value, $coupon->code);

                    if ($coupon->price_type != 'fixed' 
                            || $coupon->price_by != 'once'){ 
                        array_push($value, '<br /><span class="info-rule">&#9632;&nbsp;');

                        if ($coupon->price_type == 'fixed'){
                            array_push($value, $coupon->operation.'&nbsp;'.($settings->currency_position == 'before' ? $reservation->currency.abs($coupon->price):abs($coupon->price).$reservation->currency));
                        }
                        else{
                            array_push($value, $coupon->operation.'&nbsp;'.$coupon->price.'%');
                        }

                        if ($coupon->price_by != 'once'){
                            array_push($value, '/'.($settings->hours_enabled == 'true' ? $DOPBSP->text('COUPONS_FRONT_END_BY_HOUR'):$DOPBSP->text('COUPONS_FRONT_END_BY_DAY')));
                        }
                        array_push($value, '</span>');
                    }

                    $this->displayData($coupon->translation,
                                       implode('', $value));

                    if ($reservation->coupon_price != 0){
                        echo '<br />';
                        $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE'),
                                           ($reservation->coupon_price > 0 ? '+':'-').
                                                '&nbsp;'.
                                                ($settings->currency_position == 'before' ? $reservation->currency.abs($reservation->coupon_price):abs($reservation->coupon_price).$reservation->currency),
                                           'price');
                    }
                }
                else{
                    echo '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_COUPON').'</em>';
                }
?>
                    </div>
                </div>
<?php
            }
        }
    }