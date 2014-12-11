<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/fees/views-backend-fee.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end fee views class.
*/

    if (!class_exists('DOPBSPViewsFee')){
        class DOPBSPViewsFee extends DOPBSPViewsFees{
            /*
             * Constructor
             */
            function DOPBSPViewsFee(){
            }
            
            /*
             * Returns fee.
             * 
             * @param args (array): function arguments
             *                      * id (integer): fee ID
             *                      * language (string): fee language
             * 
             * @return fee HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->translation->get();
                
                $fee = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->fees.' WHERE id='.$id);
?>
                <div class="inputs-wrapper last">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name',
                                              'label' => $DOPBSP->text('FEES_FEE_NAME'),
                                              'value' => $fee->name,
                                              'fee_id' => $fee->id,
                                              'help' => $DOPBSP->text('FEES_FEE_NAME_HELP')));
?>
                
                    <!--
                        Language
                    -->
                    <div class="input-wrapper">
                        <label for="DOPBSP-fee-language"><?php echo $DOPBSP->text('FEES_FEE_LANGUAGE'); ?></label>
<?php
                echo $this->getLanguages('DOPBSP-fee-language',
                                         'DOPBSPFee.display('.$fee->id.', undefined, false)',
                                         $language,
                                         'DOPBSP-left');
?>
                        <a href="javascript:void()" class="button help"><span class="info help"><?php echo $DOPBSP->text('FEES_FEE_LANGUAGE_HELP'); ?></span></a>
                    </div>
<?php           
                /*
                 * Label
                 */ 
                $this->displayTextInput(array('id' => 'label',
                                              'label' => $DOPBSP->text('FEES_FEE_LABEL'),
                                              'value' => $DOPBSP->classes->translation->decodeJSON($fee->translation, $language),
                                              'fee_id' => $fee->id,
                                              'help' => $DOPBSP->text('FEES_FEE_LABEL_HELP')));      
                /*
                 * Operation
                 */
                $this->displaySelectInput(array('id' => 'operation',
                                                'label' => $DOPBSP->text('FEES_FEE_OPERATION'),
                                                'value' => $fee->operation,
                                                'fee_id' => $fee->id,
                                                'help' => $DOPBSP->text('FEES_FEE_OPERATION_HELP'),
                                                'options' => '+;;-',
                                                'options_values' => '+;;-',
                                                'container_class' => '',
                                                'input_class' => 'small'));
                /*
                 * Price
                 */
                $this->displayTextInput(array('id' => 'price',
                                              'label' => $DOPBSP->text('FEES_FEE_PRICE'),
                                              'value' => $fee->price,
                                              'fee_id' => $fee->id,
                                              'help' => $DOPBSP->text('FEES_FEE_PRICE_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'small DOPBSP-input-fee-price'));       
                /*
                 * Price type.
                 */
                $this->displaySelectInput(array('id' => 'price_type',
                                                'label' => $DOPBSP->text('FEES_FEE_PRICE_TYPE'),
                                                'value' => $fee->price_type,
                                                'fee_id' => $fee->id,
                                                'help' => $DOPBSP->text('FEES_FEE_PRICE_TYPE_HELP'),
                                                'options' => $DOPBSP->text('FEES_FEE_PRICE_TYPE_FIXED').';;'.$DOPBSP->text('FEES_FEE_PRICE_TYPE_PERCENT'),
                                                'options_values' => 'fixed;;percent'));
                /*
                 * Price by.
                 */
                $this->displaySelectInput(array('id' => 'price_by',
                                                'label' => $DOPBSP->text('FEES_FEE_PRICE_BY'),
                                                'value' => $fee->price_by,
                                                'fee_id' => $fee->id,
                                                'help' => $DOPBSP->text('FEES_FEE_PRICE_BY_HELP'),
                                                'options' => $DOPBSP->text('FEES_FEE_PRICE_BY_ONCE').';;'.$DOPBSP->text('FEES_FEE_PRICE_BY_PERIOD'),
                                                'options_values' => 'once;;period'));
                /*
                 * Included
                 */
                $this->displaySwitchInput(array('id' => 'included',
                                                'label' => $DOPBSP->text('FEES_FEE_INCLUDED'),
                                                'value' => $fee->included,
                                                'fee_id' => $fee->id,
                                                'help' => $DOPBSP->text('FEES_FEE_INCLUDED_HELP')));
                /*
                 * Include extras.
                 */
                $this->displaySwitchInput(array('id' => 'extras',
                                                'label' => $DOPBSP->text('FEES_FEE_EXTRAS'),
                                                'value' => $fee->extras,
                                                'fee_id' => $fee->id,
                                                'help' => $DOPBSP->text('FEES_FEE_EXTRAS_HELP')));
                /*
                 * Display to cart.
                 */
                $this->displaySwitchInput(array('id' => 'cart',
                                                'label' => $DOPBSP->text('FEES_FEE_CART'),
                                                'value' => $fee->cart,
                                                'fee_id' => $fee->id,
                                                'help' => $DOPBSP->text('FEES_FEE_CART_HELP'),
                                                'container_class' => 'last'));
?>
                </div>
<?php 
            }

/*
 * Inputs.
 */         
            /*
             * Create a text input for fees.
             * 
             * @param args (array): function arguments
             *                      * id (integer): fee field ID
             *                      * label (string): fee label
             *                      * value (string): fee current value
             *                      * fee_id (integer): fee ID
             *                      * help (string): fee help
             *                      * container_class (string): container class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $fee_id = $args['fee_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-fee-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-fee-'.$id.'" id="DOPBSP-fee-'.$id.'" class="'.$input_class.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) != 9){DOPBSPFee.edit('.$fee_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPFee.edit('.$fee_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPFee.edit('.$fee_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');                        
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            /*
             * Create a drop down field for fees.
             * 
             * @param args (array): function arguments
             *                      * id (integer): fee field ID
             *                      * label (string): fee label
             *                      * value (string): fee current value
             *                      * $fee (integer): fee ID
             *                      * help (string): fee help
             *                      * options (string): options labels
             *                      * options_values (string): options values
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return drop down HTML
             */
            function displaySelectInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $fee_id = $args['fee_id'];
                $help = $args['help'];
                $options = $args['options'];
                $options_values = $args['options_values'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                
                $html = array();
                $options_data = explode(';;', $options);
                $options_values_data = explode(';;', $options_values);
                
                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-settings-'.$id.'">'.$label.'</label>');
                array_push($html, '     <select name="DOPBSP-fee-'.$id.'" id="DOPBSP-fee-'.$id.'" class="DOPBSP-left '.$input_class.'" onchange="DOPBSPFee.edit('.$fee_id.', \'select\', \''.$id.'\', this.value)">');
                
                for ($i=0; $i<count($options_data); $i++){
                    if ($value == $options_values_data[$i]){
                        array_push($html, '     <option value="'.$options_values_data[$i].'" selected="selected">'.$options_data[$i].'</option>');
                    }
                    else{
                        array_push($html, '     <option value="'.$options_values_data[$i].'">'.$options_data[$i].'</option>');
                    }
                }
                array_push($html, '     </select>');
                array_push($html, '     <script type="text/JavaScript">jQuery(\'#DOPBSP-fee-'.$id.'\').DOPSelect();</script>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                
                echo implode('', $html);
            }
            
            
            /*
             * Create a switch item for fees.
             * 
             * @param args (array): function arguments
             *                      * id (integer): item ID
             *                      * label (string): item label
             *                      * value (string): item current value
             *                      * discount_item_id (integer): discount item ID
             *                      * help (string): item help
             *                      * container_class (string): container class
             * 
             * @return switch HTML
             */
            function displaySwitchInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $fee_id = $args['fee_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label class="for-switch">'.$label.'</label>');
                array_push($html, '     <div class="switch">');
                array_push($html, '         <input type="checkbox" name="DOPBSP-fee-'.$id.'-'.$fee_id.'" id="DOPBSP-fee-'.$id.'-'.$fee_id.'" class="switch-checkbox" onchange="DOPBSPFee.edit('.$fee_id.', \'switch\', \''.$id.'\')"'.($value == 'true' ? ' checked="checked"':'').' />');
                array_push($html, '         <label class="switch-label" for="DOPBSP-fee-'.$id.'-'.$fee_id.'">');
                array_push($html, '             <div class="switch-inner"></div>');
                array_push($html, '             <div class="switch-switch"></div>');
                array_push($html, '         </label>');
                array_push($html, '     </div>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help switch-help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                array_push($html, ' <style type="text/css">');
                array_push($html, '     .DOPBSP-admin .input-wrapper .switch .switch-inner:before{content: "'.$DOPBSP->text('SETTINGS_ENABLED').'";}');
                array_push($html, '     .DOPBSP-admin .input-wrapper .switch .switch-inner:after{content: "'.$DOPBSP->text('SETTINGS_DISABLED').'";}');
                array_push($html, ' </style>');
                
                echo implode('', $html);
            }
        }
    }