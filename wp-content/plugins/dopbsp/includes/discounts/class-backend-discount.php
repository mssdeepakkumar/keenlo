<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/discounts/class-backend-discount.php
* File Version            : 1.0
* Created / Last Modified : 04 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end discount PHP class.
*/

    if (!class_exists('DOPBSPBackEndDiscount')){
        class DOPBSPBackEndDiscount extends DOPBSPBackEndDiscounts{
            /*
             * Constructor
             */
            function DOPBSPBackEndDiscount(){
            }
            
            /*
             * Add a discount.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                                
                $wpdb->insert($DOPBSP->tables->discounts, array('user_id' => wp_get_current_user()->ID,
                                                                'name' => $DOPBSP->text('DISCOUNTS_ADD_DISCOUNT_NAME'))); 
                echo $DOPBSP->classes->backend_discounts->display();

            	die();
            }
            
            /*
             * Prints out the discount.
             * 
             * @post id (integer): discount ID
             * @post language (string): discount current editing language
             * 
             * @return discount HTML
             */
            function display(){
                global $DOPBSP;
                
                $id = $_POST['id'];
                $language = $_POST['language'];
                
                $DOPBSP->views->discount->template(array('id' => $id,
                                                         'language' => $language));
                $DOPBSP->views->discount_items->template(array('id' => $id,
                                                               'language' => $language));
                
                die();
            }
            
            /*
             * Edit discount fields.
             * 
             * @post id (integer): discount ID
             * @post field (string): discount field
             * @post value (string): item new value
             */
            function edit(){
                global $wpdb; 
                global $DOPBSP; 
                
                $wpdb->update($DOPBSP->tables->discounts, array($_POST['field'] => $_POST['value']), 
                                                          array('id' => $_POST['id']));
                
            	die();
            }
            
            /*
             * Delete discount.
             * 
             * @post id (integer): discount ID
             * 
             * @return number of discounts left
             */
            function delete(){
                global $wpdb;
                global $DOPBSP;
                
                $id = $_POST['id'];

                /*
                 * Delete discount.
                 */
                $wpdb->delete($DOPBSP->tables->discounts, array('id' => $id));
                
                /*
                 * Delete discount items.
                 */
                $items = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->discounts_items.' WHERE discount_id=%d',
                                                           $id));
                $wpdb->delete($DOPBSP->tables->discounts_items, array('discount_id' => $id));
                
                /*
                 * Delete discount items rules.
                 */
                foreach($items as $item){
                    $wpdb->delete($DOPBSP->tables->discounts_items_rules, array('discount_item_id' => $item->id));
                }
                
                $discounts = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->discounts.' ORDER BY id DESC');
                
                echo $wpdb->num_rows;

            	die();
            }
        }
    }