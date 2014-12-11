<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/reservations/class-backend-reservations-list.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations list PHP class.
*/

    if (!class_exists('DOPBSPBackEndReservationsList')){
        class DOPBSPBackEndReservationsList extends DOPBSPBackEndReservations{
            /*
             * Constructor.
             */
            function DOPBSPBackEndReservationsList(){
            }
            
            /*
             * Search & display reservations list.
             * 
             * @post calendar_id (string/integer): list of calendars or calendar
             * @post start_date (string): reservations start date
             * @post end_date (string): reservations end date
             * @post start_hour (string): reservations start hour
             * @post end_hour (string): reservations end hour
             * @post status_pending (boolean): display reservations with status pending
             * @post status_approved (boolean): display reservations with status approved
             * @post status_rejected (boolean): display reservations with status rejected
             * @post status_canceled (boolean): display reservations with status canceled
             * @post status_expired (boolean): display reservations with status expired
             * @post payment_methods (string): list of payment methods
             * @post search (string): search text
             * @post page (integer): page number to be displayed
             * @post per_page (integer): number of reservation displayed per page
             * @post order (string): order direction "ASC", "DESC"
             * @post order_by (string): order by "check_in", "check_out", "start_hour", "end_hour", "id", "status", "date_created"
             * 
             * @return 
             */
            function get(){
                global $wpdb;
                global $DOPBSP;
                
                $calendars_ids = array();
                $query = array();
                
                $calendar_id = $_POST['calendar_id'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $start_hour = $_POST['start_hour'];
                $end_hour = $_POST['end_hour'];
                $status_pending = $_POST['status_pending'] == 'true' ? true:false;
                $status_approved = $_POST['status_approved'] == 'true' ? true:false;
                $status_rejected = $_POST['status_rejected'] == 'true' ? true:false;
                $status_canceled = $_POST['status_canceled'] == 'true' ? true:false;
                $status_expired = $_POST['status_expired'] == 'true' ? true:false;
                $payment_methods = $_POST['payment_methods'] == '' ? array():explode(',', $_POST['payment_methods']);
                $search = $_POST['search'];
                $page = $_POST['page'];
                $per_page = $_POST['per_page'];
                $order = $_POST['order'];
                $order_by = $_POST['order_by'];
                
                /*
                 * Calendars query.
                 */
                if (strpos($calendar_id, ',') !== false){
                    $calendars_ids = explode(',', $calendar_id);
                    array_push($query, 'SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE (calendar_id='.$calendars_ids[0]);
                    
                    for ($i=1; $i<count($calendars_ids); $i++){
                        array_push($query, ' OR calendar_id='.$calendars_ids[$i]);
                    }
                    array_push($query, ')');
                }
                else{
                    array_push($query, 'SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE calendar_id='.$calendar_id);
                }

                /*
                 * Days query.
                 */
                if ($start_date != ''){
                    if ($end_date != ''){
                        array_push($query, ' AND (check_in >= "'.$start_date.'" AND check_in <= "'.$end_date.'"');
                        array_push($query, ' OR check_out >= "'.$start_date.'" AND check_out <= "'.$end_date.'" AND check_out <> "")');
                    }
                    else{
                        array_push($query, ' AND (check_in >= "'.$start_date.'")');
                    }
                }
                elseif ($end_date != ''){
                    array_push($query, ' AND check_in <= "'.$end_date.'"');
                }
               
                /*
                 * Hours query.
                 */
                array_push($query, ' AND (start_hour >= "'.$start_hour.'" AND start_hour <= "'.$end_hour.'" OR start_hour = ""');
                array_push($query, ' OR end_hour >= "'.$start_hour.'" AND end_hour <= "'.$end_hour.'" OR end_hour = "")');

                /*
                 * Status query.
                 */
                if ($status_pending 
                        || $status_approved 
                        || $status_rejected 
                        || $status_canceled 
                        || $status_expired){
                    $status_init = false;

                    if ($status_pending){
                        array_push($query, $status_init ? ' OR status = "pending"':' AND (status = "pending"');
                        $status_init = true;
                    }

                    if ($status_approved){
                        array_push($query, $status_init ? ' OR status = "approved"':' AND (status = "approved"');
                        $status_init = true;
                    }

                    if ($status_rejected){
                        array_push($query, $status_init ? ' OR status = "rejected"':' AND (status = "rejected"');
                        $status_init = true;
                    }

                    if ($status_canceled){
                        array_push($query, $status_init ? ' OR status = "canceled"':' AND (status = "canceled"');
                        $status_init = true;
                    }

                    if ($status_expired){
                        array_push($query, $status_init ? ' OR status = "expired"':' AND (status = "expired"');
                        $status_init = true;
                    }
                    array_push($query, ')');                    
                }
                else{
                    array_push($query, ' AND status <> "expired"');
                }

                /*
                 * Payment query.       
                 */
                if (count($payment_methods) > 0){
                    $payment_init = false;

                    for ($i=0; $i < count($payment_methods); $i++){
                        array_push($query, $payment_init ? ' OR payment_method="'.$payment_methods[$i].'"':' AND (payment_method="'.$payment_methods[$i].'"');
                        $payment_init = true;
                    }    
                    array_push($query, ')');                    
                }

                /*
                 * Search query.
                 */
                if ($search != ''){
                    array_push($query, ' AND (id="'.$search.'" OR transaction_id = "'.$search.'" OR form LIKE \'%'.$search.'%\')');
                }
               
                /*
                 * Order query.
                 */
                array_push($query, ' ORDER BY '.$order_by.' '.$order);

                /*
                 * ************************************************************* Get number of reservations.
                 */
                $reservations = $wpdb->get_results(implode('', $query));

                echo $wpdb->num_rows.';;;;;;;;;;;';

                /*
                 * Pagination query.
                 */
                array_push($query, ' LIMIT '.(($page-1)*$per_page).', '.$per_page);
                
                /*
                 * ************************************************************* Get reservations.
                 */
                $reservations = $wpdb->get_results(implode('', $query));
                     
                $DOPBSP->views->reservations_list->template(array('reservations' => $reservations));
                
            	die();
            }
        }
    }