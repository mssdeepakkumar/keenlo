<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/settings/class-backend-settings-calendar.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end calendar settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettingsCalendar')){
        class DOPBSPBackEndSettingsCalendar extends DOPBSPBackEndSettings{
            /*
             * Constructor
             */
            function DOPBSPBackEndSettingsCalendar(){
            }
            
            /*
             * Display calendar settings.
             * 
             * @post id (integer): calendar ID
             * 
             * @return calendar settings HTML
             */
            function display(){
                global $DOPBSP;
                
                $DOPBSP->views->settings_calendar->template(array('id' => $_POST['id']));
                
                die();
            }
        }
    }