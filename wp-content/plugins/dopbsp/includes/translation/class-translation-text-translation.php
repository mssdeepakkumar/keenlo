<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-translation.php
* File Version            : 1.0
* Created / Last Modified : 26 March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO translation translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextTranslation')){
        class DOPBSPTranslationTextTranslation{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextTranslation(){
                /*
                 * Initialize translation text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'translation'));
                add_filter('dopbsp_filter_translation', array(&$this, 'translationHelp'));
            }
            
            /*
             * Translation text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function translation($lang){
                array_push($lang, array('key' => 'PARENT_TRANSLATION',
                                        'parent' => '',
                                        'text' => 'Translation'));
                
                array_push($lang, array('key' => 'TRANSLATION_TITLE',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Translation'));
                array_push($lang, array('key' => 'TRANSLATION_SUBMIT',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Manage translation'));
                array_push($lang, array('key' => 'TRANSLATION_LOADED',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Translation has been loaded.'));
                array_push($lang, array('key' => 'TRANSLATION_LANGUAGE',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Select language'));
                array_push($lang, array('key' => 'TRANSLATION_TEXT_GROUP',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Select text group'));
                array_push($lang, array('key' => 'TRANSLATION_SEARCH',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Search'));
                
                array_push($lang, array('key' => 'TRANSLATION_MANAGE_LANGUAGES',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Manage languages'));
                array_push($lang, array('key' => 'TRANSLATION_MANAGE_LANGUAGES_LOADED',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Languages have been loaded.'));
                array_push($lang, array('key' => 'TRANSLATION_MANAGE_LANGUAGES_SETING',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'The language is being configured ...'));
                array_push($lang, array('key' => 'TRANSLATION_MANAGE_LANGUAGES_SET_SUCCESS',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'The language has been added. The page will refresh shortly.'));
                array_push($lang, array('key' => 'TRANSLATION_MANAGE_LANGUAGES_REMOVE_CONFIGURATION',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Are you sure you want to remove this language? Data will be deleted only when you reset the translation!'));
                array_push($lang, array('key' => 'TRANSLATION_MANAGE_LANGUAGES_REMOVING',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'The language is being removed ...'));
                array_push($lang, array('key' => 'TRANSLATION_MANAGE_LANGUAGES_REMOVE_SUCCESS',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'The language has been removed. The page will refresh shortly.'));
                
                array_push($lang, array('key' => 'TRANSLATION_RESET',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Reset translation'));
                array_push($lang, array('key' => 'TRANSLATION_RESET_CONFIRMATION',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Are you sure you want to reset all translation data? All your modifications are going to be overwritten.'));
                array_push($lang, array('key' => 'TRANSLATION_RESETING',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'Translation is resetting ...'));
                array_push($lang, array('key' => 'TRANSLATION_RESET_SUCCESS',
                                        'parent' => 'PARENT_TRANSLATION',
                                        'text' => 'The translation has reset. The page will refresh shortly.'));
                
                return $lang;
            }            
            
            /*
             * Translation - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function translationHelp($lang){
                array_push($lang, array('key' => 'PARENT_TRANSLATION_HELP',
                                        'parent' => '',
                                        'text' => 'Translation - Help'));
                
                array_push($lang, array('key' => 'TRANSLATION_HELP',
                                        'parent' => 'PARENT_TRANSLATION_HELP',
                                        'text' => 'Select the language & text group you want to translate.'));
                array_push($lang, array('key' => 'TRANSLATION_SEARCH_HELP',
                                        'parent' => 'PARENT_TRANSLATION_HELP',
                                        'text' => 'Use the search field to look & display the text you want.'));
                array_push($lang, array('key' => 'TRANSLATION_MANAGE_LANGUAGES_HELP',
                                        'parent' => 'PARENT_TRANSLATION_HELP',
                                        'text' => 'If you need to use more language with the plugin go to "manage langauges" section and enable them.'));
                array_push($lang, array('key' => 'TRANSLATION_RESET_HELP',
                                        'parent' => 'PARENT_TRANSLATION_HELP',
                                        'text' => 'If you want to use the translation that came with the plugin click "Reset translation" button. Note that all your modifications will be overwritten.'));
                
                return $lang;
            }
        }
    }