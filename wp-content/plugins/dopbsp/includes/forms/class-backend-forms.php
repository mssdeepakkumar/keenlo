<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/forms/class-backend-forms.php
* File Version            : 1.0
* Created / Last Modified : 29 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end forms PHP class.
*/

    if (!class_exists('DOPBSPBackEndForms')){
        class DOPBSPBackEndForms extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEndForms(){
            }
        
            /*
             * Prints out the forms page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->forms->template();
            }
                
            /*
             * Display forms list.
             * 
             * @return forms list HTML
             */      
            function display(){
                global $wpdb;
                global $DOPBSP;
                                    
                $html = array();
                $forms = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms.' WHERE user_id='.wp_get_current_user()->ID.' OR user_id=0 ORDER BY id DESC');
                
                /* 
                 * Create forms list HTML.
                 */
                array_push($html, '<ul>');
                
                if ($wpdb->num_rows != 0){
                    if ($forms){
                        foreach ($forms as $form){
                            array_push($html, $this->listItem($form));
                        }
                    }
                }
                else{
                    array_push($html, '<li class="no-data">'.$DOPBSP->text('NO_FORMS').'</li>');
                }
                array_push($html, '</ul>');
                
                echo implode('', $html);
                
            	die();                
            }
            
            /*
             * Returns forms list item HTML.
             * 
             * @param form (object): form data
             * 
             * @return form list item HTML
             */
            function listItem($form){
                global $DOPBSP;
                
                $html = array();
                $user = get_userdata($form->user_id); // Get data about the user who created the form.
                
                array_push($html, '<li class="item" id="DOPBSP-form-ID-'.$form->id.'" onclick="DOPBSPForm.display('.$form->id.')">');
                array_push($html, ' <div class="header">');
                
                /*
                 * Display form ID.
                 */
                array_push($html, '     <span class="id">ID: '.$form->id.'</span>');
                
                /*
                 * Display data about the user who created the form.
                 */
                if ($form->user_id > 0){
                    array_push($html, '     <span class="header-item avatar">'.get_avatar($form->user_id, 17));
                    array_push($html, '         <span class="info">'.$DOPBSP->text('FORMS_CREATED_BY').': '.$user->data->display_name.'</span>');
                    array_push($html, '         <br class="DOPBSP-clear" />');
                    array_push($html, '     </span>');
                }
                array_push($html, '     <br class="DOPBSP-clear" />');
                array_push($html, ' </div>');
                array_push($html, ' <div class="name">'.$form->name.'</div>');
                array_push($html, '</li>');
                
                return implode('', $html);
            }
        }
    }