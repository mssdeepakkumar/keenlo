<?php
/*
Plugin Name: Booking System PRO (WordPress Plugin)
Version: 2.0
Plugin URI: http://codecanyon.net/item/booking-system-pro-wordpress-plugin/2675936?ref=DOTonPAPER
Description: You will be able to insert it in any page or post you want with an inbuilt short code generator.<br /><br />If you like this plugin, feel free to rate it five stars at <a href="http://codecanyon.net/item/booking-system-pro-wordpress-plugin/2675936?ref=DOTonPAPER" target="_blank">CodeCanyon</a> in your downloads section. If you encounter any problems please do not give a low rating but <a href="http://envato-support.dotonpaper.net">visit</a> our <a href="http://envato-support.dotonpaper.net">Support Forums</a> first so we can help you.
Author: Dot on Paper
Author URI: http://www.dotonpaper.net

Change log:

        2.0 (2014-07-22)
 
                * "Coupons" added. Create voucher codes for your clients.
                * "Discounts" added. Give discounts for the booked period, in different time periods.
                * "Email templates" added. Customize your notifications directly from administration area.
                * "Extras" added. Add amenities, services & other stuff, with price or not, to a reservation.
                * "Rules" added. Currently you can set min/max time lapse.
                * "Taxes & fees" added. Set taxes & fees that need to be paid (VAT tax for example).
                * "Translation" page has been updated.
                * Add user permissions using custom roles.
                * AJAX requests no longer return 403, 404 errors in front end.
                * All algorithms are improved and work faster. Install, save, search ...
                * Availability text is visible on special days, bug fixed.
                * Back end UI/CSS has been changed. A new design has been created for administration area.
                * Compatibility with PHP 5.3 or higher has been fixed.
                * Complete code core changes. Everything is OOP & commented.
                * Current year changes on calendar resize, bug fixed.
                * Custom post types do not appear anymore in blog posts by default.
                * Data save/load speed & server memory usage has been optimized.
                * Days availability is restored when you cancel a reservation.
                * Different levels of checking availability have been added in the booking process.
                * Front end calendar info messages hide after a few seconds.
                * Front end calendar speed has been improved.
                * Front end UI/CSS has been changed. A new design has been created for front end calendar and all classes and ids are unique.
                * IE bugs fixed.
                * Language is not saved anymore in sessions in front end.
                * Language codes have been changed to international codes for: Albanian (al->sq), Basque (bs->eu), Belarusian (by->be), Chinese (cn->zh), Croatian (cr->hr), Czech (cz->cs), Danish (dk->da), Dutch (du->nl), Greek (gr->el), Haitian Creole(ha->ht), Irish (ir->ga), Malay (mg->ms), Maltese (ma->mt), Persian (pe->fa), Spanish (sp->es), Swedish (se->sv), Welsh (we->cy).
                * Languages can be enabled/disabled in back end.
                * Major database changes. Column changes and more indexes created.
                * Minimum booking period error message does not display randomly when you select only check in date.
                * Notifications are sent without SMTP if SMTP does not work.
                * Notifications can be enabled/disabled in administration area.
                * Notifications can be sent to multiple admins.
                * Payment transaction ID is displayed in notification emails.
                * PHPMailer class is used when sending notifications.
                * Redirect after a booking has been made, has been added.
                * Redirect after a payment has been made with PayPal, has been added.
                * Possibility to select more than one group of days/hours in a reservation has been added.
                * Required checkbox validation bug fixed.
                * Set the number of months to be initially displayed.
                * Stop booking in advance added.
                * Translation for dynamic items display correctly.
                * Translation works with special characters.
                * UAE Dirham currency added.
                * User capabilities fixed.
                * Verification if calendar has been attached to WooCommerce product has been added.
                * WooCommerce integration has been changed. This should fix all incompatibility problems that were in previous version.

        1.9.5 (2014-03-01)

                * "wp_mail()" function replaced with "mail()".
                * Booking order is added to WooCommerce cart even if form is removed from product page.
                * Calendar display even it is used twice on same page.
                * Installation on XAMP server fixed.
                * Reservation details appear on WooCommerce notifications email.
                * Reservation details appear on WooCommerce order.
                * Reservation save bug fixed.
                * Woocommerce date format fixed.

        1.9 (2013-12-16)
 
                * bbPress incompatibility, bug fixed.
                * Calendars not loading, bug fixed.
                * Config file added.
                * CSS bugs fixed.
                * Delete plugin data/database, bug fixed.
                * Delete reservation added.
                * front end translation not showing bug fix.
                * Hooks added.
                * Installation algorithms have been optimized.
                * Month not displaying in notification emails bug fixed.
                * Navigation after data is saved in back end fixed.
                * Reservations appear in custom post type.
                * Reservations calendar is generated correctly when filters are modified.
                * Reservations currency display bug fixed.
                * Save translation bug fixed.
                * Set default database values before installation.
                * Set default language for back end and/or front end before installation.
                * Set default users permissions before installation.
                * Submit button ("Add to cart" / "Book") is hidden when you submit a booking or you add a reservation to cart.
                * Translation display bug fixed when using characters like ' or ".
                * Translation edit has been optimized.
                * When a calendar is deleted the reservations area is removed.
                * WooCommerce support added.
   
        1.8 (2013-11-01)
                
                * Add reservations in admin.
                * Approving/canceling a reservation modifies the calendar data.
                * Back end CSS bugs fixed.
                * Custom post types bugs fixed.
                * Edit unavailable days, bug fixed.
                * Front end CSS bugs fixed.
                * Instant/waiting approval display, bug fixed.
                * JavaScript in admin posts fixed.
                * Localhost bugs fixed.
                * Plugin paths updated.
                * Prices, deposits, discounts can have float values.
                * Reservations logic has been completly modified (search added, filters added, calendar & list view added).
                * Select days from different months on front end calendar, bug fixed.
                * Translation system has been updated.
                * User management updated.
                * Windows server mySQL text fields bug fixed.

        1.7 (2013-07-31)

                * Add calendars in widgets.
                * Approve reservation bug fixed.
                * Back end style changes.
                * Calendar ID is removed from clients notification emails.
                * CSS bug fixes.
                * Custom post type added.
                * Date select is fixed when minimum amount of days is set.
                * Datepicker bug fix, when you can select only one day.
                * Drop down fields display correct selected option in email.
                * Hours info displayed on day hover.
                * Major changes in hours logic and display.
                * Newly created forms display correct after PayPal Payment.
                * PayPal notification email content bug fixed.
                * Send email using normal function if SMTP is incorrect.
                * Tables not created on Windows OS bug fixed.
                * Text on Settings page has been changed.
                * Translation for check fields added.
                * User role is updated when is changed in WP admin.
                * When hours are enabled days details can be set manually or set depending on hours details on that current day.
                * WordPress update error fixed. 

        1.6 (2013-06-15)

                * Admin language is different for each user.
                * Compatibility fixes.
                * Custom forms tweaks.
                * Database update.
                * Datepicker & Google translate incompatibility, bug fixed.
                * Display calendar id & name in notifications emails.
                * Display hours interval from current hour to next one.
                * Posibility to hide number of items select field has been added.
                * You can set booking requests to by approved instanly, or not.
                * You have the possibility to calculate the total price using the last hour selected value, or not.

        1.5 (2013-06-08)

                * CSS incompatibility fixes.
                * Custom forms added.
                * Datepicker z-index bug fixed.
                * Email header is custom.
                * Group day date is displayed correctly after select.
                * Users permissons translation fixed.
 
        1.4 (2013-06-03)

                * ACAO buster added.
                * Admin change language bug fixed.
                * Administrators can create calendars for users.
                * Calendar loading time is improved.
                * Calendar resize on hidden elements, bug fixed.
                * Database is deleted when you delete the plugin.
                * Display only an information calendar in front end.
                * Emails are sent using "wp_mail()".
                * Indonesia Rupiah currency bug fixed.
                * PayPal credit card payment bug fixed.
                * PayPal session bug fixed.
                * Select first day of the week.
                * Slow admin bug fixed.
                * Small admin changes.
                * Touch devices freeze bug fixed.
                * Translation fixes.
                * Update notification added.
                * User permissions updated.

        1.3 (2012-12-13)

                * Correct hours format is displayed.
                * Deposit feature has been added.
                * Discounts by number of days booked have been added.
                * Email message and language bugs have been fixed.
                * Front end responsive has been added.
                * Touch devices navigation has been enabled.
                * You can translate the sidebar datepicker.
                * You can use PayPal credit card payment.
	
	1.2 (2012-11-01)
 
                * AM/PM hour format added.
                * Hours data save bug fixed.
                * Language files added (but not translated).
                * Morning check out added.
                * Past hours are removed from current day.
                * Rejected reservation notification email fixed.  
                * Reservation cancel added.
                * Shortcode generator doesn't appear if you are not allowed to create calendars or you didn't create any calendars.
                * SMTP SSL fix.
                * User permissions bug fixed.
                * You can select minimum and/or maximum amount of days that can be booked.
                * You can set default hours values by day(s).

	1.1 (2012-09-05)
	
                * "ereg()" function replaced with "preg_match()".
                * Administrators can view and edit users calendars.
                * Back end & front end CSS incompatibility fixes.
                * Clean script to remove past days info to clear database from unnecessary data.
		* Database structure has been changed (now is much faster to save/load data & works on server with few resources).
                * Delete calendar bug fixed.
                * Display correct month in future years, bug fixed.
                * Emails template system added.
                * PayPal bugs fixed.
                * Reservation ID is displayed in notifications emails.
                * Terms & Conditions checkbox and link added.
                * You can now add calendar sidebar in a widget area.
                * You can set if individual users can create or not calendars.
                * You can use SMTP to send notification emails.
	
	1.0 (2012-07-15)
	
		* Initial release.
		
Installation: Upload the folder dopbsp from the zip file to "wp-content/plugins/" and activate the plugin in your admin panel or upload dopbsp.zip in the "Add new" section.
*/

    // ini_set('error_reporting', version_compare(PHP_VERSION,5,'>=') && version_compare(PHP_VERSION,6,'<') ? E_ALL^E_STRICT^E_NOTICE^E_WARNING:E_ALL^E_NOTICE^E_WARNING);

    /*
     * Configuration file
     */
    include_once 'dopbsp-config.php';
    
    /*
     * Libraries
     */
    include_once 'libraries/php/dop-prototypes.php';
    include_once ABSPATH.WPINC.'/class-phpmailer.php';
    include_once ABSPATH.WPINC.'/class-smtp.php';
    
    /*
     * Views
     */
    include_once 'views/views-backend.php';
    
    include_once 'views/views-backend-calendars.php';
    
    include_once 'views/coupons/views-backend-coupons.php';
    include_once 'views/coupons/views-backend-coupon.php';
    
    include_once 'views/views-backend-dashboard.php';
    
    include_once 'views/discounts/views-backend-discounts.php';
    include_once 'views/discounts/views-backend-discount.php';
    include_once 'views/discounts/views-backend-discount-items.php';
    include_once 'views/discounts/views-backend-discount-item.php';
    include_once 'views/discounts/views-backend-discount-item-rule.php';
    
    include_once 'views/emails/views-backend-emails.php';
    include_once 'views/emails/views-backend-email.php';
    
    include_once 'views/views-backend-events.php';
    
    include_once 'views/extras/views-backend-extras.php';
    include_once 'views/extras/views-backend-extra.php';
    include_once 'views/extras/views-backend-extra-groups.php';
    include_once 'views/extras/views-backend-extra-group.php';
    include_once 'views/extras/views-backend-extra-group-item.php';
    
    include_once 'views/fees/views-backend-fees.php';
    include_once 'views/fees/views-backend-fee.php';
    
    include_once 'views/forms/views-backend-forms.php';
    include_once 'views/forms/views-backend-form.php';
    include_once 'views/forms/views-backend-form-fields.php';
    include_once 'views/forms/views-backend-form-field.php';
    include_once 'views/forms/views-backend-form-field-select-option.php';
    
    include_once 'views/views-backend-locations.php';
    
    include_once 'views/reservations/views-backend-reservations.php';
    include_once 'views/reservations/views-backend-reservations-list.php';
    include_once 'views/reservations/views-backend-reservation.php';
    include_once 'views/reservations/views-backend-reservation-coupon.php';
    include_once 'views/reservations/views-backend-reservation-details.php';
    include_once 'views/reservations/views-backend-reservation-discount.php';
    include_once 'views/reservations/views-backend-reservation-extras.php';
    include_once 'views/reservations/views-backend-reservation-fees.php';
    include_once 'views/reservations/views-backend-reservation-form.php';
    
    include_once 'views/rules/views-backend-rules.php';
    include_once 'views/rules/views-backend-rule.php';
    
    include_once 'views/settings/views-backend-settings.php';
    include_once 'views/settings/views-backend-settings-calendar.php';
    include_once 'views/settings/views-backend-settings-notifications.php';
    include_once 'views/settings/views-backend-settings-payment-gateways.php';
    include_once 'views/settings/payment-gateways/views-backend-settings-paypal.php';
    include_once 'views/settings/views-backend-settings-users.php';
    
    include_once 'views/views-backend-templates.php';
    
    include_once 'views/views-backend-translation.php';
    
    /*
     * Classes
     */
    include_once 'includes/class-backend.php';
    include_once 'includes/class-frontend.php';
    
    include_once 'includes/calendars/class-backend-calendars.php';
    include_once 'includes/calendars/class-backend-calendar.php';
    include_once 'includes/calendars/class-backend-calendar-schedule.php';
    include_once 'includes/calendars/class-frontend-calendars.php';
    include_once 'includes/calendars/class-frontend-calendar.php';
    include_once 'includes/calendars/class-frontend-calendar-sidebar.php';
    
    include_once 'includes/coupons/class-backend-coupons.php';
    include_once 'includes/coupons/class-backend-coupon.php';
    include_once 'includes/coupons/class-frontend-coupons.php';
    
    include_once 'includes/class-currencies.php';
    
    include_once 'includes/custom-posts/class-custom-posts.php';
    include_once 'includes/custom-posts/class-custom-posts-loop.php';
    include_once 'includes/custom-posts/class-custom-posts-meta.php';
    
    include_once 'includes/dashboard/class-backend-dashboard.php';
    
    include_once 'includes/discounts/class-backend-discounts.php';
    include_once 'includes/discounts/class-backend-discount.php';
    include_once 'includes/discounts/class-backend-discount-items.php';
    include_once 'includes/discounts/class-backend-discount-item.php';
    include_once 'includes/discounts/class-backend-discount-item-rules.php';
    include_once 'includes/discounts/class-backend-discount-item-rule.php';
    include_once 'includes/discounts/class-frontend-discounts.php';
    
    include_once 'includes/emails/class-backend-emails.php';
    include_once 'includes/emails/class-backend-email.php';
    
    include_once 'includes/events/class-backend-events.php';
    
    include_once 'includes/extras/class-backend-extras.php';
    include_once 'includes/extras/class-backend-extra.php';
    include_once 'includes/extras/class-backend-extra-groups.php';
    include_once 'includes/extras/class-backend-extra-group.php';
    include_once 'includes/extras/class-backend-extra-group-items.php';
    include_once 'includes/extras/class-backend-extra-group-item.php';
    include_once 'includes/extras/class-frontend-extras.php';
    
    include_once 'includes/fees/class-backend-fees.php';
    include_once 'includes/fees/class-backend-fee.php';
    include_once 'includes/fees/class-frontend-fees.php';
    
    include_once 'includes/forms/class-backend-forms.php';
    include_once 'includes/forms/class-backend-form.php';
    include_once 'includes/forms/class-backend-form-fields.php';
    include_once 'includes/forms/class-backend-form-field.php';
    include_once 'includes/forms/class-backend-form-field-select-options.php';
    include_once 'includes/forms/class-backend-form-field-select-option.php';
    include_once 'includes/forms/class-frontend-forms.php';
    
    include_once 'includes/class-languages.php';
    
    include_once 'includes/locations/class-backend-locations.php';
    
    include_once 'includes/class-notifications.php';
    
    include_once 'includes/class-frontend-order.php';
    
    include_once 'includes/payment-gateways/class-payment-gateways.php';
    include_once 'includes/payment-gateways/class-paypal.php';
    
    include_once 'includes/reservations/class-backend-reservations.php';
    include_once 'includes/reservations/class-backend-reservations-add.php';
    include_once 'includes/reservations/class-backend-reservations-calendar.php';
    include_once 'includes/reservations/class-backend-reservations-list.php';
    include_once 'includes/reservations/class-backend-reservation.php';
    include_once 'includes/reservations/class-backend-reservation-notifications.php';
    include_once 'includes/reservations/class-frontend-reservations.php';
    
    include_once 'includes/rules/class-backend-rules.php';
    include_once 'includes/rules/class-backend-rule.php';
    include_once 'includes/rules/class-frontend-rules.php';
    
    include_once 'includes/class-frontend-search.php';
    
    include_once 'includes/settings/class-backend-settings.php';
    include_once 'includes/settings/class-backend-settings-calendar.php';
    include_once 'includes/settings/class-backend-settings-notifications.php';
    include_once 'includes/settings/class-backend-settings-payment-gateways.php';
    include_once 'includes/settings/class-backend-settings-users.php';
    
    include_once 'includes/shortcodes/class-backend-shortcodes.php';
    
    include_once 'includes/templates/class-backend-templates.php';
    
    include_once 'includes/translation/class-translation-text-calendars.php';
    include_once 'includes/translation/class-translation-text-cart.php';
    include_once 'includes/translation/class-translation-text-coupons.php';
    include_once 'includes/translation/class-translation-text-custom-posts.php';
    include_once 'includes/translation/class-translation-text-dashboard.php';
    include_once 'includes/translation/class-translation-text-discounts.php';
    include_once 'includes/translation/class-translation-text-emails.php';
    include_once 'includes/translation/class-translation-text-events.php';
    include_once 'includes/translation/class-translation-text-extras.php';
    include_once 'includes/translation/class-translation-text-forms.php';
    include_once 'includes/translation/class-translation-text-fees.php';
    include_once 'includes/translation/class-translation-text-general.php';
    include_once 'includes/translation/class-translation-text-locations.php';
    include_once 'includes/translation/class-translation-text-order.php';
    include_once 'includes/translation/class-translation-text-reservations.php';
    include_once 'includes/translation/class-translation-text-rules.php';
    include_once 'includes/translation/class-translation-text-search.php';
    include_once 'includes/translation/class-translation-text-settings.php';
    include_once 'includes/translation/class-translation-text-templates.php';
    include_once 'includes/translation/class-translation-text-translation.php';
    include_once 'includes/translation/class-translation-text-widgets.php';
    include_once 'includes/translation/class-translation-text-woocommerce.php';
    include_once 'includes/translation/payment-gateways/class-translation-text-paypal.php';
    include_once 'includes/translation/class-translation.php';
    
    include_once 'includes/class-update.php';
    
    include_once 'includes/class-widget.php';
    
    /*
     * WooCommerce classes.
     */
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))){
        include_once 'includes/woocommerce/class-woocommerce.php';
        include_once 'includes/woocommerce/class-woocommerce-cart.php';
        include_once 'includes/woocommerce/class-woocommerce-category.php';
        include_once 'includes/woocommerce/class-woocommerce-order.php';
        include_once 'includes/woocommerce/class-woocommerce-product.php';
        include_once 'includes/woocommerce/class-woocommerce-tab.php';
        include_once 'includes/woocommerce/class-woocommerce-variation.php';
    }
    
    /*
     * Global classes.
     */
    global $DOPBSP;
    
    /*
     * Booking System PRO main PHP class.
     */
    if (!class_exists('DOPBSP')){
        class DOPBSP{
            /*
             * Public variables.
             */
            public $classes;
            public $paths;
            public $tables;
            public $vars;
            public $views;
            
            /*
             * Constructor
             */
            function DOPBSP(){
                $this->classes = new stdClass;
                $this->paths = new stdClass;
                $this->tables = new stdClass;
                $this->vars = new stdClass;
                $this->views = new stdClass;
            
                $this->definePaths();
                $this->defineTables();
                
                /*
                 * Initialize views class.
                 */
                if (class_exists('DOPBSPViews')){
                    $this->views = new DOPBSPViews();
                }
                
                $this->initClasses();
                
                if (is_admin() 
                        && !isset($_POST['dopbsp_frontend_ajax_request'])){
                    add_action('admin_menu', array(&$this, 'initBackEnd'));
                    $this->initBackEndAJAX();
                }
                else{
                    $this->initFrontEndAJAX();
                }
                
                /*
                 * Initialize plugin's widget.
                 */
                if (class_exists('DOPBSPWidget')){
                    add_action('widgets_init', create_function('', 'return register_widget("DOPBSPWidget");'));
                }
            }
            
            /*
             * Defines plugin's paths constants.
             */
            function definePaths(){
                /*
                 * Plugin URL.
                 */
                $this->paths->url =  plugin_dir_url(__FILE__);

                /*
                 * Absolute path.
                 */
                $this->paths->abs = str_replace('\\', '/', plugin_dir_path(__FILE__));
            }
            
            /*
             * Defines plugin's tables constants.
             */
            function defineTables(){
                global $wpdb;
                
                /*
                 * Calendars table.
                 */
                $this->tables->calendars = $wpdb->prefix.'dopbsp_calendars';

                /*
                 * Counpons tables.
                 */
                $this->tables->coupons = $wpdb->prefix.'dopbsp_coupons';

                /*
                 * Days table.
                 */
                $this->tables->days = $wpdb->prefix.'dopbsp_days';

                /*
                 * Discounts tables.
                 */
                $this->tables->discounts = $wpdb->prefix.'dopbsp_discounts';
                $this->tables->discounts_items = $wpdb->prefix.'dopbsp_discounts_items';
                $this->tables->discounts_items_rules = $wpdb->prefix.'dopbsp_discounts_items_rules';

                /*
                 * Emails tables.
                 */
                $this->tables->emails = $wpdb->prefix.'dopbsp_emails';
                $this->tables->emails_translation = $wpdb->prefix.'dopbsp_emails_translation';
                
                /*
                 * Extras tables.
                 */
                $this->tables->extras = $wpdb->prefix.'dopbsp_extras';
                $this->tables->extras_groups = $wpdb->prefix.'dopbsp_extras_groups';
                $this->tables->extras_groups_items = $wpdb->prefix.'dopbsp_extras_groups_items';

                /*
                 * Fees tables.
                 */
                $this->tables->fees = $wpdb->prefix.'dopbsp_fees';
                
                /*
                 * Forms tables.
                 */
                $this->tables->forms = $wpdb->prefix.'dopbsp_forms';
                $this->tables->forms_fields = $wpdb->prefix.'dopbsp_forms_fields';
                $this->tables->forms_fields_options = $wpdb->prefix.'dopbsp_forms_select_options';
                
                /*
                 * Languages tables.
                 */
                $this->tables->languages = $wpdb->prefix.'dopbsp_languages';

                /*
                 * Reservations table.
                 */
                $this->tables->reservations = $wpdb->prefix.'dopbsp_reservations';

                /*
                 * Rules tables.
                 */
                $this->tables->rules = $wpdb->prefix.'dopbsp_rules';

                /*
                 * Settings table.
                 */
                $this->tables->settings = $wpdb->prefix.'dopbsp_settings';
                $this->tables->settings_notifications = $wpdb->prefix.'dopbsp_settings_notifications';
                $this->tables->settings_payment = $wpdb->prefix.'dopbsp_settings_payment';

                /*
                 * Translation tables.
                 */
                $this->tables->translation = $wpdb->prefix.'dopbsp_translation';

                /*
                 * WooCommerce table.
                 */
                $this->tables->woocommerce = $wpdb->prefix.'dopbsp_woocommerce';
            }
            
            /*
             * Initialize PHP classes.
             */
            function initClasses(){
                /*
                 *  Initialize DOP prototypes class. This class is the 1st initialized.
                 */
                if (class_exists('DOPPrototypes')){
                    $this->classes->prototypes = new DOPPrototypes();
                }
    
                /*
                 * Initialize langauges class. This class is the 2nd initialized.
                 */
                if (class_exists('DOPBSPLanguages')){
                    $this->classes->languages = new DOPBSPLanguages();
                }
    
                /*
                 * Initialize translation class. This class is the 3rd initialized.
                 */
                if (class_exists('DOPBSPTranslation')){
                    $this->classes->translation = new DOPBSPTranslation();
                }
    
                /*
                 * Initialize currencies class. This class is the 4th initialized.
                 */
                if (class_exists('DOPBSPCurrencies')){
                    $this->classes->currencies = new DOPBSPCurrencies();
                }

                /*
                 * Initialize notifications classes.
                 */
                if (class_exists('DOPBSPNotifications')){
                    $this->classes->notifications = new DOPBSPNotifications();
                }
    
                /*
                 * Initialize back end class. This class is the 5th initialized.
                 */
                if (class_exists('DOPBSPBackEnd')){
                    $this->classes->backend = new DOPBSPBackEnd();
                }
                
                /*
                 * Initialize front end class. This class is the 6th initialized.
                 */
                if (class_exists('DOPBSPFrontEnd')){
                    $this->classes->frontend = new DOPBSPFrontEnd();
                }
                
                /*
                 * ************************************************************* The rest of the classes are initialized in alphabetical order.
                 */
                /*
                 * Initialize calendars classes.
                 */
                if (class_exists('DOPBSPBackEndCalendars')){
                    $this->classes->backend_calendars = new DOPBSPBackEndCalendars();
                }

                if (class_exists('DOPBSPBackEndCalendar')){
                    $this->classes->backend_calendar = new DOPBSPBackEndCalendar();
                }

                if (class_exists('DOPBSPBackEndCalendarSchedule')){
                    $this->classes->backend_calendar_schedule = new DOPBSPBackEndCalendarSchedule();
                }
                
                if (class_exists('DOPBSPFrontEndCalendars')){
                    $this->classes->frontend_calendars = new DOPBSPFrontEndCalendars();
                }

                if (class_exists('DOPBSPFrontEndCalendar')){
                    $this->classes->frontend_calendar = new DOPBSPFrontEndCalendar();
                }

                if (class_exists('DOPBSPFrontEndCalendarSidebar')){
                    $this->classes->frontend_calendar_sidebar = new DOPBSPFrontEndCalendarSidebar();
                }

                /*
                 * Initialize coupons classes.
                 */
                if (class_exists('DOPBSPBackEndCoupons')){
                    $this->classes->backend_coupons = new DOPBSPBackEndCoupons();
                }

                if (class_exists('DOPBSPBackEndCoupon')){
                    $this->classes->backend_coupon = new DOPBSPBackEndCoupon();
                }
                
                if (class_exists('DOPBSPFrontEndCoupons')){
                    $this->classes->frontend_coupons = new DOPBSPFrontEndCoupons();
                }

                /*
                 * Initialize custom posts classes.
                 */
                if (class_exists('DOPBSPCustomPosts')){
                    $this->classes->custom_posts = new DOPBSPCustomPosts();
                }

                if (class_exists('DOPBSPCustomPostsLoop')){
                    $this->classes->custom_posts_loop = new DOPBSPCustomPostsLoop();
                }
                
                if (class_exists('DOPBSPCustomPostsMeta')){
                    $this->classes->custom_posts_meta = new DOPBSPCustomPostsMeta();
                }

                /*
                 * Initialize dashboard classes.
                 */
                if (class_exists('DOPBSPBackEndDashboard')){
                    $this->classes->backend_dashboard = new DOPBSPBackEndDashboard();
                }

                /*
                 * Initialize discounts classes.
                 */
                if (class_exists('DOPBSPBackEndDiscounts')){
                    $this->classes->backend_discounts = new DOPBSPBackEndDiscounts();
                }

                if (class_exists('DOPBSPBackEndDiscount')){
                    $this->classes->backend_discount = new DOPBSPBackEndDiscount();
                }

                if (class_exists('DOPBSPBackEndDiscountItems')){
                    $this->classes->backend_discount_items = new DOPBSPBackEndDiscountItems();
                }

                if (class_exists('DOPBSPBackEndDiscountItem')){
                    $this->classes->backend_discount_item = new DOPBSPBackEndDiscountItem();
                }

                if (class_exists('DOPBSPBackEndDiscountItemRules')){
                    $this->classes->backend_discount_item_rules = new DOPBSPBackEndDiscountItemRules();
                }

                if (class_exists('DOPBSPBackEndDiscountItemRule')){
                    $this->classes->backend_discount_item_rule = new DOPBSPBackEndDiscountItemRule();
                }

                if (class_exists('DOPBSPFrontEndDiscounts')){
                    $this->classes->frontend_discounts = new DOPBSPFrontEndDiscounts();
                }

                /*
                 * Initialize emails classes.
                 */
                if (class_exists('DOPBSPBackEndEmails')){
                    $this->classes->backend_emails = new DOPBSPBackEndEmails();
                }
                
                if (class_exists('DOPBSPBackEndEmail')){
                    $this->classes->backend_email = new DOPBSPBackEndEmail();
                }

                /*
                 * Initialize events classes.
                 */
                if (class_exists('DOPBSPBackEndEvents')){
                    $this->classes->backend_events = new DOPBSPBackEndEvents();
                }

                /*
                 * Initialize extras classes.
                 */
                if (class_exists('DOPBSPBackEndExtras')){
                    $this->classes->backend_extras = new DOPBSPBackEndExtras();
                }

                if (class_exists('DOPBSPBackEndExtra')){
                    $this->classes->backend_extra = new DOPBSPBackEndExtra();
                }

                if (class_exists('DOPBSPBackEndExtraGroups')){
                    $this->classes->backend_extra_groups = new DOPBSPBackEndExtraGroups();
                }

                if (class_exists('DOPBSPBackEndExtraGroup')){
                    $this->classes->backend_extra_group = new DOPBSPBackEndExtraGroup();
                }

                if (class_exists('DOPBSPBackEndExtraGroupItems')){
                    $this->classes->backend_extra_group_items = new DOPBSPBackEndExtraGroupItems();
                }

                if (class_exists('DOPBSPBackEndExtraGroupItem')){
                    $this->classes->backend_extra_group_item = new DOPBSPBackEndExtraGroupItem();
                }

                if (class_exists('DOPBSPFrontEndExtras')){
                    $this->classes->frontend_extras = new DOPBSPFrontEndExtras();
                }

                /*
                 * Initialize fees classes.
                 */
                if (class_exists('DOPBSPBackEndFees')){
                    $this->classes->backend_fees = new DOPBSPBackEndFees();
                }

                if (class_exists('DOPBSPBackEndFee')){
                    $this->classes->backend_fee = new DOPBSPBackEndFee();
                }

                if (class_exists('DOPBSPFrontEndFees')){
                    $this->classes->frontend_fees = new DOPBSPFrontEndFees();
                }

                /*
                 * Initialize forms classes.
                 */
                if (class_exists('DOPBSPBackEndForms')){
                    $this->classes->backend_forms = new DOPBSPBackEndForms();
                }

                if (class_exists('DOPBSPBackEndForm')){
                    $this->classes->backend_form = new DOPBSPBackEndForm();
                }

                if (class_exists('DOPBSPBackEndFormFields')){
                    $this->classes->backend_form_fields = new DOPBSPBackEndFormFields();
                }

                if (class_exists('DOPBSPBackEndFormField')){
                    $this->classes->backend_form_field = new DOPBSPBackEndFormField();
                }

                if (class_exists('DOPBSPBackEndFormFieldSelectOptions')){
                    $this->classes->backend_form_field_select_options = new DOPBSPBackEndFormFieldSelectOptions();
                }

                if (class_exists('DOPBSPBackEndFormFieldSelectOption')){
                    $this->classes->backend_form_field_select_option = new DOPBSPBackEndFormFieldSelectOption();
                }

                if (class_exists('DOPBSPFrontEndForms')){
                    $this->classes->frontend_forms = new DOPBSPFrontEndForms();
                }

                /*
                 * Initialize locations classes.
                 */
                if (class_exists('DOPBSPBackEndLocations')){
                    $this->classes->backend_locations = new DOPBSPBackEndLocations();
                }

                /*
                 * Initialize order classes.
                 */
                if (class_exists('DOPBSPFrontEndOrder')){
                    $this->classes->frontend_order = new DOPBSPFrontEndOrder();
                }
                
                /*
                 * Initialize payment gateways.
                 */
                if (class_exists('DOPBSPPaymentGateways')){
                    $this->classes->payment_gateways = new DOPBSPPaymentGateways();
                }

                /*
                 * Initialize reservations classes.
                 */
                if (class_exists('DOPBSPBackEndReservations')){
                    $this->classes->backend_reservations = new DOPBSPBackEndReservations();
                }
                
                if (class_exists('DOPBSPBackEndReservationsAdd')){
                    $this->classes->backend_reservations_add = new DOPBSPBackEndReservationsAdd();
                }
                
                if (class_exists('DOPBSPBackEndReservationsCalendar')){
                    $this->classes->backend_reservations_calendar = new DOPBSPBackEndReservationsCalendar();
                }
                
                if (class_exists('DOPBSPBackEndReservationsList')){
                    $this->classes->backend_reservations_list = new DOPBSPBackEndReservationsList();
                }

                if (class_exists('DOPBSPBackEndReservation')){
                    $this->classes->backend_reservation = new DOPBSPBackEndReservation();
                }

                if (class_exists('DOPBSPBackEndReservationNotifications')){
                    $this->classes->backend_reservation_notifications = new DOPBSPBackEndReservationNotifications();
                }

                if (class_exists('DOPBSPFrontEndReservations')){
                    $this->classes->frontend_reservations = new DOPBSPFrontEndReservations();
                }

                /*
                 * Initialize rules classes.
                 */
                if (class_exists('DOPBSPBackEndRules')){
                    $this->classes->backend_rules = new DOPBSPBackEndRules();
                }

                if (class_exists('DOPBSPBackEndRule')){
                    $this->classes->backend_rule = new DOPBSPBackEndRule();
                }

                if (class_exists('DOPBSPFrontEndRules')){
                    $this->classes->frontend_rules = new DOPBSPFrontEndRules();
                }

                /*
                 * Initialize search classes.
                 */
                if (class_exists('DOPBSPFrontEndSearch')){
                    $this->classes->frontend_search = new DOPBSPFrontEndSearch();
                }

                /*
                 * Initialize settings classes.
                 */
                if (class_exists('DOPBSPBackEndSettings')){
                    $this->classes->backend_settings = new DOPBSPBackEndSettings();
                }
                
                if (class_exists('DOPBSPBackEndSettingsCalendar')){
                    $this->classes->backend_settings_calendar = new DOPBSPBackEndSettingsCalendar();
                }
                
                if (class_exists('DOPBSPBackEndSettingsNotifications')){
                    $this->classes->backend_settings_notifications = new DOPBSPBackEndSettingsNotifications();
                }
                
                if (class_exists('DOPBSPBackEndSettingsPaymentGateways')){
                    $this->classes->backend_settings_payment_gateways = new DOPBSPBackEndSettingsPaymentGateways();
                }
                
                if (class_exists('DOPBSPBackEndSettingsUsers')){
                    $this->classes->backend_settings_users = new DOPBSPBackEndSettingsUsers();
                }

                /*
                 * Initialize shortcodes classes.
                 */
                if (class_exists('DOPBSPBackEndShortcodes')){
                    $this->classes->backend_shortcodes = new DOPBSPBackEndShortcodes();
                }

                /*
                 * Initialize templates classes.
                 */
                if (class_exists('DOPBSPBackEndTemplates')){
                    $this->classes->backend_templates = new DOPBSPBackEndTemplates();
                }

                /*
                 * Initialize update class.
                 */
                if (class_exists('DOPBSPUpdate')){
                    $this->classes->update = new DOPBSPUpdate();
                }

                /*
                 * Initialize WooCommerce classes.
                 */
                if (class_exists('DOPBSPWooCommerce')){
                    $this->classes->woocommerce = new DOPBSPWooCommerce();
                }
                
                if (class_exists('DOPBSPWooCommerceCart')){
                    $this->classes->woocommerce_cart = new DOPBSPWooCommerceCart();
                }
                
                if (class_exists('DOPBSPWooCommerceCategory')){
                    $this->classes->woocommerce_category = new DOPBSPWooCommerceCategory();
                }
                
                if (class_exists('DOPBSPWooCommerceOrder')){
                    $this->classes->woocommerce_order = new DOPBSPWooCommerceOrder();
                }
                
                if (class_exists('DOPBSPWooCommerceProduct')){
                    $this->classes->woocommerce_product = new DOPBSPWooCommerceProduct();
                }
                
                if (class_exists('DOPBSPWooCommerceTab')){
                    $this->classes->woocommerce_tab = new DOPBSPWooCommerceTab();
                }
                
                if (class_exists('DOPBSPWooCommerceVariation')){
                    $this->classes->woocommerce_variation = new DOPBSPWooCommerceVariation();
                }
            }
            
            /*
             * Initialize back end.
             */
            function initBackEnd(){
                /*
                 * Set role action for current user.
                 */
                if (!is_super_admin()){
                    switch (wp_get_current_user()->roles[0]){
                        case 'author':
                            $role_action = 'publish_posts';
                            break;
                        case 'contributor':
                            $role_action = 'edit_posts';
                            break;
                        case 'editor':
                            $role_action = 'edit_pages';
                            break;
                        case 'subscriber':
                            $role_action = 'read';
                            break;
                        default:
                            $role_action = 'manage_options';
                            break;
                    }
                } 
                else {
                    $role_action = 'manage_options';
                }
                
                if (!$this->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')
                        && !$this->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-calendars')){
                    $role_action = 'manage_options';  
                }

                /*
                 * Set back end menu.
                 */
                if (function_exists('add_options_page')){
                    add_menu_page($this->text('TITLE'), $this->text('TITLE'), $role_action, 'dopbsp', array(&$this->classes->backend_dashboard, 'view'), 'div');
                    add_submenu_page('dopbsp', $this->text('DASHBOARD_TITLE').$this->text('SOON'), $this->text('DASHBOARD_TITLE').$this->text('SOON'), $role_action, 'dopbsp', array(&$this->classes->backend_dashboard, 'view'));
                    add_submenu_page('dopbsp', $this->text('CALENDARS_TITLE'), $this->text('CALENDARS_TITLE'), $role_action, 'dopbsp-calendars', array(&$this->classes->backend_calendars, 'view'));
                        add_submenu_page('dopbsp', $this->text('EVENTS_TITLE').$this->text('SOON'), $this->text('EVENTS_TITLE').$this->text('SOON'), $role_action, 'dopbsp-events', array(&$this->classes->backend_events, 'view'));
                    add_submenu_page('dopbsp', $this->text('RESERVATIONS_TITLE'), $this->text('RESERVATIONS_TITLE'), $role_action, 'dopbsp-reservations', array(&$this->classes->backend_reservations, 'view'));
                        add_submenu_page('dopbsp', $this->text('LOCATIONS_TITLE').$this->text('SOON'), $this->text('LOCATIONS_TITLE').$this->text('SOON'), $role_action, 'dopbsp-locations', array(&$this->classes->backend_locations, 'view'));
                    add_submenu_page('dopbsp', $this->text('RULES_TITLE'), $this->text('RULES_TITLE'), $role_action, 'dopbsp-rules', array(&$this->classes->backend_rules, 'view'));
                    add_submenu_page('dopbsp', $this->text('EXTRAS_TITLE'), $this->text('EXTRAS_TITLE'), $role_action, 'dopbsp-extras', array(&$this->classes->backend_extras, 'view'));
                    add_submenu_page('dopbsp', $this->text('DISCOUNTS_TITLE'), $this->text('DISCOUNTS_TITLE'), $role_action, 'dopbsp-discounts', array(&$this->classes->backend_discounts, 'view'));
                    add_submenu_page('dopbsp', $this->text('FEES_TITLE'), $this->text('FEES_TITLE'), $role_action, 'dopbsp-fees', array(&$this->classes->backend_fees, 'view'));
                    add_submenu_page('dopbsp', $this->text('COUPONS_TITLE'), $this->text('COUPONS_TITLE'), $role_action, 'dopbsp-coupons', array(&$this->classes->backend_coupons, 'view'));
                    add_submenu_page('dopbsp', $this->text('FORMS_TITLE'), $this->text('FORMS_TITLE'), $role_action, 'dopbsp-forms', array(&$this->classes->backend_forms, 'view'));
                        add_submenu_page('dopbsp', $this->text('TEMPLATES_TITLE').$this->text('SOON'), $this->text('TEMPLATES_TITLE').$this->text('SOON'), $role_action, 'dopbsp-templates', array(&$this->classes->backend_templates, 'view'));
                    add_submenu_page('dopbsp', $this->text('EMAILS_TITLE'), $this->text('EMAILS_TITLE'), $role_action, 'dopbsp-emails', array(&$this->classes->backend_emails, 'view'));
                    add_submenu_page('dopbsp', $this->text('TRANSLATION_TITLE'), $this->text('TRANSLATION_TITLE'), 'manage_options', 'dopbsp-translation', array(&$this->classes->translation, 'view'));
                    add_submenu_page('dopbsp', $this->text('SETTINGS_TITLE'), $this->text('SETTINGS_TITLE'), 'manage_options', 'dopbsp-settings', array(&$this->classes->backend_settings, 'view'));
                }
            }
            
            /*
             * Initialize back end AJAX requests.
             */
            function initBackEndAJAX(){
                /*
                 * Calendars back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_calendars_display', array(&$this->classes->backend_calendars, 'display')); // Returns calendars list.
                
                /*
                 * Calendar back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_calendar_get_options', array(&$this->classes->backend_calendar, 'getOptions'));
                add_action('wp_ajax_dopbsp_calendar_add', array(&$this->classes->backend_calendar, 'add'));
                add_action('wp_ajax_dopbsp_calendar_edit', array(&$this->classes->backend_calendar, 'edit'));
                add_action('wp_ajax_dopbsp_calendar_delete', array(&$this->classes->backend_calendar, 'delete'));
                
                add_action('wp_ajax_dopbsp_calendar_schedule_get', array(&$this->classes->backend_calendar_schedule, 'get'));
                add_action('wp_ajax_dopbsp_calendar_schedule_set', array(&$this->classes->backend_calendar_schedule, 'set'));
                add_action('wp_ajax_dopbsp_calendar_schedule_delete', array(&$this->classes->backend_calendar_schedule, 'delete'));
            
                /*
                 * Coupons back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_coupons_display', array(&$this->classes->backend_coupons, 'display'));
                add_action('wp_ajax_dopbsp_coupon_display', array(&$this->classes->backend_coupon, 'display'));
                add_action('wp_ajax_dopbsp_coupon_add', array(&$this->classes->backend_coupon, 'add'));
                add_action('wp_ajax_dopbsp_coupon_edit', array(&$this->classes->backend_coupon, 'edit'));
                add_action('wp_ajax_dopbsp_coupon_delete', array(&$this->classes->backend_coupon, 'delete'));
                
                /*
                 * Custom posts back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_custom_posts_get', array(&$this->classes->custom_posts_meta, 'get')); 
            
                /*
                 * Discounts back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_discounts_display', array(&$this->classes->backend_discounts, 'display'));
                add_action('wp_ajax_dopbsp_discount_display', array(&$this->classes->backend_discount, 'display'));
                add_action('wp_ajax_dopbsp_discount_add', array(&$this->classes->backend_discount, 'add'));
                add_action('wp_ajax_dopbsp_discount_edit', array(&$this->classes->backend_discount, 'edit'));
                add_action('wp_ajax_dopbsp_discount_delete', array(&$this->classes->backend_discount, 'delete'));

                add_action('wp_ajax_dopbsp_discount_items_sort', array(&$this->classes->backend_discount_items, 'sort'));
                add_action('wp_ajax_dopbsp_discount_item_add', array(&$this->classes->backend_discount_item, 'add'));
                add_action('wp_ajax_dopbsp_discount_item_edit', array(&$this->classes->backend_discount_item, 'edit'));
                add_action('wp_ajax_dopbsp_discount_item_delete', array(&$this->classes->backend_discount_item, 'delete'));
                
                add_action('wp_ajax_dopbsp_discount_item_rules_sort', array(&$this->classes->backend_discount_item_rules, 'sort'));
                add_action('wp_ajax_dopbsp_discount_item_rule_add', array(&$this->classes->backend_discount_item_rule, 'add'));
                add_action('wp_ajax_dopbsp_discount_item_rule_edit', array(&$this->classes->backend_discount_item_rule, 'edit'));
                add_action('wp_ajax_dopbsp_discount_item_rule_delete', array(&$this->classes->backend_discount_item_rule, 'delete'));
            
                /*
                 * Emails back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_emails_display', array(&$this->classes->backend_emails, 'display'));
                add_action('wp_ajax_dopbsp_email_display', array(&$this->classes->backend_email, 'display'));
                add_action('wp_ajax_dopbsp_email_add', array(&$this->classes->backend_email, 'add'));
                add_action('wp_ajax_dopbsp_email_edit', array(&$this->classes->backend_email, 'edit'));
                add_action('wp_ajax_dopbsp_email_delete', array(&$this->classes->backend_email, 'delete'));
            
                /*
                 * Extras back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_extras_display', array(&$this->classes->backend_extras, 'display'));
                add_action('wp_ajax_dopbsp_extra_display', array(&$this->classes->backend_extra, 'display'));
                add_action('wp_ajax_dopbsp_extra_add', array(&$this->classes->backend_extra, 'add'));
                add_action('wp_ajax_dopbsp_extra_edit', array(&$this->classes->backend_extra, 'edit'));
                add_action('wp_ajax_dopbsp_extra_delete', array(&$this->classes->backend_extra, 'delete'));

                add_action('wp_ajax_dopbsp_extra_groups_sort', array(&$this->classes->backend_extra_groups, 'sort'));
                add_action('wp_ajax_dopbsp_extra_group_add', array(&$this->classes->backend_extra_group, 'add'));
                add_action('wp_ajax_dopbsp_extra_group_edit', array(&$this->classes->backend_extra_group, 'edit'));
                add_action('wp_ajax_dopbsp_extra_group_delete', array(&$this->classes->backend_extra_group, 'delete'));
                
                add_action('wp_ajax_dopbsp_extra_group_items_sort', array(&$this->classes->backend_extra_group_items, 'sort'));
                add_action('wp_ajax_dopbsp_extra_group_item_add', array(&$this->classes->backend_extra_group_item, 'add'));
                add_action('wp_ajax_dopbsp_extra_group_item_edit', array(&$this->classes->backend_extra_group_item, 'edit'));
                add_action('wp_ajax_dopbsp_extra_group_item_delete', array(&$this->classes->backend_extra_group_item, 'delete'));
            
                /*
                 * Fees back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_fees_display', array(&$this->classes->backend_fees, 'display'));
                add_action('wp_ajax_dopbsp_fee_display', array(&$this->classes->backend_fee, 'display'));
                add_action('wp_ajax_dopbsp_fee_add', array(&$this->classes->backend_fee, 'add'));
                add_action('wp_ajax_dopbsp_fee_edit', array(&$this->classes->backend_fee, 'edit'));
                add_action('wp_ajax_dopbsp_fee_delete', array(&$this->classes->backend_fee, 'delete'));
                
                /*
                 * Forms back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_forms_display', array(&$this->classes->backend_forms, 'display'));
                add_action('wp_ajax_dopbsp_form_display', array(&$this->classes->backend_form, 'display'));
                add_action('wp_ajax_dopbsp_form_add', array(&$this->classes->backend_form, 'add'));
                add_action('wp_ajax_dopbsp_form_edit', array(&$this->classes->backend_form, 'edit'));
                add_action('wp_ajax_dopbsp_form_delete', array(&$this->classes->backend_form, 'delete'));

                add_action('wp_ajax_dopbsp_form_fields_sort', array(&$this->classes->backend_form_fields, 'sort'));
                add_action('wp_ajax_dopbsp_form_field_add', array(&$this->classes->backend_form_field, 'add'));
                add_action('wp_ajax_dopbsp_form_field_edit', array(&$this->classes->backend_form_field, 'edit'));
                add_action('wp_ajax_dopbsp_form_field_delete', array(&$this->classes->backend_form_field, 'delete'));
                
                add_action('wp_ajax_dopbsp_form_field_select_options_sort', array(&$this->classes->backend_form_field_select_options, 'sort'));
                add_action('wp_ajax_dopbsp_form_field_select_option_add', array(&$this->classes->backend_form_field_select_option, 'add'));
                add_action('wp_ajax_dopbsp_form_field_select_option_edit', array(&$this->classes->backend_form_field_select_option, 'edit'));
                add_action('wp_ajax_dopbsp_form_field_select_option_delete', array(&$this->classes->backend_form_field_select_option, 'delete'));
            
                /*
                 * Reservations back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_reservations_add_get_json', array(&$this->classes->backend_reservations_add, 'getJSON'));
                add_action('wp_ajax_dopbsp_reservations_add_book', array(&$this->classes->backend_reservations_add, 'book'));
                
                add_action('wp_ajax_dopbsp_reservations_calendar_get_json', array(&$this->classes->backend_reservations_calendar, 'getJSON'));
                add_action('wp_ajax_dopbsp_reservations_calendar_get', array(&$this->classes->backend_reservations_calendar, 'get'));
                
                add_action('wp_ajax_dopbsp_reservations_list_get', array(&$this->classes->backend_reservations_list, 'get'));
                
                add_action('wp_ajax_dopbsp_reservation_approve', array(&$this->classes->backend_reservation, 'approve'));
                add_action('wp_ajax_dopbsp_reservation_reject', array(&$this->classes->backend_reservation, 'reject'));
                add_action('wp_ajax_dopbsp_reservation_cancel', array(&$this->classes->backend_reservation, 'cancel'));
                add_action('wp_ajax_dopbsp_reservation_delete', array(&$this->classes->backend_reservation, 'delete'));
            
                /*
                 * Rules back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_rules_display', array(&$this->classes->backend_rules, 'display'));
                add_action('wp_ajax_dopbsp_rule_display', array(&$this->classes->backend_rule, 'display'));
                add_action('wp_ajax_dopbsp_rule_add', array(&$this->classes->backend_rule, 'add'));
                add_action('wp_ajax_dopbsp_rule_edit', array(&$this->classes->backend_rule, 'edit'));
                add_action('wp_ajax_dopbsp_rule_delete', array(&$this->classes->backend_rule, 'delete'));
            
                /*
                 * Settings back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_settings_calendar_display', array(&$this->classes->backend_settings_calendar, 'display'));
                add_action('wp_ajax_dopbsp_settings_notifications_display', array(&$this->classes->backend_settings_notifications, 'display'));
                add_action('wp_ajax_dopbsp_settings_payment_gateways_display', array(&$this->classes->backend_settings_payment_gateways, 'display'));
                add_action('wp_ajax_dopbsp_settings_users_permissions_display', array(&$this->classes->backend_settings_users, 'display'));
                add_action('wp_ajax_dopbsp_settings_set', array(&$this->classes->backend_settings, 'set'));
                
                /*
                 * Settings users permissions back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_settings_users_display', array(&$this->classes->backend_settings_users, 'display'));
                add_action('wp_ajax_dopbsp_settings_users_get', array(&$this->classes->backend_settings_users, 'get'));
                add_action('wp_ajax_dopbsp_settings_users_set', array(&$this->classes->backend_settings_users, 'set'));
                add_action('wp_ajax_dopbsp_settings_users_display_calendar', array(&$this->classes->backend_settings_users, 'displayCalendar'));
                add_action('wp_ajax_dopbsp_settings_users_set_calendar', array(&$this->classes->backend_settings_users, 'setCalendar'));
                
                /*
                 * Translation back end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_translation_change', array(&$this->classes->translation, 'change'));
                add_action('wp_ajax_dopbsp_translation_display', array(&$this->classes->translation, 'display'));
                add_action('wp_ajax_dopbsp_translation_edit', array(&$this->classes->translation, 'edit')); 
                add_action('wp_ajax_dopbsp_translation_display_languages', array(&$this->classes->translation, 'displayLanguages'));
                add_action('wp_ajax_dopbsp_translation_set_language', array(&$this->classes->translation, 'setLanguage'));             
                add_action('wp_ajax_dopbsp_translation_reset', array(&$this->classes->translation, 'reset'));
                add_action('wp_ajax_dopbsp_translation_check', array(&$this->classes->translation, 'check'));
            }
            
            /*
             * Initialize front end AJAX requests. 
             */
            function initFrontEndAJAX(){
                /*
                 * Calendar front end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_calendar_schedule_get', array(&$this->classes->backend_calendar_schedule, 'get'));
                add_action('wp_ajax_nopriv_dopbsp_calendar_schedule_get', array(&$this->classes->backend_calendar_schedule, 'get'));
                
                /*
                 * Coupons front end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_coupons_verify', array(&$this->classes->frontend_coupons, 'verify'));
                add_action('wp_ajax_nopriv_dopbsp_coupons_verify', array(&$this->classes->frontend_coupons, 'verify'));
                
                /*
                 * Reservations front end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_reservations_book', array(&$this->classes->frontend_reservations, 'book'));
                add_action('wp_ajax_nopriv_dopbsp_reservations_book', array(&$this->classes->frontend_reservations, 'book'));
            
                /*
                 * WooCommerce front end AJAX requests.
                 */
                add_action('wp_ajax_dopbsp_woocommerce_variation_add', array(&$this->classes->woocommerce_variation, 'add'));
                add_action('wp_ajax_nopriv_dopbsp_woocommerce_variation_add', array(&$this->classes->woocommerce_variation, 'add'));
            }
            
            /*
             * Get text.
             * 
             * @param key (string): translation text key
             * 
             * @return a string 
             */
            function text($key){
                switch ($key){
                    case 'BETA':
                        $prefix = '&nbsp;<em class="small beta">';
                        $suffix = '</em>';
                        break;
                    case 'BETA_TITLE':
                        $prefix = '<em class="beta">';
                        $suffix = '</em>';
                        break;
                    case 'SOON':
                        $prefix = '&nbsp;<em class="small soon">';
                        $suffix = '</em>';
                        break;
                    case 'SOON_TITLE':
                        $prefix = '<em class="soon">';
                        $suffix = '</em>';
                        break;
                    default:
                        $prefix = '';
                        $suffix = '';
                }
                
                return isset($this->vars->translation_text[$key]) ? $prefix.$this->vars->translation_text[$key].$suffix:'!';
            }
        }
        $DOPBSP = new DOPBSP();
    }
    
    
    /*
     * Delete all plugin data if you uninstall it. the function needs to be in this file.
     */
    function DOPBSPUninstall(){
        if (DOPBSP_CONFIG_DELETE_DATA_ON_DELETE){
            global $wpdb;
            global $wp_roles;

            /*
             * Delete database tables.
             */
            $tables = $wpdb->get_results('SHOW TABLES');

            foreach ($tables as $table){
                $object_name = 'Tables_in_'.DB_NAME;
                $table_name = $table->$object_name;

                if (strrpos($table_name, 'dopbsp_') !== false){
                    $wpdb->query('DROP TABLE IF EXISTS '.$table_name);
                }
            }
            
            /*
             * Delete options.
             */
            delete_option('DOPBSP_db_version');

            $roles = $wp_roles->get_names();

            while ($data = current($roles)){
                delete_option('DOPBSP_users_permissions_'.key($roles));
                delete_option('DOPBSP_users_permissions_custom_posts_'.key($roles));
                next($roles);                        
            }
        }
    }
          
    /*
     * Hook uninstall function. The registration needs to be in this file.
     */
    register_uninstall_hook(__FILE__, 'DOPBSPUninstall');