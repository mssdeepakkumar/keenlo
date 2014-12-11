<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/calendars/class-backend-calendar-schedule.php
* File Version            : 1.0
* Created / Last Modified : 07 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end calendar schedule PHP class.
*/

    if (!class_exists('DOPBSPBackEndCalendarSchedule')){
        class DOPBSPBackEndCalendarSchedule extends DOPBSPBackEndCalendar{
            /*
             * Constructor
             */
            function DOPBSPBackEndCalendarSchedule(){
//                add_action('init', array(&$this, 'init'));
            }
            
            function init(){
                if ($this->validateHours(1, '2014-06-12', '06:00', '07:00', 3)){
                    echo 'true';
                }
                else{
                    echo 'false';
                }
            }
        
            /*
             * Get calendar schedule.
             * 
             * @post id (integer): calendar ID
             * @post year (integer): year for which the data will be loaded
             * 
             * @return schedule JSON
             */
            function get(){
                global $wpdb;
                global $DOPBSP;
                
                $schedule = array();

                $calendar_id = $_POST['id'];
                $year = $_POST['year'];
                
                $days = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id=%d AND year=%d',
                                                          $calendar_id, $year));

                foreach ($days as $day):
                    $schedule[$day->day] = $day->data;
                endforeach;

                if (count($schedule) > 0){
                    echo json_encode($schedule);
                }

                die();
            }
            
            /*
             * Set calendar schedule.
             * 
             * @post id (integer): calendar ID
             * @post schedule (string): calendar data
             * 
             */
            function set(){
                global $wpdb;
                global $DOPBSP;

                $schedule = json_decode(stripslashes(utf8_encode($_POST['schedule'])));
                $id = $_POST['id'];
                $query_insert_values = array();

                /*
                 * Set days data.
                 */
                while ($data = current($schedule)){
                    $day = key($schedule);
                    $day_items = explode('-', $day);
                    $control_data = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$id.' AND day="'.$day.'"');
                    
                    if ($wpdb->num_rows != 0){
                        $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                             array('calendar_id' => $id,
                                                                   'day' => $day));
                    }
                    else{
                        array_push($query_insert_values, '(\''.$id.'_'.$day.'\', \''.$id.'\', \''.$day.'\', \''.$day_items[0].'\', \''.json_encode($data).'\')');
                    }
                    next($schedule);                        
                }
                
                if (count($query_insert_values) > 0){
                    $wpdb->query('INSERT INTO '.$DOPBSP->tables->days.' (unique_key, calendar_id, day, year, data) VALUES '.implode(', ', $query_insert_values));
                }
                
                $this->clean();
                $this->setMaxYear($id);
                $this->setAvailability($id);

                die();      
            }
            
            /*
             * Change schedule when reservation is approved.
             * 
             * @param reservation_id (integer): reservation ID
             */
            function setApproved($reservation_id){
                global $wpdb;
                global $DOPBSP;
                
                $reservation = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE id='.$reservation_id);
                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$reservation->calendar_id);
                
                /*
                 * Select days to be updated.
                 */
                if ($reservation->check_out == ''){
                    $day = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$reservation->calendar_id.' AND day="'.$reservation->check_in.'"');
                }
                else{
                    if ($settings->days_morning_check_out == 'true'){
                        $days = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$reservation->calendar_id.' AND day>="'.$reservation->check_in.'" AND day<"'.$reservation->check_out.'"');
                    }
                    else{
                        $days = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$reservation->calendar_id.' AND day>="'.$reservation->check_in.'" AND day<="'.$reservation->check_out.'"');
                    }
                }

                if ($reservation->check_out == '' 
                        && $reservation->start_hour == ''){
                /*
                 * Change single day.
                 */    
                    $data = json_decode($day->data);

                    if ($data->available == '' 
                            || (int)$data->available < 1){
                        $available = 1;
                    }
                    else{
                        $available = $data->available;
                    }

                    if ($available-$reservation->no_items == 0){
                        $data->price = '';
                        $data->promo = '';
                        $data->status = 'booked';
                    }

                    $data->available = $available-$reservation->no_items;

                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day->day));
                }
                else if ($reservation->check_out != ''){    
                /*
                 * Change multiple days.
                 */                
                    foreach ($days as $key => $day){
                        $data = json_decode($day->data);

                        if ($data->available == '' 
                                || (int)$data->available < 1){
                            $available = 1;
                        }
                        else{
                            $available = $data->available;
                        }

                        if ($available-$reservation->no_items == 0){
                            $data->price = '';
                            $data->promo = '';
                            $data->status = 'booked';
                        }

                        $data->available = $available-$reservation->no_items;

                        $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                             array('calendar_id' => $reservation->calendar_id, 
                                                                   'day' => $day->day));
                    }
                }
                else if ($reservation->start_hour != '' 
                            && $reservation->end_hour == ''){    
                /*
                 * Change single hour.
                 */
                    $data = json_decode($day->data);
                    $start_hour = $reservation->start_hour;
                    $hour = $data->hours->$start_hour;

                    if ($hour->available == '' 
                            || (int)$hour->available < 1){
                        $available = 1;
                    }
                    else{
                        $available = (int)$hour->available;
                    }

                    if ($available-$reservation->no_items == 0){
                        $hour->price = '';
                        $hour->promo = '';
                        $hour->status = 'booked';
                    }

                    $hour->available = $available-$reservation->no_items;

                    $data->hours->$start_hour = $hour;
                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day->day));
                    
                    if ($settings->days_details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id, 
                                               $day->day);
                    }
                }
                else if ($reservation->end_hour != ''){  
                /*
                 * Change multiple hour.
                 */
                    $data = json_decode($day->data);

                    foreach ($data->hours as $key => $item){
                        if ($reservation->start_hour <= $key 
                                && ((($settings->hours_add_last_hour_to_total_price == 'false' 
                                                        || $settings->hours_interval_enabled == 'true') 
                                                && $key < $reservation->end_hour) || 
                                        ($settings->hours_add_last_hour_to_total_price == 'true' 
                                                        && $settings->hours_interval_enabled == 'false' 
                                                        && $key <= $reservation->end_hour))){
                            $hour = $data->hours->$key;

                            if ($hour->available == '' 
                                    || (int)$hour->available < 1){
                                $available = 1;
                            }
                            else{
                                $available = (int)$hour->available;
                            }

                            if ($available-$reservation->no_items == 0){
                                $hour->price = '';
                                $hour->promo = '';
                                $hour->status = 'booked';
                            }

                            $hour->available = $available-$reservation->no_items;

                            $data->hours->$key = $hour;
                        }
                    }

                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)),
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day->day));
                    
                    if ($settings->days_details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id,
                                                             $day->day);
                    }
                }
                
                $this->clean();
                $this->setAvailability($reservation->calendar_id);
            }
            
            /*
             * Change schedule when reservation is canceled.
             * 
             * @param reservation_id (integer): reservation ID
             */
            function setCanceled($reservation_id){
                global $wpdb;
                global $DOPBSP;
                
                $reservation = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE id='.$reservation_id);
                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$reservation->calendar_id);
                $history = json_decode($reservation->days_hours_history);    
                
                /*
                 * Select days to be updated.
                 */
                if ($reservation->check_out == ''){
                    $day = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$reservation->calendar_id.' AND day="'.$reservation->check_in.'"');
                }
                else{
                    if ($settings->days_morning_check_out == 'true'){
                        $days = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$reservation->calendar_id.' AND day>="'.$reservation->check_in.'" AND day<"'.$reservation->check_out.'"');
                    }
                    else{
                        $days = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$reservation->calendar_id.' AND day>="'.$reservation->check_in.'" AND day<="'.$reservation->check_out.'"');
                    }
                }
                
                if ($reservation->check_out == '' 
                        && $reservation->start_hour == ''){ 
                /*
                 * Change single day.
                 */ 
                    $data = json_decode($day->data);
                    $day_date = $day->day;
                    
                    if ($data->status == 'booked'){
                        $data->available = $history->$day_date->available == '' ? '':$data->available+$reservation->no_items;
                        $data->bind = (int)$history->$day_date->bind;
                        $data->price = (int)$history->$day_date->price;
                        $data->promo = (int)$history->$day_date->promo;
                        $data->status = $history->$day_date->status;
                    }
                    else{
                        if ($data->available != ''){
                            $data->available = $data->available+$reservation->no_items;
                        }
                    }
                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day_date));
                }
                else if ($reservation->check_out != ''){  
                /*
                 * Change multiple days.
                 */                
                    foreach ($days as $key => $day){
                        $data = json_decode($day->data);
                        $day_date = $day->day;

                        if ($data->status == 'booked'){
                            $data->available = $history->$day_date->available == '' ? '':$data->available+$reservation->no_items;
                            $data->bind = (int)$history->$day_date->bind;
                            $data->price = (int)$history->$day_date->price;
                            $data->promo = (int)$history->$day_date->promo;
                            $data->status = $history->$day_date->status;
                        }
                        else{
                            if ($data->available != ''){
                                $data->available = $data->available+$reservation->no_items;
                            }
                        }
                        $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                             array('calendar_id' => $reservation->calendar_id, 
                                                                   'day' => $day_date));
                    }
                }
                else if ($reservation->start_hour != '' 
                            && $reservation->end_hour == ''){ 
                /*
                 * Change single hour.
                 */
                    $data = json_decode($day->data);
                    $hour_time = $reservation->start_hour;
                    $hour = $data->hours->$hour_time;
                    
                    if ($hour->status == 'booked'){
                        $hour->available = $history->$hour_time->available == '' ? '':$hour->available+$reservation->no_items;
                        $hour->bind = (int)$history->$hour_time->bind;
                        $hour->price = (int)$history->$hour_time->price;
                        $hour->promo = (int)$history->$hour_time->promo;
                        $hour->status = $history->$hour_time->status;
                    }
                    else{
                        if ($hour->available != ''){
                            $hour->available = $hour->available+$reservation->no_items;
                        }
                    }

                    $data->hours->$hour_time = $hour;
                    
                    $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                         array('calendar_id' => $reservation->calendar_id, 
                                                               'day' => $day->day));
                    
                    if ($settings->days_details_from_hours == 'true'){
                        $this->setDayFromHours($reservation->calendar_id, 
                                               $day->day);
                    }
                }
                else if ($reservation->end_hour != ''){ 
                /*
                 * Change multiple hours.
                 */
                    $data = json_decode($day->data);

                    foreach ($data->hours as $key => $item){
                        if ($reservation->start_hour <= $key &&
                                ((($settings->hours_add_last_hour_to_total_price == 'false' 
                                                        || $settings->hours_interval_enabled == 'true') 
                                                && $key < $reservation->end_hour) || 
                                        ($settings->hours_add_last_hour_to_total_price == 'true' 
                                                        && $settings->hours_interval_enabled == 'false' 
                                                        && $key <= $reservation->end_hour))){
                            $hour_time = $key;
                            $hour = $data->hours->$hour_time;

                            if ($hour->status == 'booked'){
                                $hour->available = $history->$hour_time->available == '' ? '':$hour->available+$reservation->no_items;
                                $hour->bind = (int)$history->$hour_time->bind;
                                $hour->price = (int)$history->$hour_time->price;
                                $hour->promo = (int)$history->$hour_time->promo;
                                $hour->status = $history->$hour_time->status;
                            }
                            else{
                                if ($hour->available != ''){
                                    $hour->available = $hour->available+$reservation->no_items;
                                }
                            }

                            $data->hours->$hour_time = $hour;
                        }

                        $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                             array('calendar_id' => $reservation->calendar_id, 
                                                                   'day' => $day->day));
                        
                        if ($settings->days_details_from_hours == 'true'){
                            $this->setDayFromHours($reservation->calendar_id,
                                                   $day->day);
                        }
                    }
                }
                
                $this->clean();
                $this->setAvailability($reservation->calendar_id);
            }
            
            /*
             * Set day data from hours data.
             * 
             * @param caledar_id (integer): calendar ID
             * @param day (string): selected day in YYYY-MM-DD format
             */
            function setDayFromHours($calendar_id, 
                                     $day){
                global $wpdb;
                global $DOPBSP;
                
                $day_data = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$calendar_id.' AND day="'.$day.'"');
                $data = json_decode($day_data->data);
                
                $available = 0;
                $price = '';
                $status = 'none';

                foreach ($data->hours as $hour){
                    if ($hour->bind == 0 
                            || $hour->bind == 1){
                        /*
                         * Check availability.
                         */
                        if ($hour->available != ''){
                            $available += $hour->available;
                        }

                        /*
                         * Check price.
                         */
                        if ($hour->price != '' 
                                && ($price == '' 
                                        || (float)$hour->price < $price)){
                            $price = (float)$hour->price;
                        }

                        if ($hour->promo != '' 
                                && ($price == '' 
                                        || (float)$hour->promo < $price)){
                            $price = (float)$hour->promo;
                        }

                        /*
                         * Check status 
                         */
                        if ($hour->status == 'unavailable' 
                                && $status == 'none'){
                            $status = 'unavailable';
                        }

                        if ($hour->status == 'booked' 
                                && ($status == 'none' 
                                        || $status == 'unavailable')){
                            $status = 'booked';
                        }

                        if ($hour->status == 'special' 
                                && ($status == 'none' 
                                        || $status == 'unavailable' 
                                        || $status == 'booked')){
                            $status = 'special';
                        }

                        if ($hour->status == 'available'){
                            $status = 'available';
                        }
                    }
                }
                
                $data->available = $available == 0 ? '':$available;
                $data->price = $price;
                $data->status = $status;
                
                $wpdb->update($DOPBSP->tables->days, array('data' => json_encode($data)), 
                                                     array('calendar_id' => $calendar_id, 
                                                           'day' => $day));
            }
            
            /*
             * Delete calendar schedule.
             * 
             * @post id (integer): calendar ID
             * @post schedule (string): calendar data
             */
            function delete(){
                global $wpdb;
                global $DOPBSP;

                $id = $_POST['id'];
                $schedule = json_decode(stripslashes($_POST['schedule']));
                
                $query = array();

                while ($data = current($schedule)){
                    $day = key($schedule);
                    array_push($query, 'day="'.$day.'"');                
                    next($schedule);                        
                }
                $wpdb->query('DELETE FROM '.$DOPBSP->tables->days.' WHERE calendar_id="'.$id.'" AND ('.implode(' OR ', $query).')');
                $this->setMaxYear($id);

                die();
            }
            
            /*
             * Clean database by past days data.
             */
            function clean(){
                global $wpdb;
                global $DOPBSP;
                
                $wpdb->query('DELETE FROM '.$DOPBSP->tables->days.' WHERE day < \''.date('Y-m-d').'\'');
            }
            
            /*
             * Get all days between 2 dates.
             * 
             * @param check_in (string): check in day in "YYYY-MM-DD" format
             * @param check_out (string): check out day in "YYYY-MM-DD" format
             * 
             * @return array of days
             */
            function getDays($check_in,
                             $check_out){
                $days = array();
                
                $ci_year = substr($check_in, 0, 4);
                $ci_month = substr($check_in, 5, 2);
                $ci_day = substr($check_in, 8, 2);
                
                $co_year = substr($check_out, 0, 4);
                $co_month = substr($check_out, 5, 2);
                $co_day = substr($check_out, 8, 2);

                $ci = mktime(1, 0, 0, $ci_month, $ci_day, $ci_year);
                $co = mktime(1, 0, 0, $co_month, $co_day, $co_year);

                if ($co >= $ci){
                    /*
                     * First day.
                     */
                    array_push($days, date('Y-m-d', $ci));

                    /*
                     * Create the rest of the days
                     */
                    while ($ci < $co){
                        $ci += 86400;
                        array_push($days, date('Y-m-d', $ci));
                    }
                }
                return $days;
            }
            
            /*
             * Check if days are available.
             * 
             * @param calendar_id (integer): calendar ID
             * @param check_in (string): check in day in "YYYY-MM-DD" format
             * @param check_out (string): check out day in "YYYY-MM-DD" format
             * @param no_items (integer): no of booked items
             * 
             * @return true/false
             */
            function validateDays($calendar_id,
                                  $check_in,
                                  $check_out,
                                  $no_items = 1){
                global $wpdb;
                global $DOPBSP;
                
                $check_out = $check_out == '' ? $check_in:$check_out;
                
                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$calendar_id);
                
                $selected_days = $this->getDays($check_in,
                                                $check_out);
                
                for ($i=0; $i<count($selected_days)-($settings->days_morning_check_out == 'true' ? 1:0); $i++){
                    $day = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$calendar_id.' AND day="'.$selected_days[$i].'"');
                    
                    $day_data = json_decode($day->data);
                    
                    if ($day_data->status != 'available'
                            && $day_data->status != 'special'
                            || ($day_data->available != '' && $no_items > $day_data->available)
                            || ($day_data->available == '' && $no_items > 1)){
                        return false;
                    }
                }
                
                return true;
            }
            
            /*
             * Check if reservations (days) do not overlap.
             * 
             * @param calendar_id (integer): calendar ID
             * @param reservations (array): a list of reservations to be verified
             * 
             * @return true/false
             */
            function validateDaysOverlap($calendar_id,
                                         $reservations){
                global $wpdb;
                global $DOPBSP;
                
                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$calendar_id);
                $days = array();
                
                for ($i=0; $i<count($reservations); $i++){
                    $check_in = $reservations[$i]->check_in;
                    $check_out = $reservations[$i]->check_out == '' ? $reservations[$i]->check_in:$reservations[$i]->check_out;
                    $no_items = $reservations[$i]->no_items;
                    
                    if ($this->validateDays($calendar_id, $check_in, $check_out, $no_items)){
                        $selected_days = $this->getDays($check_in,
                                                        $check_out);

                        for ($j=0; $j<count($selected_days)-($settings->days_morning_check_out == 'true' ? 1:0); $j++){
                            if (!isset($days[$selected_days[$j]])){
                                $day = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$calendar_id.' AND day="'.$selected_days[$j].'"');
                                $days[$selected_days[$j]] = json_decode($day->data);
                            }

                            $day_data = $days[$selected_days[$j]];

                            if ($day_data->status != 'available'
                                    && $day_data->status != 'special'
                                    || ($day_data->available != '' && $no_items > $day_data->available)
                                    || ($day_data->available == '' && $no_items > 1)){
                                return false;
                            }
                            else{
                                if ($day_data->available == '' 
                                        || (int)$day_data->available < 1){
                                    $available = 1;
                                }
                                else{
                                    $available = $day_data->available;
                                }

                                if ($available-$no_items == 0){
                                    $days[$selected_days[$j]]->status = 'booked';
                                }
                                $days[$selected_days[$j]]->available = $available-$no_items;
                            }
                        }
                    }
                }
                
                return true;
            }
            
            /*
             * Check if hours are available.
             * 
             * @param calendar_id (integer): calendar ID
             * @param reservations (array): a list of reservations to be verified
             * 
             * @return true/false
             */
            function validateHours($calendar_id,
                                   $day,
                                   $start_hour,
                                   $end_hour,
                                   $no_items = 1){
                global $wpdb;
                global $DOPBSP;
                
                $end_hour = $end_hour == '' ? $start_hour:$end_hour;
                
                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$calendar_id);
                $day = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$calendar_id.' AND day="'.$day.'"');
                
                $day_data = json_decode($day->data);
                
                foreach ($day_data->hours as $key => $hour){
                    if ($start_hour <= $key 
                            && ((($settings->hours_add_last_hour_to_total_price == 'false' 
                                                    || $settings->hours_interval_enabled == 'true') 
                                            && $key < $end_hour) || 
                                    ($settings->hours_add_last_hour_to_total_price == 'true' 
                                                    && $settings->hours_interval_enabled == 'false' 
                                                    && $key <= $end_hour))
                            && ($hour->status != 'available'
                                    && $hour->status != 'special'
                                    || ($hour->available != '' && $no_items > $hour->available)
                                    || ($hour->available == '' && $no_items > 1))){
                        return false;
                    }
                }
                
                return true;
            }
            
            /*
             * Check if reservations (hours) do not overlap.
             * 
             * @param calendar_id (integer): calendar ID
             * @param reservations (array): a list of reservations to be verified
             * 
             * @return true/false
             */
            function validateHoursOverlap($calendar_id,
                                          $reservations){
                global $wpdb;
                global $DOPBSP;
                
                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$calendar_id);
                $days = array();
                
                for ($i=0; $i<count($reservations); $i++){
                    $day = $reservations[$i]->check_in;
                    $start_hour = $reservations[$i]->start_hour;
                    $end_hour = $reservations[$i]->end_hour == '' ? $reservations[$i]->start_hour:$reservations[$i]->end_hour;
                    $no_items = $reservations[$i]->no_items;
                    
                    if ($this->validateHours($calendar_id, $day, $start_hour, $end_hour, $no_items)){
                        if (!isset($days[$day])){
                            $day_result = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$calendar_id.' AND day="'.$day.'"');
                            $days[$day] = json_decode($day_result->data);
                        }

                        $day_data = $days[$day];

                        foreach ($day_data->hours as $key => $hour){
                            if ($start_hour <= $key 
                                    && ((($settings->hours_add_last_hour_to_total_price == 'false' 
                                                            || $settings->hours_interval_enabled == 'true') 
                                                    && $key < $end_hour) || 
                                            ($settings->hours_add_last_hour_to_total_price == 'true' 
                                                            && $settings->hours_interval_enabled == 'false' 
                                                            && $key <= $end_hour))
                                    && ($hour->status != 'available'
                                            && $hour->status != 'special'
                                            || ($hour->available != '' && $no_items > $hour->available)
                                            || ($hour->available == '' && $no_items > 1))){
                                return false;
                            }
                            else{
                                if ($hour->available == '' 
                                        || (int)$hour->available < 1){
                                    $available = 1;
                                }
                                else{
                                    $available = (int)$hour->available;
                                }

                                if ($available-$no_items == 0){
                                    $hour->status = 'booked';
                                }

                                $hour->available = $available-$no_items;

                                $days[$day]->hours->$key = $hour;
                            }
                        }
                    }
                }
                
                return true;
            }
        }
    }