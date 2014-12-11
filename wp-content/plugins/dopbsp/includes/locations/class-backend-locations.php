<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/locations/class-backend-locations.php
* File Version            : 1.0
* Created / Last Modified : 28 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end locations PHP class.
*/

    if (!class_exists('DOPBSPBackEndLocations')){
        class DOPBSPBackEndLocations extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEndLocations(){
            }
        
            /*
             * Prints out the locations page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->locations->template();
            }
        }
    }