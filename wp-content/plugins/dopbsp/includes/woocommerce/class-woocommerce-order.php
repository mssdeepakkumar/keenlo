<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/woocommerce/class-woocommerce-cart.php
* File Version            : 1.0
* Created / Last Modified : 04 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO WooCommerce cart PHP class.
*/

    if (!class_exists('DOPBSPWooCommerceOrder')){
        class DOPBSPWooCommerceOrder extends DOPBSPWooCommerce{
            /*
             * Constructor
             */
            function DOPBSPWooCommerceOrder(){
                /*
                 * Add order item meta.
                 */
                add_action('woocommerce_add_order_item_meta', array(&$this, 'set'), 10, 3);
            }
            
            /*
             * Set order item meta (Details, Extras, Discount).
             * 
             * @param item_id (integer): order item ID
             * @param values (object): order item data (not received from WC)
             * @param cart_item_key (object): cart item key from which the order item is created (not received from WC)
             */
            function set($item_id,
                         $values,
                         $cart_item_key){            
                global $wpdb;
                global $DOPBSP;
                
                $reservation_data = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->woocommerce.' WHERE variation_id='.wc_get_order_item_meta($item_id, '_variation_id'));
                
                if ($reservation_data){
                    $reservation = json_decode($reservation_data->data);
                    $reservation->currency = $reservation_data->currency;
                    $reservation->item_id = $item_id;

                    $calendar = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id='.$reservation_data->calendar_id);
                    $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$reservation_data->calendar_id);

                    /*
                     * Display details data.
                     */
                    wc_add_order_item_meta($item_id, 
                                           $DOPBSP->text('RESERVATIONS_RESERVATION_DETAILS_TITLE'), 
                                           $this->getDetails($reservation,
                                                             $calendar,
                                                             $settings));

                    /*
                     * Display extra data.
                     */
                    if ($settings->extra != 0){
                        wc_add_order_item_meta($item_id,
                                               $DOPBSP->text('EXTRAS_FRONT_END_TITLE'), 
                                               $this->getExtras($reservation,
                                                                $settings));
                    }

                    /*
                     * Display discount data.
                     */
                    if ($settings->discount != 0){
                        wc_add_order_item_meta($item_id, 
                                               $DOPBSP->text('DISCOUNTS_FRONT_END_TITLE'), 
                                               $this->getDiscount($reservation,
                                                                 $settings));
                    }
                }
            }
        }
    }