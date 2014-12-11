<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/calendars/class-backend-calendar.php
* File Version            : 1.0
* Created / Last Modified : 05 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end calendar PHP class.
*/

    if (!class_exists('DOPBSPBackEndCalendar')){
        class DOPBSPBackEndCalendar extends DOPBSPBackEndCalendars{
            /*
             * Constructor
             */
            function DOPBSPBackEndCalendar(){
            }
        
            /*
             * Get custom post calendar ID.
             * 
             * @post post_id (integer): custom post ID
             * 
             * @return calendar ID attached to a custom post
             */
            function getCustomPostCalendarId(){
                global $wpdb;
                global $DOPBSP;
                
                $post_id = $_POST['post_id'];
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE post_id=%d ORDER BY id',
                                                          $post_id));
                echo $calendar->id;
                
                die();
            }

            /* 
             * Returns a JSON with calendar's data & options.
             * 
             * @post id (integer): calendar ID
             * 
             * @return options JSON
             */
            function getOptions(){
                global $wpdb;
                global $DOPBSP;
                
                $id = $_POST['id'];
                $settings = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id=%d', 
                                                          $id));

                $data = array('AddLastHourToTotalPrice' => $settings->hours_add_last_hour_to_total_price,
                              'AddtMonthViewText' => $DOPBSP->text('CALENDARS_CALENDAR_ADD_MONTH_VIEW'),
                              'AvailableDays' => explode(',', $settings->days_available),
                              'AvailableLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_AVAILABLE_LABEL'),
                              'AvailableOneText' => $DOPBSP->text('CALENDARS_CALENDAR_AVAILABLE_ONE_TEXT'),
                              'AvailableText' => $DOPBSP->text('CALENDARS_CALENDAR_AVAILABLE_TEXT'),
                              'BookedText' => $DOPBSP->text('CALENDARS_CALENDAR_BOOKED_TEXT'),
                              'Currency' => $DOPBSP->classes->currencies->get($settings->currency),
                              'DateEndLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_DATE_END_LABEL'),
                              'DateStartLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_DATE_START_LABEL'),
                              'DateType' => 1,
                              'DayNames' => array($DOPBSP->text('DAY_SUNDAY'), 
                                                  $DOPBSP->text('DAY_MONDAY'), 
                                                  $DOPBSP->text('DAY_TUESDAY'), 
                                                  $DOPBSP->text('DAY_WEDNESDAY'), 
                                                  $DOPBSP->text('DAY_THURSDAY'), 
                                                  $DOPBSP->text('DAY_FRIDAY'), 
                                                  $DOPBSP->text('DAY_SATURDAY')),
                              'DetailsFromHours' => $settings->days_details_from_hours,
                              'FirstDay' => $settings->days_first,
                              'HoursEnabled' => $settings->hours_enabled,
                              'GroupDaysLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_GROUP_DAYS_LABEL'),
                              'GroupHoursLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_GROUP_HOURS_LABEL'),
                              'HourEndLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_END_LABEL'),
                              'HourStartLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_START_LABEL'),
                              'HoursAMPM' => $settings->hours_ampm,
                              'HoursDefinitions' => json_decode($settings->hours_definitions),
                              'HoursDefinitionsChangeLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_DEFINITIONS_CHANGE_LABEL'),
                              'HoursDefinitionsLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_DEFINITIONS_LABEL'),
                              'HoursSetDefaultDataLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_SET_DEFAULT_DATA_LABEL'),
                              'HoursIntervalEnabled' => $settings->hours_interval_enabled,
                              'ID' => $id,
                              'InfoLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_INFO_LABEL'),
                              'MaxYear' => $settings->max_year,
                              'MonthNames' => array($DOPBSP->text('MONTH_JANUARY'), 
                                                    $DOPBSP->text('MONTH_FEBRUARY'), 
                                                    $DOPBSP->text('MONTH_MARCH'),
                                                    $DOPBSP->text('MONTH_APRIL'), 
                                                    $DOPBSP->text('MONTH_MAY'), 
                                                    $DOPBSP->text('MONTH_JUNE'), 
                                                    $DOPBSP->text('MONTH_JULY'), 
                                                    $DOPBSP->text('MONTH_AUGUST'), 
                                                    $DOPBSP->text('MONTH_SEPTEMBER'), 
                                                    $DOPBSP->text('MONTH_OCTOBER'), 
                                                    $DOPBSP->text('MONTH_NOVEMBER'), 
                                                    $DOPBSP->text('MONTH_DECEMBER')),
                              'NextMonthText' => $DOPBSP->text('CALENDARS_CALENDAR_NEXT_MONTH'),
                              'NotesLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_HOURS_NOTES_LABEL'),
                              'PreviousMonthText' => $DOPBSP->text('CALENDARS_CALENDAR_PREVIOUS_MONTH'),
                              'PriceLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_PRICE_LABEL'),
                              'PromoLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_PROMO_LABEL'),
                              'RemoveMonthViewText' => $DOPBSP->text('CALENDARS_CALENDAR_REMOVE_MONTH_VIEW'),
                              'ResetConfirmation' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_RESET_CONFIRMATION'),
                              'SetDaysAvailabilityLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_SET_DAYS_AVAILABILITY_LABEL'),
                              'SetHoursAvailabilityLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_SET_HOURS_AVAILABILITY_LABEL'),
                              'SetHoursDefinitionsLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_SET_HOURS_DEFINITIONS_LABEL'),
                              'StatusAvailableText' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_AVAILABLE_TEXT'),
                              'StatusBookedText' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_BOOKED_TEXT'),
                              'StatusLabel' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_LABEL'),
                              'StatusSpecialText' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_SPECIAL_TEXT'),
                              'StatusUnavailableText' => $DOPBSP->text('CALENDARS_CALENDAR_FORM_STATUS_UNAVAILABLE_TEXT'),
                              'UnavailableText' => $DOPBSP->text('CALENDARS_CALENDAR_UNAVAILABLE_TEXT'));

                echo json_encode($data);

                die();
            }
        
            /*
             * Add calendar.
             */
            function add(){
                global $wpdb;
                global $DOPBSP;
                
                /*
                 * Add calendar.
                 */
                $wpdb->insert($DOPBSP->tables->calendars, array('user_id' => wp_get_current_user()->ID,
                                                                'name' => $DOPBSP->text('CALENDARS_ADD_CALENDAR_NAME'),
                                                                'availability' => ''));
                $calendar_id = $wpdb->insert_id;
                /*
                 * Add calendar settings.
                 */
                $wpdb->insert($DOPBSP->tables->settings, array('calendar_id' => $calendar_id,
                                                               'hours_definitions' => '[{"value": "00:00"}]'));
                $settings_id = $wpdb->insert_id;
                $wpdb->insert($DOPBSP->tables->settings_notifications, array('id' => $settings_id,
                                                                             'calendar_id' => $calendar_id));
                $wpdb->insert($DOPBSP->tables->settings_payment, array('id' => $settings_id,
                                                                       'calendar_id' => $calendar_id));
                /*
                 * Display new calendars list.
                 */
                $this->display();

            	die();
            }
            
            /*
             * Edit calendar.
             * 
             * @post field (string): calendars table field
             * @post id (integer): calendar ID
             * @post value (string): the value with which the field will be updated
             */
            function edit(){
                global $wpdb;
                global $DOPBSP;
                
                $field = $_POST['field'];
                $id = $_POST['id'];
                $value = $_POST['value'];
                
                /*
                 * Update calendar field.
                 */
                $wpdb->update($DOPBSP->tables->calendars, array($field => $value), 
                                                          array('id' => $id));
                
                die();
            }

            /*
             * Delete calendar.
             * 
             * @post id (integer): calendar ID
             * 
             * @return number of calendars left
             */
            function delete(){
                global $wpdb;
                global $DOPBSP;

                $id = $_POST['id'];
                
                /*
                 * Delete calendar.
                 */
                $wpdb->delete($DOPBSP->tables->calendars, array('id' => $id));
                
                /*
                 * Delete calendar schedule.
                 */
                $wpdb->delete($DOPBSP->tables->days, array('calendar_id' => $id));
                
                /*
                 * Delete calendar reservations.
                 */
                $wpdb->delete($DOPBSP->tables->reservations, array('calendar_id' => $id));
                
                /*
                 * Delete calendar settings.
                 */
                $wpdb->delete($DOPBSP->tables->settings, array('calendar_id' => $id));
                
                /*
                 * Count the number of remaining calendars.
                 */
                $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id DESC');
                echo $wpdb->num_rows;

            	die();
            }
            
            /*
             * Set calendar maximum available year.
             * 
             * @post id (integer): calendar ID
             */
            function setMaxYear($id){
                global $wpdb;
                global $DOPBSP;
                
                $max_year = $wpdb->get_row('SELECT MAX(year) AS year FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$id); 

                if ($max_year->year > 0){
                    $wpdb->update($DOPBSP->tables->settings, array('max_year' => $max_year->year), 
                                                             array('calendar_id' => $id));
                }
                else{
                    $wpdb->update($DOPBSP->tables->settings, array('max_year' => date('Y')), 
                                                             array('calendar_id' => $id));
                }
            }
            
            /*
             * Set availability indexes for faster search.
             * 
             * @post id (integer): calendar ID
             */
            function setAvailability($id){
                global $wpdb;
                global $DOPBSP;
                
                $min = 1000000000;
                $max = 0;
                $start_date = '';
                $end_date = '';  
                $availability = array();

                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$id);
                $days = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->days.' WHERE calendar_id='.$id.' ORDER BY day');

                foreach ($days as $day):
                    $day_data = json_decode($day->data);
                    
                    if ($settings->hours_enabled == 'false'){
                        if ($day_data->promo != ''){
                            if ($min > $day_data->promo){
                                $min = $day_data->promo;
                            }

                            if ($max < $day_data->promo){
                                $max = $day_data->promo;
                            }
                        }
                        else{
                            if ($day_data->price != ''){
                                if ($min > $day_data->price){
                                    $min = $day_data->price;
                                }

                                if ($max < $day_data->price){
                                    $max = $day_data->price;
                                }
                            }
                        }
                        
                        if ($day_data->status == 'available' 
                                || $day_data->status == 'special'){
                            if ($start_date == ''){
                                $start_date = $day->day;   
                            }

                            if ($end_date == ''){
                                $end_date = $day->day;
                            }

                            if ($end_date < $day->day 
                                    && $day->day == date('Y-m-d', strtotime($end_date.' +1 day'))){
                                $end_date = $day->day;
                            }
                            else if ($end_date != $day->day){
                                array_push($availability, array('start-date' => $start_date,
                                                                'end-date' => $end_date));
                                
                                if ($day_data->status == 'available' 
                                        || $day_data->status == 'special'){
                                    $start_date = $day->day; 
                                    $end_date = $day->day;
                                }
                                else{
                                    $start_date = ''; 
                                    $end_date = '';
                                }
                            }
                        }
                    }
                    else{
                        $start_hour = '';  
                        $end_hour = '';
                        $hours_availability = array();
                            
                        foreach ($day_data->hours as $key => $hour):
                            if ($hour->promo != ''){
                                if ($min > $hour->promo){
                                    $min = $hour->promo;
                                }

                                if ($max < $hour->promo){
                                    $max = $hour->promo;
                                }
                            }
                            else{
                                if ($hour->price != ''){
                                    if ($min > $hour->price){
                                        $min = $hour->price;
                                    }

                                    if ($max < $hour->price){
                                        $max = $hour->price;
                                    }
                                }
                            }
                            
                            if ($hour->status == 'available' 
                                    || $hour->status == 'special'){
                                if ($start_hour == ''){
                                    $start_hour = $key;   
                                }

                                if ($end_hour == ''){
                                    $end_hour = $key;
                                }

                                if ($end_hour < $key 
                                        && $key == $this->getNextHour($end_hour, $day_data->hours_definitions)){
                                    $end_hour = $key;
                                }
                                else if ($end_hour != $key){
                                    array_push($hours_availability, array('start-hour' => $start_hour,
                                                                          'end-hour' => $end_hour));

                                    if ($hour->status == 'available' 
                                            || $hour->status == 'special'){
                                        $start_hour = $key;
                                        $end_hour = $key;
                                    }
                                    else{
                                        $start_hour = '';
                                        $end_hour = '';
                                    }
                                }
                            }
                        endforeach;
                        
                        if ($start_hour != '' 
                                && $end_hour != ''){
                            array_push($hours_availability, array('start-hour' => $start_hour,
                                                                  'end-hour' => $end_hour));
                        }
                        
                        if (count($hours_availability) > 0){
                            array_push($availability, array('date' => $day->day,
                                                            'hours' => $hours_availability));
                        }
                    }
                endforeach;
                
                if ($settings->hours_enabled == 'false' 
                        && $start_date != '' 
                        && $end_date != ''){
                    array_push($availability, array('start-date' => $start_date,
                                                    'end-date' => $end_date));
                }
                
                $wpdb->update($DOPBSP->tables->calendars, array('min_price' => $min,
                                                                'max_price' => $max,
                                                                'availability' => json_encode($availability)), 
                                                          array('id' => $id));
            }
            
            /*
             * Returns next hour reported to an hour in a list of time definitions.
             * 
             * @param hour (string): the hour for which the next hour will be returned
             * @param hours (string): the time definitions list
             * 
             * @return next hour (hh:mm)
             */
            function getNextHour($hour,
                                 $hours){
                $next_hour = '24:00';
                        
                for ($i=count($hours)-1; $i>=0; $i--){
                    if ($hours[$i]->value > $hour){
                        $next_hour = $hours[$i]->value;
                    }
                }
                
                return $next_hour;
            }
        }
    }