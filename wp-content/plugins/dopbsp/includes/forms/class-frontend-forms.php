<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/forms/class-frontend-forms.php
* File Version            : 1.0
* Created / Last Modified : 01 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO front end forms PHP class.
*/

    if (!class_exists('DOPBSPFrontEndForms')){
        class DOPBSPFrontEndForms extends DOPBSPFrontEnd{
            /*
             * Constructor.
             */
            function DOPBSPFrontEndForms(){
            }
            
            /*
             * Get selected form.
             * 
             * @param id (integer): form ID
             * @param language (string): selected language
             * 
             * @return data array
             */
            function get($id,
                         $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE){
                global $wpdb;
                global $DOPBSP;
                
                $fields = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms_fields.' WHERE form_id='.$id.' ORDER BY position');
                
                foreach ($fields as $field){
                    $field->translation = $DOPBSP->classes->translation->decodeJSON($field->translation,
                                                                                    $language);
                    
                    if ($field->type == 'select'){
                        $options = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms_fields_options.' WHERE field_id='.$field->id.' ORDER BY position');
                        
                        foreach ($options as $option){
                            $option->translation = $DOPBSP->classes->translation->decodeJSON($option->translation,
                                                                                             $language);
                        }
                        $field->options = $options;
                    }
                }
                
                return array('data' => array('form' => $fields,
                                             'id' => $id),
                             'text' => array('invalidEmail' => $DOPBSP->text('FORMS_FRONT_END_INVALID_EMAIL'),
                                             'required' => $DOPBSP->text('FORMS_FRONT_END_REQUIRED'),
                                             'title' => $DOPBSP->text('FORMS_FRONT_END_TITLE')));
            }
        }
    }