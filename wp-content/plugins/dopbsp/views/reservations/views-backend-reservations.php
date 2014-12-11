<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/reservations/views-backend-reservations.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end reservations views class.
*/

    if (!class_exists('DOPBSPViewsReservations')){
        class DOPBSPViewsReservations extends DOPBSPViews{
            /*
             * Constructor
             */
            function DOPBSPViewsReservations(){
            }
            
            /*
             * Returns reservations template.
             * 
             * @param args (array): function arguments
             * 
             * @return reservations HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!--
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE').' - '.$DOPBSP->text('RESERVATIONS_TITLE')); ?>
        <input type="hidden" name="DOPBSP-discount-ID" id="DOPBSP-discount-ID" value="" />
        
<!--
    Content
-->
        <div class="main">
            <table class="content-wrapper">
                <colgroup>
                    <col id="DOPBSP-col-column1" class="column1 reservations" />
                    <col id="DOPBSP-col-column-separator1" class="separator" />
                    <col id="DOPBSP-col-column2" class="column2" />
                    <col id="DOPBSP-col-column-separator2" class="separator" />
                    <col id="DOPBSP-col-column3" class="column3" />
                </colgroup>
                <tbody>
                    <tr>
                        <td class="column" id="DOPBSP-column1">
                            <div class="column-header">
                                <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('RESERVATIONS_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>                           
                                <br class="DOPBSP-clear" />
                            </div>
                            <div class="column-content">
<?php
                $this->filters();
?>                    
                            </div>
                        </td>
                        <td id="DOPBSP-column-separator1" class="separator"></td>
                        <td id="DOPBSP-column2" class="column">
                            <div class="column-header">&nbsp;</div>
                            <div class="column-content">&nbsp;</div>
                        </td>
                        <td id="DOPBSP-column-separator2" class="separator"></td>
                        <td id="DOPBSP-column3" class="column">
                            <div class="column-header">&nbsp;</div>
                            <div class="column-content">&nbsp;</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>       
<?php
            }
            
            /*
             * Returns filters template.
             * 
             * @return filters HTML
             */
            function filters(){
                global $DOPBSP;
                
                $this->getTranslation();
                $hours = $DOPBSP->classes->prototypes->getHours('00:00',
                                                                '24:00',
                                                                60);
?>                        
                                <!--
                                    General filters.
                                -->
                                <div id="DOPBSP-inputs-reservations-filters-calendars" class="inputs-wrapper">
                                    <!--
                                        Calendars list.
                                    -->
                                    <div class="input-wrapper">
                                        <label for="DOPBSP-calendar-ID"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_CALENDAR'); ?></label>
                                        <select name="DOPBSP-calendar-ID" id="DOPBSP-calendar-ID" onchange="DOPBSPReservations.display()">
                                            <?php echo $this->listCalendars(); ?>
                                        </select>
                                        <script type="text/JavaScript">
                                            jQuery('#DOPBSP-calendar-ID').DOPSelect();
                                        </script>
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_CALENDAR_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>

                                    <!--
                                        View
                                    -->
                                    <div class="input-wrapper last">
                                        <label>&nbsp;</label>
                                        <a href="javascript:DOPBSPReservationsList.display()" class="button reservations-list-button">
                                            <span class="info"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_VIEW_LIST'); ?></span>
                                        </a>
                                        <a href="javascript:DOPBSPReservationsCalendar.display()" class="button reservations-calendar-button" style="display: none;">
                                            <span class="info"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_VIEW_CALENDAR'); ?></span>
                                        </a>
                                        <a href="javascript:DOPBSPReservationsAdd.display()" class="button reservations-add-button">
                                            <span class="info"><?php echo $DOPBSP->text('RESERVATIONS_RESERVATION_ADD'); ?></span>
                                        </a>
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help">
                                            <span class="info help">
                                                <?php echo $DOPBSP->text('RESERVATIONS_FILTERS_VIEW_LIST_HELP'); ?>
                                                <br /><br />
                                                <?php echo $DOPBSP->text('RESERVATIONS_FILTERS_VIEW_CALENDAR_HELP'); ?>
                                                <br /><br />
                                                <?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                
                                <!--
                                    Period
                                -->
                                <div class="inputs-header hide">
                                    <h3><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_PERIOD'); ?></h3>
                                    <a href="javascript:DOPBSP.toggleInputs('reservations-filters-period')" id="DOPBSP-inputs-button-reservations-filters-period" class="button"></a>
                                </div>
                                <div id="DOPBSP-inputs-reservations-filters-period" class="inputs-wrapper">
                                
                                    <!--
                                        Start date.
                                    -->
                                    <div class="input-wrapper data">
                                        <label for="DOPBSP-reservations-start-date"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_START_DAY'); ?></label>
                                        <input type="text" name="DOPBSP-reservations-start-date" id="DOPBSP-reservations-start-date" class="DOPBSP-left" value="" onchange="DOPBSPReservationsList.get()" />
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_START_DAY_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>
                                
                                    <!--
                                        End date.
                                    -->
                                    <div class="input-wrapper data">
                                        <label for="DOPBSP-reservations-end-date"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_END_DAY'); ?></label>
                                        <input type="text" name="DOPBSP-reservations-end-date" id="DOPBSP-reservations-end-date" class="DOPBSP-left" value="" onchange="DOPBSPReservationsList.get()" />
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_END_DAY_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>
<?php
                /*
                 * Start hour.
                 */
                $this->displaySelectInput(array('id' => 'start-hour',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_START_HOUR'),
                                                'value' => '00:00',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_START_HOUR_HELP'),
                                                'options' => implode(';;', $hours),
                                                'options_values' => implode(';;', $hours),
                                                'container_class' => '',
                                                'input_class' => 'hour'));
                /*
                 * End hour.
                 */
                $this->displaySelectInput(array('id' => 'end-hour',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_END_HOUR'),
                                                'value' => '23:59',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_END_HOUR_HELP'),
                                                'options' => implode(';;', $hours),
                                                'options_values' => implode(';;', $hours),
                                                'container_class' => 'last',
                                                'input_class' => 'hour'));
?>                
                                </div>
                                
                                <!--
                                    Period
                                -->
                                <div class="inputs-header hide">
                                    <h3><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS'); ?></h3>
                                    <a href="javascript:DOPBSP.toggleInputs('reservations-filters-status')" id="DOPBSP-inputs-button-reservations-filters-status" class="button"></a>
                                </div>
                                <div id="DOPBSP-inputs-reservations-filters-status" class="inputs-wrapper">
                                    <div class="input-wrapper last">
                                        <label><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_LABEL'); ?></label>
                                        <div class="checkboxes-wrapper">
                                            <!--
                                                Pending
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-pending" id="DOPBSP-reservations-pending" onclick="DOPBSPReservationsList.get()" />
                                            <label class="for-checkbox" id="DOPBSP-reservations-pending-label" for="DOPBSP-reservations-pending"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_PENDING'); ?></label>
                                            <br class="DOPBSP-clear" />
                                            <!--
                                                Approved
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-approved" id="DOPBSP-reservations-approved" onclick="DOPBSPReservationsList.get()" />
                                            <label class="for-checkbox" id="DOPBSP-reservations-approved-label" for="DOPBSP-reservations-approved"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_APPROVED'); ?></label>
                                            <br class="DOPBSP-clear" />
                                            <!--
                                                Rejected
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-rejected" id="DOPBSP-reservations-rejected" onclick="DOPBSPReservationsList.get()" />
                                            <label class="for-checkbox" id="DOPBSP-reservations-rejected-label" for="DOPBSP-reservations-rejected"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_REJECTED'); ?></label>
                                            <br class="DOPBSP-clear" />
                                            <!--
                                                Canceled
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-canceled" id="DOPBSP-reservations-canceled" onclick="DOPBSPReservationsList.get()" />
                                            <label class="for-checkbox" id="DOPBSP-reservations-canceled-label" for="DOPBSP-reservations-canceled"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_CANCELED'); ?></label>
                                            <br class="DOPBSP-clear" />
                                            <!--
                                                Expired
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-expired" id="DOPBSP-reservations-expired" onclick="DOPBSPReservationsList.get()" />
                                            <label class="for-checkbox" id="DOPBSP-reservations-expired-label" for="DOPBSP-reservations-expired"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_EXPIRED'); ?></label>
                                            <br class="DOPBSP-clear" />
                                        </div>
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_STATUS_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>
                                </div>
                                
                                <!--
                                    Payment
                                -->
                                <div class="inputs-header hide">
                                    <h3><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD'); ?></h3>
                                    <a href="javascript:DOPBSP.toggleInputs('reservations-filters-payment')" id="DOPBSP-inputs-button-reservations-filters-payment" class="button"></a>
                                </div>
                                <div id="DOPBSP-inputs-reservations-filters-payment" class="inputs-wrapper">
                                    <div class="input-wrapper last">
                                        <label><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_PAYMENT_LABEL'); ?></label>
                                        <div class="checkboxes-wrapper">  
                                            <!--
                                                None
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-payment-none" id="DOPBSP-reservations-payment-none" onclick="DOPBSPReservationsList.get()" />
                                            <label class="for-checkbox" for="DOPBSP-reservations-payment-none"><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD_NONE'); ?></label>
                                            <br class="DOPBSP-clear" />
                                            <!--
                                                Arrival
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-payment-default" id="DOPBSP-reservations-payment-default" onclick="DOPBSPReservationsList.get()" />
                                            <label class="for-checkbox" for="DOPBSP-reservations-payment-arrival"><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD_ARRIVAL'); ?></label>  
                                            <br class="DOPBSP-clear" />
                                            <!--
                                                WooCommerce
                                            -->
                                            <input type="checkbox" name="DOPBSP-reservations-payment-woocommerce" id="DOPBSP-reservations-payment-woocommerce" onclick="DOPBSPReservationsList.get()" />
                                            <label class="for-checkbox" for="DOPBSP-reservations-payment-woocomemrce"><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD_WOOCOMMERCE'); ?></label>
                                            <br class="DOPBSP-clear" />
                                            <!--
                                                Payment gateways.
                                            -->
<?php
                $pg_list = $DOPBSP->classes->payment_gateways->get();
                
                for ($i=0; $i<count($pg_list); $i++){
                    $pg_id = $pg_list[$i]['id'];
                                        
?>
                                            <input type="checkbox" name="DOPBSP-reservations-payment-<?php echo $pg_id; ?>" id="DOPBSP-reservations-payment-<?php echo $pg_id; ?>" onclick="DOPBSPReservationsList.get()" />
                                            <label class="for-checkbox" for="DOPBSP-reservations-payment-<?php echo $pg_id; ?>"><?php echo $DOPBSP->text('ORDER_PAYMENT_METHOD_'.strtoupper($pg_id)); ?></label>
                                            <br class="DOPBSP-clear" />
<?php                                            
                }
?>
                                        </div>
                                        <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_PAYMENT_HELP'); ?><br /><br /><?php echo $DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                    </div>
                                </div>
                                
                                <!--
                                    Search
                                -->
                                <div class="inputs-header hide last">
                                    <h3><?php echo $DOPBSP->text('RESERVATIONS_FILTERS_SEARCH'); ?></h3>
                                    <a href="javascript:DOPBSP.toggleInputs('reservations-filters-search')" id="DOPBSP-inputs-button-reservations-filters-search" class="button"></a>
                                </div>
                                <div id="DOPBSP-inputs-reservations-filters-search" class="inputs-wrapper last">
<?php
                /*
                 * Search
                 */
                $this->displayTextInput(array('id' => 'search',
                                              'label' => $DOPBSP->text('RESERVATIONS_FILTERS_SEARCH'),
                                              'help' => $DOPBSP->text('RESERVATIONS_FILTERS_SEARCH_HELP')));
                /*
                 * Page
                 */
                $this->displaySelectInput(array('id' => 'page',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_PAGE'),
                                                'value' => '',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_PAGE_HELP'),
                                                'options' => '1',
                                                'options_values' => '1',
                                                'container_class' => '',
                                                'input_class' => 'small'));
                /*
                 * Per page.
                 */
                $this->displaySelectInput(array('id' => 'per-page',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_PER_PAGE'),
                                                'value' => '25',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_PER_PAGE_HELP'),
                                                'options' => '5;;10;;25;;50;;100',
                                                'options_values' => '5;;10;;25;;50;;100',
                                                'container_class' => '',
                                                'input_class' => 'small'));
                /*
                 * Order
                 */
                $this->displaySelectInput(array('id' => 'order',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER'),
                                                'value' => '',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_HELP'),
                                                'options' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_ASCENDING').';;'.
                                                                $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_DESCENDING'),
                                                'options_values' => 'ASC;;DESC'));
                /*
                 * Order by.
                 */
                $this->displaySelectInput(array('id' => 'order-by',
                                                'label' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_BY'),
                                                'value' => '',
                                                'help' => $DOPBSP->text('RESERVATIONS_FILTERS_ORDER_BY_HELP'),
                                                'options' => $DOPBSP->text('SEARCH_CHECK_IN').';;'.
                                                                $DOPBSP->text('SEARCH_CHECK_OUT').';;'.
                                                                $DOPBSP->text('SEARCH_START_HOUR').';;'.
                                                                $DOPBSP->text('SEARCH_END_HOUR').';;'.
                                                                'ID;;'.
                                                                $DOPBSP->text('RESERVATIONS_RESERVATION_STATUS').';;'.
                                                                $DOPBSP->text('RESERVATIONS_RESERVATION_DATE_CREATED'),
                                                'options_values' => 'check_in;;check_out;;start_hour;;end_hour;;id;;status;;date_created',
                                                'container_class' => 'last'));
?>      
                                </div>
<?php                
            }
            
            /*
             * Returns reservations list template.
             * 
             * @param reservations (array): reservations list
             * 
             * @return list HTML
             */
            function displayList($reservations){
                global $DOPBSP;
                
?>
                <ul class="reservations-list">
<?php
                /*
                 * Check if reservations exist.
                 */
                if (count($reservations) > 0){
                    foreach ($reservations as $reservation){
                        $DOPBSP->views->reservation->template(array('reservation' => $reservation));
                    }
                }
                else{
?>                    
                    <li class="no-data"><?php echo $DOPBSP->text('RESERVATIONS_NO_RESERVATIONS'); ?></li>
<?php                    
                }
?>
                </ul>    
<?php
            }
            
/*
 * Inputs.
 */
            /*
             * Create a text input field for filters.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * settings_id (integer): settings ID
             *                      * help (string): field help
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return text input HTML
             */
            function displayTextInput($args){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-reservations-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-reservations-'.$id.'" id="DOPBSP-reservations-'.$id.'" class="DOPBSP-left '.$input_class.'" value="" onkeyup="if ((event.keyCode||event.which) != 9){DOPBSPReservationsList.get();}" onpaste="DOPBSPReservationsList.get()" onblur="DOPBSPReservationsList.get()" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            /*
             * Create a drop down field for filters.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field default value
             *                      * help (string): field help
             *                      * options (string): options labels
             *                      * options_values (string): options values
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return drop down HTML
             */
            function displaySelectInput($args){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $help = $args['help'];
                $options = $args['options'];
                $options_values = $args['options_values'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                
                $html = array();
                $options_data = explode(';;', $options);
                $options_values_data = explode(';;', $options_values);
                
                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-reservations-'.$id.'">'.$label.'</label>');
                array_push($html, '     <select name="DOPBSP-reservations-'.$id.'" id="DOPBSP-reservations-'.$id.'" class="DOPBSP-left '.$input_class.'" onchange="DOPBSPReservationsList.get('.($id == 'page' ? 'false':'').')">');
                
                for ($i=0; $i<count($options_data); $i++){
                    if ($value != $options_values_data[$i]){
                        array_push($html, '     <option value="'.$options_values_data[$i].'">'.$options_data[$i].'</option>');
                    }
                    else{
                        array_push($html, '     <option value="'.$options_values_data[$i].'" selected="selected">'.$options_data[$i].'</option>');
                    }
                }
                array_push($html, '     </select>');
                array_push($html, '     <script type="text/JavaScript">jQuery(\'#DOPBSP-reservations-'.$id.'\').DOPSelect();</script>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                
                echo implode('', $html);
            }
            
            /*
             * List calendars in drop down.
             * 
             * @return calendars list
             */
            function listCalendars(){
                global $wpdb;
                global $DOPBSP;
                                    
                $html_calendars = array();
                $ids_calendars = array();
                $no_calendars = 0;
                
                /*
                 * If curent user is an administrator and can view all calendars get all calendars.
                 */
                if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                    $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' ORDER BY id ASC');
                    $no_calendars = $wpdb->num_rows;
                }
                else{
                    /*
                     * If current user can use the booking system get the calendars he created.
                     */
                    if ($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-booking-system')){
                        $calendars = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE user_id='.wp_get_current_user()->ID.' ORDER BY id ASC');
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
                           $calendars_assigned = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE id IN ('.$calendar_list.') ORDER BY id ASC');   
                        }
                    }
                    else{
                        $calendars_assigned = $calendars;
                    }
                }
                
                /* 
                 * Create calendars list HTML.
                 */
                if ($no_calendars != 0 
                        || (isset($calendars_assigned) 
                                && count($calendars_assigned) != 0)){
                    if ($calendars){
                        foreach ($calendars as $calendar){
                            array_push($ids_calendars, $calendar->id);
                            
                            if (isset($calendars_found)){
                                if (!in_array($calendar->id, $calendars_found)){
                                    array_push($html_calendars, '<option value="'.$calendar->id.'">ID: '.$calendar->id.' - '.$calendar->name.'</option>');
                                }
                            }
                            
                            if($DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'view-all-calendars')){
                              array_push($html_calendars, '<option value="'.$calendar->id.'">ID: '.$calendar->id.' - '.$calendar->name.'</option>');  
                            }
                        }
                    }
                    
                    if (isset($calendars_assigned)){
                        foreach ($calendars_assigned as $calendar) {
                            array_push($html_calendars, '<option value="'.$calendar->id.'">ID: '.$calendar->id.' - '.$calendar->name.'</option>');
                        }
                    }
                }
                
                return (count($ids_calendars) > 1 ? '<option value="'.implode(',', $ids_calendars).'">'.$DOPBSP->text('RESERVATIONS_FILTERS_CALENDAR_ALL').'</option>':'').
                       implode('', $html_calendars);
            }
        }
    }