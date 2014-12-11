<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-locations.php
* File Version            : 1.0
* Created / Last Modified : 27 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO locations translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextLocations')){
        class DOPBSPTranslationTextLocations{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextLocations(){
                /*
                 * Initialize locations text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'locations'));
            }

            /*
             * Locations text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function locations($lang){
                array_push($lang, array('key' => 'PARENT_LOCATIONS',
                                        'parent' => '',
                                        'text' => 'Locations'));
                
                array_push($lang, array('key' => 'LOCATIONS_TITLE',
                                        'parent' => 'PARENT_LOCATIONS',
                                        'text' => 'Locations'));
                
                return $lang;
            }
        }
    }