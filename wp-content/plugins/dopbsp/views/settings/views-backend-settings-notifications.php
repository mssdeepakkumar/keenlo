<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/setttings/views-backend-settings-emails.php
* File Version            : 1.0
* Created / Last Modified : 19 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end emails settings views class.
*/

    if (!class_exists('DOPBSPViewsSettingsNotifications')){
        class DOPBSPViewsSettingsNotifications extends DOPBSPViewsSettings{
            /*
             * Constructor
             */
            function DOPBSPViewsSettingsNotifications(){
            }
            
            /*
             * Returns notifications settings template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): calendar ID
             * 
             * @return emails settings HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                
                $settings_notifications = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings_notifications.' WHERE calendar_id='.$id);
?>
                <div class="inputs-wrapper">
<?php
                    /*
                     * Select templates.
                     */
                    $this->displaySelectInput(array('id' => 'templates',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEMPLATES'),
                                                    'value' => $settings_notifications->templates,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_TEMPLATES_HELP'),
                                                    'options' => $this->listEmails('labels'),
                                                    'options_values' => $this->listEmails('ids')));
                    /*
                     * Admin notification emails.
                     */
                    $this->displayTextInput(array('id' => 'email',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL'),
                                                  'value' => $settings_notifications->email,
                                                  'settings_id' => $settings_notifications->id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_HELP')));
                    /*
                     * Admin notification replay email.
                     */
                    $this->displayTextInput(array('id' => 'email_reply',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_REPLY'),
                                                  'value' => $settings_notifications->email_reply,
                                                  'settings_id' => $settings_notifications->id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_REPLY_HELP')));
                    /*
                     * Admin notification name.
                     */
                    $this->displayTextInput(array('id' => 'email_name',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_NAME'),
                                                  'value' => $settings_notifications->email_name,
                                                  'settings_id' => $settings_notifications->id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_EMAIL_NAME_HELP'),
                                                  'container_class' => 'last'));
?>
                </div>
<?php
                /*
                 * SMTP configuration.
                 */
                $this->templateSMTP($settings_notifications);
                
                /*
                 * Send notifications.
                 */
                $this->templateSend($settings_notifications);
            }
            
            /*
             * Returns notifications send settings template.
             * 
             * @param settings_notifications (object): notifications settings
             * 
             * @return send notifications settings HTML
             */
            function templateSend($settings_notifications){
                global $DOPBSP;
?>
                 <div class="inputs-header last hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_TITLE'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('settings-notifications-send')" id="DOPBSP-inputs-button-settings-notifications-send" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-settings-notifications-send" class="inputs-wrapper last">
<?php
                    /*
                     * Send on book request to admin.
                     */
                    $this->displaySwitchInput(array('id' => 'send_book_admin',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_ADMIN'),
                                                    'value' => $settings_notifications->send_book_admin,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_ADMIN_HELP')));
                    /*
                     * Send on book request to user.
                     */
                    $this->displaySwitchInput(array('id' => 'send_book_user',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_USER'),
                                                    'value' => $settings_notifications->send_book_user,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_USER_HELP')));
                    /*
                     * Send on book with approval request to admin.
                     */
                    $this->displaySwitchInput(array('id' => 'send_book_with_approval_admin',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_ADMIN'),
                                                    'value' => $settings_notifications->send_book_with_approval_admin,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_ADMIN_HELP')));
                    /*
                     * Send on book with approval request to user.
                     */
                    $this->displaySwitchInput(array('id' => 'send_book_with_approval_user',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_USER'),
                                                    'value' => $settings_notifications->send_book_with_approval_user,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_USER_HELP')));
                    /*
                     * Send on approved reservation.
                     */
                    $this->displaySwitchInput(array('id' => 'send_approved',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_APPROVED'),
                                                    'value' => $settings_notifications->send_approved,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_APPROVED_HELP')));
                    /*
                     * Send on canceled reservation.
                     */
                    $this->displaySwitchInput(array('id' => 'send_canceled',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_CANCELED'),
                                                    'value' => $settings_notifications->send_canceled,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_CANCELED_HELP')));
                    /*
                     * Send on rejected reservation.
                     */
                    $this->displaySwitchInput(array('id' => 'send_rejected',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_REJECTED'),
                                                    'value' => $settings_notifications->send_rejected,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SEND_REJECTED_HELP'),
                                                    'container_class' => 'last'));
                    
/*
 * ACTION HOOK (dopbsp_action_views_settings_notifications) ***************** Add payment gateways settings.
 */
                    do_action('dopbsp_action_views_settings_notifications', array('settings_notifications' => $settings_notifications));
?>
                </div>
<?php
            }
            
            /*
             * Returns notifications SMTP settings template.
             * 
             * @param settings_notifications (object): notifications settings
             * 
             * @return SMTP settings HTML
             */
            function templateSMTP($settings_notifications){
                global $DOPBSP;
?>
                 <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_TITLE'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('settings-notifications-smtp')" id="DOPBSP-inputs-button-settings-notifications-smtp" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-settings-notifications-smtp" class="inputs-wrapper">
<?php
                    /*
                     * Enable SMTP.
                     */
                    $this->displaySwitchInput(array('id' => 'smtp_enabled',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_ENABLED'),
                                                    'value' => $settings_notifications->smtp_enabled,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_ENABLED_HELP')));
                    /*
                     * SMTP host name.
                     */
                    $this->displayTextInput(array('id' => 'smtp_host_name',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME'),
                                                  'value' => $settings_notifications->smtp_host_name,
                                                  'settings_id' => $settings_notifications->id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME_HELP')));
                    /*
                     * SMTP host port.
                     */
                    $this->displayTextInput(array('id' => 'smtp_host_port',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT'),
                                                  'value' => $settings_notifications->smtp_host_port,
                                                  'settings_id' => $settings_notifications->id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT_HELP')));
                    /*
                     * SMTP ssl.
                     */
                    $this->displaySwitchInput(array('id' => 'smtp_ssl',
                                                    'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_SSL'),
                                                    'value' => $settings_notifications->smtp_ssl,
                                                    'settings_id' => $settings_notifications->id,
                                                    'settings_type' => 'notifications',
                                                    'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_SSL_HELP')));
                    /*
                     * SMTP username.
                     */
                    $this->displayTextInput(array('id' => 'smtp_user',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_USER'),
                                                  'value' => $settings_notifications->smtp_user,
                                                  'settings_id' => $settings_notifications->id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_USER_HELP')));
                    /*
                     * SMTP password.
                     */
                    $this->displayTextInput(array('id' => 'smtp_password',
                                                  'label' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_PASSWORD'),
                                                  'value' => $settings_notifications->smtp_password,
                                                  'settings_id' => $settings_notifications->id,
                                                  'settings_type' => 'notifications',
                                                  'help' => $DOPBSP->text('SETTINGS_NOTIFICATIONS_SMTP_PASSWORD_HELP'),
                                                  'container_class' => 'last'));
?>
                </div>
<?php
            }
            
            /*
             * Get emails list.
             * 
             * @param type (string): type of list to be displayed (ids or labels)
             * 
             * @return a string with the emails
             */
            function listEmails($type = 'ids'){
                global $wpdb;
                global $DOPBSP;
                
                $result = array();
                
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $emails = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->emails.' ORDER BY id ASC');
                }
                elseif ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                    $emails = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->emails.' WHERE user_id='.wp_get_current_user()->ID.' OR user_id=0 ORDER BY id ASC');
                }
                
                if ($wpdb->num_rows != 0){
                    foreach ($emails as $email){
                        if ($type == 'ids'){
                            array_push($result, $email->id); 
                        }
                        else{
                            array_push($result, $email->id.': '.$email->name); 
                        } 
                    }
                    return implode(';;', $result);
                }
                else{
                    return '';
                }
            }
        }
    }