<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/class-backend-dashboard.php
* File Version            : 1.0
* Created / Last Modified : 27 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end dashboard PHP class.
*/

    if (!class_exists('DOPBSPBackEndDashboard')){
        class DOPBSPBackEndDashboard extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEndDashboard(){
            }
        
            /*
             * Prints out the dashboard page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->dashboard->template();
            }
        }
    }