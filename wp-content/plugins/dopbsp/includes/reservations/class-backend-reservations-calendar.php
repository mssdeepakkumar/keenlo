<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/reservations/class-backend-reservations.php
* File Version            : 1.0
* Created / Last Modified : 15 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations PHP class.
*/

    if (!class_exists('DOPBSPBackEndReservationsCalendar')){
        class DOPBSPBackEndReservationsCalendar extends DOPBSPBackEndReservations{
            /*
             * Constructor.
             */
            function DOPBSPBackEndReservationsCalendar(){
            }

            /*
             * Get calendar settings
             */
            function getJSON(){
                global $DOPBSP;

                $settings = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id=%d',
                                                          $_POST['calendar_id']));

                if ($_POST['view'] == 'calendar'){
                    $data = array('AddtMonthViewText' => $DOPBSP->text('ADD_MONTH_VIEW'),
                                  'AdultsLabel' => $DOPBSP->text('RESERVATIONS_NO_ADULTS_LABEL'),
                                  'ButtonApproveLabel' => $DOPBSP->text('RESERVATIONS_APPROVE_LABEL'),
                                  'ButtonCancelLabel' => $DOPBSP->text('RESERVATIONS_CANCEL_LABEL'),
                                  'ButtonCloseLabel' => $DOPBSP->text('RESERVATIONS_CLOSE_LABEL'),
                                  'ButtonDeleteLabel' => $DOPBSP->text('RESERVATIONS_DELETE_LABEL'),
                                  'ButtonJumpToDayLabel' => $DOPBSP->text('RESERVATIONS_JUMP_TO_DAY_LABEL'),
                                  'ButtonRejectLabel' => $DOPBSP->text('RESERVATIONS_REJECT_LABEL'),
                                  'CheckInLabel' => $DOPBSP->text('RESERVATIONS_CHECK_IN_LABEL'),
                                  'CheckOutLabel' => $DOPBSP->text('RESERVATIONS_CHECK_OUT_LABEL'),
                                  'ChildrenLabel' => $DOPBSP->text('RESERVATIONS_NO_CHILDREN_LABEL'),
                                  'ClikToEditLabel' => $DOPBSP->text('CLICK_TO_EDIT_LABEL'),
                                  'Currency' => $DOPBSP->classes->currencies->get($settings->currency),
                                  'DateCreatedLabel' => $DOPBSP->text('RESERVATIONS_DATE_CREATED_LABEL'),
                                  'DateType' => $settings->date_type,
                                  'DayNames' => array($DOPBSP->text('DAY_SUNDAY'), 
                                                      $DOPBSP->text('DAY_MONDAY'), 
                                                      $DOPBSP->text('DAY_TUESDAY'), 
                                                      $DOPBSP->text('DAY_WEDNESDAY'), 
                                                      $DOPBSP->text('DAY_THURSDAY'), 
                                                      $DOPBSP->text('DAY_FRIDAY'), 
                                                      $DOPBSP->text('DAY_SATURDAY')),
                                  'DepositLabel' => $DOPBSP->text('RESERVATIONS_DEPOSIT_PRICE_LABEL'),
                                  'DiscountLabel' => $DOPBSP->text('RESERVATIONS_DISCOUNT_PRICE_LABEL'),
                                  'DiscountInfoLabel' => $DOPBSP->text('RESERVATIONS_DISCOUNT_PRICE_TEXT'),
                                  'FirstDay' => $settings->first_day,
                                  'HourEndLabel' => $DOPBSP->text('RESERVATIONS_END_HOURS_LABEL'),
                                  'HoursAMPM' => $settings->hours_ampm,
                                  'HoursEnabled' => $settings->hours_enabled,
                                  'HourStartLabel' => $DOPBSP->text('RESERVATIONS_START_HOURS_LABEL'),
                                  'ID' => $_POST['calendar_id'],
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
                                  'NextMonthText' => $DOPBSP->text('NEXT_MONTH'),
                                  'NoItemsLabel' => $DOPBSP->text('RESERVATIONS_NO_ITEMS_LABEL'),
                                  'PaymentMethodArrivalEnabled' => $settings->payment_arrival_enabled,
                                  'PaymentMethodLabel' => $DOPBSP->text('RESERVATIONS_PAYMENT_METHOD_LABEL'),
                                  'PaymentMethodPayPalEnabled' => $settings->payment_paypal_enabled,
                                  'PeopleLabel' => $DOPBSP->text('RESERVATIONS_NO_PEOPLE_LABEL'),
                                  'PreviousMonthText' => $DOPBSP->text('PREVIOUS_MONTH'),
                                  'PriceLabel' => $DOPBSP->text('RESERVATIONS_PRICE_LABEL'),
                                  'Reinitialize' => true,
                                  'RemoveMonthViewText' => $DOPBSP->text('REMOVE_MONTH_VIEW'),
                                  'StatusApprovedLabel' => $DOPBSP->text('RESERVATIONS_STATUS_APPROVED'),
                                  'StatusCanceledLabel' => $DOPBSP->text('RESERVATIONS_STATUS_CANCELED'),
                                  'StatusExpiredLabel' => $DOPBSP->text('RESERVATIONS_STATUS_EXPIRED'),
                                  'StatusLabel' => $DOPBSP->text('RESERVATIONS_STATUS_LABEL'),
                                  'StatusPendingLabel' => $DOPBSP->text('RESERVATIONS_STATUS_PENDING'),
                                  'StatusRejectedLabel' => $DOPBSP->text('RESERVATIONS_STATUS_REJECTED'),
                                  'TransactionIDLabel' => $DOPBSP->text('RESERVATIONS_PAYMENT_METHOD_PAYPAL_TRANSACTION_ID_LABEL'));
                }
                else{
                    $form = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->forms_fields.' WHERE form_id='.$settings->form.' ORDER BY position');
                    $language = $DOPBSP->classes->translation->get();

                    $form_fields = array();
                    
                    foreach ($form as $field){
                        $translation = json_decode(stripslashes($field->translation));
                        $field->name = $field->translation;
                        $field->translation = $translation->$language;

                        if ($field->type == 'text'){
                            array_push($form_fields, $field);
                        }
                    }
             
                    $data = array('DateType' => $settings->date_type,
                                  'DayNames' => array($DOPBSP->text('DAY_SUNDAY'), 
                                                      $DOPBSP->text('DAY_MONDAY'), 
                                                      $DOPBSP->text('DAY_TUESDAY'),
                                                      $DOPBSP->text('DAY_WEDNESDAY'), 
                                                      $DOPBSP->text('DAY_THURSDAY'), 
                                                      $DOPBSP->text('DAY_FRIDAY'), 
                                                      $DOPBSP->text('DAY_SATURDAY')),
                                  'DayShortNames' => array($DOPBSP->text('SHORT_DAY_SUNDAY'), 
                                                           $DOPBSP->text('SHORT_DAY_MONDAY'), 
                                                           $DOPBSP->text('SHORT_DAY_TUESDAY'), 
                                                           $DOPBSP->text('SHORT_DAY_WEDNESDAY'), 
                                                           $DOPBSP->text('SHORT_DAY_THURSDAY'), 
                                                           $DOPBSP->text('SHORT_DAY_FRIDAY'), 
                                                           $DOPBSP->text('SHORT_DAY_SATURDAY')),
                                  'FirstDay' => $settings->days_first,
                                  'Form' => $form_fields,
                                  'HoursAMPM' => $settings->hours_ampm,
                                  'HoursEnabled' => $settings->hours_enabled,
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
                                  'MonthShortNames' => array($DOPBSP->text('SHORT_MONTH_JANUARY'), 
                                                             $DOPBSP->text('SHORT_MONTH_FEBRUARY'), 
                                                             $DOPBSP->text('SHORT_MONTH_MARCH'), 
                                                             $DOPBSP->text('SHORT_MONTH_APRIL'), 
                                                             $DOPBSP->text('SHORT_MONTH_MAY'), 
                                                             $DOPBSP->text('SHORT_MONTH_JUNE'), 
                                                             $DOPBSP->text('SHORT_MONTH_JULY'), 
                                                             $DOPBSP->text('SHORT_MONTH_AUGUST'), 
                                                             $DOPBSP->text('SHORT_MONTH_SEPTEMBER'), 
                                                             $DOPBSP->text('SHORT_MONTH_OCTOBER'), 
                                                             $DOPBSP->text('SHORT_MONTH_NOVEMBER'), 
                                                             $DOPBSP->text('SHORT_MONTH_DECEMBER')),
                                  'MultipleDaysSelect' => $settings->days_multiple_select,
                                  'MultipleHoursSelect' => $settings->hours_multiple_select,
                                  'NoReservations' => $wpdb->num_rows,
                                  'PaymentMethodArrivalEnabled' => $settings->payment_arrival_enabled,
                                  'PaymentMethodPayPalEnabled' => $settings->payment_paypal_enabled);
                }
                
                echo json_encode($data);
                
                die();
            }
          
            /*
             * Search & get reservations in JSON format.
             */
            function get(){
                global $wpdb;
                global $DOPBSP;
                
                $calendar_id = $_POST['calendar_id'];
                
                $query = 'SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE'.($calendar_id != 0 ? ' calendar_id="'.$calendar_id.'"':'');
                $query .= ($calendar_id != 0 ? ' AND':'').' status <> "expired" ORDER BY check_in ASC, start_hour ASC';
                
                $reservations = $wpdb->get_results($query);
                echo json_encode($reservations);
                
            	die();      
            }
        }
    }