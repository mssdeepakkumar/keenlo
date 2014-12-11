<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-cart.php
* File Version            : 1.0
* Created / Last Modified : 07 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO car translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextCart')){
        class DOPBSPTranslationTextCart{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextCart(){
                /*
                 * Initialize order text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'cart'));
            }

            /*
             * Cart text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function cart($lang){
                array_push($lang, array('key' => 'PARENT_CART',
                                        'parent' => '',
                                        'text' => 'Cart'));
                
                array_push($lang, array('key' => 'CART_TITLE',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'Cart'));
                array_push($lang, array('key' => 'CART_IS_EMPTY',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'Cart is empty.'));
                
                array_push($lang, array('key' => 'CART_ERROR',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'Error'));
                array_push($lang, array('key' => 'CART_UNAVAILABLE',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'The period you selected is not available anymore. Please review your reservations.'));
                array_push($lang, array('key' => 'CART_OVERLAP',
                                        'parent' => 'PARENT_CART',
                                        'text' => 'The period you selected will overlap with the ones you already added to cart. Please select another one.'));
                
                return $lang;
            }
        }
    }