<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/events/class-backend-events.php
* File Version            : 1.0
* Created / Last Modified : 27 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end events PHP class.
*/

    if (!class_exists('DOPBSPBackEndEvents')){
        class DOPBSPBackEndEvents extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEndEvents(){
            }
        
            /*
             * Prints out the events page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->events->template();
            }
        }
    }