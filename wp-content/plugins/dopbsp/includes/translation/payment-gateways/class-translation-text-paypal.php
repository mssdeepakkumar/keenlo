<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/payment-gateways/class-translation-text-paypal.php
* File Version            : 1.0
* Created / Last Modified : 10 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO settings PayPal translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextPayPal')){
        class DOPBSPTranslationTextPayPal{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextPayPal(){
                /*
                 * Initialize settings text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'settings'));
                add_filter('dopbsp_filter_translation', array(&$this, 'settingsHelp'));
                
                /*
                 * Initialize order text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'order'));
                
                /*
                 * Initialize email text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'email'));
            }
            
            /*
             * PayPal settings text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settings($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'parent' => '',
                                        'text' => 'Settings - PayPal'));
               
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Enable PayPal payment'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_USERNAME',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal API user name'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_PASSWORD',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal API password'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SIGNATURE',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal API signature'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_CREDIT_CARD',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Enable PayPal credit card payment'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_ENABLED',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Enable PayPal sandbox'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REDIRECT',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Redirect after payment'));
                /*
                 * Notifications
                 */     
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_ADMIN',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal - Notify admin'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_USER',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'PayPal - Notify user'));
                
                return $lang;
            }
            
            /*
             * PayPal settings help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function settingsHelp($lang){
                array_push($lang, array('key' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'parent' => '',
                                        'text' => 'Settings - PayPal - Help'));
                
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Default value: Disabled. Allow users to pay with PayPal. The period is instantly booked.'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_USERNAME_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter PayPal API credentials user name. View documentation to see from were you can get them.'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_PASSWORD_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter PayPal API credentials password. View documentation to see from were you can get them.'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SIGNATURE_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter PayPal API credentials signature. View documentation to see from were you can get them.'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_CREDIT_CARD_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Default value: Disabled. Enable so that users can pay directly with their credit card.'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SANDBOX_ENABLED_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Default value: Disabled. Enable to use PayPal sandbox features.'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_REDIRECT_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enter the URL where to redirect after the payment has been completed. Leave it blank to redirect back to the calendar.'));
                /*
                 * Notifications
                 */
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_ADMIN_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enable to send an email notification to admin on book request payed with PayPal.'));
                array_push($lang, array('key' => 'SETTINGS_PAYMENT_GATEWAYS_PAYPAL_SEND_USER_HELP',
                                        'parent' => 'PARENT_SETTINGS_PAYMENT_GATEWAYS_PAYPAL_HELP',
                                        'text' => 'Enable to send an email notification to user on book request payed with PayPal.'));
                
                return $lang;
            }

            /*
             * PayPal order text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function order($lang){
                array_push($lang, array('key' => 'PARENT_ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'parent' => '',
                                        'text' => 'Order - PayPal'));
                /*
                 * Payment method.
                 */
                array_push($lang, array('key' => 'ORDER_PAYMENT_METHOD_PAYPAL',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'PayPal'));
                /*
                 * Front end.
                 */
                array_push($lang, array('key' => 'ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'parent' => 'PARENT_ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Pay on PayPal (instant booking)',
                                        'de' => 'Bezahlung mit PayPal',
                                        'nl' => 'Betaal via PayPal (direct boeken)',
                                        'fr' => 'Payer sur PayPal (réservation instantanée)',
                                        'pl' => 'Pay on PayPal (instant booking)'));
                array_push($lang, array('key' => 'ORDER_PAYMENT_GATEWAYS_PAYPAL_SUCCESS',
                                        'parent' => 'PARENT_ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'Your payment was approved and services are booked.',
                                        'de' => 'Ihre zahlung wurde akzeptiert und die leistungen sind gebucht.',
                                        'nl' => 'Uw betaling is goedgekeurd en de diensten zijn geboekt.',
                                        'fr' => 'Votre paiement a été approuvé et vos services sont réservés.',
                                        'pl' => 'Płatność została zaakceptowana i rezerwacj potwierdzona.')); 
                array_push($lang, array('key' => 'ORDER_PAYMENT_GATEWAYS_PAYPAL_ERROR',
                                        'parent' => 'PARENT_ORDER_PAYMENT_GATEWAYS_PAYPAL',
                                        'text' => 'There was an error while processing PayPal payment. Please try again.',
                                        'de' => 'Es gab einen fehler während der Paypal-bezahlung. Bitte versuchen Sie es erneut.',
                                        'nl' => 'Er is een fout opgetreden tijdens het verwerken van PayPal-betaling. Probeer het opnieuw.',
                                        'fr' => 'Il y a eu une erreur lors du traitement de paiement PayPal. Veuillez essayer à nouveau.',
                                        'pl' => 'Wystapił bład podczas płatności, prosimy spróbować ponownie.'));
                
                return $lang;
            }

            /*
             * PayPal email text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function email($lang){
                array_push($lang, array('key' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'parent' => '',
                                        'text' => 'Email templates - PayPal default messages'));
                /*
                 * Admin
                 */
                array_push($lang, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_PAYPAL_ADMIN',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'PayPal admin notification'));
                array_push($lang, array('key' => 'EMAILS_DEFAULT_PAYPAL_ADMIN_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'You received a booking request.',
                                        'de' => 'Sie haben eine buchungsanfrage erhalten.',
                                        'nl' => 'U heeft een boekingsaanvraag ontvangen',
                                        'fr' => 'Vous avez reçu une demande de réservation.',
                                        'pl' => 'Otrzymałeś nową rezerwację.'));
                array_push($lang, array('key' => 'EMAILS_DEFAULT_PAYPAL_ADMIN',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'Below are the details. Payment has been done via PayPal and the period has been booked.',
                                        'de' => 'Details finden sie nachfolgend. Es wurde mit PayPal bezahlt und der zeitraum wurde gebucht.',
                                        'nl' => 'Hieronder staan de gegevens. De betaling is gedaan via PayPal en de periode is geboekt.',
                                        'fr' => 'Voici les détails. Le paiement a été effectué via PayPal et la période a été réservée.',
                                        'pl' => 'Szczegóły zamówienia, rezerwacja została opłacona i termin zarezerwowany.'));
                /*
                 * User
                 */
                array_push($lang, array('key' => 'EMAILS_EMAIL_TEMPLATE_SELECT_PAYPAL_USER',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'PayPal user notification'));
                array_push($lang, array('key' => 'EMAILS_DEFAULT_PAYPAL_USER_SUBJECT',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'Your booking request has been sent.',
                                        'de' => 'Ihre Buchungsanfrage wurde versendet.',
                                        'nl' => 'Uw boekingsverzoek is verzonden.',
                                        'fr' => 'Votre demande de réservation a été envoyée.',
                                        'pl' => 'Zamówienie została wysłane.'));
                array_push($lang, array('key' => 'EMAILS_DEFAULT_PAYPAL_USER',
                                        'parent' => 'PARENT_EMAILS_DEFAULT_PAYPAL',
                                        'text' => 'The period has been book. Below are the details.',
                                        'de' => 'Der zeitraum wurde gebucht. Details finden sie nachfolgend.',
                                        'nl' => 'De periode is geboekt. Hieronder staan de gegevens.',
                                        'fr' => 'La période a été réservée. Voici les détails.',
                                        'pl' => 'Termin został zarezerwowany.'));
                
                return $lang;
            }
        }
    }