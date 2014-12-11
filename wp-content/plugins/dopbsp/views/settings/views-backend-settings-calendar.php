<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/views-backend-settings-calendar.php
* File Version            : 1.0
* Created / Last Modified : 13 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end calendar settings views class.
*/

    if (!class_exists('DOPBSPViewsSettingsCalendar')){
        class DOPBSPViewsSettingsCalendar extends DOPBSPViewsSettings{
            /*
             * Constructor
             */
            function DOPBSPViewsSettingsCalendar(){
            }
            
            /*
             * Returns calendar settings template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): calendar ID
             * 
             * @return calendar settings HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                
                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$id);
                
                if ($id != 0){
                    $calendar = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id='.$id);
?>
                <div class="inputs-wrapper">
                    <div class="input-wrapper last">
                         <label for="DOPBSP-settings-name"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_NAME'); ?></label>
                         <input type="text" name="DOPBSP-settings-name" id="DOPBSP-settings-name" value="<?php echo $calendar->name; ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPCalendar.edit(<?php echo $calendar->id; ?>, 'name', 'name', this.value);}" onpaste="DOPBSPCalendar.edit(<?php echo $calendar->id; ?>, 'name', 'name', this.value)" onblur="DOPBSPCalendar.edit(<?php echo $calendar->id; ?>, 'name', 'name', this.value, true)" />
                         <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_NAME_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
                </div>
<?php
                }
                
                $this->templateGeneral($settings);
                $this->templateCurrency($settings);
                $this->templateDays($settings);
                $this->templateHours($settings);
                $this->templateSidebar($settings);
                $this->templateRules($settings);
                $this->templateExtras($settings);
                $this->templateCart($settings);
                $this->templateDiscounts($settings);
                $this->templateFees($settings);
                $this->templateCoupons($settings);
                $this->templateDeposit($settings);
                $this->templateForms($settings);
                $this->templateOrder($settings);
            }
            
            /*
             * Returns calendar general settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return general settings HTML
             */
            function templateGeneral($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('general-settings')" id="DOPBSP-inputs-button-general-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-general-settings" class="inputs-wrapper">
<?php   
                /*
                 * Select date type.
                 */
                $this->displaySelectInput(array('id' => 'date_type',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_DATE_TYPE'),
                                                'value' => $settings->date_type,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_DATE_TYPE_HELP'),
                                                'options' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_DATE_TYPE_AMERICAN').';;'.$DOPBSP->text('SETTINGS_CALENDAR_GENERAL_DATE_TYPE_EUROPEAN'),
                                                'options_values' => '1;;2'));
                /*
                 * Select calendar template.
                 */
                $this->displaySelectInput(array('id' => 'template',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_TEMPLATE'),
                                                'value' => $settings->template,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_TEMPLATE_HELP'),
                                                'options' => $this->listTemplates(),
                                                'options_values' => $this->listTemplates()));
                /*
                 * Stop booking x minutes in advance.
                 */
                $this->displayTextInput(array('id' => 'booking_stop',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_BOOKING_STOP'),
                                              'value' => $settings->booking_stop,
                                              'settings_id' => $settings->id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_BOOKING_STOP_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'small'));
                /*
                 * Number of months displayed.
                 */
                $this->displayTextInput(array('id' => 'months_no',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_MONTHS_NO'),
                                              'value' => $settings->months_no,
                                              'settings_id' => $settings->id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_MONTHS_NO_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'small'));
                /*
                 * Enable view only.
                 */
                $this->displaySwitchInput(array('id' => 'view_only',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_VIEW_ONLY'),
                                                'value' => $settings->view_only,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_VIEW_ONLY_HELP')));
                /*
                 * Enter the page URL were the calendar is used.
                 */
                $this->displayTextInput(array('id' => 'post_id',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_POST_ID'),
                                              'value' => $settings->post_id,
                                              'settings_id' => $settings->id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_GENERAL_POST_ID_HELP'),
                                              'container_class' => 'last'));
?>
                </div>
<?php                
            }
            
            /*
             * Returns calendar currency settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return currency settings HTML
             */
            function templateCurrency($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('currency-settings')" id="DOPBSP-inputs-button-currency-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-currency-settings" class="inputs-wrapper">
<?php
                /*
                 * Select currency.
                 */
                $this->displaySelectInput(array('id' => 'currency',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY'),
                                                'value' => $settings->currency,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_HELP'),
                                                'options' => $this->listCurrencies('labels'),
                                                'options_values' => $this->listCurrencies('ids')));
                /*
                 * Select currency position.
                 */
                $this->displaySelectInput(array('id' => 'currency_position',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION'),
                                                'value' => $settings->currency_position,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION_HELP'),
                                                'options' => $DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION_BEFORE').';;'.$DOPBSP->text('SETTINGS_CALENDAR_CURRENCY_POSITION_AFTER'),
                                                'options_values' => 'before;;after',
                                                'container_class' => 'last'));
?>
                </div>
<?php
            }
            
            /*
             * Returns calendar days settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return days settings HTML
             */
            function templateDays($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DAYS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('days-settings')" id="DOPBSP-inputs-button-days-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-days-settings" class="inputs-wrapper">
<?php
                /*
                 * Set available days.
                 */
                    $days_available = explode(',', $settings->days_available);
?>
                    <div class="input-wrapper">
                        <label class="for-checkboxes" for="DOPBSP-settings-days_available"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DAYS_AVAILABLE'); ?></label>
                        <div class="checkboxes-wrapper">
                            <input type="checkbox" name="DOPBSP-settings-days-available-0" id="DOPBSP-settings-days-available-0"<?php echo $days_available[0] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'days-available', 'days_available')" />
                            <label class="for-checkbox" for="DOPBSP-settings-days-available-0"><?php echo $DOPBSP->text('DAY_SUNDAY'); ?></label>
                            <br class="DOPBSP-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-1" id="DOPBSP-settings-days-available-1"<?php echo $days_available[1] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'days-available', 'days_available')" />
                            <label class="for-checkbox" for="DOPBSP-settings-days-available-1"><?php echo $DOPBSP->text('DAY_MONDAY'); ?></label>
                            <br class="DOPBSP-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-2" id="DOPBSP-settings-days-available-2"<?php echo $days_available[2] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'days-available', 'days_available')" />
                            <label class="for-checkbox" for="DOPBSP-settings-day-available-2"><?php echo $DOPBSP->text('DAY_TUESDAY'); ?></label>
                            <br class="DOPBSP-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-3" id="DOPBSP-settings-days-available-3"<?php echo $days_available[3] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'days-available', 'days_available')" />
                            <label class="for-checkbox" for="DOPBSP-settings-days-available-3"><?php echo $DOPBSP->text('DAY_WEDNESDAY'); ?></label>
                            <br class="DOPBSP-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-4" id="DOPBSP-settings-days-available-4"<?php echo $days_available[4] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'days-available', 'days_available')"  />
                            <label class="for-checkbox" for="DOPBSP-settings-days-available-4"><?php echo $DOPBSP->text('DAY_THURSDAY'); ?></label>
                            <br class="DOPBSP-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-5" id="DOPBSP-settings-days-available-5"<?php echo $days_available[5] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'days-available', 'days_available')" />
                            <label class="for-checkbox" for="DOPBSP-settings-days-available-5"><?php echo $DOPBSP->text('DAY_FRIDAY'); ?></label>
                            <br class="DOPBSP-clear" />
                            <input type="checkbox" name="DOPBSP-settings-days-available-6" id="DOPBSP-settings-days-available-6"<?php echo $days_available[6] == 'true' ? ' checked="checked"':'' ?> onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'days-available', 'days_available')" />
                            <label class="for-checkbox" for="DOPBSP-settings-days-available-6"><?php echo $DOPBSP->text('DAY_SATURDAY'); ?></label>
                        </div>
                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DAYS_AVAILABLE_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
