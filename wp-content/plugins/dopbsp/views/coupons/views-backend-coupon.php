<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/coupons/views-backend-coupon.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end coupon views class.
*/

    if (!class_exists('DOPBSPViewsCoupon')){
        class DOPBSPViewsCoupon extends DOPBSPViewsCoupons{
            /*
             * Constructor
             */
            function DOPBSPViewsCoupon(){
            }
            
            /*
             * Returns coupon template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): coupon ID
             *                      * language (string): coupon language
             * 
             * @return coupon HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->translation->get();
                
                $coupon = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->coupons.' WHERE id='.$id);
                $hours = $DOPBSP->classes->prototypes->getHours();
?>
                <div class="inputs-wrapper last">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name',
                                              'label' => $DOPBSP->text('COUPONS_COUPON_NAME'),
                                              'value' => $coupon->name,
                                              'coupon_id' => $coupon->id,
                                              'help' => $DOPBSP->text('COUPONS_COUPON_NAME_HELP')));
?>
                
                    <!--
                        Language
                    -->
                    <div class="input-wrapper">
                        <label for="DOPBSP-coupon-language"><?php echo $DOPBSP->text('COUPONS_COUPON_LANGUAGE'); ?></label>
<?php
                echo $this->getLanguages('DOPBSP-coupon-language',
                                         'DOPBSPCoupon.display('.$coupon->id.', undefined, false)',
                                         $language,
                                         'DOPBSP-left');
?>
                        <a href="javascript:void()" class="button help"><span class="info help"><?php echo $DOPBSP->text('COUPONS_COUPON_LANGUAGE_HELP'); ?></span></a>
                    </div>
<?php           
                /*
                 * Label
                 */
                $this->displayTextInput(array('id' => 'label',
                                              'label' => $DOPBSP->text('COUPONS_COUPON_LABEL'),
                                              'value' => $DOPBSP->classes->translation->decodeJSON($coupon->translation, $language),
                                              'coupon_id' => $coupon->id,
                                              'help' => $DOPBSP->text('COUPONS_COUPON_LABEL_HELP')));
                /*
                 * Code
                 */
                $this->displayTextInput(array('id' => 'code',
                                              'label' => $DOPBSP->text('COUPONS_COUPON_CODE'),
                                              'value' => $coupon->code,
                                              'coupon_id' => $coupon->id,
                                              'help' => $DOPBSP->text('COUPONS_COUPON_CODE_HELP'),
                                              'container_class' => '',
                                              'input_class' => '',
                                              'code_help' => $DOPBSP->text('COUPONS_COUPON_CODE_GENERATE')));
               /*
                * Start date.
                */
                $this->displayTextInput(array('id' => 'start_date',
                                              'label' => $DOPBSP->text('COUPONS_COUPON_START_DATE'),
                                              'value' => $coupon->start_date,
                                              'coupon_id' => $coupon->id,
                                              'help' => $DOPBSP->text('COUPONS_COUPON_START_DATE_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'date'));
               /*
                * End date.
                */
                $this->displayTextInput(array('id' => 'end_date',
                                              'label' => $DOPBSP->text('COUPONS_COUPON_END_DATE'),
                                              'value' => $coupon->end_date,
                                              'coupon_id' => $coupon->id,
                                              'help' => $DOPBSP->text('COUPONS_COUPON_END_DATE_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'date'));
                /*
                 * Start hour.
                 */
                $this->displaySelectInput(array('id' => 'start_hour',
                                                'label' => $DOPBSP->text('COUPONS_COUPON_START_HOUR'),
                                                'value' => $coupon->start_hour,
                                                'coupon_id' => $coupon->id,
                                                'help' => $DOPBSP->text('COUPONS_COUPON_START_HOUR_HELP'),
                                                'options' => ';;'.implode(';;', $hours),
                                                'options_values' => ';;'.implode(';;', $hours),
                                                'container_class' => '',
                                                'input_class' => 'hour'));
                /*
                 * End hour.
                 */
                $this->displaySelectInput(array('id' => 'end_hour',
                                                'label' => $DOPBSP->text('COUPONS_COUPON_END_HOUR'),
                                                'value' => $coupon->end_hour,
                                                'coupon_id' => $coupon->id,
                                                'help' => $DOPBSP->text('COUPONS_COUPON_END_HOUR_HELP'),
                                                'options' => ';;'.implode(';;', $hours),
                                                'options_values' => ';;'.implode(';;', $hours),
                                                'container_class' => '',
                                                'input_class' => 'hour'));
                /*
                 * Number of coupons.
                 */
                $this->displayTextInput(array('id' => 'no_coupons',
                                              'label' => $DOPBSP->text('COUPONS_COUPON_NO_COUPONS'),
                                              'value' => $coupon->no_coupons,
                                              'coupon_id' => $coupon->id,
                                              'help' => $DOPBSP->text('COUPONS_COUPON_NO_COUPONS_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'small'));
                /*
                 * Operation
                 */
                $this->displaySelectInput(array('id' => 'operation',
                                                'label' => $DOPBSP->text('COUPONS_COUPON_OPERATION'),
                                                'value' => $coupon->operation,
                                                'coupon_id' => $coupon->id,
                                                'help' => $DOPBSP->text('COUPONS_COUPON_OPERATION_HELP'),
                                                'options' => '+;;-',
                                                'options_values' => '+;;-',
                                                'container_class' => '',
                                                'input_class' => 'small'));
                /*
                 * Price
                 */
                $this->displayTextInput(array('id' => 'price',
                                              'label' => $DOPBSP->text('COUPONS_COUPON_PRICE'),
                                              'value' => $coupon->price,
                                              'coupon_id' => $coupon->id,
                                              'help' => $DOPBSP->text('COUPONS_COUPON_PRICE_HELP'),
                                              'container_class' => '',
                                              'input_class' => 'small'));     
                /*
                 * Price type.
                 */
                $this->displaySelectInput(array('id' => 'price_type',
                                                'label' => $DOPBSP->text('COUPONS_COUPON_PRICE_TYPE'),
                                                'value' => $coupon->price_type,
                                                'coupon_id' => $coupon->id,
                                                'help' => $DOPBSP->text('COUPONS_COUPON_PRICE_TYPE_HELP'),
                                                'options' => $DOPBSP->text('COUPONS_COUPON_PRICE_TYPE_FIXED').';;'.$DOPBSP->text('COUPONS_COUPON_PRICE_TYPE_PERCENT'),
                                                'options_values' => 'fixed;;percent',
                                                'container_class' => '',
                                                'input_class' => ''));
                /*
                 * Price by.
                 */
                $this->displaySelectInput(array('id' => 'price_by',
                                                'label' => $DOPBSP->text('COUPONS_COUPON_PRICE_BY'),
                                                'value' => $coupon->price_by,
                                                'coupon_id' => $coupon->id,
                                                'help' => $DOPBSP->text('COUPONS_COUPON_PRICE_BY_HELP'),
                                                'options' => $DOPBSP->text('COUPONS_COUPON_PRICE_BY_ONCE').';;'.$DOPBSP->text('COUPONS_COUPON_PRICE_BY_PERIOD'),
                                                'options_values' => 'once;;period',
                                                'container_class' => 'last',
                                                'input_class' => ''));
?>
                </div>
<?php 
            }

/*
 * Inputs.
 */         
            /*
             * Create a text input for coupon.
             * 
             * @param args (array): function arguments
             *                      * id (integer): coupon field ID
             *                      * label (string): coupon label
             *                      * value (string): coupon current value
             *                      * coupon_id (integer): coupon ID
             *                      * help (string): coupon help
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             *                      * code_help (string): code generator help
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $coupon_id = $args['coupon_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                $code_help = isset($args['code_help']) ? $args['code_help']:'';
                    
                $html = array();

                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-coupon-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-coupon-'.$id.'" id="DOPBSP-coupon-'.$id.'" class="'.$input_class.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) != 9){DOPBSPCoupon.edit('.$coupon_id.', \'text\', \''.$id.'\', this.value);}" onchange="DOPBSPCoupon.edit('.$coupon_id.', \'text\', \''.$id.'\', this.value)" onpaste="DOPBSPCoupon.edit('.$coupon_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPCoupon.edit('.$coupon_id.', \'text\', \''.$id.'\', this.value, true)" />');
                
                if ($code_help != '') {
                    array_push($html, '     <a href="javascript:void(0)" onclick="DOPBSPCoupon.generateCode('.$coupon_id.');" target="_blank" class="button generate-code"><span class="info">'.$code_help.'</span></a>');
                }
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                        
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            /*
             * Create a drop down field for coupon.
             * 
             * @param args (array): function arguments
             *                      * id (integer): coupon field ID
             *                      * label (string): coupon label
             *                      * value (string): coupon current value
             *                      * coupon_id (integer): coupon ID
             *                      * help (string): coupon help
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
                $coupon_id = $args['coupon_id'];
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
                array_push($html, '     <select name="DOPBSP-coupon-'.$id.'" id="DOPBSP-coupon-'.$id.'" class="DOPBSP-left '.$input_class.'" onchange="DOPBSPCoupon.edit('.$coupon_id.', \'select\', \''.$id.'\', this.value)">');
                
                for ($i=0; $i<count($options_data); $i++){
                    if ($value == $options_values_data[$i]){
                        array_push($html, '     <option value="'.$options_values_data[$i].'" selected="selected">'.$options_data[$i].'</option>');
                    }
                    else{
                        array_push($html, '     <option value="'.$options_values_data[$i].'">'.$options_data[$i].'</option>');
                    }
                }
                array_push($html, '     </select>');
                array_push($html, '     <script type="text/JavaScript">jQuery(\'#DOPBSP-coupon-'.$id.'\').DOPSelect();</script>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                
                echo implode('', $html);
            }
        }
    }