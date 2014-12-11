<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/extras/views-backend-extra.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end extra views class.
*/

    if (!class_exists('DOPBSPViewsExtra')){
        class DOPBSPViewsExtra extends DOPBSPViewsExtras{
            /*
             * Constructor
             */
            function DOPBSPViewsExtra(){
            }
            
             /*
             * Returns extra template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): extra ID
             *                      * language (string): extra language
             * 
             * @return extra HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->translation->get();
                
                $extra = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->extras.' WHERE id='.$id);
?>
                <div class="inputs-wrapper">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name',
                                              'label' => $DOPBSP->text('EXTRAS_EXTRA_NAME'),
                                              'value' => $extra->name,
                                              'extra_id' => $extra->id,
                                              'help' => $DOPBSP->text('EXTRAS_EXTRA_NAME_HELP')));
?>
                
                    <!--
                        Language
                    -->
                    <div class="input-wrapper last">
                        <label for="DOPBSP-extra-language"><?php echo $DOPBSP->text('EXTRAS_EXTRA_LANGUAGE'); ?></label>
<?php
                echo $this->getLanguages('DOPBSP-extra-language',
                                         'DOPBSPExtra.display('.$extra->id.', undefined, false)',
                                         $language,
                                         'DOPBSP-left');
?>
                        <a href="javascript:void()" class="button help"><span class="info help"><?php echo $DOPBSP->text('EXTRAS_EXTRA_LANGUAGE_HELP'); ?></span></a>
                    </div>
                </div>
<?php 
            }
            
/*
 * Inputs.
 */         
            /*
             * Create a text input group for extras.
             * 
             * @param args (array): function arguments
             *                      * id (integer): group ID
             *                      * label (string): group label
             *                      * value (string): group current value
             *                      * extra_id (integer): extra ID
             *                      * help (string): group help
             *                      * container_class (string): container class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $extra_id = $args['extra_id'];
                $help = isset($args['help']) ? $args['help']:'';
                $container_class = isset($args['container_class']) ? $args['container_class']:'';

                $html = array();

                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-extra-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-extra-'.$id.'" id="DOPBSP-extra-'.$id.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) != 9){DOPBSPExtra.edit('.$extra_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPExtra.edit('.$extra_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPExtra.edit('.$extra_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
        }
    }
    
    