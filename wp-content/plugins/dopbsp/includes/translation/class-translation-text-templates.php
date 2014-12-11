<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-templates.php
* File Version            : 1.0
* Created / Last Modified : 27 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO templates translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextTemplates')){
        class DOPBSPTranslationTextTemplates{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextTemplates(){
                /*
                 * Initialize templates text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'templates'));
            }

            /*
             * Templates text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function templates($lang){
                array_push($lang, array('key' => 'PARENT_TEMPLATES',
                                        'parent' => '',
                                        'text' => 'Templates'));
                
                array_push($lang, array('key' => 'TEMPLATES_TITLE',
                                        'parent' => 'PARENT_TEMPLATES',
                                        'text' => 'Templates'));
                
                return $lang;
            }
        }
    }