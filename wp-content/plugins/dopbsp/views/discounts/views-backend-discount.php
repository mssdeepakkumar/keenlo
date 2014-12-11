<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/discounts/views-backend-discount.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end discount views class.
*/

    if (!class_exists('DOPBSPViewsDiscount')){
        class DOPBSPViewsDiscount extends DOPBSPViewsDiscounts{
            /*
             * Constructor
             */
            function DOPBSPViewsDiscount(){
            }
            
             /*
             * Returns discount template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): discount ID
             *                      * language (string): discount language
             * 
             * @return discount HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->translation->get();
                
                $discount = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->discounts.' WHERE id='.$id);
?>
                <div class="inputs-wrapper">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name', 
                                              'label' => $DOPBSP->text('DISCOUNTS_DISCOUNT_NAME'), 
                                              'value' => $discount->name, 
                                              'discount_id' => $discount->id, 
                                              'help' => $DOPBSP->text('DISCOUNTS_DISCOUNT_NAME_HELP')));
?>
                
                    <!--
                        Language
                    -->
                    <div class="input-wrapper last">
                        <label for="DOPBSP-discount-language"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_LANGUAGE'); ?></label>
<?php
                echo $this->getLanguages('DOPBSP-discount-language',
                                         'DOPBSPDiscount.display('.$discount->id.', undefined, false)',
                                         $language,
                                         'DOPBSP-left');
?>
                        <a href="javascript:void()" class="button help"><span class="info help"><?php echo $DOPBSP->text('DISCOUNTS_DISCOUNT_LANGUAGE_HELP'); ?></span></a>
                    </div>
                </div>
<?php 
            }
            
/*
 * Inputs.
 */         
            /*
             * Create a text input item for discount.
             * 
             * @param args (array): function arguments
             *                      * id (integer): item ID
             *                      * label (string): item label
             *                      * value (string): item current value
             *                      * discount_id (integer): discount ID
             *                      * help (string): item help
             *                      * container_class (string): container class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $discount_id = $args['discount_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-discount-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-discount-'.$id.'" id="DOPBSP-discount-'.$id.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) != 9){DOPBSPDiscount.edit('.$discount_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPDiscount.edit('.$discount_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPDiscount.edit('.$discount_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');                        
                array_push($html, ' </div>');

                echo implode('', $html);
            }
        }
    }
    
    