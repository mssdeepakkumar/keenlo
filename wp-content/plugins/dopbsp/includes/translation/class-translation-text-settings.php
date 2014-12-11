<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-settings.php
* File Version            : 1.0
* Created / Last Modified : 13 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO settings translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextSettings')){
        class DOPBSPTranslationTextSettings{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextSettings(){
                /*
                 * Initialize settings text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'settings'));
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsHelp'));
                
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsCalendar'));
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsCalendarHelp'));
                
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsNotifications'));
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsNotificationsHelp'));
                
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsPaymentGateways'));
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsPaymentGatewaysHelp'));
                
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsUsers'));
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsUsersHelp'));
            }
            
            /*
             * Settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settings($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS',
                                        'parent' => '',
                                        'text' => 'Settings'));
                
                array_push($lang, array('key' => 'SETTINGS_TITLE',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'Settings'));
                
                array_push($lang, array('key' => 'SETTINGS_GENERAL_TITLE',
                                        'parent' => 'PARENT_SETTINGS',
                                        'text' => 'General settings'));
                
                return $lang;
            }
            
            /*
             * Settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsHelp($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Help'));
                
                array_push($lang, array('key' => 'SETTINGS_HELP',
                                        'parent' => 'PARENT_SETTINGS_HELP',
                                        'text' => 'Edit booking system settings.'));
                
                return $lang;
            }
            
            /*
             * Calendar settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsCalendar($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_CALENDAR',
                                        'parent' => '',
                                        'text' => 'Settings - Calendar'));
                
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_TITLE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Calendar settings'));
                
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_NAME',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Name'));
                /*
                 * General settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'General settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_DATE_TYPE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Date type'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_DATE_TYPE_AMERICAN',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'American (mm dd, yyyy)'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_DATE_TYPE_EUROPEAN',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'European (dd mm yyyy)'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_TEMPLATE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Style views'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_BOOKING_STOP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Stop booking x minutes in advance'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_MONTHS_NO',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Number of months displayed'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_VIEW_ONLY',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'View only info'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_POST_ID',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Post ID'));
                /*
                 * Currency settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CURRENCY_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Currency settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CURRENCY',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Currency'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Currency position'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION_BEFORE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Before'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION_AFTER',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'After'));
                /*
                 * Days settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Days settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_AVAILABLE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Available days'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_FIRST',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'First day'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_MULTIPLE_SELECT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Use Check in/Check out'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_MORNING_CHECK_OUT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Morning check out'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_DETAILS_FROM_HOURS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Use hours details to set day details'));
                /*
                 * Hours settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Hours settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Use hours'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_INFO_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable hours info'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_DEFINITIONS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Define hours'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_MULTIPLE_SELECT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Use start/finish hours'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_AMPM',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable AM/PM format'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Add last selected hour price to total price'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_INTERVAL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable hours interval'));
                /*
                 * Sidebar settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Sidebar settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_STYLE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Sidebar style'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_NO_ITEMS_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable number of items select'));
                /*
                 * Rules settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_RULES_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Rules settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_RULES',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select rule'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_RULES_NONE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'None'));
                /*
                 * Extras settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_EXTRAS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Extras settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_EXTRAS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select extra'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_EXTRAS_NONE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'None'));
                /*
                 * Cart settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CART_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Cart settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CART_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable cart'));
                /*
                 * Discounts settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DISCOUNTS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Discounts settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DISCOUNTS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select discount'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DISCOUNTS_NONE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'None'));
                /*
                 * Taxes & fees settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_FEES_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Taxes & fees settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_FEES',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select taxes and/or fees'));
                /*
                 * Coupons settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_COUPONS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Coupons settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_COUPONS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select coupons'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_COUPONS_NONE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'None'));
                /*
                 * Deposit settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Deposit settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DEPOSIT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Deposit value'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_TYPE',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Deposit type'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_TYPE_FIXED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Fixed'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_TYPE_PERCENT',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Percent'));
                /*
                 * Forms ssettings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_FORMS_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Forms settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_FORMS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Select form'));
                /*
                 * Order settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_ORDER_SETTINGS',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Order settings'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Enable Terms & Conditions'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_LINK',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Terms & Conditions link'));
                
                return $lang;
            }
            
            /*
             * Calendar settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsCalendarHelp($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Calendar - Help'));
                
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_NAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Change calendar name.'));
                /*
                 * General settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_DATE_TYPE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: American. Select date format: American (mm dd, yyyy) or European (dd mm yyyy).'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_TEMPLATE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: default. Select styles views.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_BOOKING_STOP_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR',
                                        'text' => 'Default value: 0. Set the number of minutes before the booking is stopped in advance. For 1 hour you have 60 minutes, for 1 day you have 1440 minutes.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_MONTHS_NO_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: 1. Set the number of months initialy displayed. Maximum number allowed is 6.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_VIEW_ONLY_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Set to display only booking information in front end.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_GENERAL_POST_ID_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Set post ID were the calendar will be added. It is mandatory if you create a searching system through some calendars.'));
                /*
                 * Currency settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CURRENCY_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: United States Dollar ($, USD). Select calendar currency.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CURRENCY_POSITION_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Before. Select currency position.'));
                /*
                 * Days settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_MULTIPLE_SELECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Use Check in/Check out or select only one day.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_AVAILABLE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: all available. Select available weekdays.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_FIRST_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Monday. Select calendar first day.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_MORNING_CHECK_OUT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. This option enables "Check in" in the afternoon of first day and "Check out" in the morning of the day after last day.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DAYS_DETAILS_FROM_HOURS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Check this option, when hours are enabled, if you want for days details to be updated (calculated) from hours details or disable it if you want to have complete control of day derails.'));
                /*
                 * Hours settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Enable hours for the calendar.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_INFO_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Display hours info when you hover a day in calendar.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_DEFINITIONS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter hh:mm ... add one per line. Changing the definitions will overwrite any previous hours data. Use only 24 hours format.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_MULTIPLE_SELECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Use Start/Finish Hours or select only one hour.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_AMPM_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Display hours in AM/PM format. NOTE: Hours definitions still need to be in 24 hours format.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. It calculates the total price before the last hours selected if Disabled. It calculates the total price including the last hour selected if Enabled. <br /><br /><strong>Warning: </strong> In administration area the last hours from your definitions list will not be displayed.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_HOURS_INTERVAL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Show hours interval from the current hour to the next one.'));
                /*
                 * Sidebar settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_STYLE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Set sidebar position and number of columns.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_SIDEBAR_NO_ITEMS_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Enabled. Set to display number of items you want to book in front end.'));
                /*
                 * Rules settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_RULES_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar rules.'));
                /*
                 * Extras settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_EXTRAS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar extras.'));
                /*
                 * Cart settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_CART_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Use a shopping cart in calendar.'));
                /*
                 * Discounts settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DISCOUNTS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar discount.'));
                /*
                 * Taxes & fees settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_FEES_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar taxes and/or fees.'));
                /*
                 * Coupons settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_COUPONS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar coupons.'));
                /*
                 * Deposit settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: 0. Set calendar deposit value.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_DEPOSIT_TYPE_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Percent. Set deposit value type.'));
                /*
                 * Forms settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_FORMS_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Select calendar form.'));
                /*
                 * Order settings help.
                 */
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Enable Terms & Conditions check box.'));
                array_push($lang, array('key' => 'SETTINGS_CALENDAR_ORDER_TERMS_AND_CONDITIONS_LINK_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter the link to Terms & Conditions page.'));
                
                return $lang;
            }
            
            /*
             * Notifications settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsNotifications($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'parent' => '',
                                        'text' => 'Settings - Notifications'));
                
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_TITLE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notifications'));
                
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_TEMPLATES',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Email templates'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notifications emails'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_REPLY',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Reply email'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_NAME',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Email name'));
                /*
                 * Send notifications.
                 */
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_TITLE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Enable notifications'));
                
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_ADMIN',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify admin on book request'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_USER',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user on book request'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_ADMIN',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify admin on approved book request'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_USER',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user on approved book request'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_APPROVED',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user when reservation is approved'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_CANCELED',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user when reservation is canceled'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_REJECTED',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Notify user when reservation is rejected'));
                /*
                 * SMTP settings.
                 */
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_TITLE',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP settings'));
                
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'Enable SMTP'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP host name'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP host port'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_SSL',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP SSL conenction'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_USER',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP host user'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_PASSWORD',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS',
                                        'text' => 'SMTP host password'));
                
                return $lang;
            }
            
            /*
             * Notifications settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsNotificationsHelp($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Notifications - Help'));
                
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_TEMPLATES_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Select email templates.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the email were you will be notified about booking requests or you will use to notify users. Separate multiple emails with ; character.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_REPLY_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the reply email that will appear in the email the user will receive.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_EMAIL_NAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter the name that will appear in the email the user will receive.'));
                /*
                 * Send notifications.
                 */
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_ADMIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to admin on book request.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user on book request.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_ADMIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to admin on book request and reservation is approved.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_BOOK_WITH_APPROVAL_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user on book request and reservation is approved.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_APPROVED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user when reservation is approved.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_CANCELED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user when reservation is canceled.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SEND_REJECTED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enable to send an email notification to user when reservation is rejected.'));
                /*
                 * SMTP
                 */
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Use SMTP to send emails.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_HOST_NAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter SMTP host name.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_HOST_PORT_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter SMTP host port.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_SSL_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Use a  SSL conenction.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter SMTP host username.'));
                array_push($lang, array('key' => 'SETTINGS_NOTIFICATIONS_SMTP_PASSWORD_HELP',
                                        'parent' => 'PARENT_SETTINGS_NOTIFICATIONS_HELP',
                                        'text' => 'Enter SMTP host password.'));
                
                return $lang;
            }
            
            /*
             * Payment gateways settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsPaymentGateways($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'parent' => '',
                                        'text' => 'Settings - Payment gateways'));
                
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_TITLE',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Payment gateways'));
                
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Enable payment on arrival'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_WITH_APPROVAL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Enable instant approval'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_REDIRECT',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS',
                                        'text' => 'Redirect after book'));
                
                return $lang;
            }
            
            /*
             * Payment gateways settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsPaymentGatewaysHelp($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Payment gateways - Help'));
                
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_HELP',
                                        'text' => 'Default value: Enabled. Allow user to pay on arrival. Need approval.'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_ARRIVAL_WITH_APPROVAL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Default value: Disabled. Instantly approve the reservation once the request to pay on arrival has been submitted.'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYMENT_REDIRECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_CALENDAR_HELP',
                                        'text' => 'Enter the URL where to redirect after the booking request has been sent. Leave it blank to not redirect.'));
                
                return $lang;
            }
            
            /*
             * Users settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsUsers($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_USERS',
                                        'parent' => '',
                                        'text' => 'Settings - Users permissions'));
                
                array_push($lang, array('key' => 'SETTINGS_USERS_TITLE',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Users permissions'));
                /*
                 * Users permissions.
                 */
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Set users permissions to use the booking system'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_ADMINISTRATORS_LABEL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Allow %s users to view all the calendars from all the users and/or individually add/edit them.'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_LABEL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Allow %s users to view the plugin and individually edit only their own calendars.'));
                /*
                 * Users custom posts permissions.
                 */
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_CUSTOM_POSTS',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Set users permissions to use custom posts'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_CUSTOM_POSTS_LABEL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Allow %s users to use custom posts.'));
                /*
                 * Individual users permissions.
                 */
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_INDIVIDUAL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Set permissions on individual users'));
                /*
                 * Search filters.
                 */
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ROLE',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Change role to'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ROLE_ALL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'All'));
                
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Order by'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_EMAIL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Email'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_ID',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'ID'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_USERNAME',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Username'));
                
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Order'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_ASCENDING',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Ascending'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_DESCENDING',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Descending'));
                
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_FILTERS_SEARCH',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Search'));
                /*
                 * Users list.
                 */
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_LIST_ID',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'ID'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_USERNAME',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Username'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_EMAIL',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Email'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_ROLE',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Role'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_VIEW',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'View all calendars'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_USE',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Use booking system'));
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_USE_CUSTOM_POSTS',
                                        'parent' => 'PARENT_SETTINGS_USERS',
                                        'text' => 'Use custom posts'));
                
                return $lang;
            }
            
            /*
             * Users settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsUsersHelp($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_USERS_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - Users Permissions - Help'));
                
                array_push($lang, array('key' => 'SETTINGS_USERS_PERMISSIONS_HELP',
                                        'parent' => 'PARENT_SETTINGS_USERS_HELP',
                                        'text' => 'Allow administrators to edit/view all calendars and other users to use the plugin.'));
                array_push($lang, array('key' => 'SETTINGS_USERS_CUSTOM_POSTS_PERMISSIONS_HELP',
                                        'parent' => 'PARENT_SETTINGS_USERS_HELP',
                                        'text' => 'Allow users to use custom posts.'));
                
                return $lang;
            }
        }
    }