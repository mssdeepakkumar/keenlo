<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/discounts/views-backend-discount-items.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end discount items views class.
*/

    if (!class_exists('DOPBSPViewsDiscountItems')){
        class DOPBSPViewsDiscountItems extends DOPBSPViewsDiscount{
            /*
             * Constructor
             */
            function DOPBSPViewsDiscountItems(){
            }
            
            /*
             * Returns discount items template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): discount ID
             *                      * language (string): discount language
             * 
             * @return discount items HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->translation->get();
?>
                <div class="discount-items-header">
                    <a href="javascript:DOPBSPDiscountItem.add(<?php echo $id; ?>, '<?php echo $language; ?>')" class="button add"><span class="info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ADD_ITEM_SUBMIT'); ?></span></a>
                    <h3><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEMS'); ?></h3>
                </div>
                <ul id="DOPBSP-discount-items" class="discount-items">
<?php
                $items = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->discounts_items.' WHERE discount_id='.$id.' ORDER BY position ASC');
                
                if ($wpdb->num_rows > 0){
                    foreach($items as $item){
                        $DOPBSP->views->discount_item->template(array('item' => $item,
                                                                      'language' => $language));
                    }
                }
?>    
                </ul>
<?php                    
            }
        }
    }
    
    