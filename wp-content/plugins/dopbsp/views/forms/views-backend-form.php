<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/forms/views-backend-form.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end form views class.
*/

    if (!class_exists('DOPBSPViewsForm')){
        class DOPBSPViewsForm extends DOPBSPViewsForms{
            /*
             * Constructor
             */
            function DOPBSPViewsForm(){
            }
            
            /*
             * Returns form template.
             * 
             * @param args (array): function arguments
             *                      * id (integer): form ID
             *                      * language (string): form language
             * 
             * @return form HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->translation->get();
                
                $form = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->forms.' WHERE id='.$id);
?>
                <div class="inputs-wrapper">
<?php                    
                /*
                 * Name
                 */
                $this->displayTextInput(array('id' => 'name',
                                              'label' => $DOPBSP->text('FORMS_FORM_NAME'),
                                              'value' => $form->name,
                                              'form_id' => $form->id,
                                              'help' => $DOPBSP->text('FORMS_FORM_NAME_HELP')));
?>
                
                    <!--
                        Language
                    -->
                    <div class="input-wrapper last">
                        <label for="DOPBSP-form-language"><?php echo $DOPBSP->text('FORMS_FORM_LANGUAGE'); ?></label>
<?php
                echo $this->getLanguages('DOPBSP-form-language',
                                         'DOPBSPForm.display('.$form->id.', undefined, false)',
                                         $language,
                                         'DOPBSP-left');
?>
                        <a href="javascript:void()" class="button help"><span class="info help"><?php echo $DOPBSP->text('FORMS_FORM_LANGUAGE_HELP'); ?></span></a>
                    </div>
                </div>
<?php 
            }
            
/*
 * Inputs.
 */         
            /*
             * Create a text input field for forms.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * form_id (integer): form ID
             *                      * help (string): field help
             *                      * container_class (string): container class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $form_id = $args['form_id'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-form-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-form-'.$id.'" id="DOPBSP-form-'.$id.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) != 9){DOPBSPForm.edit('.$form_id.', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPForm.edit('.$form_id.', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPForm.edit('.$form_id.', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');                        
                array_push($html, ' </div>');

                echo implode('', $html);
            }
        }
    }