<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/class-payment-gateways.php
* File Version            : 1.0
* Created / Last Modified : 02 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO payment gateways PHP class.
*/

    if (!class_exists('DOPBSPPaymentGateways')){
        class DOPBSPPaymentGateways{
            /*
             * Private variables.
             */
            private $payment_gateways = array();
            
            /*
             * Public variables.
             */
            public $paypal;
            
            /*
             * Constructor
             */
            function DOPBSPPaymentGateways(){
                $this->init($this->payment_gateways);
                
                $this->payment_gateways = apply_filters('dopbsp_filter_payment_gateways', $this->payment_gateways);
            }
            
            /*
             * Set payment gateways classes.
             */
            function init($payment_gateways){
                /*
                 * Initialize PayPal class.
                 */
                if (class_exists('DOPBSPPayPal')){
                    $this->paypal = new DOPBSPPayPal();
                }
            }
            
            /*
             * Get payment gateways.
             * 
             * @return list of payment gateways
             */
            function get(){
                return $this->payment_gateways;
            }
        }
    }