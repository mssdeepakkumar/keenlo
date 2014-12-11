<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/forms/views-backend-form-fields.php
* File Version            : 1.0
* Created / Last Modified : 08 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end form fields views class.
*/

    if (!class_exists('DOPBSPViewsFormFields')){
        class DOPBSPViewsFormFields extends DOPBSPViewsForm{
            /*
             * Constructor
             */
            function DOPBSPViewsFormFields(){
            }
            
            /*
             * Returns form fields tempalte.
             * 
             * @param args (array): function arguments
             *                      * id (integer): form ID
             *                      * language (string): form language
             * 
             * @return form fields HTML
             */
            function template($args = array()){
                global $wpdb;
                global $DOPBSP;
                
                $id = $args['id'];
                $language = isset($args['language']) && $args['language'] != '' ? $args['language']:$DOPBSP->classes->translation->get();
?>
                <div class="form-fields-header">
                    <div class="form-fields-types-wrapper">
                        <a href="javascript:void(0)" class="button add"></a>
                        <ul class="form-fields-types">
                            <li>
                                <a href="javascript:DOPBSPFormField.add(<?php echo $id; ?>, 'text', '<?php echo $language; ?>')">
                                    <span class="icon text"></span>
                                    <span class="label"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_TYPE_TEXT_LABEL'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:DOPBSPFormField.add(<?php echo $id; ?>, 'textarea', '<?php echo $language; ?>')">
                                    <span class="icon textarea"></span>
                                    <span class="label"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_TYPE_TEXTAREA_LABEL'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:DOPBSPFormField.add(<?php echo $id; ?>, 'checkbox', '<?php echo $language; ?>')">
                                    <span class="icon checkbox"></span>
                                    <span class="label"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_TYPE_CHECKBOX_LABEL'); ?></span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:DOPBSPFormField.add(<?php echo $id; ?>, 'select', '<?php echo $language; ?>')">
                                    <span class="icon select"></span>
                                    <span class="label"><?php echo $DOPBSP->text('FORMS_FORM_FIELD_TYPE_SELECT_LABEL'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <h3><?php echo $DOPBSP->text('FORMS_FORM_FIELDS'); ?></h3>
                </div>
                <ul id="DOPBSP-form-fields" class="form-fields">
<?php
                $fields = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms_fields.' WHERE form_id='.$id.' ORDER BY position ASC');
                
                if ($wpdb->num_rows > 0){
                    foreach($fields as $field){
                        switch ($field->type){
                            case 'checkbox':
                                $DOPBSP->views->form_field->templateCheckbox(array('field' => $field,
                                                                                   'language' => $language));
                                break;
                            case 'select':
                                $DOPBSP->views->form_field->templateSelect(array('field' => $field,
                                                                                 'language' => $language));
                                break;
                            case 'text':
                                $DOPBSP->views->form_field->templateText(array('field' => $field,
                                                                               'language' => $language));
                                break;
                            case 'textarea':
                                $DOPBSP->views->form_field->templateTextarea(array('field' => $field,
                                                                                   'language' => $language));
                                break;
                        }
                    }
                }
?>    
                </ul>
<?php                    
            }
        }
    }