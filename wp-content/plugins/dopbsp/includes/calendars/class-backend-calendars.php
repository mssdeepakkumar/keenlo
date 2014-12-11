<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/calendars/class-backend-calendars.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end calendars PHP class.
*/

    if (!class_exists('DOPBSPBackEndCalendars')){
        class DOPBSPBackEndCalendars extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEndCalendars(){
            }
        
            /*
             * Prints out the calendars page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->calendars->template();
            }
                
            /*
             * Display calendars list.
             * 
             * @return calendars list HTML
             */
            function display(){
                global $wpdb;
                global $DOPBSP;
                                    
                $html_calendars = array();
                $no_calendars = 0;
                
                /*
                 * If curent user is an administrator and can view all calendars get all calendars.
                 */
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id DESC');
                    $no_calendars = $wpdb->num_rows;
                }
                else{
                    /*
                     * If current user can use the booking system get the calendars he created.
                     */
                    if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                        $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE user_id='.wp_get_current_user()->ID.' ORDER BY id DESC');
                    }

                    /*
                     * If current user has been allowed to use only some calendars.
                     */
                    if (get_user_meta(wp_get_current_user()->ID, 'DOPBSP_permissions_calendars', true) != ''){
                        $calendar_ids = explode(',', get_user_meta(wp_get_current_user()->ID, 'DOPBSP_permissions_calendars', true));
                        $calendar_list = '';
                        $calendars_found = array();
                        $i=0;

                        foreach($calendar_ids as $calendar_id){
                            if ($i < 1){
                                $calendar_list .= $calendar_id;
                            }
                            else{
                              $calendar_list .= ", ".$calendar_id;  
                            }

                            array_push($calendars_found, $calendar_id);
                            $i++;
                        }

                        if ($calendar_list){
                           $calendars_assigned = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id IN ('.$calendar_list.') ORDER BY id DESC');   
                        }
                    }
                    else{
                        $calendars_assigned = $calendars;
                    }
                }
                
                /* 
                 * Create calendars list HTML.
                 */
                array_push($html_calendars, '<ul>');
                
                if ($no_calendars != 0 
                        || (isset($calendars_assigned) 
                                && count($calendars_assigned) != 0)){
                    if ($calendars){
                        foreach ($calendars as $calendar){
                            if (isset($calendars_found)){
                                if (!in_array($calendar->id, $calendars_found)){
                                    array_push($html_calendars, $this->listItem($calendar));
                                }
                            }
                            
                            if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                              array_push($html_calendars, $this->listItem($calendar));  
                            }
                        }
                    }
                    
                    if (isset($calendars_assigned)){
                        foreach ($calendars_assigned as $calendar) {
                            array_push($html_calendars, $this->listItem($calendar));
                        }
                    }
                }
                else{
                    array_push($html_calendars, '<li class="no-data">'.$DOPBSP->text('CALENDARS_NO_CALENDARS').'</li>');
                }
                array_push($html_calendars, '</ul>');
                
                echo implode('', $html_calendars);
                
            	die();                
            }
            
            /*
             * Returns calendars list item HTML.
             * 
             * @param calendar (object): calendar data
             * 
             * @return calendar list item HTML
             */
            function listItem($calendar){
                global $wpdb;
                global $DOPBSP;
                
                $HTML = array();
                $user = get_userdata($calendar->user_id); // Get data about the user who created the calendar.
                $reservations_no_pending = 0;
                $reservations_no_approved = 0;
                $reservations_no_rejected = 0;
                $reservations_no_canceled = 0;
                $reservations = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE calendar_id='.$calendar->id.'  AND status <> "expired"');
                
                /*
                 * Count the number of reservations.
                 */
                foreach ($reservations as $reservation){
                    switch ($reservation->status){
                        case 'pending':
                            $reservations_no_pending++;
                            break;
                        case 'approved':
                            $reservations_no_approved++;
                            break;
                        case 'rejected':
                            $reservations_no_rejected++;
                            break;
                        case 'canceled':
                            $reservations_no_canceled++;
                            break;
                    }
                }
                
                array_push($HTML, '<li class="item" id="DOPBSP-calendar-ID-'.$calendar->id.'" onclick="DOPBSPCalendar.init('.$calendar->id.')">');
                array_push($HTML, ' <div class="header">');
                
                /*
                 * Display calendar ID.
                 */
                array_push($HTML, '     <span class="id">ID: '.$calendar->id.'</span>');
                
                /*
                 * Display data about the user who created the calendar.
                 */
                array_push($HTML, '     <span class="header-item avatar">'.get_avatar($calendar->user_id, 17));
                array_push($HTML, '         <span class="info">'.$DOPBSP->text('CALENDARS_CREATED_BY').': '.$user->data->display_name.'</span>');
                array_push($HTML, '         <br class="DOPBSP-clear" />');
                array_push($HTML, '     </span>');
                
                /*
                 * Display the number of pending reservations.
                 */
                array_push($HTML, '     <span class="header-item DOPBSP-pending-background">');
                array_push($HTML, '         <span class="text">'.$reservations_no_pending.'</span>');
                array_push($HTML, '         <span class="info">'.$reservations_no_pending.' '.$DOPBSP->text('CALENDARS_NO_PENDING_RESERVATIONS').'</span>');
                array_push($HTML, '         <br class="DOPBSP-clear" />');
                array_push($HTML, '     </span>');
                
                /*
                 * Display the number of approved reservations.
                 */
                array_push($HTML, '     <span class="header-item DOPBSP-approved-background">');
                array_push($HTML, '         <span class="text">'.$reservations_no_approved.'</span>');
                array_push($HTML, '         <span class="info">'.$reservations_no_approved.' '.$DOPBSP->text('CALENDARS_NO_APPROVED_RESERVATIONS').'</span>');
                array_push($HTML, '         <br class="DOPBSP-clear" />');
                array_push($HTML, '     </span>');
                
                /*
                 * Display the number of rejected reservations.
                 */
                array_push($HTML, '     <span class="header-item DOPBSP-rejected-background">');
                array_push($HTML, '         <span class="text">'.$reservations_no_rejected.'</span>');
                array_push($HTML, '         <span class="info">'.$reservations_no_rejected.' '.$DOPBSP->text('CALENDARS_NO_REJECTED_RESERVATIONS').'</span>');
                array_push($HTML, '         <br class="DOPBSP-clear" />');
                array_push($HTML, '     </span>');
                
                /*
                 * Display the number of canceled reservations.
                 */
                array_push($HTML, '     <span class="header-item DOPBSP-canceled-background">');
                array_push($HTML, '         <span class="text">'.$reservations_no_canceled.'</span>');
                array_push($HTML, '         <span class="info">'.$reservations_no_canceled.' '.$DOPBSP->text('CALENDARS_NO_CANCELED_RESERVATIONS').'</span>');
                array_push($HTML, '         <br class="DOPBSP-clear" />');
                array_push($HTML, '     </span>');
                array_push($HTML, '     <br class="DOPBSP-clear" />');
                array_push($HTML, ' </div>');
                array_push($HTML, ' <div class="name">'.$calendar->name.'</div>');
                array_push($HTML, '</li>');
                
                return implode('', $HTML);
            }
        }
    }