<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/class-update.php
* File Version            : 1.0
* Created / Last Modified : 26 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO update PHP class.
*/         
     
    if (!class_exists('DOPBSPUpdate')){
        class DOPBSPUpdate{
            /*
             * Constructor
             */
            function DOPBSPUpdate(){
            
            }
            
            /*
             * Update database. Rename table columns and transfer data from old tables.
             */
            function database(){
                global $wpdb;
                global $DOPBSP;
                
                $current_db_version = get_option('DOPBSP_db_version');
                
                if ($current_db_version != ''){
                    if ($current_db_version < 2.0){
                        /*
                         * Update settings table.
                         */
                        $control_data = $wpdb->query('SHOW TABLES LIKE "'.$DOPBSP->tables->settings.'"');

                        if ($wpdb->num_rows != 0){
                            $new_columns = array('available_days' => 'CHANGE available_days days_available VARCHAR(128) DEFAULT "'.DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_AVAILABLE.'" COLLATE '.DOPBSP_CONFIG_DATABASE_COLLATION.' NOT NULL',
                                                 'details_from_hours' => 'CHANGE details_from_hours days_details_from_hours VARCHAR(6) DEFAULT "'.DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_DETAILS_FROM_HOURS.'" COLLATE '.DOPBSP_CONFIG_DATABASE_COLLATION.' NOT NULL',
                                                 'first_day' => 'CHANGE first_day days_first INT DEFAULT '.DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_FIRST.' NOT NULL',
                                                 'morning_check_out' => 'CHANGE morning_check_out days_morning_check_out VARCHAR(6) DEFAULT "'.DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_MORNING_CHECK_OUT.'" COLLATE '.DOPBSP_CONFIG_DATABASE_COLLATION.' NOT NULL',
                                                 'multiple_days_select' => 'CHANGE multiple_days_select days_multiple_select VARCHAR(6) DEFAULT "'.DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_MULTIPLE_SELECT.'" COLLATE '.DOPBSP_CONFIG_DATABASE_COLLATION.' NOT NULL',
                                                 'last_hour_to_total_price' => 'CHANGE last_hour_to_total_price hours_add_last_hour_to_total_price VARCHAR(6) DEFAULT "'.DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE.'" COLLATE '.DOPBSP_CONFIG_DATABASE_COLLATION.' NOT NULL',
                                                 'multiple_hours_select' => 'CHANGE multiple_hours_select hours_multiple_select VARCHAR(6) DEFAULT "'.DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_MULTIPLE_SELECT.'" COLLATE '.DOPBSP_CONFIG_DATABASE_COLLATION.' NOT NULL',
                                                 'no_items_enabled' => 'CHANGE no_items_enabled sidebar_no_items_enabled VARCHAR(6) DEFAULT "'.DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_SIDEBAR_NO_ITEMS_ENABLED.'" COLLATE '.DOPBSP_CONFIG_DATABASE_COLLATION.' NOT NULL');

                            $columns = $wpdb->get_results('SHOW COLUMNS FROM '.$DOPBSP->tables->settings);

                            foreach ($columns as $column){
                                foreach ($new_columns as $key => $query){
                                    if ($column->Field == $key){
                                        $wpdb->query('ALTER TABLE '.$DOPBSP->tables->settings.' '.$query);
                                    }
                                }
                            }
                            
                            /*
                             * Update notifications & payment settings.
                             */
                            $notifications = $wpdb->query('SHOW TABLES LIKE "'.$DOPBSP->tables->settings_notifications.'"');

                            if (!$notifications){
                                if (get_option('DOPBSP_db_update_settings') == ''){
                                    add_option('DOPBSP_db_update_settings', 'true');
                                }
                                else{
                                    update_option('DOPBSP_db_update_settings', 'true');
                                }
                            }
                        }

                        /*
                         * Update reservation table.
                         */
                        $control_data = $wpdb->query('SHOW TABLES LIKE "'.$DOPBSP->tables->reservations.'"');

                        if ($wpdb->num_rows != 0){
                            $new_columns = array('total_price' => 'CHANGE total_price price_total FLOAT DEFAULT '.DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_PRICE_TOTAL.' NOT NULL',
                                                 'discount' => 'CHANGE discount discount_price FLOAT DEFAULT '.DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_DISCOUNT_PRICE.' NOT NULL',
                                                 'deposit' => 'CHANGE deposit deposit_price FLOAT DEFAULT '.DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_DEPOSIT_PRICE.' NOT NULL',
                                                 'paypal_transaction_id' => 'CHANGE paypal_transaction_id transaction_id VARCHAR(128) DEFAULT "'.DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_TRANSACTION_ID.'" COLLATE '.DOPBSP_CONFIG_DATABASE_COLLATION.' NOT NULL',
                                                 'info' => 'CHANGE info form TEXT COLLATE '.DOPBSP_CONFIG_DATABASE_COLLATION.' NOT NULL');
                            $valid = true;

                            $columns = $wpdb->get_results('SHOW COLUMNS FROM '.$DOPBSP->tables->reservations);
                                
                            foreach ($columns as $column){
                                if ($column->Field == 'discount_price'
                                        || $column->Field == 'deposit_price'){
                                    $valid = false;
                                }
                            }
                            
                            if ($valid){
                                foreach ($columns as $column){
                                    foreach ($new_columns as $key => $query){
                                        if ($column->Field == $key){
                                            $wpdb->query('ALTER TABLE '.$DOPBSP->tables->reservations.' '.$query);
                                        }
                                    }
                                }  
                                
                                /*
                                 * Update reservations data.
                                 */
                                $reservations = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->reservations);
                                
                                foreach ($reservations as $reservation){
                                    switch ($reservation->payment_method){
                                        case '0':
                                            $payment_method = 'none';
                                            break;
                                        case '1':
                                            $payment_method = 'default';
                                            break;
                                        case '2':
                                            $payment_method = 'paypal';
                                            break;
                                        default:
                                            $payment_method = $reservation->payment_method;
                                    }
                                    
                                    $form = json_decode($reservation->form);
                                    
                                    for ($i=0; $i<count($form); $i++){
                                        $form[$i]->translation = $form[$i]->name;
                                    }
                                    
                                    $wpdb->update($DOPBSP->tables->reservations, array('discount_price' => $reservation->discount,
                                                                                       'deposit_price' => $reservation->deposit,
                                                                                       'form' => json_encode($form),
                                                                                       'payment_method' => $payment_method), 
                                                                                 array('id' => $reservation->id));
                                }  
                            }
                        }
                        
                        /*
                         * Update forms tables.
                         */
                        $fields = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms_fields);
                        
                        foreach ($fields as $field){
                            if (!is_object(json_decode($field->translation))){
                                $wpdb->update($DOPBSP->tables->forms_fields, array('translation' => stripslashes($field->translation)), 
                                                                             array('id' => $field->id));
                            }
                        }
                    }
                }
            }
            
            /*
             * Update database settings. Add data to new created tables.
             */
            function databaseSettings(){
                global $wpdb;
                global $DOPBSP;
                
                $settings = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->settings);
                
                foreach ($settings as $data){
                    /*
                     * Update notifications settings.
                     */
                    $wpdb->insert($DOPBSP->tables->settings_notifications, array('id' => $data->id,
                                                                                 'calendar_id' => $data->calendar_id,
                                                                                 'email' => isset($data->notifications_email) ? $data->notifications_email:DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_EMAIL,
                                                                                 'smtp_enabled' => isset($data->smtp_enabled) ? $data->smtp_enabled:DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_ENABLED,
                                                                                 'smtp_host_name' => isset($data->smtp_host_name) ? $data->smtp_host_name:DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_HOST_NAME,
                                                                                 'smtp_host_port' => isset($data->smtp_host_port) ? $data->smtp_host_port:DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_HOST_PORT,
                                                                                 'smtp_ssl' => isset($data->smtp_ssl) ? $data->smtp_ssl:DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_SSL,
                                                                                 'smtp_user' => isset($data->smtp_user) ? $data->smtp_user:DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_USER,
                                                                                 'smtp_password' => isset($data->smtp_password) ? $data->smtp_password:DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_PASSWORD));
                    /*
                     * Update payment settings.
                     */
                    $wpdb->insert($DOPBSP->tables->settings_payment, array('id' => $data->id,
                                                                           'calendar_id' => $data->calendar_id,
                                                                           'arrival_enabled' => isset($data->payment_arrival_enabled) ? $data->payment_arrival_enabled:DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_ARRIVAL_ENABLED,
                                                                           'arrival_with_approval_enabled' => isset($data->instant_booking) ? $data->instant_booking:DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_ARRIVAL_WITH_APPROVAL_ENABLED,
                                                                           'paypal_enabled' => isset($data->payment_paypal_enabled) ? $data->payment_paypal_enabled:DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_ENABLED,
                                                                           'paypal_username' => isset($data->payment_paypal_username) ? $data->payment_paypal_username:DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_USERNAME,
                                                                           'paypal_password' => isset($data->payment_paypal_password) ? $data->payment_paypal_password:DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_PASSWORD,
                                                                           'paypal_signature' => isset($data->payment_paypal_signature) ? $data->payment_paypal_signature:DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_SIGNATURE,
                                                                           'paypal_credit_card' => isset($data->payment_paypal_credit_card) ? $data->payment_paypal_credit_card:DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_CREDIT_CARD,
                                                                           'paypal_sandbox_enabled' => isset($data->payment_paypal_sandbox_enabled) ? $data->payment_paypal_sandbox_enabled:DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_SANDBOX_ENABLED));
                }
                
                update_option('DOPBSP_db_update_settings', 'false');
            }
        }   
    }