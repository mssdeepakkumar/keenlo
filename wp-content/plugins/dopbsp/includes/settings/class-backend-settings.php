<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/settings/class-backend-settings.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettings')){
        class DOPBSPBackEndSettings extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEndSettings(){
            }
        
            /*
             * Prints out the settings page.
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->settings->template();
            }
            
            /*
             * Edit settings.
             * 
             * @post id (integer): calendar ID
             * @post settings_type (integer): settings type
             * @post field (string): option database field
             * @post value (combined): the value with which the option will be modified
             */
            function set(){
                global $wpdb;
                global $DOPBSP;
                
                $id = $_POST['id'];
                $settings_type = $_POST['settings_type'];
                $field = $_POST['field'];
                $value = $field == 'hours_definitions' ? json_encode($_POST['value']):$_POST['value'];
                
                switch ($settings_type){
                    case 'notifications':
                        $table = $DOPBSP->tables->settings_notifications;
                        break;
                    case 'payment':
                        $table = $DOPBSP->tables->settings_payment;
                        break;
                    default:
                        $table = $DOPBSP->tables->settings;
                }
                
                $wpdb->update($table, array($field => $value), 
                                      array('id' => $id));
                
                die();
            }
        }
    }