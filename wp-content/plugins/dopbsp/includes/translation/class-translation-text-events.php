<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-events.php
* File Version            : 1.0
* Created / Last Modified : 27 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO events translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextEvents')){
        class DOPBSPTranslationTextEvents{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextEvents(){
                /*
                 * Initialize events text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'events'));
            }

            /*
             * Events text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function events($lang){
                array_push($lang, array('key' => 'PARENT_EVENTS',
                                        'parent' => '',
                                        'text' => 'Events'));
                
                array_push($lang, array('key' => 'EVENTS_TITLE',
                                        'parent' => 'PARENT_EVENTS',
                                        'text' => 'Events'));
                
                return $lang;
            }
        }
    }