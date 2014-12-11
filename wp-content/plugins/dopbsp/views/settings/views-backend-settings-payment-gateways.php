<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/setttings/views-backend-settings-payment-gateways.php
* File Version            : 1.0
* Created / Last Modified : 10 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end payment gateways settings views class.
*/

    if (!class_exists('DOPBSPViewsSettingsPaymentGateways')){
        class DOPBSPViewsSettingsPaymentGateways extends DOPBSPViewsSettings{
            /*
             * Constructor
             */
            function DOPBSPViewsSettingsPaymentGateways(){
            }
            
            /*
             * Returns payment gateways settings template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): calendar ID
             * 
             * @return payment gateways settings HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                
                $settings_payment = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings_payment.' WHERE calendar_id='.$id);
?>
                <div class="inputs-wrapper">
<?php            
                    /*
                     * Pay on arrival.
                     */
                    $this->displaySwitchInput(array('id' => 'arrival_enabled',
                                                    'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_ENABLED'),
                                                    'value' => $settings_payment->arrival_enabled,
                                                    'settings_id' => $settings_payment->id,
                                                    'settings_type' => 'payment',
                                                    'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_ENABLED_HELP'),
                                                    'container_class' => ''));  
                    /*
                     * Pay on arrival with approval.
                     */
                    $this->displaySwitchInput(array('id' => 'arrival_with_approval_enabled',
                                                    'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_WITH_APPROVAL_ENABLED'),
                                                    'value' => $settings_payment->arrival_with_approval_enabled,
                                                    'settings_id' => $settings_payment->id,
                                                    'settings_type' => 'payment',
                                                    'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_WITH_APPROVAL_ENABLED_HELP')));
                    /*
                     * Redirect.
                     */
                    $this->displayTextInput(array('id' => 'redirect',
                                                  'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_REDIRECT'),
                                                  'value' => $settings_payment->redirect,
                                                  'settings_id' => $settings_payment->id,
                                                  'settings_type' => 'payment',
                                                  'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYMENT_REDIRECT_HELP'),
                                                  'container_class' => 'last'));
?>
                </div>
<?php
/*
 * ACTION HOOK (dopbsp_action_views_settings_payment_gateways) ***************** Add payment gateways settings.
 */
                do_action('dopbsp_action_views_settings_payment_gateways', array('settings_payment' => $settings_payment));
            }
        }
    }