<?php

/*
* Title                   : DOP Prototypes (PHP class)
* Version                 : 1.0
* File                    : dop-prototypes.php
* File Version            : 1.0
* Created / Last Modified : 26 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2014 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : List of general functions that we use at Dot on Paper.
* Licence                 : MIT
*/

    if (!class_exists('DOPPrototypes')){
        class DOPPrototypes{
            /*
             * Constructor
             */
            function DOPPrototypes(){
            }
            
/*
 * Date/time 
 */
            
            /*
             * Converts time to AM/PM format.
             * 
             * @param $time (string): time that will returned in format HH:MM
             * 
             * @return time to AM/PM format
             */
            function getAMPM($time){
                $time_pieces = explode(':', $time);
                $hour = (int)$time_pieces[0];
                $minutes = $time_pieces[1];
                $result = '';

                if ($hour == 0){
                    $result = '12';
                }
                else if ($hour > 12){
                    $result = $this->getLeadingZero($hour-12);
                }
                else{
                    $result = $this->getLeadingZero($hour);
                }

                $result .= ':'.$minutes.' '.($hour < 12 ? 'AM':'PM');

                return $result;
            }
            
            /*
             * Get hours list.
             * 
             * @param start_hour (string): start hour
             * @param end_hour (integer): end hour
             * @param diff (integer): difference between hours in minutes
             * 
             * @return array with hours
             */
            function getHours($start_hour = '00:00',
                              $end_hour = '23:59',
                              $diff = 5){
                $hours = array();
                $hour = '';
                $curr_hour = 0;
                $curr_minute = 0;
                
                array_push($hours, $start_hour);
                
                while ($hour < $end_hour && $hour < '23:59'){
                    $curr_minute += $diff;
                    
                    if ($curr_minute >= 60){
                        $curr_hour++;
                        $curr_minute = $curr_minute-60;
                    }
                    
                    $hour = $this->getLeadingZero($curr_hour).':'.$this->getLeadingZero($curr_minute);
                    $hour = $hour == '24:00' ? '23:59':$hour;
                    $hour >= $start_hour ? array_push($hours, $hour):'';
                }
                
                return $hours;
            }
            
            /*
             * Returns date in requested format.
             * 
             * @param $date (string): date that will be returned in format YYYY-MM-DD
             * @param $type (string): '1' for american ([month name] DD, YYYY)
             *                      : '2' for european (DD [month name] YYYY)
             * 
             * @return date to format
             */
            function setDateToFormat($date, 
                                     $type, 
                                     $month_names = array('January',
                                                          'February',
                                                          'March',
                                                          'April',
                                                          'May',
                                                          'June',
                                                          'July',
                                                          'August',
                                                          'September',
                                                          'October',
                                                          'November',
                                                          'December')){
                $dayPieces = explode('-', $date);

                if ($type == '1'){
                    return $month_names[(int)$dayPieces[1]-1].' '.$dayPieces[2].', '.$dayPieces[0];
                }
                else{
                    return $dayPieces[2].' '.$month_names[(int)$dayPieces[1]-1].' '.$dayPieces[0];
                }
            }
  
/*
 * String & numbers            
 */
    
            /*
             * Adds a leading 0 if number smaller than 10.
             * 
             * @param no (number): the number
             * 
             * @return number with leading 0 if needed
             */
            function getLeadingZero($no){
                if ($no < 10){
                    return '0'.$no;
                }
                else{
                    return $no;
                }
            }
            
            /*
             * Creates a string with random characters.
             * 
             * @param string_length (Number): the length of the returned string
             * @param allowed_characters (String): the string of allowed characters
             * 
             * @return random string
             */
            function getRandomString($string_length,
                                     $allowed_characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz'){
                $random_string = '';

                for ($i=0; $i<$string_length; $i++){
                    $characters_position = mt_rand(1, strlen($allowed_characters))-1;
                    $random_string .= $allowed_characters[$characters_position];
                }
                
                return $random_string;
            }
            
            /*
             * Returns a number with a predefined number of decimals.
             * 
             * @param number (float): the number
             * @param no (integer): the number of decimals
             * 
             * @return string with number and decimals
             */
            function getWithDecimals($number, 
                                     $no = 2){
                return (int)$number == $number ? (string)$number:number_format($number, $no, '.', '');
            }
            
            /*
             * Email validation.
             * 
             * @param email (string): email to be checked
             * 
             * @return true/false
             */
            function validEmail($email){
                if (preg_match("/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is", $email)){
                    return true;
                }
                else{
                    return false;
                }
            }        
        }
    }