<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-dashboard.php
* File Version            : 1.0
* Created / Last Modified : 26 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO dashboard translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextDashboard')){
        class DOPBSPTranslationTextDashboard{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextDashboard(){
                /*
                 * Initialize dashboard text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'dashboard'));
            }

            /*
             * Dashboard text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function dashboard($lang){
                array_push($lang, array('key' => 'PARENT_DASHBOARD',
                                        'parent' => '',
                                        'text' => 'Dashboard'));
                
                array_push($lang, array('key' => 'DASHBOARD_TITLE',
                                        'parent' => 'PARENT_DASHBOARD',
                                        'text' => 'Dashboard'));
                
                return $lang;
            }
        }
    }