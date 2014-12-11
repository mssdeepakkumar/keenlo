<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/fees/class-backend-fees.php
* File Version            : 1.0
* Created / Last Modified : 29 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end fees PHP class.
*/

    if (!class_exists('DOPBSPBackEndFees')){
        class DOPBSPBackEndFees extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEndFees(){
            }
        
            /*
             * Prints out the fees page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->fees->template();
            }
                
            /*
             * Display fees list.
             * 
             * @return fees list HTML
             */      
            function display(){
                global $wpdb;
                global $DOPBSP;
                                    
                $html = array();
                
                $fees = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->fees.' WHERE user_id='.wp_get_current_user()->ID.' OR user_id=0 ORDER BY id DESC');
                
                /* 
                 * Create fees list HTML.
                 */
                array_push($html, '<ul>');
                
                if ($wpdb->num_rows != 0){
                    if ($fees){
                        foreach ($fees as $fee){
                            array_push($html, $this->listItem($fee));
                        }
                    }
                }
                else{
                    array_push($html, '<li class="no-data">'.$DOPBSP->text('FEES_NO_FEES').'</li>');
                }
                array_push($html, '</ul>');
                
                echo implode('', $html);
                
            	die();                
            }
            
            /*
             * Returns fees list item HTML.
             * 
             * @param fee (object): fee data
             * 
             * @return fee list item HTML
             */
            function listItem($fee){
                global $DOPBSP;
                
                $html = array();
                $user = get_userdata($fee->user_id); // Get data about the user who created the fees.
                
                array_push($html, '<li class="item" id="DOPBSP-fee-ID-'.$fee->id.'" onclick="DOPBSPFee.display('.$fee->id.')">');
                array_push($html, ' <div class="header">');
                
                /*
                 * Display fee ID.
                 */
                array_push($html, '     <span class="id">ID: '.$fee->id.'</span>');
                
                /*
                 * Display data about the user who created the fee.
                 */
                if ($fee->user_id > 0){
                    array_push($html, '     <span class="header-item avatar">'.get_avatar($fee->user_id, 17));
                    array_push($html, '         <span class="info">'.$DOPBSP->text('FEES_CREATED_BY').': '.$user->data->display_name.'</span>');
                    array_push($html, '         <br class="DOPBSP-clear" />');
                    array_push($html, '     </span>');
                }
                array_push($html, '     <br class="DOPBSP-clear" />');
                array_push($html, ' </div>');
                array_push($html, ' <div class="name">'.$fee->name.'</div>');
                array_push($html, '</li>');
                
                return implode('', $html);
            }
        }
    }