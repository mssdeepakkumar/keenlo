<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/reservations/views-backend-reservations-list.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations list views class.
*/

    if (!class_exists('DOPBSPViewsReservationsList')){
        class DOPBSPViewsReservationsList extends DOPBSPViewsReservations{
            /*
             * Constructor
             */
            function DOPBSPViewsReservationsList(){
            }
            
            /*
             * Returns reservations template.
             * 
             * @param args (array): function arguments
             *                      * reservations (array): reservations list
             * 
             * @return reservations HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $reservations = $args['reservations'];
?>
                <ul class="reservations-list">
<?php
                /*
                 * Check if reservations exist.
                 */
                if (count($reservations) > 0){
                    foreach ($reservations as $reservation){
                        $DOPBSP->views->reservation->template(array('reservation' => $reservation));
                    }
                }
                else{
?>                    
                    <li class="no-data"><?php echo $DOPBSP->text('RESERVATIONS_NO_RESERVATIONS'); ?></li>
<?php                    
                }
?>
                </ul>    
<?php
            }
        }
    }