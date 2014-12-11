<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/settings/class-backend-settings-payment-gateways.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end payment gateways settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettingsPaymentGateways')){
        class DOPBSPBackEndSettingsPaymentGateways extends DOPBSPBackEndSettings{
            /*
             * Constructor
             */
            function DOPBSPBackEndSettingsPaymentGateways(){
            }
        
            /*
             * Prints out the payment gateways settings page.
             * 
             * @post id (integer): calendar ID
             * 
             * @return payment gateway settings HTML
             */
            function display(){
                global $DOPBSP;
                
                $DOPBSP->views->settings_payment_gateways->template(array('id' => $_POST['id']));
                
                die();
            }
        }
    }