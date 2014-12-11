<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/reservations/views-backend-reservation-fees.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservation fees views class.
*/

    if (!class_exists('DOPBSPViewsReservationFees')){
        class DOPBSPViewsReservationFees extends DOPBSPViewsReservation{
            /*
             * Constructor
             */
            function DOPBSPViewsReservationFees(){
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
?>
                <div class="data-module">
                    <div class="data-head"> 
                        <h3><?php echo $DOPBSP->text('FEES_FRONT_END_TITLE'); ?></h3>
                    </div>
                    <div class="data-body"> 
<?php           
                if ($reservation->fees != ''){
                    $fees = json_decode(utf8_decode($reservation->fees));

                    for ($i=0; $i<count($fees); $i++){
                        $value = array();
                        $fee = $fees[$i];

                        if ($fee->price_type != 'fixed' 
                                || $fee->price_by != 'once'){ 
                            array_push($value, '<span class="info-rule">&#9632;&nbsp;');

                            if ($fee->price_type == 'fixed'){
                                array_push($value, $fee->operation.'&nbsp;'.($settings->currency_position == 'before' ? $reservation->currency.abs($fee->price):abs($fee->price).$reservation->currency));
                            }
                            else{
                                array_push($value, $fee->operation.'&nbsp;'.$fee->price.'%');
                            }

                            if ($fee->price_by != 'once'){
                                array_push($value, '/'.($settings->hours_enabled == 'true' ? $DOPBSP->text('FEES_FRONT_END_BY_HOUR'):$DOPBSP->text('FEES_FRONT_END_BY_DAY')));
                            }
                            array_push($value, '<br /></span>');
                        }
                        
                        if ($fee->included == 'true'){
                            array_push($value, '<span class="info-price">'.$DOPBSP->text('FEES_FRONT_END_INCLUDED').'</span>');
                        }
                        else{
                            array_push($value, '<span class="info-price">'.$fee->operation.'&nbsp;');
                            array_push($value, $settings->currency_position == 'before' ? $reservation->currency.abs($fee->price_total):abs($fee->price_total).$reservation->currency);
                            array_push($value, '</span>');
                        }

                        $this->displayData($fee->translation,
                                           implode('', $value));
                    }
                    
                    if ($reservation->fees_price != 0){
                        echo '<br />';
                        $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE'),
                                           ($reservation->fees_price > 0 ? '+':'-').
                                                '&nbsp;'.
                                                ($settings->currency_position == 'before' ? $reservation->currency.abs($reservation->fees_price):abs($reservation->fees_price).$reservation->currency),
                                           'price');
                    }
                }
                else{
                    echo '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_FEES').'</em>';
                }
?>
                    </div>
                </div>
<?php
            }
        }
    }