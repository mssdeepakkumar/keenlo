<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-woocommerce.php
* File Version            : 1.0
* Created / Last Modified : 07 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO WooCommerce translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextWooCommerce')){
        class DOPBSPTranslationTextWooCommerce{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextWooCommerce(){
                /*
                 * Initialize WooCommerce text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'woocommerce'));
                add_filter('dopbsp_filter_translation', array(&$this, 'woocommerceHelp'));
            }
            
            /*
             * WooCommerce text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function woocommerce($lang){
                array_push($lang, array('key' => 'PARENT_WOOCOMMERCE',
                                        'parent' => '',
                                        'text' => 'WooCommerce'));
                /*
                 * Back end tab.
                 */
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Booking System PRO'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_CALENDAR',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Calendar'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_CALENDAR_NO_CALENDARS',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'No calendars.'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_CALENDAR_SELECT',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Select calendar'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_LANGUAGE',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Language'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_POSITION',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Position'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_POSITION_SUMMARY',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Summary'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_POSITION_TABS',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Tabs'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_POSITION_SUMMARY_AND_TABS',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Summary & Tabs'));
                
                /*
                 * Front end.
                 */
                array_push($lang, array('key' => 'WOOCOMMERCE_VIEW_AVAILABILITY',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'View availability'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TABS',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'Book'));
                array_push($lang, array('key' => 'WOOCOMMERCE_PRODUCT_NONE',
                                        'parent' => 'PARENT_WOOCOMMERCE',
                                        'text' => 'No reservation'));
                
                return $lang;
            }
            
            /*
             * WooCommerce - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function woocommerceHelp($lang){
                array_push($lang, array('key' => 'PARENT_WOOCOMMERCE_HELP',
                                        'parent' => '',
                                        'text' => 'WooCommerce - Help'));
                
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_CALENDAR_HELP',
                                        'parent' => 'PARENT_WOOCOMMERCE_HELP',
                                        'text' => 'Select the calendar that you want asociated with this product.'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_LANGUAGE_HELP',
                                        'parent' => 'PARENT_WOOCOMMERCE_HELP',
                                        'text' => 'Select the language for the calendar.'));
                array_push($lang, array('key' => 'WOOCOMMERCE_TAB_POSITION_HELP',
                                        'parent' => 'PARENT_WOOCOMMERCE_HELP',
                                        'text' => 'Select the calendar position. Add it in "product summary", "product tabs" or add the form in "summary" and the calendar in "product tabs".'));
                
                return $lang;
            }
        }
    }