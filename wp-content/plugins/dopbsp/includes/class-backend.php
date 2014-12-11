<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/class-backend.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end PHP class.
*/

    if (!class_exists('DOPBSPBackEnd')){
        class DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEnd(){
                global $pagenow;
                
                /*
                 * Init back end.
                 */
                add_action('init', array(&$this, 'init'));
                
                /*
                 * Add styles needed outside plugin pages.
                 */
                add_action('admin_enqueue_scripts', array(&$this, 'addWPAdminStyles'));
                
                /*
                 * Add widgets scripts.
                 */
                if ($pagenow == 'widgets.php'){
                    add_action('admin_enqueue_scripts', array(&$this, 'addWidgetScripts'));
                }
                
                /*
                 * Add styles and scripts only on plugin pages.
                 */
                if ($this->validPage()){
                    add_action('admin_enqueue_scripts', array(&$this, 'addStyles'));
                    add_action('admin_enqueue_scripts', array(&$this, 'addScripts'));
                } else {
                    add_action('admin_enqueue_scripts', array(&$this, 'addWPAdminScripts'));
                }
            }
            
            /*
             * Add plugin's CSS files outside plugin's pages.
             */
            function addWPAdminStyles(){
                global $DOPBSP;
                
                /*
                 * Register Styles.
                 */
                wp_register_style('DOPBSP-css-backend-wp-admin', $DOPBSP->paths->url.'assets/gui/css/backend-wp-admin.css');
                wp_register_style('DOPBSP-css-backend-shortcodes', $DOPBSP->paths->url.'assets/gui/css/backend-shortcodes.css');
                
                /*
                 * Enqueue Styles.
                 */
                wp_enqueue_style('DOPBSP-css-backend-wp-admin');
                wp_enqueue_style('DOPBSP-css-backend-shortcodes');
            }
            
            /*
             * Add plugin's CSS files.
             */
            function addStyles(){
                global $DOPBSP;
                
                /*
                 * Register styles.
                 */
                wp_register_style('DOPBSP-css-dopselect', $DOPBSP->paths->url.'libraries/css/jquery.dop.Select.css');
                wp_register_style('DOPBSP-css-backend', $DOPBSP->paths->url.'assets/gui/css/backend.css');
                wp_register_style('DOPBSP-css-backend-calendar', $DOPBSP->paths->url.'assets/gui/css/jquery.dop.backend.BSPCalendar.css');
                wp_register_style('DOPBSP-css-backend-coupons', $DOPBSP->paths->url.'assets/gui/css/backend-coupons.css');
                wp_register_style('DOPBSP-css-backend-emails', $DOPBSP->paths->url.'assets/gui/css/backend-emails.css');
                wp_register_style('DOPBSP-css-backend-discounts', $DOPBSP->paths->url.'assets/gui/css/backend-discounts.css');
                wp_register_style('DOPBSP-css-backend-extras', $DOPBSP->paths->url.'assets/gui/css/backend-extras.css');
                wp_register_style('DOPBSP-css-backend-forms', $DOPBSP->paths->url.'assets/gui/css/backend-forms.css');
                wp_register_style('DOPBSP-css-backend-reservations', $DOPBSP->paths->url.'assets/gui/css/backend-reservations.css');
                wp_register_style('DOPBSP-css-backend-reservations-add', $DOPBSP->paths->url.'assets/gui/css/jquery.dop.backend.BSPReservationsAdd.css');
                wp_register_style('DOPBSP-css-backend-reservations-calendar', $DOPBSP->paths->url.'assets/gui/css/jquery.dop.backend.BSPReservationsCalendar.css');
                wp_register_style('DOPBSP-css-backend-settings', $DOPBSP->paths->url.'assets/gui/css/backend-settings.css');
                wp_register_style('DOPBSP-css-backend-translation', $DOPBSP->paths->url.'assets/gui/css/backend-translation.css');

                /*
                 * Enqueue styles.
                 */
                wp_enqueue_style('thickbox');
                wp_enqueue_style('DOPBSP-css-dopselect');
                wp_enqueue_style('DOPBSP-css-backend');
                wp_enqueue_style('DOPBSP-css-backend-calendar');
                wp_enqueue_style('DOPBSP-css-backend-coupons');
                wp_enqueue_style('DOPBSP-css-backend-emails');
                wp_enqueue_style('DOPBSP-css-backend-discounts');
                wp_enqueue_style('DOPBSP-css-backend-extras');
                wp_enqueue_style('DOPBSP-css-backend-forms');
                wp_enqueue_style('DOPBSP-css-backend-reservations');
                wp_enqueue_style('DOPBSP-css-backend-reservations-add');
                wp_enqueue_style('DOPBSP-css-backend-reservations-calendar');
                wp_enqueue_style('DOPBSP-css-backend-settings');
                wp_enqueue_style('DOPBSP-css-backend-translation');
            }
            
            /*
             * Add admin JavaScript files.
             */
            function addWPAdminScripts(){
                global $DOPBSP;
                
                /*
                 * Register JavaScript.
                 */
                wp_register_script('DOPBSP-js-backend-shortcodes', $DOPBSP->paths->url.'assets/js/backend-shortcodes.js', array('jquery'), false, true);
                
                /*
                 * Enqueue JavaScript.
                 */
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                /*
                 * Enqueue JavaScript.
                 */
                wp_enqueue_script('DOPBSP-js-backend-shortcodes');
            }
            
            /*
             * Add widget JavaScript files.
             */
            function addWidgetScripts(){
                global $DOPBSP;
                
                /*
                 * Register JavaScript.
                 */
                wp_register_script('DOPBSP-js-backend-widget', $DOPBSP->paths->url.'assets/js/backend-widget.js', array('jquery'), false, true);
                
                /*
                 * Enqueue JavaScript.
                 */
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                wp_enqueue_script('DOPBSP-js-backend-widget');
            }
            
            /*
             * Add plugin's JavaScript files.
             */
            function addScripts(){
                global $DOPBSP;
                
                /*
                 * Register JavaScript.
                 */
                
                /*
                 * Libraries.
                 */
                wp_register_script('DOP-js-prototypes', $DOPBSP->paths->url.'libraries/js/dop-prototypes.js', array('jquery'));
                wp_register_script('DOP-js-jquery-dopselect', $DOPBSP->paths->url.'libraries/js/jquery.dop.Select.js', array('jquery'));
                wp_register_script('js-isotope', $DOPBSP->paths->url.'libraries/js/isotope.pkgd.min.js', array('jquery'), false, true);
                
                /*
                 * Back end.
                 */
                wp_register_script('DOPBSP-js-backend', $DOPBSP->paths->url.'assets/js/backend.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-jquery-backend-calendar', $DOPBSP->paths->url.'assets/js/jquery.dop.backend.BSPCalendar.js', array('jquery'), false, true);
                
                /*
                 * Calendars
                 */
                wp_register_script('DOPBSP-js-backend-calendars', $DOPBSP->paths->url.'assets/js/calendars/backend-calendars.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-calendar', $DOPBSP->paths->url.'assets/js/calendars/backend-calendar.js', array('jquery'), false, true);
                
                /*
                 * Coupons
                 */
                wp_register_script('DOPBSP-js-backend-coupons', $DOPBSP->paths->url.'assets/js/coupons/backend-coupons.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-coupon', $DOPBSP->paths->url.'assets/js/coupons/backend-coupon.js', array('jquery'), false, true);
                
                /*
                 * Discounts
                 */
                wp_register_script('DOPBSP-js-backend-discounts', $DOPBSP->paths->url.'assets/js/discounts/backend-discounts.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount', $DOPBSP->paths->url.'assets/js/discounts/backend-discount.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount-items', $DOPBSP->paths->url.'assets/js/discounts/backend-discount-items.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount-item', $DOPBSP->paths->url.'assets/js/discounts/backend-discount-item.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount-item-rules', $DOPBSP->paths->url.'assets/js/discounts/backend-discount-item-rules.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-discount-item-rule', $DOPBSP->paths->url.'assets/js/discounts/backend-discount-item-rule.js', array('jquery'), false, true);
                
                /*
                 * Emails
                 */
                wp_register_script('DOPBSP-js-backend-emails', $DOPBSP->paths->url.'assets/js/emails/backend-emails.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-email', $DOPBSP->paths->url.'assets/js/emails/backend-email.js', array('jquery'), false, true);
                
                /*
                 * Extras
                 */
                wp_register_script('DOPBSP-js-backend-extras', $DOPBSP->paths->url.'assets/js/extras/backend-extras.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra', $DOPBSP->paths->url.'assets/js/extras/backend-extra.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra-groups', $DOPBSP->paths->url.'assets/js/extras/backend-extra-groups.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra-group', $DOPBSP->paths->url.'assets/js/extras/backend-extra-group.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra-group-items', $DOPBSP->paths->url.'assets/js/extras/backend-extra-group-items.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-extra-group-item', $DOPBSP->paths->url.'assets/js/extras/backend-extra-group-item.js', array('jquery'), false, true);
                
                /*
                 * Fees
                 */
                wp_register_script('DOPBSP-js-backend-fees', $DOPBSP->paths->url.'assets/js/fees/backend-fees.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-fee', $DOPBSP->paths->url.'assets/js/fees/backend-fee.js', array('jquery'), false, true);
                
                /*
                 * Forms
                 */
                wp_register_script('DOPBSP-js-backend-forms', $DOPBSP->paths->url.'assets/js/forms/backend-forms.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form', $DOPBSP->paths->url.'assets/js/forms/backend-form.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form-fields', $DOPBSP->paths->url.'assets/js/forms/backend-form-fields.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form-field', $DOPBSP->paths->url.'assets/js/forms/backend-form-field.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form-field-select-options', $DOPBSP->paths->url.'assets/js/forms/backend-form-field-select-options.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-form-field-select-option', $DOPBSP->paths->url.'assets/js/forms/backend-form-field-select-option.js', array('jquery'), false, true);
                
                /*
                 * Reservations
                 */
                wp_register_script('DOPBSP-js-jquery-backend-reservations-add', $DOPBSP->paths->url.'assets/js/jquery.dop.backend.BSPReservationsAdd.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-jquery-backend-reservations-calendar', $DOPBSP->paths->url.'assets/js/jquery.dop.backend.BSPReservationsCalendar.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservations', $DOPBSP->paths->url.'assets/js/reservations/backend-reservations.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservations-add', $DOPBSP->paths->url.'assets/js/reservations/backend-reservations-add.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservations-calendar', $DOPBSP->paths->url.'assets/js/reservations/backend-reservations-calendar.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservations-list', $DOPBSP->paths->url.'assets/js/reservations/backend-reservations-list.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-reservation', $DOPBSP->paths->url.'assets/js/reservations/backend-reservation.js', array('jquery'), false, true);
                
                /*
                 * Rules
                 */
                wp_register_script('DOPBSP-js-backend-rules', $DOPBSP->paths->url.'assets/js/rules/backend-rules.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-rule', $DOPBSP->paths->url.'assets/js/rules/backend-rule.js', array('jquery'), false, true);
                
                /*
                 * Settings
                 */
                wp_register_script('DOPBSP-js-backend-settings', $DOPBSP->paths->url.'assets/js/settings/backend-settings.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-settings-calendar', $DOPBSP->paths->url.'assets/js/settings/backend-settings-calendar.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-settings-notifications', $DOPBSP->paths->url.'assets/js/settings/backend-settings-notifications.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-settings-payment-gateways', $DOPBSP->paths->url.'assets/js/settings/backend-settings-payment-gateways.js', array('jquery'), false, true);
                wp_register_script('DOPBSP-js-backend-settings-users', $DOPBSP->paths->url.'assets/js/settings/backend-settings-users.js', array('jquery'), false, true);
                
                /*
                 * Translation
                 */
                wp_register_script('DOPBSP-js-backend-translation', $DOPBSP->paths->url.'assets/js/backend-translation.js', array('jquery'), false, true);

                /*
                 * Enqueue JavaScript.
                 */
                
                /*
                 * Libraries.
                 */
                if (!wp_script_is('jquery', 'queue')){
                    wp_enqueue_script('jquery');
                }
                
                if (!wp_script_is('jquery-effects-core', 'queue')){
                    wp_enqueue_script('jquery-effects-core');
                }
                
                if (!wp_script_is('jquery-ui-datepicker', 'queue')){
                    wp_enqueue_script('jquery-ui-datepicker');
                }
                
                if (!wp_script_is('jquery-ui-sortable', 'queue')){
                    wp_enqueue_script('jquery-ui-sortable');
                }
                
                wp_enqueue_script('DOP-js-prototypes');
                wp_enqueue_script('DOP-js-jquery-dopselect');
                wp_enqueue_script('js-isotope');
                
                /*
                 * Back end.
                 */
                wp_enqueue_script('DOPBSP-js-backend');
                wp_enqueue_script('DOPBSP-js-jquery-backend-calendar');
                
                /*
                 * Calendars
                 */
                wp_enqueue_script('DOPBSP-js-backend-calendars');
                wp_enqueue_script('DOPBSP-js-backend-calendar');
                
                /*
                 * Coupons
                 */
                wp_enqueue_script('DOPBSP-js-backend-coupons');
                wp_enqueue_script('DOPBSP-js-backend-coupon');
                
                /*
                 * Discounts
                 */
                wp_enqueue_script('DOPBSP-js-backend-discounts');
                wp_enqueue_script('DOPBSP-js-backend-discount');
                wp_enqueue_script('DOPBSP-js-backend-discount-items');
                wp_enqueue_script('DOPBSP-js-backend-discount-item');
                wp_enqueue_script('DOPBSP-js-backend-discount-item-rules');
                wp_enqueue_script('DOPBSP-js-backend-discount-item-rule');
                
                /*
                 * Emails
                 */
                wp_enqueue_script('DOPBSP-js-backend-emails');
                wp_enqueue_script('DOPBSP-js-backend-email');
                
                /*
                 * Extras
                 */
                wp_enqueue_script('DOPBSP-js-backend-extras');
                wp_enqueue_script('DOPBSP-js-backend-extra');
                wp_enqueue_script('DOPBSP-js-backend-extra-groups');
                wp_enqueue_script('DOPBSP-js-backend-extra-group');
                wp_enqueue_script('DOPBSP-js-backend-extra-group-items');
                wp_enqueue_script('DOPBSP-js-backend-extra-group-item');
                
                /*
                 * Fees
                 */
                wp_enqueue_script('DOPBSP-js-backend-fees');
                wp_enqueue_script('DOPBSP-js-backend-fee');
                
                /*
                 * Forms
                 */
                wp_enqueue_script('DOPBSP-js-backend-forms');
                wp_enqueue_script('DOPBSP-js-backend-form');
                wp_enqueue_script('DOPBSP-js-backend-form-fields');
                wp_enqueue_script('DOPBSP-js-backend-form-field');
                wp_enqueue_script('DOPBSP-js-backend-form-field-select-options');
                wp_enqueue_script('DOPBSP-js-backend-form-field-select-option');
                
                /*
                 * Reservations
                 */
                wp_enqueue_script('DOPBSP-js-jquery-backend-reservations-add');
                wp_enqueue_script('DOPBSP-js-jquery-backend-reservations-calendar');
                wp_enqueue_script('DOPBSP-js-backend-reservations');
                wp_enqueue_script('DOPBSP-js-backend-reservations-add');
                wp_enqueue_script('DOPBSP-js-backend-reservations-calendar');
                wp_enqueue_script('DOPBSP-js-backend-reservations-list');
                wp_enqueue_script('DOPBSP-js-backend-reservation');
                
                /*
                 * Rules
                 */
                wp_enqueue_script('DOPBSP-js-backend-rules');
                wp_enqueue_script('DOPBSP-js-backend-rule');
                
                /*
                 * Settings
                 */
                wp_enqueue_script('DOPBSP-js-backend-settings');
                wp_enqueue_script('DOPBSP-js-backend-settings-calendar');
                wp_enqueue_script('DOPBSP-js-backend-settings-notifications');
                wp_enqueue_script('DOPBSP-js-backend-settings-payment-gateways');
                wp_enqueue_script('DOPBSP-js-backend-settings-users');
                
                /*
                 * Translation
                 */
                wp_enqueue_script('DOPBSP-js-backend-translation');
            }
            
            /*
             * Initialize plugin back end.
             */
            function init(){
                global $DOPBSP;
                
                $this->setTables();
                $DOPBSP->classes->translation->setTranslation();
            }
            
            /*
             * Check if current back end page is a plugin page.
             * 
             * @get action (string): wp post action
             * @get post_type (string): wp post type
             * @get page (string): wp page type
             * 
             * @return true/false
             */
            function validPage(){
                if (isset($_GET['page'])){
                    /*
                     * Verify if current page is a plugin page.
                     */
                    if ($_GET['page'] == 'dopbsp'
                        || $_GET['page'] == 'dopbsp-calendars'
                        || $_GET['page'] == 'dopbsp-coupons'
                        || $_GET['page'] == 'dopbsp-discounts'
                        || $_GET['page'] == 'dopbsp-emails'
                        || $_GET['page'] == 'dopbsp-events'
                        || $_GET['page'] == 'dopbsp-extras'
                        || $_GET['page'] == 'dopbsp-fees'
                        || $_GET['page'] == 'dopbsp-forms'
                        || $_GET['page'] == 'dopbsp-locations'
                        || $_GET['page'] == 'dopbsp-reservations'
                        || $_GET['page'] == 'dopbsp-rules'
                        || $_GET['page'] == 'dopbsp-settings'
                        || $_GET['page'] == 'dopbsp-templates'
                        || $_GET['page'] == 'dopbsp-translation'){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else if (isset($_GET['post_type'])){
                    /*
                     * Verify if current page is a custom post page.
                     */
                    if ($_GET['post_type'] == DOPBSP_CONFIG_CUSTOM_POSTS_SLUG) {
                        return true; 
                    } 
                    else{
                        return false;
                    }
                }
                else if (isset($_GET['action'])){
                    /*
                     * Verify if current page is a custom post edit page.
                     */
                    if ($_GET['action'] == 'edit') {
                        return true; 
                    } 
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }
            }

// Database            
            /*
             * Set plugin tables.
             */
            function setTables(){
                global $DOPBSP;
                
                if (DOPBSP_CONFIG_INIT_DATABASE){
                    update_option('DOPBSP_db_version', '1.0');
                }
                $current_db_version = get_option('DOPBSP_db_version');
                
                if (DOPBSP_CONFIG_DATABASE_VERSION != $current_db_version){
                    require_once(str_replace('\\', '/', ABSPATH).'wp-admin/includes/upgrade.php');
                    
                    $DOPBSP->classes->update->database();
                    
                    /*
                     * Calendars table.
                     */
                    $sql_calendars = "CREATE TABLE ".$DOPBSP->tables->calendars." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            user_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_USER_ID." NOT NULL,
                                            post_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_POST_ID." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            min_price FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_MIN_PRICE." NOT NULL,
                                            max_price FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_CALENDARS_DEFAULT_MAX_PRICE." NOT NULL,
                                            rating VARCHAR(2) DEFAULT '-1' NOT NULL,
                                            availability TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_calendars);
                    
                    /*
                     * Coupons table.
                     */
                    $sql_coupons = "CREATE TABLE ".$DOPBSP->tables->coupons." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            user_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_USER_ID." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            code VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_CODE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            start_date VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_START_DATE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            end_date VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_END_DATE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            start_hour VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_START_HOUR."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            end_hour VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_END_HOUR."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            no_coupons VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_NO_COUPONS."' NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_OPERATION."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price FLOAT DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_PRICE."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_PRICE_TYPE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_COUPONS_DEFAULT_PRICE_BY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            translation TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_coupons);
                    
                    /*
                     * Days table.
                     */
                    $sql_days = "CREATE TABLE " . $DOPBSP->tables->days." (
                                            unique_key VARCHAR(32) COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            calendar_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_DAYS_DEFAULT_CALENDAR_ID." NOT NULL,
                                            day VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_DAYS_DEFAULT_DAY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            year INT DEFAULT ".DOPBSP_CONFIG_DATABASE_DAYS_DEFAULT_YEAR." NOT NULL,
                                            data TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (unique_key)
                                        );";
                    dbDelta($sql_days);

                    /*
                     * Discounts tables.
                     */
                    $sql_discounts = "CREATE TABLE ".$DOPBSP->tables->discounts." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            user_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_DISCOUTS_DEFAULT_USER_ID." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_DEFAULT_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_discounts);
                    
                    $sql_discounts_items = "CREATE TABLE ".$DOPBSP->tables->discounts_items." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            discount_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_DEFAULT_DISCOUNT_ID." NOT NULL,
                                            position INT DEFAULT ".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_DEFAULT_POSITION." NOT NULL,
                                            start_time_lapse VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_DEFAULT_START_TIME_LAPSE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            end_time_lapse VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_DEFAULT_END_TIME_LAPSE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_DEFAULT_OPERATION."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price FLOAT DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_DEFAULT_PRICE."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_DEFAULT_PRICE_TYPE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_DEFAULT_PRICE_BY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            translation TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_discounts_items);
                    
                    $sql_discounts_items_rules = "CREATE TABLE ".$DOPBSP->tables->discounts_items_rules." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            discount_item_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_DISCOUNT_ITEM_ID." NOT NULL,
                                            position INT DEFAULT ".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_POSITION." NOT NULL,
                                            start_date VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_START_DATE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            end_date VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_END_DATE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            start_hour VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_START_HOUR."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            end_hour VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_END_HOUR."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_OPERATION."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price FLOAT DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_PRICE."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_PRICE_TYPE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_DISCOUNTS_ITEMS_RULES_DEFAULT_PRICE_BY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_discounts_items_rules);
                    
                    /*
                     * Emails table.
                     */
                    $sql_emails = "CREATE TABLE ".$DOPBSP->tables->emails." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            user_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_EMAILS_DEFAULT_USER_ID." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_EMAILS_DEFAULT_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_emails);
                    
                    $sql_emails_translation = "CREATE TABLE ".$DOPBSP->tables->emails_translation." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            email_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_EMAILS_TRANSLATION_DEFAULT_EMAIL_ID." NOT NULL,
                                            template VARCHAR(64) DEFAULT '".DOPBSP_CONFIG_DATABASE_EMAILS_TRANSLATION_DEFAULT_TEMPLATE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            subject TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            message TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_emails_translation);

                    /*
                     * Extras tables.
                     */
                    $sql_extras = "CREATE TABLE ".$DOPBSP->tables->extras." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            user_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_EXTRAS_DEFAULT_USER_ID." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_EXTRAS_DEFAULT_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_extras);
                    
                    $sql_extras_groups = "CREATE TABLE ".$DOPBSP->tables->extras_groups." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            extra_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_DEFAULT_EXTRA_ID." NOT NULL,
                                            position INT DEFAULT ".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_DEFAULT_POSITION." NOT NULL,
                                            multiple_select VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_DEFAULT_MULTIPLE_SELECT."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            required VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_DEFAULT_REQUIRED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            translation TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_extras_groups);
                    
                    $sql_extras_groups_items = "CREATE TABLE ".$DOPBSP->tables->extras_groups_items." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            group_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_ITEMS_DEFAULT_GROUP_ID." NOT NULL,
                                            position INT DEFAULT ".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_ITEMS_DEFAULT_POSITION." NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_ITEMS_DEFAULT_OPERATION."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price FLOAT DEFAULT '".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_ITEMS_DEFAULT_PRICE."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_ITEMS_DEFAULT_PRICE_TYPE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_EXTRAS_GROUPS_ITEMS_DEFAULT_PRICE_BY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            translation TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_extras_groups_items);
                    
                    /*
                     * Fees table.
                     */
                    $sql_fees = "CREATE TABLE ".$DOPBSP->tables->fees." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            user_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_FEES_DEFAULT_USER_ID." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_FEES_DEFAULT_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            operation VARCHAR(1) DEFAULT '".DOPBSP_CONFIG_DATABASE_FEES_DEFAULT_OPERATION."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price FLOAT DEFAULT '".DOPBSP_CONFIG_DATABASE_FEES_DEFAULT_PRICE."' NOT NULL,
                                            price_type VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_FEES_DEFAULT_PRICE_TYPE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            price_by VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_FEES_DEFAULT_PRICE_BY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            included VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_FEES_DEFAULT_INCLUDED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            extras VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_FEES_DEFAULT_EXTRAS."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            cart VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_FEES_DEFAULT_CART."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            translation TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_fees);

                    /*
                     * Forms tables.
                     */
                    $sql_forms = "CREATE TABLE " . $DOPBSP->tables->forms . " (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            user_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_FORMS_DEFAULT_USER_ID." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_FORMS_DEFAULT_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_forms);
                    
                    $sql_forms_fields = "CREATE TABLE " . $DOPBSP->tables->forms_fields . " (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            form_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_FORM_ID." NOT NULL,
                                            type VARCHAR(20) DEFAULT '".DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_TYPE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            position INT DEFAULT ".DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_POSITION." NOT NULL,
                                            multiple_select VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_MULTIPLE_SELECT."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            allowed_characters TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            size INT DEFAULT ".DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_SIZE." NOT NULL,
                                            is_email VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_IS_EMAIL."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            required VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_FORMS_FIELDS_DEFAULT_REQUIRED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            translation TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_forms_fields);
                    
                    $sql_forms_select_options = "CREATE TABLE " . $DOPBSP->tables->forms_fields_options . " (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            field_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_FORMS_SELECT_OPTIONS_DEFAULT_FIELD_ID." NOT NULL,
                                            position INT DEFAULT ".DOPBSP_CONFIG_DATABASE_FORMS_SELECT_OPTIONS_DEFAULT_POSITION." NOT NULL,
                                            translation TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_forms_select_options);
                    
                    /*
                     * Languages table.
                     */
                    $sql_languages = "CREATE TABLE ".$DOPBSP->tables->languages." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_LANGUAGES_DEFAULT_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            code VARCHAR(2) DEFAULT '".DOPBSP_CONFIG_DATABASE_LANGUAGES_DEFAULT_CODE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            enabled VARCHAR(6) DEFAULT ".DOPBSP_CONFIG_DATABASE_LANGUAGES_DEFAULT_ENABLED." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_languages);

                    /*
                     * Reservations table.
                     */   
                    $sql_reservations = "CREATE TABLE " . $DOPBSP->tables->reservations . " (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            calendar_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CALENDAR_ID." NOT NULL,
                                            language VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_LANGUAGE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            currency VARCHAR(32) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CURRENCY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            currency_code VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CURRENCY_CODE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            check_in VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CHECK_IN."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            check_out VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_CHECK_OUT."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            start_hour VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_START_HOUR."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            end_hour VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_END_HOUR."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            no_items INT DEFAULT ".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_NO_ITEMS." NOT NULL,
                                            price FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_PRICE." NOT NULL,
                                            price_total FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_PRICE_TOTAL." NOT NULL,
                                            extras TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            extras_price FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_EXTRAS_PRICE." NOT NULL,
                                            discount TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            discount_price FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_DISCOUNT_PRICE." NOT NULL,
                                            coupon TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            coupon_price FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_COUPON_PRICE." NOT NULL,
                                            fees TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            fees_price FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_FEES_PRICE." NOT NULL,
                                            deposit TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            deposit_price FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_DEPOSIT_PRICE." NOT NULL,
                                            days_hours_history TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            form TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            email VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_EMAIL."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            status VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_STATUS."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            payment_method VARCHAR(32) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_PAYMENT_METHOD."' NOT NULL, 
                                            transaction_id VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_TRANSACTION_ID."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL, 
                                            token VARCHAR(32) DEFAULT '".DOPBSP_CONFIG_DATABASE_RESERVATIONS_DEFAULT_TOKEN."' NOT NULL, 
                                            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                                            UNIQUE KEY id (id)
                                    );";
                    dbDelta($sql_reservations);
                    
                    /*
                     * Rules table.
                     */
                    $sql_rules = "CREATE TABLE ".$DOPBSP->tables->rules." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            user_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_RULES_DEFAULT_USER_ID." NOT NULL,
                                            name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_RULES_DEFAULT_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            time_lapse_min FLOAT DEFAULT '".DOPBSP_CONFIG_DATABASE_RULES_DEFAULT_TIME_LAPSE_MIN."' NOT NULL,
                                            time_lapse_max FLOAT DEFAULT '".DOPBSP_CONFIG_DATABASE_RULES_DEFAULT_TIME_LAPSE_MAX."' NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_rules);
                    
                    /*
                     * Settings tables.
                     */
                    $sql_settings = "CREATE TABLE ".$DOPBSP->tables->settings." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            calendar_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_CALENDAR_ID." NOT NULL,
                                            date_type INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DATE_TYPE." NOT NULL,
                                            template VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_TEMPLATE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            booking_stop INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_BOOKING_STOP." NOT NULL,
                                            months_no INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MONTHS_NO." NOT NULL,
                                            view_only VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_VIEW_ONLY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,  
                                            post_id INT DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_POST_ID."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            max_year INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_MAX_YEAR." NOT NULL,
                                            currency VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_CURRENCY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            currency_position VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_CURRENCY_POSITION."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            days_available VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_AVAILABLE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            days_details_from_hours VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_DETAILS_FROM_HOURS."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            days_first INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_FIRST." NOT NULL,
                                            days_morning_check_out VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_MORNING_CHECK_OUT."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            days_multiple_select VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DAYS_MULTIPLE_SELECT."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            hours_add_last_hour_to_total_price VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_ADD_LAST_HOUR_TO_TOTAL_PRICE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            hours_ampm VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_AMPM."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            hours_definitions TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            hours_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            hours_info_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_INFO_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            hours_interval_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_INTERVAL_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            hours_multiple_select VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_HOURS_MULTIPLE_SELECT."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            sidebar_style INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_SIDEBAR_STYLE." NOT NULL,
                                            sidebar_no_items_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_SIDEBAR_NO_ITEMS_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            rule INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_RULE." NOT NULL,
                                            extra INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_EXTRA." NOT NULL,
                                            cart_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_CART_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            discount INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DISCOUNT." NOT NULL,
                                            fees VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_FEES."' NOT NULL,
                                            coupon INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_COUPON." NOT NULL,
                                            deposit FLOAT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DEPOSIT." NOT NULL,
                                            deposit_type VARCHAR(16) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_DEPOSIT_TYPE."' NOT NULL,
                                            form INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_FORM." NOT NULL,
                                            terms_and_conditions_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_TERMS_AND_CONDITIONS_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            terms_and_conditions_link VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_DEFAULT_TERMS_AND_CONDITIONS_LINK."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_settings);
                    
                    $sql_settings_notifications = "CREATE TABLE ".$DOPBSP->tables->settings_notifications." (
                                            id INT NOT NULL,
                                            calendar_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_CALENDAR_ID." NOT NULL,
                                            templates INT DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_TEMPLATES."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            email VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_EMAIL."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            email_reply VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_EMAIL_REPLY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            email_name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_EMAIL_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            smtp_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,                                     
                                            smtp_host_name VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_HOST_NAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            smtp_host_port INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_HOST_PORT." NOT NULL,
                                            smtp_ssl VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_SSL."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,                                   
                                            smtp_user VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_USER."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,                                   
                                            smtp_password VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SMTP_PASSWORD."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            send_book_admin VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SEND_BOOK_ADMIN."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            send_book_user VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SEND_BOOK_USER."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            send_book_with_approval_admin VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SEND_BOOK_WITH_APPROVAL_ADMIN."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            send_book_with_approval_user VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SEND_BOOK_WITH_APPROVAL_USER."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            send_paypal_admin VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SEND_PAYPAL_ADMIN."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            send_paypal_user VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SEND_PAYPAL_USER."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            send_approved VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SEND_APPROVED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            send_canceled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SEND_CANCELED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            send_rejected VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_NOTIFICATIONS_DEFAULT_SEND_REJECTED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,                                
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_settings_notifications);
                    
                    $sql_settings_payment = "CREATE TABLE ".$DOPBSP->tables->settings_payment." (
                                            id INT NOT NULL,
                                            calendar_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_CALENDAR_ID." NOT NULL,
                                            arrival_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_ARRIVAL_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            arrival_with_approval_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_ARRIVAL_WITH_APPROVAL_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            redirect VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_REDIRECT."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            paypal_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            paypal_username VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_USERNAME."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            paypal_password VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_PASSWORD."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            paypal_signature VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_SIGNATURE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            paypal_credit_card VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_CREDIT_CARD."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            paypal_sandbox_enabled VARCHAR(6) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_SANDBOX_ENABLED."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            paypal_redirect VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_SETTINGS_PAYMENT_DEFAULT_PAYPAL_REDIRECT."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_settings_payment);
                    
                    /*
                     * Translation tables.
                     */
                    $languages = explode(',', DOPBSP_CONFIG_TRANSLATION_LANGUAGES_TO_INSTALL);
                    
                    for ($l=0; $l<count($languages); $l++){
                        $sql_translation = "CREATE TABLE ".$DOPBSP->tables->translation."_".$languages[$l]." (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            key_data VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_KEY_DATA."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            position INT DEFAULT ".DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_POSITION." NOT NULL,
                                            parent_key VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_PARENT_KEY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            text_data TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            translation TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                        dbDelta($sql_translation);
                    }
                    
                    /*
                     * WooCommerce table.
                     */
                    $sql_woocommerce = "CREATE TABLE " . $DOPBSP->tables->woocommerce . " (
                                            id INT NOT NULL AUTO_INCREMENT,
                                            cart_key VARCHAR(64) DEFAULT '".DOPBSP_CONFIG_DATABASE_WOOCOMMERCE_DEFAULT_CART_KEY."' NOT NULL,
                                            variation_id INT DEFAULT '".DOPBSP_CONFIG_DATABASE_WOOCOMMERCE_DEFAULT_VARIATION_ID."' NOT NULL,
                                            product_id INT DEFAULT '".DOPBSP_CONFIG_DATABASE_WOOCOMMERCE_DEFAULT_PRODUCT_ID."' NOT NULL,
                                            calendar_id INT DEFAULT ".DOPBSP_CONFIG_DATABASE_WOOCOMMERCE_DEFAULT_CALENDAR_ID." NOT NULL,
                                            language VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_WOOCOMMERCE_DEFAULT_LANGUAGE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            currency VARCHAR(32) DEFAULT '".DOPBSP_CONFIG_DATABASE_WOOCOMMERCE_DEFAULT_CURRENCY."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            currency_code VARCHAR(8) DEFAULT '".DOPBSP_CONFIG_DATABASE_WOOCOMMERCE_DEFAULT_CURRENCY_CODE."' COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            data TEXT COLLATE ".DOPBSP_CONFIG_DATABASE_COLLATION." NOT NULL,
                                            date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                                            UNIQUE KEY id (id)
                                        );";
                    dbDelta($sql_woocommerce);
                    
                    /*
                     * Update settings tables.
                     */
                    if (get_option('DOPBSP_db_update_settings') == 'true'){
                        $DOPBSP->classes->update->databaseSettings();
                    }

                    /*
                     * Update database version.
                     */
                    if ($current_db_version == ''){
                        add_option('DOPBSP_db_version', DOPBSP_CONFIG_DATABASE_VERSION);
                    }
                    else{
                        update_option('DOPBSP_db_version', DOPBSP_CONFIG_DATABASE_VERSION);
                    }
                    
                    /*
                     * Initialize users permissions.
                     */
                    $DOPBSP->classes->backend_settings_users->init();
                    
                    $this->setTablesData();
                }
            }
            
            /*
             * Set initial data for plugin tables.
             */
            function setTablesData(){
                global $wpdb;
                global $DOPBSP;
                
                /*
                 * Translation data.
                 */
                $DOPBSP->classes->translation->setDatabase();
                $DOPBSP->classes->translation->setTranslation();
                
                /*
                 * Emails data.
                 */
                $control_data = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->emails.' WHERE id=1');
                
                if ($wpdb->num_rows == 0){
                     $wpdb->insert($DOPBSP->tables->emails, array('id' => 1,
                                                                  'user_id' => 0,
                                                                  'name' => $DOPBSP->text('EMAILS_DEFAULT_NAME')));
                    /*
                     * Simple book.
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'book_admin',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_ADMIN_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_ADMIN')));
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'book_user',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_USER_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_USER')));
                    /*
                     * Book with approval.
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'book_with_approval_admin',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_ADMIN')));
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'book_with_approval_user',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_BOOK_WITH_APPROVAL_USER')));
                    /*
                     * Approved
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'approved',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_APPROVED_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_APPROVED')));
                    /*
                     * Canceled
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'canceled',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_CANCELED_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_CANCELED')));
                    /*
                      Rejected
                     */
                    $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                            'template' => 'rejected',
                                                                            'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_REJECTED_SUBJECT'),
                                                                            'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_REJECTED')));

                    /*
                     * Payment gateways.
                     */
                    $payment_gateways = $DOPBSP->classes->payment_gateways->get();

                    for ($i=0; $i<count($payment_gateways); $i++){
                       $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                                'template' => $payment_gateways[$i]['id'].'_admin',
                                                                                'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_'.strtoupper($payment_gateways[$i]['id']).'_ADMIN_SUBJECT'),
                                                                                'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_'.strtoupper($payment_gateways[$i]['id']).'_ADMIN')));
                       $wpdb->insert($DOPBSP->tables->emails_translation, array('email_id' => 1,
                                                                                'template' => $payment_gateways[$i]['id'].'_user',
                                                                                'subject' => $DOPBSP->classes->translation->encodeJSON('EMAILS_DEFAULT_'.strtoupper($payment_gateways[$i]['id']).'_USER_SUBJECT'),
                                                                                'message' => $DOPBSP->classes->backend_email->defaultTemplate('EMAILS_DEFAULT_'.strtoupper($payment_gateways[$i]['id']).'_USER')));
                    }
                }
                
                /*
                 * Extras data.
                 */
                $control_data = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->extras.' WHERE id=1');
                
                if ($wpdb->num_rows == 0){
                    $wpdb->insert($DOPBSP->tables->extras, array('id' => 1,
                                                                 'user_id' => 0,
                                                                 'name' => $DOPBSP->text('EXTRAS_DEFAULT_PEOPLE')));
                    $wpdb->insert($DOPBSP->tables->extras_groups, array('id' => 1,
                                                                        'extra_id' => 1,
                                                                        'position' => 1,
                                                                        'multiple_select' => 'false',
                                                                        'required' => 'true',
                                                                        'translation' => $DOPBSP->classes->translation->encodeJSON('EXTRAS_DEFAULT_ADULTS')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 1,
                                                                              'group_id' => 1,
                                                                              'position' => 1,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '1')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 2,
                                                                              'group_id' => 1,
                                                                              'position' => 2,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '2')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 3,
                                                                              'group_id' => 1,
                                                                              'position' => 3,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '3')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 4,
                                                                              'group_id' => 1,
                                                                              'position' => 4,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '4')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 5,
                                                                              'group_id' => 1,
                                                                              'position' => 5,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '5')));
                    $wpdb->insert($DOPBSP->tables->extras_groups, array('id' => 2,
                                                                        'extra_id' => 1,
                                                                        'position' => 2,
                                                                        'multiple_select' => 'false',
                                                                        'required' => 'true',
                                                                        'translation' => $DOPBSP->classes->translation->encodeJSON('EXTRAS_DEFAULT_CHILDREN')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 6,
                                                                              'group_id' => 2,
                                                                              'position' => 1,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '0')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 7,
                                                                              'group_id' => 2,
                                                                              'position' => 2,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '1')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 8,
                                                                              'group_id' => 2,
                                                                              'position' => 3,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '2')));
                    $wpdb->insert($DOPBSP->tables->extras_groups_items, array('id' => 9,
                                                                              'group_id' => 2,
                                                                              'position' => 4,
                                                                              'translation' => $DOPBSP->classes->translation->encodeJSON('', '3')));
                }
                
                /*
                 * Forms data.
                 */
                $control_data = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms.' WHERE id=1');
                
                if ($wpdb->num_rows == 0){
                    $wpdb->insert($DOPBSP->tables->forms, array('id' => 1,
                                                                'user_id' => 0,
                                                                'name' => $DOPBSP->text('FORMS_DEFAULT_NAME')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 1,
                                                                       'form_id' => 1,
                                                                       'type' => 'text',
                                                                       'position' => 1,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '',
                                                                       'size' => 0,
                                                                       'is_email' => 'false',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_FIRST_NAME')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 2,
                                                                       'form_id' => 1,
                                                                       'type' => 'text',
                                                                       'position' => 2,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '',
                                                                       'size' => 0,
                                                                       'is_email' => 'false',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_LAST_NAME')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 3,
                                                                       'form_id' => 1,
                                                                       'type' => 'text',
                                                                       'position' => 3,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '',
                                                                       'size' => 0,
                                                                       'is_email' => 'true',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_EMAIL')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 4,
                                                                       'form_id' => 1,
                                                                       'type' => 'text',
                                                                       'position' => 4,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '0123456789+-().',
                                                                       'size' => 0,
                                                                       'is_email' => 'false',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_PHONE')));
                    $wpdb->insert($DOPBSP->tables->forms_fields, array('id' => 5,
                                                                       'form_id' => 1,
                                                                       'type' => 'textarea',
                                                                       'position' => 5,
                                                                       'multiple_select' => 'false',
                                                                       'allowed_characters' => '',
                                                                       'size' => 0,
                                                                       'is_email' => 'false',
                                                                       'required' => 'true',
                                                                       'translation' => $DOPBSP->classes->translation->encodeJSON('FORMS_DEFAULT_MESSAGE')));
                }
                
                /*
                 * Settings data.
                 */
                $control_data = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id=0');

                if ($wpdb->num_rows == 0){
                    $wpdb->insert($DOPBSP->tables->settings, array('calendar_id' => 0,
                                                                   'hours_definitions' => '[{"value": "00:00"}]'));
                    
                    $settings_id = $wpdb->insert_id;
                    
                    $wpdb->insert($DOPBSP->tables->settings_notifications, array('id' => $settings_id,
                                                                                 'calendar_id' => 0));
                    $wpdb->insert($DOPBSP->tables->settings_payment, array('id' => $settings_id,
                                                                           'calendar_id' => 0));
                } 
            }
        }
    }