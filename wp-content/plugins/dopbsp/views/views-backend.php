<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/views-backend.php
* File Version            : 1.0
* Created / Last Modified : 18 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end views class.
*/

    if (!class_exists('DOPBSPViews')){
        class DOPBSPViews{
            /*
             * Public variables.
             */
            public $calendars;
            
            public $coupons;
            public $coupon;
            
            public $dashboard;
            
            public $discounts;
            public $discount;
            public $discount_items;
            public $discount_item;
            public $discount_item_rule;
            
            public $emails;
            public $email;
            
            public $events;
            
            public $extras;
            public $extra;
            public $extra_groups;
            public $extra_group;
            public $extra_group_item;
            
            public $fees;
            public $fee;
            
            public $forms;
            public $form;
            public $form_fields;
            public $form_field;
            public $form_field_select_option;
            
            public $locations;
            
            public $reservations;
            public $reservations_list;
            public $reservation;
            public $reservation_coupon;
            public $reservation_details;
            public $reservation_discount;
            public $reservation_extras;
            public $reservation_fees;
            public $reservation_form;
            
            public $rules;
            public $rule;
            
            public $settings;
            public $settings_calendar;
            public $settings_notifications;
            public $settings_payment_gateways;
            public $settings_paypal;
            public $settings_users;
            
            public $templates;
            
            public $translation;
            
            /*
             * Constructor
             */
            function DOPBSPViews(){
                $this->init();
            }
            
            /*
             * Initialize view classes.
             */
            function init(){
                /*
                 * Initialize calendars view classes.
                 */
                if (class_exists('DOPBSPViewsCalendars')){
                    $this->calendars = new DOPBSPViewsCalendars();
                }
                
                /*
                 * Initialize coupons view classes.
                 */
                if (class_exists('DOPBSPViewsCoupons')){
                    $this->coupons = new DOPBSPViewsCoupons();
                }
                
                if (class_exists('DOPBSPViewsCoupon')){
                    $this->coupon = new DOPBSPViewsCoupon();
                }
                
                /*
                 * Initialize dashboard view classes.
                 */
                if (class_exists('DOPBSPViewsDashboard')){
                    $this->dashboard = new DOPBSPViewsDashboard();
                }
                
                /*
                 * Initialize discounts view classes.
                 */
                if (class_exists('DOPBSPViewsDiscounts')){
                    $this->discounts = new DOPBSPViewsDiscounts();
                }
                
                if (class_exists('DOPBSPViewsDiscount')){
                    $this->discount = new DOPBSPViewsDiscount();
                }
                
                if (class_exists('DOPBSPViewsDiscountItems')){
                    $this->discount_items = new DOPBSPViewsDiscountItems();
                }
                
                if (class_exists('DOPBSPViewsDiscountItem')){
                    $this->discount_item = new DOPBSPViewsDiscountItem();
                }
                
                if (class_exists('DOPBSPViewsDiscountItemRule')){
                    $this->discount_item_rule = new DOPBSPViewsDiscountItemRule();
                }
                
                /*
                 * Initialize emails view classes.
                 */
                if (class_exists('DOPBSPViewsEmails')){
                    $this->emails = new DOPBSPViewsEmails();
                }
                
                if (class_exists('DOPBSPViewsEmail')){
                    $this->email = new DOPBSPViewsEmail();
                }
                
                /*
                 * Initialize events view classes.
                 */
                if (class_exists('DOPBSPViewsEvents')){
                    $this->events = new DOPBSPViewsEvents();
                }
                
                /*
                 * Initialize extras view classes.
                 */
                if (class_exists('DOPBSPViewsExtras')){
                    $this->extras = new DOPBSPViewsExtras();
                }
                
                if (class_exists('DOPBSPViewsExtra')){
                    $this->extra = new DOPBSPViewsExtra();
                }
                
                if (class_exists('DOPBSPViewsExtraGroups')){
                    $this->extra_groups = new DOPBSPViewsExtraGroups();
                }
                
                if (class_exists('DOPBSPViewsExtraGroup')){
                    $this->extra_group = new DOPBSPViewsExtraGroup();
                }
                
                if (class_exists('DOPBSPViewsExtraGroupItem')){
                    $this->extra_group_item = new DOPBSPViewsExtraGroupItem();
                }
                
                /*
                 * Initialize fees view classes.
                 */
                if (class_exists('DOPBSPViewsFees')){
                    $this->fees = new DOPBSPViewsFees();
                }
                
                if (class_exists('DOPBSPViewsFee')){
                    $this->fee = new DOPBSPViewsFee();
                }
                
                /*
                 * Initialize forms view classes.
                 */
                if (class_exists('DOPBSPViewsForms')){
                    $this->forms = new DOPBSPViewsForms();
                }
                
                if (class_exists('DOPBSPViewsForm')){
                    $this->form = new DOPBSPViewsForm();
                }
                
                if (class_exists('DOPBSPViewsFormFields')){
                    $this->form_fields = new DOPBSPViewsFormFields();
                }
                
                if (class_exists('DOPBSPViewsFormField')){
                    $this->form_field = new DOPBSPViewsFormField();
                }
                
                if (class_exists('DOPBSPViewsFormFieldSelectOption')){
                    $this->form_field_select_option = new DOPBSPViewsFormFieldSelectOption();
                }
                
                /*
                 * Initialize locations view classes.
                 */
                if (class_exists('DOPBSPViewsLocations')){
                    $this->locations = new DOPBSPViewsLocations();
                }
                
                /*
                 * Initialize reservations view classes.
                 */
                if (class_exists('DOPBSPViewsReservations')){
                    $this->reservations = new DOPBSPViewsReservations();
                }
                
                if (class_exists('DOPBSPViewsReservationsList')){
                    $this->reservations_list = new DOPBSPViewsReservationsList();
                }
                
                if (class_exists('DOPBSPViewsReservation')){
                    $this->reservation = new DOPBSPViewsReservation();
                }
                
                if (class_exists('DOPBSPViewsReservationCoupon')){
                    $this->reservation_coupon = new DOPBSPViewsReservationCoupon();
                }
                
                if (class_exists('DOPBSPViewsReservationDetails')){
                    $this->reservation_details = new DOPBSPViewsReservationDetails();
                }
                
                if (class_exists('DOPBSPViewsReservationDiscount')){
                    $this->reservation_discount = new DOPBSPViewsReservationDiscount();
                }
                
                if (class_exists('DOPBSPViewsReservationExtras')){
                    $this->reservation_extras = new DOPBSPViewsReservationExtras();
                }
                
                if (class_exists('DOPBSPViewsReservationFees')){
                    $this->reservation_fees = new DOPBSPViewsReservationFees();
                }
                
                if (class_exists('DOPBSPViewsReservationForm')){
                    $this->reservation_form = new DOPBSPViewsReservationForm();
                }
                
                /*
                 * Initialize rules view classes.
                 */
                if (class_exists('DOPBSPViewsRules')){
                    $this->rules = new DOPBSPViewsRules();
                }
                
                if (class_exists('DOPBSPViewsRule')){
                    $this->rule = new DOPBSPViewsRule();
                }
                
                /*
                 * Initialize settings view classes.
                 */
                if (class_exists('DOPBSPViewsSettings')){
                    $this->settings = new DOPBSPViewsSettings();
                }
                
                if (class_exists('DOPBSPViewsSettingsCalendar')){
                    $this->settings_calendar = new DOPBSPViewsSettingsCalendar();
                }
                
                if (class_exists('DOPBSPViewsSettingsNotifications')){
                    $this->settings_notifications = new DOPBSPViewsSettingsNotifications();
                }
                
                if (class_exists('DOPBSPViewsSettingsPaymentGateways')){
                    $this->settings_payment_gateways = new DOPBSPViewsSettingsPaymentGateways();
                }
                
                if (class_exists('DOPBSPViewsSettingsPayPal')){
                    $this->settings_paypal = new DOPBSPViewsSettingsPayPal();
                }
                
                if (class_exists('DOPBSPViewsSettingsUsers')){
                    $this->settings_users = new DOPBSPViewsSettingsUsers();
                }
                
                /*
                 * Initialize templates view classes.
                 */
                if (class_exists('DOPBSPViewsTemplates')){
                    $this->templates = new DOPBSPViewsTemplates();
                }
                
                /*
                 * Initialize translation view classes.
                 */
                if (class_exists('DOPBSPViewsTranslation')){
                    $this->translation = new DOPBSPViewsTranslation();
                }
            }
            
            /*
             * Display default page header.
             * 
             * @param title (string): page title
             * 
             * @return default page header HTML
             */
            function displayHeader($title){
                global $DOPBSP;
?>
                <h2></h2>
                <div class="header">
                    <h3><?php echo $title?></h3>
                    <?php echo $this->getLanguages(); ?>
                    <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank"><?php echo $DOPBSP->text('HELP_FAQ'); ?></a>
                    <a href="<?php echo DOPBSP_CONFIG_HELP_FAQ_URL; ?>" target="_blank"><?php echo $DOPBSP->text('HELP_DOCUMENTATION'); ?></a>
                    <br class="DOPBSP-clear" />
                </div>
                <?php $this->displayBoxes(); ?>
<?php                
            }
            
            /*
             * Display messages, confirmation & go to top boxes.
             * 
             * @return boxes HTML
             */
            function displayBoxes(){
                global $DOPBSP;
?>                
                <div id="DOPBSP-messages-background"></div>
                
                <!--
                    Messages box.
                -->
                <div id="DOPBSP-messages-box">
                    <a href="javascript:DOPBSP.toggleMessages()" class="close"></a>
                    <div class="icon-active"></div>
                    <div class="icon-success"></div>
                    <div class="icon-error"></div>
                    <div class="message"></div>
                </div>
                
                <!--
                    Confirmation box.
                -->
                <div id="DOPBSP-confirmation-box">
                    <div class="icon"></div>
                    <div class="message"></div>
                    <div class="buttons">
                        <a href="javascript:void(0)" class="button-yes"><?php echo $DOPBSP->text('MESSAGES_CONFIRMATION_YES'); ?></a>
                        <a href="javascript:void(0)" class="button-no"><?php echo $DOPBSP->text('MESSAGES_CONFIRMATION_NO'); ?></a>
                    </div>    
                </div>
                
                <!--
                    Go to top button.
                -->
                <a href="javascript:DOPPrototypes.scrollToY(0)" id="DOPBSP-go-top"></a>
<?php    
            }
            
            /*
             * Add translation to JavaScript for AJAX usage.
             */
            function getTranslation(){
                global $wpdb;
                global $DOPBSP;
                
                if (isset($_GET['page'])){
                    $current_page = $_GET['page'];

                    switch($current_page){
                        case 'dopbsp-calendars':
                            $DOPBSP_curr_page = 'Calendars';
                            break;
                        case 'dopbsp-coupons':
                            $DOPBSP_curr_page = 'Coupons';
                            break;
                        case 'dopbsp-discounts':
                            $DOPBSP_curr_page = 'Discounts';
                            break;
                        case 'dopbsp-emails':
                            $DOPBSP_curr_page = 'Emails';
                            break;
                        case 'dopbsp-events':
                            $DOPBSP_curr_page = 'Events';
                            break;
                        case 'dopbsp-extras':
                            $DOPBSP_curr_page = 'Extras';
                            break;
                        case 'dopbsp-fees':
                            $DOPBSP_curr_page = 'Fees';
                            break;
                        case 'dopbsp-forms':
                            $DOPBSP_curr_page = 'Forms';
                            break;
                        case 'dopbsp-locations':
                            $DOPBSP_curr_page = 'Locations';
                            break;
                        case 'dopbsp-reservations':
                            $DOPBSP_curr_page = 'Reservations';
                            break;
                        case 'dopbsp-rules':
                            $DOPBSP_curr_page = 'Rules';
                            break;
                        case 'dopbsp-settings':
                            $DOPBSP_curr_page = 'Settings';
                            break;
                        case 'dopbsp-templates':
                            $DOPBSP_curr_page = 'Templates';
                            break;
                        case 'dopbsp-translation':
                            $DOPBSP_curr_page = 'Translation';
                            break;
                        default:
                            $DOPBSP_curr_page = 'Dashboard';
                            break;
                    }
                }
                else{
                    $DOPBSP_curr_page = 'Calendars';
                }
                
                if (!is_super_admin()){
                    $DOPBSP_user_role = wp_get_current_user()->roles[0];
                }
                else{
                    $DOPBSP_user_role = 'administrator';
                }
?>          
            <script type="text/JavaScript">
                var DOPBSP_curr_page = '<?php echo $DOPBSP_curr_page; ?>',
                DOPBSP_user_role = '<?php echo $DOPBSP_user_role; ?>',
                DOPBSP_plugin_url = '<?php echo $DOPBSP->paths->url; ?>',
                DOPBSP_translation_text = new Array(),
                DOPBSP_CONFIG_HELP_DOCUMENTATION_URL = '<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>',
                DOPBSP_CONFIG_HELP_FAQ_URL = '<?php echo DOPBSP_CONFIG_HELP_FAQ_URL; ?>';
                
<?php
                $language = $DOPBSP->classes->translation->get();
                $translation = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language);

                foreach ($translation as $item){
                    $text = stripslashes($item->translation);
                    $text = str_replace('<<single-quote>>', "\'", $text);
                    $text = str_replace('<script>', "", $text);
                    $text = str_replace('</script>', "", $text);
?>
                    
                    DOPBSP_translation_text['<?php echo $item->key_data; ?>'] = '<?php echo $text; ?>';
<?php                    
                }
?>
            </script>
<?php  
            }
            
            /*
             * Get languages drop down.
             * 
             * @param id (string): drop down ID
             * @param function (string): onchange function
             * @param class (string): drop down class
             * 
             * @return drop down HTML
             */
            function getLanguages($id = 'DOPBSP-admin-translation', 
                                  $function = 'DOPBSPTranslation.change()', 
                                  $selected_language = '',
                                  $class = ''){
                global $wpdb;
                global $DOPBSP;
                
                $HTML = array();
                
                $languages = $DOPBSP->classes->translation->languages;
                $selected_language = $selected_language == '' ? $DOPBSP->classes->translation->get():$selected_language;
                
                $enabled_languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');
                
                array_push($HTML, '<select name="'.$id.'" id="'.$id.'"'.($class == '' ? '':' class="'.$class.'"').' onchange="'.$function.'">');
                
                foreach ($enabled_languages as $enabled_language){
                    for ($i=0; $i<count($languages); $i++){
                        if ($enabled_language->code == $languages[$i]['code']){
                            array_push($HTML, '<option value="'.$languages[$i]['code'].'"'.($selected_language == $languages[$i]['code'] ? ' selected="selected"':'').'>'.$languages[$i]['name'].'</option>');
                            break;
                        }
                    }
                }
                array_push($HTML, '</select>');
                array_push($HTML, '<script type="text/JavaScript">jQuery(\'#'.$id.'\').DOPSelect();</script>');
                
                return implode('', $HTML);
            }
        }
    }