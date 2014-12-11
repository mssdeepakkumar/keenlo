<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/discounts/views-backend-discount-item-rule.php
* File Version            : 1.0
* Created / Last Modified : 29 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end discount item rule views class.
*/

    if (!class_exists('DOPBSPViewsDiscountItemRule')){
        class DOPBSPViewsDiscountItemRule extends DOPBSPViewsDiscountItem{
            /*
             * Constructor
             */
            function DOPBSPViewsDiscountItemRule(){
            }
            
            /*
             * Returns item rule template.
             * 
             * @param args (array): function arguments
             *                      * rule (integer): select data
             *                      * language (string): item language
             * 
             * @return select item HTML
             */
            function template($args = array()){
                global $DOPBSP;
                
                $rule = $args['rule'];
                
                $hours = $DOPBSP->classes->prototypes->getHours();
?>
                <li id="DOPBSP-discount-item-rule-<?php echo $rule->id; ?>" class="item-rule-wrapper">
                    <div class="input-wrapper">
                        <!--
                            Buttons
                        -->
                        <a href="javascript:void(0)" class="button small handle"><span class="info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULE_SORT'); ?></span></a>
                        <a href="javascript:DOPBSP.confirmation('DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_CONFIRMATION', 'DOPBSPDiscountItemRule.delete(<?php echo $rule->id; ?>)')" class="button small delete"><span class="info"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_DELETE_RULE_SUBMIT'); ?></span></a>
                        
                        <!--
                            Start date
                        -->
                        <input type="text" name="DOPBSP-discount-item-rule-start-date-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-start-date-<?php echo $rule->id; ?>" class="DOPBSP-discount-item-rule-start-date date" value="<?php echo $rule->start_date; ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'start_date', this.value); DOPBSPDiscountItemRule.init();}" onchange="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'start_date', this.value); DOPBSPDiscountItemRule.init()" onpaste="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'start_date', this.value); DOPBSPDiscountItemRule.init()" onblur="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'start_date', this.value, true); DOPBSPDiscountItemRule.init()" />
                        
                        <!--
                            End date
                        -->
                        <input type="text" name="DOPBSP-discount-item-rule-end-date-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-end-date-<?php echo $rule->id; ?>" class="DOPBSP-discount-item-rule-end-date date" value="<?php echo $rule->end_date; ?>" style="margin-left:5px;" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'end_date', this.value);}" onchange="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'end_date', this.value)" onpaste="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'end_date', this.value)" onblur="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'end_date', this.value, true)" />                        
                        <br class="DOPBSP-clear" />
                        
                        <!--
                            Start Hour
                        -->
                        <select name="DOPBSP-discount-item-rule-start-hour-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-start-hour-<?php echo $rule->id; ?>" class="no-margin hour" onchange="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'start_hour', this.value)">
                            <option value=""></option>
<?php
                for ($i=0; $i<count($hours); $i++){
?>
                            <option value="<?php echo $hours[$i]; ?>"<?php echo $rule->start_hour == $hours[$i] ? ' selected="selected"':''; ?>><?php echo $hours[$i]; ?></option>
<?php
                }
?>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-start-hour-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                        
                        <!--
                            End Hour
                        -->
                        <select name="DOPBSP-discount-item-rule-end-hour-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-end-hour-<?php echo $rule->id; ?>" class="hour" onchange="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'end_hour', this.value)">
                            <option value=""></option>
<?php
                for ($i=0; $i<count($hours); $i++){
?>
                            <option value="<?php echo $hours[$i]; ?>"<?php echo $rule->end_hour == $hours[$i] ? ' selected="selected"':''; ?>><?php echo $hours[$i]; ?></option>
<?php
                }
?>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-end-hour-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                        
                        <br class="DOPBSP-clear" />
                        
                        <!--
                            Operation
                        -->
                        <label for="DOPBSP-discount-item-rule-operation-<?php echo $rule->id; ?>" class="no-margin"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_OPERATION'); ?></label>
                        <select name="DOPBSP-discount-item-rule-operation-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-operation-<?php echo $rule->id; ?>" class="small" onchange="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'operation', this.value)">
                            <option value="+"<?php echo $rule->operation == '+' ? ' selected="selected"':''; ?>>+</option>
                            <option value="-"<?php echo $rule->operation == '-' ? ' selected="selected"':''; ?>>-</option>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-operation-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                        
                        <!--
                            Price
                        -->
                        <label for="DOPBSP-discount-item-rule-price-<?php echo $rule->id; ?>"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_PRICE'); ?></label>
                        <input type="text" name="DOPBSP-discount-item-rule-price-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-price-<?php echo $rule->id; ?>" class="small DOPBSP-input-discount-item-rule-price" value="<?php echo $rule->price; ?>" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'price', this.value);}" onpaste="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'price', this.value)" onblur="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'text', 'price', this.value, true)" />
                        
                        <!--
                            Price type
                        -->
                        <label for="DOPBSP-discount-item-rule-price_type-<?php echo $rule->id; ?>"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_PRICE_TYPE'); ?></label>
                        <select name="DOPBSP-discount-item-rule-price_type-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-price_type-<?php echo $rule->id; ?>" class="small" onchange="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'price_type', this.value)">
                            <option value="fixed"<?php echo $rule->price_type == 'fixed' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_TYPE_FIXED'); ?></option>
                            <option value="percent"<?php echo $rule->price_type == 'percent' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_TYPE_PERCENT'); ?></option>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-price_type-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                        
                        <!--
                            Price by
                        -->
                        <label for="DOPBSP-discount-item-rule-price_by-<?php echo $rule->id; ?>"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_LABELS_PRICE_BY'); ?></label>
                        <select name="DOPBSP-discount-item-rule-price_by-<?php echo $rule->id; ?>" id="DOPBSP-discount-item-rule-price_by-<?php echo $rule->id; ?>" class="small" onchange="DOPBSPDiscountItemRule.edit(<?php echo $rule->id; ?>, 'select', 'price_by', this.value)">
                            <option value="once"<?php echo $rule->price_by == 'once' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_BY_ONCE'); ?></option>
                            <option value="period"<?php echo $rule->price_by == 'period' ? ' selected="selected"':''; ?>><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_ITEM_RULES_PRICE_BY_PERIOD'); ?></option>
                        </select>
                        <script>
                            jQuery('#DOPBSP-discount-item-rule-price_by-<?php echo $rule->id; ?>').DOPSelect();
                        </script>
                    </div>
                </li>
<?php
            }
        }
    }
    
    