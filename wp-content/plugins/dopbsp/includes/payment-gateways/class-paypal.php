<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/payment-gateways/class-paypal.php
* File Version            : 1.0
* Created / Last Modified : 13 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO front end PHP class.
*/

    if (!class_exists('DOPBSPPayPal')){
        class DOPBSPPayPal extends DOPBSPPaymentGateways{
            /*
             * Private variables.
             */
            private $api_username = '';
            private $api_password = '';
            private $api_signature = '';
            private $api_end_point = '';
            private $credit_card = false;
            private $sandbox = false;
            private $redirect = '';
            
            private $version = '64';
            private $sBN_code = 'PP-ECWizard';
            
            private $currency_code = '';
            private $language = 'en';
            private $payment_amount = 0;
            private $payment_type = 'Sale';
            private $url_cancel = '';
            private $url_paypal = '';
            private $url_return = '';
            
            /*
             * Constructor
             */
            function DOPBSPPayPal(){
                /*
                 * Initialize paypal payment gateway.
                 */
                add_filter('dopbsp_filter_payment_gateways', array(&$this, 'init'));
                
                /*
                 * Pay after a booking request has been made.
                 */
                add_action('dopbsp_action_book_payment', array(&$this, 'pay'));
                
                /*
                 * Initialize payment verification.
                 */
                add_action('init', array(&$this, 'verify'));
            }
            
            /*
             * Initialize PayPal payment gateway.
             */
            function init($payment_gateways){
                array_push($payment_gateways, array('id' => 'paypal'));
                
                return $payment_gateways;
            }
            
            /*
             * Pay with PayPal.
             * 
             * @post calendar_id(integer): calendar ID
             * @post language(string): selected language
             * @post currency(string): currency sign
             * @post currency_code(string): ISO 4217 currency code
             * @post cart_data(array): the cart, list of reservations
             * @post form(object): form data
             * @post payment_method(string): payment method
             * @post page_url(string): the page from were the payment is requested
             */
            function pay(){
                $calendar_id = $_POST['calendar_id'];
                $language = $_POST['language'];
                $currency_code = $_POST['currency_code'];
                $cart = $_POST['cart_data'];
                $payment_method = $_POST['payment_method'];
                $page_url = $_POST['page_url'];
                
                /*
                 * If selected payment method is PayPal access express checkout API.
                 */
                if ($payment_method == 'paypal'){
                    $this->set($calendar_id);
                    $this->expressCheckOut($calendar_id,
                                           $language,
                                           $currency_code,
                                           $cart,
                                           $page_url);
                }
            }
            
            /*
             * Verify if the payment has been successful.
             * 
             * @get dopbsp_pay_action (string): PayPal payment actions
             *                                  "cancel" the user canceled the transaction
             *                                  "payed" the user proceded with payment
             * @get dopbsp_calendar_id (integer): calendar ID
             * @get dopbsp_token (string): cart token
             * @get PayerID (string): payer PayPal ID
             * @get token (string): PayPal transaction token
             */
            function verify(){
                global $wpdb;
                global $DOPBSP;
                
                if (isset($_GET['dopbsp_pay_action'])){
                    $calendar_id = $_GET['dopbsp_calendar_id'];
                    $token = $_GET['dopbsp_token'];

                    $this->set($calendar_id);
                    
                    if ($_GET['dopbsp_pay_action'] == 'payed'){
                        /*
                         * Calculate transaction payment amount.
                         */
                        $reservations = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->reservations.' WHERE token="%s"', 
                                                                          $token));
                        $this->payment_amount = 0;
                        
                        foreach ($reservations as $reservation){
                            $this->payment_amount += ($reservation->discount_price > 0 ? $reservation->discount_price:$reservation->price_total);
                            $this->currency_code = $reservation->currency_code;
                        }
                        
                        /*
                         * Confirm payment and get transaction ID.
                         */
                        $transaction_id = $this->confirm();
                        
                        if ($transaction_id != false){
                            /*
                             * Update status to approved if payment succeeded.
                             */
                            $wpdb->update($DOPBSP->tables->reservations, array('status' => 'approved',
                                                                               'transaction_id' => $transaction_id,
                                                                               'token' => ''), 
                                                                         array('token' => $token));
                            /*
                             * Send notifications if the transaction was successful.
                             */
                            foreach ($reservations as $reservation){
                                $DOPBSP->classes->backend_reservation_notifications->send($reservation->id,
                                                                                          'paypal_admin');
                                $DOPBSP->classes->backend_reservation_notifications->send($reservation->id,
                                                                                          'paypal_user');
                            }
                        }
                        else{
                            /*
                             * Delete the reservations if the payment did not succeed.
                             */
                            $wpdb->delete($DOPBSP->tables->reservations, array('token' => $token));
                        }
                    }
                    else{
                        /*
                         * Delete the reservations if payment process has been canceled.
                         */
                        $wpdb->delete($DOPBSP->tables->reservations, array('token' => $token));
                    }
                    
                    /*
                     * Remove get variables from url.
                     */
                    $page_url = (isset($_SERVER['HTTPS']) ? 'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                    $page_url_pieces =  explode((strpos($page_url, '?dopbsp_pay_action') !== false ? '?':'&').'dopbsp_pay_action', $page_url);
                    header('Location: '.($this->redirect != '' ? $this->redirect:$page_url_pieces[0].(strpos($page_url_pieces[0], '?') !== false ? '&':'?').'dopbsp_payment_success=paypal'));
                }
            }

            /*
             * Set PayPal options.
             * 
             * @param calendar_id(integer): calendar ID
             */
            function set($calendar_id){
                global $wpdb;
                global $DOPBSP;
                
                $settings_payment = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings_payment.' WHERE calendar_id='.$calendar_id);
                
                /*
                 * Set PayPal configuration.
                 */
                $this->api_username = $settings_payment->paypal_username;
                $this->api_password = $settings_payment->paypal_password;
                $this->api_signature = $settings_payment->paypal_signature;
                $this->credit_card = $settings_payment->paypal_credit_card == 'true' ? true:false;
                $this->sandbox = $settings_payment->paypal_sandbox_enabled == 'true' ? true:false;
                $this->redirect = $settings_payment->paypal_redirect;
                
                /*
                 * Set links.
                 */
                if ($this->sandbox == true){
                    $this->api_end_point = 'https://api-3t.sandbox.paypal.com/nvp';
                    $this->url_paypal = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token=';
                }
                else{
                    $this->api_end_point = 'https://api-3t.paypal.com/nvp';
                    $this->url_paypal = 'https://www.paypal.com/cgi-bin/webscr?cmd=_express-checkout&useraction=commit&token=';
                }
            }
            
            /*
             * Initialize PayPal express check out.
             * 
             * @param calendar_id(integer): calendar ID
             * @param language(string): selected language
             * @param currency_code(string): ISO 4217 currency code
             * @param cart(array): the cart, list of reservations
             * @param page_url(string): the page from were the payment is requested
             * 
             * @return error or success redirect link
             */
            function expressCheckOut($calendar_id,
                                     $language,
                                     $currency_code,
                                     $cart,
                                     $page_url){
                global $wpdb;
                global $DOPBSP;
                
                $error = array();
                $url_variables = array();
                
                $settings = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->settings.' WHERE calendar_id='.$calendar_id);
                
                /*
                 * Set payment details.
                 */
                $this->currency_code = $currency_code;
                $this->language = $language;
                
                /*
                 * Set cancel & return links.
                 */
                array_push($url_variables, 'dopbsp_calendar_id='.$calendar_id);
                array_push($url_variables, 'dopbsp_token='.$DOPBSP->vars->payment_token);
                
                $this->url_cancel = urlencode($page_url.(strpos($page_url, '?') !== false ? '&':'?').'dopbsp_pay_action=cancel&'.implode('&', $url_variables));
                $this->url_return = urlencode($page_url.(strpos($page_url, '?') !== false ? '&':'?').'dopbsp_pay_action=payed&'.implode('&', $url_variables));
                
                $call_response = $this->expressCheckOutNVP($cart,
                                                           $settings);
                $ack = strtoupper($call_response['ACK']);

                if ($ack == 'SUCCESS' 
                        || $ack == 'SUCCESSWITHWARNING'){
                    /*
                     * Redirect link.
                     */
                    echo 'success;;;;;'.$this->url_paypal.urlencode($call_response['TOKEN']);
                } 
                else{
                    /*
                     * Error message.
                     */
                    array_push($error, 'Express check out API call failed.');
                    array_push($error, '<br /><strong class="DOPBSPCalendar-strong">Error code:</strong>');
                    array_push($error, urldecode($call_response['L_ERRORCODE0']));
                    array_push($error, '<br /><strong class="DOPBSPCalendar-strong">Error severity code:</strong>');
                    array_push($error, urldecode($call_response['L_SEVERITYCODE0']));
                    array_push($error, '<br /><strong class="DOPBSPCalendar-strong">Detailed error message:</strong>');
                    array_push($error, urldecode($call_response['L_LONGMESSAGE0']).'.');
                    array_push($error, '<br /><strong class="DOPBSPCalendar-strong">Short error message:</strong>');
                    array_push($error, urldecode($call_response['L_SHORTMESSAGE0'].'.'));
                    
                    echo implode('<br />', $error);
                }
            }
            
            /*
             * Set name-value pair for PayPal express check out.
             * 
             * @param cart(array): the cart, list of reservations
             * @param settigns(object): calendar settings
             * 
             * @return response array
             */
            function expressCheckOutNVP($cart,
                                        $settings){
                global $DOPBSP;
                
                $nvp_data = array();

                /*
                 * Set payment details.
                 */    
                for ($i=0; $i<count($cart); $i++){
                    $description = array();
                    $reservation = $cart[$i];
                    
                    /*
                     * Set item description.
                     */
                    array_push($description, $DOPBSP->text('SEARCH_CHECK_IN').': '.$reservation['check_in']);
                    array_push($description, $reservation['check_out'] != '' ? $DOPBSP->text('SEARCH_CHECK_OUT').': '.$reservation['check_out']:'');
                    array_push($description, $reservation['start_hour'] != '' ? $DOPBSP->text('SEARCH_START_HOUR').': '.$reservation['check_out']:'');
                    array_push($description, $reservation['end_hour'] != '' ? $DOPBSP->text('SEARCH_END_HOUR').': '.$reservation['check_out']:'');
                    array_push($description, $settings->sidebar_no_items_enabled == 'true' ? $DOPBSP->text('SEARCH_NO_ITEMS').': '.$reservation['no_items']:'');
                    array_push($description, '...');
                    
                    array_push($nvp_data, '&L_PAYMENTREQUEST_0_NAME'.$i.'='.urlencode($DOPBSP->text('RESERVATIONS_RESERVATION_FRONT_END_TITLE').' #'.($i+1)));
                    array_push($nvp_data, '&L_PAYMENTREQUEST_0_DESC'.$i.'='.urlencode(implode(' ', $description)));
                    array_push($nvp_data, '&L_PAYMENTREQUEST_0_AMT'.$i.'='.((float)$reservation['deposit_price'] > 0 ? $reservation['deposit_price']:$reservation['price_total']));
                    
                    $this->payment_amount += (float)$reservation['deposit_price'] > 0 ? (float)$reservation['deposit_price']:(float)$reservation['price_total'];
                }
                
                /*
                 * Set payment option.
                 */
                array_push($nvp_data, '&PAYMENTREQUEST_0_PAYMENTACTION='.$this->payment_type);
                array_push($nvp_data, '&PAYMENTREQUEST_0_AMT='.$this->payment_amount);
                array_push($nvp_data, '&PAYMENTREQUEST_0_CURRENCYCODE='.$this->currency_code);
                array_push($nvp_data, '&RETURNURL='.$this->url_return);
                array_push($nvp_data, '&CANCELURL='.$this->url_cancel);
                array_push($nvp_data, '&LOCALECODE='.$this->language);

                if ($this->credit_card == 'true'){
                    array_push($nvp_data, '&SOLUTIONTYPE=Sole');
                }

                /*
                 * Make the API call to PayPal.
                 */
                return $this->call('SetExpressCheckout', 
                                   implode('', $nvp_data));
            }

            /*
             * Confirm payment.
             * 
             * @get dopbsp_pay_action (string): PayPal payment actions
             *                                  "cancel" the user canceled the transaction
             *                                  "payed" the user proceded with payment
             * @get dopbsp_calendar_id (integer): calendar ID
             * @get dopbsp_token (string): cart token
             * @get PayerID (string): payer PayPal ID
             * @get token (string): PayPal transaction token
             * 
             * @return false or transaction ID 
             */
            function confirm(){
                $nvp_data = array();
                
                $token = urlencode($_GET['token']);
                $payer_id = urlencode($_GET['PayerID']);
                $server_name = urlencode($_SERVER['SERVER_NAME']);

                array_push($nvp_data, 'TOKEN='.$token);
                array_push($nvp_data, 'PAYERID='.$payer_id);
                array_push($nvp_data, 'PAYMENTREQUEST_0_PAYMENTACTION='.$this->payment_type);
                array_push($nvp_data, 'PAYMENTREQUEST_0_AMT='.$this->payment_amount);
                array_push($nvp_data, 'PAYMENTREQUEST_0_CURRENCYCODE='.$this->currency_code);
                array_push($nvp_data, 'IPADDRESS='.$server_name);
                
                $call_response = $this->call('DoExpressCheckoutPayment',
                                             '&'.implode('&', $nvp_data));
                $ack = strtoupper($call_response['ACK']);
                
                if ($ack == 'SUCCESS' 
                        || $ack == 'SUCCESSWITHWARNING'){
                    return $call_response['PAYMENTINFO_0_TRANSACTIONID'];
                }
                else{
                    return false;
                }
            }
            
            /*
             * Call PayPal API. 
             * 
             * @param method(string): call method
             * @param nvp_data(string): call data
             * 
             * @return response array
             */
            function call($method, 
                          $nvp_data){
                $nvp_req = array();

                /*
                 * Set curl parameters.
                 */
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->api_end_point);
                curl_setopt($ch, CURLOPT_VERBOSE, 1);

                /*
                 * Turn off the server and peer verification (TrustManager Concept).
                 */
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                
                /*
                 * NVP request for submitting to server.
                 */
                array_push($nvp_req, 'METHOD='.urlencode($method));
                array_push($nvp_req, '&VERSION='.urlencode($this->version));
                array_push($nvp_req, '&PWD='.urlencode($this->api_password));
                array_push($nvp_req, '&USER='.urlencode($this->api_username));
                array_push($nvp_req, '&SIGNATURE='.urlencode($this->api_signature));
                array_push($nvp_req, $nvp_data);
                array_push($nvp_req, '&BUTTONSOURCE='.urlencode($this->sBN_code));

                /*
                 * Set NVP request as post field to curl.
                 */
                curl_setopt($ch, CURLOPT_POSTFIELDS, implode('', $nvp_req));

                /*
                 * Get server response.
                 */
                $nvp_response = curl_exec($ch);

                /*
                 * Convert NVP response to an associative array.
                 */
                $response = $this->convertNVPToArray($nvp_response);

                if (curl_errno($ch)){
                    echo curl_error($ch);
                } 
                else{
                    curl_close($ch);
                }

                return $response;
            }
            
            /*
             * Convert PayPal call response from string to array.
             * 
             * @param nvp_response(string): PayPal call response
             * 
             * @return response array
             */
            function convertNVPToArray($nvp_response){
                $intial=0;
                $nvp_array = array();

                while (strlen($nvp_response)){
                    /*
                     * Key postion.
                     */
                    $key_position = strpos($nvp_response, '=');
                    
                    /*
                     * Value position.
                     */
                    $value_position = strpos($nvp_response, '&') ? strpos($nvp_response, '&'):strlen($nvp_response);

                    /*
                     * Get the key and value and store them in an associative array.
                     */
                    $key_value = substr($nvp_response, $intial, $key_position);
                    $value = substr($nvp_response, $key_position+1, $value_position-$key_position-1);
                    
                    /*
                     * Decode the respose.
                     */
                    $nvp_array[urldecode($key_value)] = urldecode($value);
                    $nvp_response = substr($nvp_response, $value_position+1, strlen($nvp_response));
                }

                return $nvp_array;
            }
        }
    }