<?php                        
                /*
                 * Select calendar first week day.
                 */
                $this->displaySelectInput(array('id' => 'days_first',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_FIRST'),
                                                'value' => $settings->days_first,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_FIRST_HELP'),
                                                'options' => $DOPBSP->text('DAY_MONDAY').';;'.$DOPBSP->text('DAY_TUESDAY').';;'.$DOPBSP->text('DAY_WEDNESDAY').';;'.$DOPBSP->text('DAY_THURSDAY').';;'.$DOPBSP->text('DAY_FRIDAY').';;'.$DOPBSP->text('DAY_SATURDAY').';;'.$DOPBSP->text('DAY_SUNDAY'),
                                                'options_values' => '1;;2;;3;;4;;5;;6;;7'));
                /*
                 * Enable multiple days select.
                 */
                $this->displaySwitchInput(array('id' => 'days_multiple_select',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_MULTIPLE_SELECT'),
                                                'value' => $settings->days_multiple_select,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_MULTIPLE_SELECT_HELP')));
                /*
                 * Enable morning check out.
                 */
                $this->displaySwitchInput(array('id' => 'days_morning_check_out',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_MORNING_CHECK_OUT'),
                                                'value' => $settings->days_morning_check_out,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_MORNING_CHECK_OUT_HELP')));
                /*
                 * Enable details from hours.
                 */
                $this->displaySwitchInput(array('id' => 'days_details_from_hours',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_DETAILS_FROM_HOURS'),
                                                'value' => $settings->days_details_from_hours,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DAYS_DETAILS_FROM_HOURS_HELP'),
                                                'container_class' => 'last'));
?>
                </div>
<?php
            }
            
            /*
             * Returns calendar hours settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return hours settings HTML
             */
            function templateHours($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_HOURS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('hours-settings')" id="DOPBSP-inputs-button-hours-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-hours-settings" class="inputs-wrapper">
<?php
                /*
                 * Hours enabled.
                 */
                $this->displaySwitchInput(array('id' => 'hours_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_ENABLED'),
                                                'value' => $settings->hours_enabled,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_ENABLED_HELP')));
                /*
                 * Hours info enabled.
                 */
                $this->displaySwitchInput(array('id' => 'hours_info_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INFO_ENABLED'),
                                                'value' => $settings->hours_info_enabled,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INFO_ENABLED_HELP')));
                /*
                 * Hours definitions.
                 */
                $this->displayHoursInput(array('id' => 'hours_definitions',
                                               'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_DEFINITIONS'),
                                               'value' => json_decode($settings->hours_definitions),
                                               'settings_id' => $settings->id,
                                               'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_DEFINITIONS_HELP')));
                /*
                 * Enable multiple hours select.
                 */
                $this->displaySwitchInput(array('id' => 'hours_multiple_select',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_MULTIPLE_SELECT'),
                                                'value' => $settings->hours_multiple_select,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_MULTIPLE_SELECT_HELP')));
                /*
                 * Set hours AM/PM.
                 */
                $this->displaySwitchInput(array('id' => 'hours_ampm',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_AMPM'),
                                                'value' => $settings->hours_ampm,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_AMPM_HELP')));
                /*
                 * Enable to add last hour to total price.
                 */
                $this->displaySwitchInput(array('id' => 'hours_add_last_hour_to_total_price',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE'),
                                                'value' => $settings->hours_add_last_hour_to_total_price,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE_HELP')));
                /*
                 * Enable hours interval.
                 */
                $this->displaySwitchInput(array('id' => 'hours_interval_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INTERVAL_ENABLED'),
                                                'value' => $settings->hours_interval_enabled,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_HOURS_INTERVAL_ENABLED_HELP'),
                                                'container_class' => 'last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar sidebar settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return sidebar settings HTML
             */
            function templateSidebar($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('sidebar-settings')" id="DOPBSP-inputs-button-sidebar-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-sidebar-settings" class="inputs-wrapper">
                    <div class="input-wrapper">
                        <label class="for-checkboxes"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_STYLE'); ?></label>
                        <input type="radio" name="DOPBSP-settings-sidebar_style" id="DOPBSP-settings-sidebar_style1" value="1" onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 1)"<?php echo $settings->sidebar_style == 1 ? 'checked="checked"':''; ?> />
                        <input type="radio" name="DOPBSP-settings-sidebar_style" id="DOPBSP-settings-sidebar_style2" value="2" onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 2)"<?php echo $settings->sidebar_style == 2 ? 'checked="checked"':''; ?> />
                        <input type="radio" name="DOPBSP-settings-sidebar_style" id="DOPBSP-settings-sidebar_style3" value="3" onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 3)"<?php echo $settings->sidebar_style == 3 ? 'checked="checked"':''; ?> />
                        <input type="radio" name="DOPBSP-settings-sidebar_style" id="DOPBSP-settings-sidebar_style4" value="4" onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 4)"<?php echo $settings->sidebar_style == 4 ? 'checked="checked"':''; ?> />
                        <input type="radio" name="DOPBSP-settings-sidebar_style" id="DOPBSP-settings-sidebar_style5" value="5" onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'sidebar-style', 'sidebar_style', 5)"<?php echo $settings->sidebar_style == 5 ? 'checked="checked"':''; ?> />
                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_STYLE_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
<?php    
                /*
                 * Enable number of items display.
                 */
                $this->displaySwitchInput(array('id' => 'sidebar_no_items_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_NO_ITEMS_ENABLED'),
                                                'value' => $settings->sidebar_no_items_enabled,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_SIDEBAR_NO_ITEMS_ENABLED_HELP'),
                                                'container_class' => 'last'));
?>
                </div>
<?php                
            }
            
            /*
             * Returns calendar rules settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return rules settings HTML
             */
            function templateRules($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_RULES_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('calendar-rules-settings')" id="DOPBSP-inputs-button-calendar-rules-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-rules-settings" class="inputs-wrapper">
<?php           
                /*
                 * Extra select.
                 */
                $this->displaySelectInput(array('id' => 'rule',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_RULES'),
                                                'value' => $settings->rule,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_RULES_HELP'),
                                                'options' => $this->listRules('labels'),
                                                'options_values' => $this->listRules('ids'),
                                                'container_class' => 'last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar extras settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return extras settings HTML
             */
            function templateExtras($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_EXTRAS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('calendar-extras-settings')" id="DOPBSP-inputs-button-calendar-extras-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-extras-settings" class="inputs-wrapper">
<?php           
                /*
                 * Extra select.
                 */
                $this->displaySelectInput(array('id' => 'extra',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_EXTRAS'),
                                                'value' => $settings->extra,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_EXTRAS_HELP'),
                                                'options' => $this->listExtras('labels'),
                                                'options_values' => $this->listExtras('ids'),
                                                'container_class' => 'last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar cart settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return cart settings HTML
             */
            function templateCart($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_CART_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('calendar-cart-settings')" id="DOPBSP-inputs-button-calendar-cart-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-cart-settings" class="inputs-wrapper">
<?php          
                /*
                 * Enable cart.
                 */
                $this->displaySwitchInput(array('id' => 'cart_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_CART_ENABLED'),
                                                'value' => $settings->cart_enabled,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_CART_ENABLED_HELP'),
                                                'container_class' => 'last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar discounts settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return discounts settings HTML
             */
            function templateDiscounts($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DISCOUNTS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('calendar-discounts-settings')" id="DOPBSP-inputs-button-calendar-discounts-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-discounts-settings" class="inputs-wrapper">
<?php           
                /*
                 * Discount select.
                 */
                $this->displaySelectInput(array('id' => 'discount',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DISCOUNTS'),
                                                'value' => $settings->discount,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DISCOUNTS_HELP'),
                                                'options' => $this->listDiscounts('labels'),
                                                'options_values' => $this->listDiscounts('ids'),
                                                'container_class' => 'last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar fees settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return fees settings HTML
             */
            function templateFees($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_FEES_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('calendar-fees-settings')" id="DOPBSP-inputs-button-calendar-fees-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-fees-settings" class="inputs-wrapper">
                    <div class="input-wrapper last">
                        <label class="for-checkboxes"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_FEES'); ?></label>
                        <div class="checkboxes-wrapper" id="DOPBSP-settings-fees">
<?php           
                /*
                 * Fees list.
                 */
                echo $this->listFees($settings);
?>
                        </div>
                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_FEES_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                    </div>
                </div>
<?php       
            }
            
            /*
             * Returns calendar coupons settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return coupons settings HTML
             */
            function templateCoupons($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_COUPONS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('calendar-coupons-settings')" id="DOPBSP-inputs-button-calendar-coupons-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-coupons-settings" class="inputs-wrapper">
<?php           
                /*
                 * Discount select.
                 */
                $this->displaySelectInput(array('id' => 'coupon',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_COUPONS'),
                                                'value' => $settings->coupon,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_COUPONS_HELP'),
                                                'options' => $this->listCoupons('labels'),
                                                'options_values' => $this->listCoupons('ids'),
                                                'container_class' => 'last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar deposit settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return deposit settings HTML
             */
            function templateDeposit($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('calendar-deposit-settings')" id="DOPBSP-inputs-button-calendar-deposit-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-deposit-settings" class="inputs-wrapper">
<?php           
                /*
                 * Deposit
                 */
                $this->displayTextInput(array('id' => 'deposit',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT'),
                                              'value' => $settings->deposit,
                                              'settings_id' => $settings->id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_HELP')));
                /*
                 * Deposit type.
                 */
                $this->displaySelectInput(array('id' => 'deposit_type',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_TYPE'),
                                                'value' => $settings->deposit_type,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_TYPE_HELP'),
                                                'options' => $DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_TYPE_FIXED').';;'.$DOPBSP->text('SETTINGS_CALENDAR_DEPOSIT_TYPE_PERCENT'),
                                                'options_values' => 'fixed;;percent',
                                                'container_class' => 'last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar form settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return form settings HTML
             */
            function templateForms($settings){
                global $DOPBSP;
?>
                <div class="inputs-header hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_FORMS_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('calendar-forms-settings')" id="DOPBSP-inputs-button-calendar-forms-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-forms-settings" class="inputs-wrapper">
<?php           
                /*
                 * Form select.
                 */
                $this->displaySelectInput(array('id' => 'form',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_FORMS'),
                                                'value' => $settings->form,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_FORMS_HELP'),
                                                'options' => $this->listForms('labels'),
                                                'options_values' => $this->listForms('ids'),
                                                'container_class' => 'last'));
?>
                </div>
<?php       
            }
            
            /*
             * Returns calendar order settings template.
             * 
             * @param settings (object): settings data
             * 
             * @return order settings HTML
             */
            function templateOrder($settings){
                global $DOPBSP;
?>
                <div class="inputs-header last hide">
                    <h3><?php echo $DOPBSP->text('SETTINGS_CALENDAR_ORDER_SETTINGS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('calendar-order-settings')" id="DOPBSP-inputs-button-calendar-order-settings" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-calendar-order-settings" class="inputs-wrapper last displayed">
<?php                
                /*
                 * Enable terms & conditions.
                 */
                $this->displaySwitchInput(array('id' => 'terms_and_conditions_enabled',
                                                'label' => $DOPBSP->text('SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_ENABLED'),
                                                'value' => $settings->terms_and_conditions_enabled,
                                                'settings_id' => $settings->id,
                                                'settings_type' => 'calendar',
                                                'help' => $DOPBSP->text('SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_ENABLED_HELP')));
                /*
                 * Terms & conditions link.
                 */
                $this->displayTextInput(array('id' => 'terms_and_conditions_link',
                                              'label' => $DOPBSP->text('SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_LINK'),
                                              'value' => $settings->terms_and_conditions_link,
                                              'settings_id' => $settings->id,
                                              'settings_type' => 'calendar',
                                              'help' => $DOPBSP->text('SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_LINK_HELP'),
                                              'container_class' => 'last'));
?>
                </div>
<?php       
            }
            
/*
 * Inputs.
 */
            /*
             * Create a textarea field for settings.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * settings_id (integer): settings ID
             *                      * help (string): field help
             *                      * container_class (string): container class
             * 
             * @return textarea HTML
             */
            function displayHoursInput($args){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $settings_id = $args['settings_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                
                $html = array();
                $hours_html = array();

                foreach ($value as $hour){
                    array_push($hours_html, $hour->value);
                }
                
                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-settings-'.$id.'">'.$label.'</label>');
                array_push($html, '     <textarea name="DOPBSP-settings-'.$id.'" id="DOPBSP-settings-'.$id.'" rows="5" cols="" onkeyup="if ((event.keyCode||event.which) != 9){DOPBSPSettings.set('.$settings_id.', \'calendar\', \'hours-definitions\', \''.$id.'\', this.value);}" onpaste="DOPBSPSettings.set('.$settings_id.', \'calendar\', \'hours-definitions\', \''.$id.'\', this.value)" onblur="DOPBSPSettings.set('.$settings_id.', \'calendar\', \'hours-definitions\', \''.$id.'\', this.value, true)">'.implode("\n", $hours_html).'</textarea>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
/*
 * Lists
 */         
            /*
             * Get templates list.
             * 
             * @return a string with the templates
             */
            function listTemplates(){
                global $DOPBSP;
                
                $folder = $DOPBSP->paths->abs.'templates/';
                $folderData = opendir($folder);
                $list = array();
                
                while (($file = readdir($folderData)) !== false){
                    if ($file != '.' && $file != '..' && $file != '.DS_Store'){                        
                        array_push($list, $file);
                    }
                }
                closedir($folderData);
                
                return implode(';;', $list);
            }
            
            /*
             * Get currencies list.
             * 
             * @param type (string): type of list to be displayed (ids or labels)
             * 
             * @return a string with the currencies
             */
            function listCurrencies($type = 'ids'){
                global $DOPBSP;
                
                $currencies = $DOPBSP->classes->currencies->getList();
                $result = array();
                
                for ($i=0; $i<count($currencies); $i++){
                    if ($type == 'ids'){
                        array_push($result, $currencies[$i]['code']);
                    }
                    else{
                        array_push($result, $currencies[$i]['name'].' ('.$currencies[$i]['sign'].', '.$currencies[$i]['code'].')');
                    }
                }
                
                return implode(';;', $result);
            }
            
            /*
             * Get rules list.
             * 
             * @param type (string): type of list to be displayed (ids or labels)
             * 
             * @return HTML with the extras
             */
            function listRules($type = 'ids'){
                global $wpdb;
                global $DOPBSP;
                
                $result = array();
                
                if ($type == 'ids'){
                    array_push($result, '0'); 
                }
                else{
                    array_push($result, $DOPBSP->text('SETTINGS_CALENDAR_RULES_NONE')); 
                }
                
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $rules = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->rules.' ORDER BY id ASC');
                }
                elseif ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                    $rules = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->rules.' WHERE user_id='.wp_get_current_user()->ID.' OR user_id=0 ORDER BY id ASC');
                }
                
                if ($wpdb->num_rows != 0){
                    foreach ($rules as $rule){
                        if ($type == 'ids'){
                            array_push($result, $rule->id); 
                        }
                        else{
                            array_push($result, $rule->id.': '.$rule->name); 
                        } 
                    }
                    return implode(';;', $result);
                }
                else{
                    return '';
                }
            }
            
            /*
             * Get extras list.
             * 
             * @param type (string): type of list to be displayed (ids or labels)
             * 
             * @return HTML with the extras
             */
            function listExtras($type = 'ids'){
                global $wpdb;
                global $DOPBSP;
                
                $result = array();
                
                if ($type == 'ids'){
                    array_push($result, '0'); 
                }
                else{
                    array_push($result, $DOPBSP->text('SETTINGS_CALENDAR_EXTRAS_NONE')); 
                }
                
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $extras = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->extras.' ORDER BY id ASC');
                }
                elseif ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                    $extras = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->extras.' WHERE user_id='.wp_get_current_user()->ID.' OR user_id=0 ORDER BY id ASC');
                }
                
                if ($wpdb->num_rows != 0){
                    foreach ($extras as $extra){
                        if ($type == 'ids'){
                            array_push($result, $extra->id); 
                        }
                        else{
                            array_push($result, $extra->id.': '.$extra->name); 
                        } 
                    }
                    return implode(';;', $result);
                }
                else{
                    return '';
                }
            }
           
            /*
             * Get fees list.
             * 
             * @param settings (object): settings data
             * 
             * @return HTML with the fees
             */
            function listFees($settings){
                global $wpdb;
                global $DOPBSP;
                
                $result = array();    
                $fees_data = ','.$settings->fees.',';
                $add_clear = false;
                
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $fees = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->fees.' ORDER BY id ASC');
                }
                elseif ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                    $fees = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->fees.' WHERE user_id='.wp_get_current_user()->ID.' OR user_id=0 ORDER BY id ASC');
                }
                
                if ($wpdb->num_rows != 0){
                    foreach ($fees as $fee){
                        if ($add_clear){
                            echo '<br class="DOPBSP-clear" />';
                        }
                        else{
                            $add_clear = true;
                        }
?>                          
                        <input type="checkbox" name="DOPBSP-settings-fee-<?php echo $fee->id; ?>" id="DOPBSP-settings-fee-<?php echo $fee->id; ?>"<?php echo strrpos($fees_data, ','.$fee->id.',') === false ? '':' checked="checked"'; ?> onclick="DOPBSPSettings.set('<?php echo $settings->id; ?>', 'calendar', 'fees', 'fees')" />
                        <label class="for-checkbox" for="DOPBSP-settings-fee-<?php echo $fee->id; ?>"><?php echo $fee->name; ?></label>
<?php
                    }
                }
            
                return implode('<br class="DOPBSP-clear" />', $result);
            }
            
            /*
             * Get discounts list.
             * 
             * @param type (string): type of list to be displayed (ids or labels)
             * 
             * @return a string with the discounts
             */
            function listDiscounts($type = 'ids'){
                global $wpdb;
                global $DOPBSP;
                
                $result = array();
                
                if ($type == 'ids'){
                    array_push($result, '0'); 
                }
                else{
                    array_push($result, $DOPBSP->text('SETTINGS_CALENDAR_DISCOUNTS_NONE')); 
                } 
                
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $discounts = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->discounts.' ORDER BY id ASC');
                }
                elseif ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                    $discounts = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->discounts.' WHERE user_id='.wp_get_current_user()->ID.' OR user_id=0 ORDER BY id ASC');
                }
                
                if ($wpdb->num_rows != 0){
                    foreach ($discounts as $discount){
                        if ($type == 'ids'){
                            array_push($result, $discount->id); 
                        }
                        else{
                            array_push($result, $discount->id.': '.$discount->name); 
                        } 
                    }
                }
            
                return implode(';;', $result);
            }
            
            /*
             * Get coupons list.
             * 
             * @param type (string): type of list to be displayed (ids or labels)
             * 
             * @return a string with the coupons
             */
            function listCoupons($type = 'ids'){
                global $wpdb;
                global $DOPBSP;
                
                $result = array();
                
                if ($type == 'ids'){
                    array_push($result, '0'); 
                }
                else{
                    array_push($result, $DOPBSP->text('SETTINGS_CALENDAR_COUPONS_NONE')); 
                } 
                
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $coupons = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->coupons.' ORDER BY id ASC');
                }
                elseif ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                    $coupons = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->coupons.' WHERE user_id='.wp_get_current_user()->ID.' OR user_id=0 ORDER BY id ASC');
                }
                
                if ($wpdb->num_rows != 0){
                    foreach ($coupons as $coupon){
                        if ($type == 'ids'){
                            array_push($result, $coupon->id); 
                        }
                        else{
                            array_push($result, $coupon->id.': '.$coupon->name); 
                        } 
                    }
                }
            
                return implode(';;', $result);
            }
           
            /*
             * Get forms list.
             * 
             * @param type (string): type of list to be displayed (ids or labels)
             * 
             * @return a string with the forms
             */
            function listForms($type = 'ids'){
                global $wpdb;
                global $DOPBSP;
                
                $result = array();
                
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $forms = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms.' ORDER BY id ASC');
                }
                elseif ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                    $forms = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms.' WHERE user_id='.wp_get_current_user()->ID.' OR user_id=0 ORDER BY id ASC');
                }
                
                if ($wpdb->num_rows != 0){
                    foreach ($forms as $form){
                        if ($type == 'ids'){
                            array_push($result, $form->id); 
                        }
                        else{
                            array_push($result, $form->id.': '.$form->name); 
                        } 
                    }
                }
            
                return implode(';;', $result);
            }
        }
    }