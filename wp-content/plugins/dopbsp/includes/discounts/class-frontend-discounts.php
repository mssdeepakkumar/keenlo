<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/discounts/class-frontend-discounts.php
* File Version            : 1.0
* Created / Last Modified : 01 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO front end discounts PHP class.
*/

    if (!class_exists('DOPBSPFrontEndDiscounts')){
        class DOPBSPFrontEndDiscounts extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function DOPBSPFrontEndDiscounts(){
            }
            
            /*
             * Get selected discount.
             * 
             * @param id (integer): discount ID
             * @param language (string): selected language
             * 
             * @return data array
             */
            function get($id,
                         $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE){
                global $wpdb;
                global $DOPBSP;
                
                $items = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->discounts_items.' WHERE discount_id='.$id.' ORDER BY position');
                
                foreach ($items as $item){
                    $item->translation = $DOPBSP->classes->translation->decodeJSON($item->translation,
                                                                                   $language);
                    
                    $rules = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->discounts_items_rules.' WHERE discount_item_id='.$item->id.' ORDER BY position');

                    $item->rules = $rules;
                }
                
                return array('data' => array('discount' => $items,
                                             'id' => $id),
                             'text' => array('byDay' => $DOPBSP->text('DISCOUNTS_FRONT_END_BY_DAY'),
                                             'byHour' => $DOPBSP->text('DISCOUNTS_FRONT_END_BY_HOUR'),
                                             'title' => $DOPBSP->text('DISCOUNTS_FRONT_END_TITLE')));
            }
        }
    }