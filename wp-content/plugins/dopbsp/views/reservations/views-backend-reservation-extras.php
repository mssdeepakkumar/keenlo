<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/reservations/views-backend-reservation-extras.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservation extras views class.
*/

    if (!class_exists('DOPBSPViewsReservationExtras')){
        class DOPBSPViewsReservationExtras extends DOPBSPViewsReservation{
            /*
             * Constructor
             */
            function DOPBSPViewsReservationExtras(){
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
                        <h3><?php echo $DOPBSP->text('EXTRAS_FRONT_END_TITLE'); ?></h3>
                    </div>
                    <div class="data-body"> 
<?php           
                if ($reservation->extras != ''){
                    $extras = json_decode(utf8_decode($reservation->extras));
                
                    for ($i=0; $i<count($extras); $i++){
                        $extras[$i]->displayed = false;
                    }

                    for ($i=0; $i<count($extras); $i++){
                        $values = array();

                        if ($extras[$i]->displayed == false){
                            for ($j=0; $j<count($extras); $j++){
                                $value = array();
                                $extra = $extras[$j];

                                if ($extras[$i]->group_id == $extra->group_id){
                                    array_push($value, $extra->translation);

                                    if ($extra->price != 0){
                                        array_push($value, '<br />');


                                        if ($extra->price_type != 'fixed' 
                                                || $extra->price_by != 'once'){ 
                                            array_push($value, '<span class="info-rule">&#9632;&nbsp;');

                                            if ($extra->price_type == 'fixed'){
                                                array_push($value, $extra->operation.'&nbsp;'.($settings->currency_position == 'before' ? $reservation->currency.abs($extra->price):abs($extra->price).$reservation->currency));
                                            }
                                            else{
                                                array_push($value, $extra->operation.'&nbsp;'.$extra->price.'%');
                                            }

                                            if ($extra->price_by != 'once'){
                                                array_push($value, '/'.($settings->hours_enabled == 'true' ? $DOPBSP->text('EXTRAS_FRONT_END_BY_HOUR'):$DOPBSP->text('EXTRAS_FRONT_END_BY_DAY')));
                                            }
                                            array_push($value, '</span><br />');
                                        }
                                        array_push($value, '<span class="info-price">'.$extra->operation.'&nbsp;');
                                        array_push($value, $settings->currency_position == 'before' ? $reservation->currency.abs($extra->price_total):abs($extra->price_total).$reservation->currency);
                                        array_push($value, '</span>');
                                    }

                                    if (count($value) != 0){
                                        $extras[$j]->displayed = true;
                                        array_push($values, implode('', $value));
                                    }
                                }
                            }    
                            $this->displayData($extras[$i]->group_translation,
                                               implode('<br /><br />', $values));
                        }
                    }
                    
                    if ($reservation->extras_price != 0){
                        echo '<br />';
                        $this->displayData($DOPBSP->text('RESERVATIONS_RESERVATION_PAYMENT_PRICE_CHANGE'),
                                           ($reservation->extras_price > 0 ? '+':'-').
                                                '&nbsp;'.
                                                ($settings->currency_position == 'before' ? $reservation->currency.abs($reservation->extras_price):abs($reservation->extras_price).$reservation->currency),
                                           'price');
                    }
                }
                else{
                    echo '<em>'.$DOPBSP->text('RESERVATIONS_RESERVATION_NO_EXTRAS').'</em>';
                }
?>
                    </div>
                </div>
<?php
            }
        }
    }