<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-search.php
* File Version            : 1.0
* Created / Last Modified : 13 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO search translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextSearch')){
        class DOPBSPTranslationTextSearch{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextSearch(){
                /*
                 * Initialize search text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'search'));
            }
            
            /*
             * Search text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function search($lang){
                array_push($lang, array('key' => 'PARENT_SEARCH',
                                        'parent' => '',
                                        'text' => 'Search'));
                     
                array_push($lang, array('key' => 'SEARCH_TITLE',
                                        'parent' => 'PARENT_SEARCH',
                                        'text' => 'Search'));
                     
                array_push($lang, array('key' => 'SEARCH_CHECK_IN',
                                        'parent' => 'PARENT_SEARCH',
                                        'text' => 'Check in',
                                        'de' => 'Anreise',
                                        'nl' => 'Check in',
                                        'fr' => 'Arrivée',
                                        'pl' => 'Przyjazd'));
                array_push($lang, array('key' => 'SEARCH_CHECK_OUT',
                                        'parent' => 'PARENT_SEARCH',
                                        'text' => 'Check out',
                                        'de' => 'Abreise',
                                        'nl' => 'Check uit',
                                        'fr' => 'Départ',
                                        'pl' => 'Wyjazd'));
                array_push($lang, array('key' => 'SEARCH_START_HOUR',
                                        'parent' => 'PARENT_SEARCH',
                                        'text' => 'Start at',
                                        'de' => 'Start um',
                                        'nl' => 'Start op',
                                        'fr' => 'Arrivée à',
                                        'pl' => 'Rozpoczęcie')); 
                array_push($lang, array('key' => 'SEARCH_END_HOUR',
                                        'parent' => 'PARENT_SEARCH',
                                        'text' => 'Finish at',
                                        'de' => 'Ende um',
                                        'nl' => 'Eindigd op',
                                        'fr' => 'Départ à',
                                        'pl' => 'Zakończenie'));
                array_push($lang, array('key' => 'SEARCH_NO_ITEMS',
                                        'parent' => 'PARENT_SEARCH',
                                        'text' => 'No book items',
                                        'de' => 'No book items',
                                        'nl' => '# Accomodaties',
                                        'fr' => 'Aucun élément de réservation',
                                        'pl' => 'Brak rezerwacji'));
                array_push($lang, array('key' => 'SEARCH_NO_SERVICES_AVAILABLE',
                                        'parent' => 'PARENT_SEARCH',
                                        'text' => 'There are no services available for the period you selected.',
                                        'de' => 'There are no services available for the period you selected.',
                                        'nl' => 'Er zijn geen er zijn geen diensten beschikbaar voor de periode die u hebt geselecteerd.',
                                        'fr' => 'Il n<<single-quote>>y a pas de services disponibles pour la période que vous avez sélectionné.',
                                        'pl' => 'W wybranych terminie nie posiadamy wolnych miejsc.'));
                array_push($lang, array('key' => 'SEARCH_NO_SERVICES_AVAILABLE_SPLIT_GROUP',
                                        'parent' => 'PARENT_SEARCH',
                                        'text' => 'You cannot add divided groups to a reservation.'));
                
                return $lang;
            }
        }
    }