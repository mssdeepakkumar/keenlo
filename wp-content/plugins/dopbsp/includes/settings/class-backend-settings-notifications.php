<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/settings/class-backend-settings-notifications.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end notifications settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettingsNotifications')){
        class DOPBSPBackEndSettingsNotifications extends DOPBSPBackEndSettings{
            /*
             * Constructor
             */
            function DOPBSPBackEndSettingsNotifications(){
            }
            
            /*
             * Display notifications settings.
             * 
             * @post id (integer): calendar ID
             * 
             * @return emails settings HTML
             */
            function display(){
                global $DOPBSP;
                
                $DOPBSP->views->settings_notifications->template(array('id' => $_POST['id']));
                
                die();
            }
        }
    }