<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/setttings/payment-gateways/views-backend-settings-paypal.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end PayPal settings views class.
*/

    if (!class_exists('DOPBSPViewsSettingsPayPal')){
        class DOPBSPViewsSettingsPayPal extends DOPBSPViewsSettingsPaymentGateways{
            /*
             * Constructor
             */
            function DOPBSPViewsSettingsPayPal(){
                add_action('dopbsp_action_views_settings_payment_gateways', array(&$this, 'template'));
                add_action('dopbsp_action_views_settings_notifications', array(&$this, 'templateNotifications'));
            }
            
            /*
             * Returns payment PayPal settings template.
             * 
             * @param args (array): function arguments
             *                      * settings_payment (object): payment settings
             * 
             * @return PayPal settings HTML
             */
            function template($args = array()){
                global $DOPBSP;
                
                $settings_payment = $args['settings_payment'];
?>
                <div class="inputs-header last <?php echo $settings_payment->paypal_enabled == 'true' ? 'hide':'display'; ?>">
                    <h3><?php echo $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('paypal')" id="DOPBSP-inputs-button-paypal" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-paypal" class="inputs-wrapper last <?php echo $settings_payment->paypal_enabled == 'true' ? 'displayed':'hidden'; ?>">
<?php
                    /*
                     * Enable PayPal.
                     */
                    $this->displaySwitchInput(array('id' => 'paypal_enabled',
                                                    'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_ENABLED'),
                                                    'value' => $settings_payment->paypal_enabled,
                                                    'settings_id' => $settings_payment->id,
                                                    'settings_type' => 'payment',
                                                    'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_ENABLED_HELP'),
                                                    'container_class' => ''));  
                    /*
                     * PayPal username.
                     */
                    $this->displayTextInput(array('id' => 'paypal_username',
                                                  'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_USERNAME'),
                                                  'value' => $settings_payment->paypal_username,
                                                  'settings_id' => $settings_payment->id,
                                                  'settings_type' => 'payment',
                                                  'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_USERNAME_HELP')));
                    /*
                     * PayPal password.
                     */
                    $this->displayTextInput(array('id' => 'paypal_password',
                                                  'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_PASSWORD'),
                                                  'value' => $settings_payment->paypal_password,
                                                  'settings_id' => $settings_payment->id,
                                                  'settings_type' => 'payment',
                                                  'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_PASSWORD_HELP')));
                    /*
                     * PayPal signature.
                     */
                    $this->displayTextInput(array('id' => 'paypal_signature',
                                                  'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SIGNATURE'),
                                                  'value' => $settings_payment->paypal_signature,
                                                  'settings_id' => $settings_payment->id,
                                                  'settings_type' => 'payment',
                                                  'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SIGNATURE_HELP')));
                    /*
                     * Enable credit card.
                     */
                    $this->displaySwitchInput(array('id' => 'paypal_credit_card',
                                                    'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_CREDIT_CARD'),
                                                    'value' => $settings_payment->paypal_credit_card,
                                                    'settings_id' => $settings_payment->id,
                                                    'settings_type' => 'payment',
                                                    'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_CREDIT_CARD_HELP'),
                                                    'container_class' => '')); 
                    /*
                     * Enable sandbox.
                     */
                    $this->displaySwitchInput(array('id' => 'paypal_sandbox_enabled',
                                                    'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_ENABLED'),
                                                    'value' => $settings_payment->paypal_sandbox_enabled,
                                                    'settings_id' => $settings_payment->id,
                                                    'settings_type' => 'payment',
                                                    'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_ENABLED_HELP')));  
                    /*
                     * PayPal redirect.
                     */
                    $this->displayTextInput(array('id' => 'paypal_redirect',
                                                  'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REDIRECT'),
                                                  'value' => $settings_payment->paypal_redirect,
                                                  'settings_id' => $settings_payment->id,
                                                  'settings_type' => 'payment',
                                                  'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REDIRECT_HELP'),
                                                  'container_class' => 'last'));
?>
                </div>
<?php
            }
            
            /*
             * Returns notifications PayPal settings template.
             * 
             * @param args (array): function arguments
             *                      * settings_notifications (object): notifications settings
             * 
             * @return PayPal settings HTML
             */
            function templateNotifications($args){
                global $DOPBSP;
                
                $settings_notifications = $args['settings_notifications'];
                
                /*
                 * Send on PayPal payment to admin.
                 */
                $this->displaySwitchInput(array('id' => 'send_paypal_admin',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_ADMIN'),
                                                'value' => $settings_notifications->send_paypal_admin,
                                                'settings_id' => $settings_notifications->id,
                                                'settings_type' => 'notifications',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_ADMIN_HELP')));
                /*
                 * Send on PayPal payment to user.
                 */
                $this->displaySwitchInput(array('id' => 'send_paypal_user',
                                                'label' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_USER'),
                                                'value' => $settings_notifications->send_paypal_user,
                                                'settings_id' => $settings_notifications->id,
                                                'settings_type' => 'notifications',
                                                'help' => $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_USER_HELP')));
            }
        }
    }