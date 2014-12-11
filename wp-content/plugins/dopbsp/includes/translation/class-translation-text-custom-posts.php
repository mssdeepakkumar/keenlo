<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-custom-posts.php
* File Version            : 1.0
* Created / Last Modified : 07 April March 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO custom posts translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextCustomPosts')){
        class DOPBSPTranslationTextCustomPosts{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextCustomPosts(){
                /*
                 * Initialize custom posts text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'customPosts'));
            }
            
            /*
             * Custom posts text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function customPosts($lang){
                array_push($lang, array('key' => 'PARENT_CUSTOM_POSTS',
                                        'parent' => '',
                                        'text' => 'Custom posts'));
                
                array_push($lang, array('key' => 'CUSTOM_POSTS',
                                        'parent' => 'PARENT_CUSTOM_POSTS',
                                        'text' => 'Booking System PRO custom posts'));
                array_push($lang, array('key' => 'CUSTOM_POSTS_ADD_ALL',
                                        'parent' => 'PARENT_CUSTOM_POSTS',
                                        'text' => 'Posts'));
                array_push($lang, array('key' => 'CUSTOM_POSTS_ADD',
                                        'parent' => 'PARENT_CUSTOM_POSTS',
                                        'text' => 'Add new Booking System PRO custom post'));
                array_push($lang, array('key' => 'CUSTOM_POSTS_EDIT',
                                        'parent' => 'PARENT_CUSTOM_POSTS',
                                        'text' => 'Edit Booking System PRO custom post'));
                array_push($lang, array('key' => 'CUSTOM_POSTS_BOOKING_SYSTEM',
                                        'parent' => 'PARENT_CUSTOM_POSTS',
                                        'text' => 'Booking System PRO'));
                
                return $lang;
            }
        }
    }