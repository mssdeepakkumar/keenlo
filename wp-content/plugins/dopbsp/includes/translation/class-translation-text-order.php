<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-order.php
* File Version            : 1.0
* Created / Last Modified : 15 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO order translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextOrder')){
        class DOPBSPTranslationTextOrder{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextOrder(){
                /*
                 * Initialize order text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'order'));
            }

            /*
             * Order text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function order($lang){
                array_push($lang, array('key' => 'PARENT_ORDER',
                                        'parent' => '',
                                        'text' => 'Order'));
                
                array_push($lang, array('key' => 'ORDER_TITLE',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Order'));
                array_push($lang, array('key' => 'ORDER_UNAVAILABLE',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'The period you selected is not available anymore. The calendar will refresh to update the schedule.'));
                array_push($lang, array('key' => 'ORDER_UNAVAILABLE_COUPON',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'The coupon you entered is not available anymore.'));
                /*
                 * Payment methods.
                 */
                array_push($lang, array('key' => 'ORDER_PAYMENT_METHOD',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Payment method'));
                array_push($lang, array('key' => 'ORDER_PAYMENT_METHOD_NONE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'None'));
                array_push($lang, array('key' => 'ORDER_PAYMENT_METHOD_ARRIVAL',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'On arrival'));
                array_push($lang, array('key' => 'ORDER_PAYMENT_METHOD_WOOCOMMERCE',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'WooCommerce'));
                array_push($lang, array('key' => 'ORDER_PAYMENT_METHOD_WOOCOMMERCE_ORDER_ID',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Order ID'));
                array_push($lang, array('key' => 'ORDER_PAYMENT_METHOD_TRANSACTION_ID',
                                        'parent' => 'PARENT_RESERVATIONS_RESERVATION',
                                        'text' => 'Transaction ID',
                                        'de' => 'Transaktions ID',
                                        'nl' => 'Transactie ID',
                                        'fr' => 'ID de tansaction',
                                        'pl' => 'Transaction ID'));
                /*
                 * Front end.
                 */
                array_push($lang, array('key' => 'ORDER_PAYMENT_ARRIVAL',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Pay on arrival (need to be approved)',
                                        'de' => 'Zahlung bei ankunft (muss genehmigt werden)',
                                        'nl' => 'Betaling na bevestiging',
                                        'fr' => 'Payer à l<<single-quote>>arrivée (besoin d<<single-quote>>être approuvé)')); 
                array_push($lang, array('key' => 'ORDER_PAYMENT_ARRIVAL_WITH_APPROVAL',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Pay on arrival (instant booking)',
                                        'nl' => 'Betaling na bevestiging (direct boeken)',
                                        'fr' => 'Payer à l<<single-quote>>arrivée (réservation instantanée)',
                                        'pl' => 'Pay on arrival (need to be approved)')); 
                array_push($lang, array('key' => 'ORDER_PAYMENT_ARRIVAL_SUCCESS',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Your request has been successfully sent. Please wait for approval.',
                                        'de' => 'Ihre anfrage wurde erfolgreich übermittelt. Bitte warten sie auf ihre bestätigung.',
                                        'nl' => 'Uw aanvraag is succesvol verzonden. U ontvangt z.s.m. een reactie.',
                                        'fr' => 'Votre demande a bien été envoyé. Veuillez attendre l<<single-quote>>approbation.',
                                        'pl' => 'Państwa rezerwacja została wysłana, prosimy czekać na potwierdzenie.'));
                array_push($lang, array('key' => 'ORDER_PAYMENT_ARRIVAL_WITH_APPROVAL_SUCCESS',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Your request has been successfully received. We are waiting you!',
                                        'de' => 'Wir haben ihre buchung erhalten. Wir freuen uns auf sie!',
                                        'nl' => 'Your request has been successfully received. We are waiting you!',
                                        'fr' => 'Votre demande a bien été reçue. Nous vous attendons!',
                                        'pl' => 'Państwa rezerwacja została potwierdzona, dziękujemy!'));
                
                array_push($lang, array('key' => 'ORDER_TERMS_AND_CONDITIONS',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'I accept to agree to the Terms & Conditions.',
                                        'de' => 'Ich akzeptiere die AGB.',
                                        'nl' => 'Ik accepteer de algemene voorwaarden.',
                                        'fr' => 'Je m<<single-quote>>engage à accepter les Termes & Conditions.',
                                        'pl' => 'Akceptuję regulamin.'));
                array_push($lang, array('key' => 'ORDER_TERMS_AND_CONDITIONS_INVALID',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'You must agree with our Terms & Conditions to continue.',
                                        'de' => 'Sie müssen unseren AGB zustimmen, um fortfahren zu können.',
                                        'nl' => 'U moet de algemene voorwaarden accepteren om door te gaan.',
                                        'fr' => 'Vous devez accepter nos Termes & Conditions pour continuer.',
                                        'pl' => 'Proszę zaakceptować regulamin.'));
                
                array_push($lang, array('key' => 'ORDER_BOOK',
                                        'parent' => 'PARENT_ORDER',
                                        'text' => 'Book now',
                                        'de' => 'Jetzt buchen',
                                        'nl' => 'Reserveer nu',
                                        'fr' => 'Réserver maintenant',
                                        'pl' => 'Rezerwuj teraz'));
                
                return $lang;
            }
        }
    }