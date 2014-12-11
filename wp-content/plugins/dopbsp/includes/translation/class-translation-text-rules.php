<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation-text-rules.php
* File Version            : 1.0
* Created / Last Modified : 14 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO rules translation text PHP class.
*/

    if (!class_exists('DOPBSPTranslationTextRules')){
        class DOPBSPTranslationTextRules{
            /*
             * Constructor
             */
            function DOPBSPTranslationTextRules(){
                /*
                 * Initialize rules text.
                 */
                add_filter('dopbsp_filter_translation', array(&$this, 'rules'));
                
                add_filter('dopbsp_filter_translation', array(&$this, 'rulesRule'));
                add_filter('dopbsp_filter_translation', array(&$this, 'rulesAddRule'));
                add_filter('dopbsp_filter_translation', array(&$this, 'rulesDeleteRule'));
                
                add_filter('dopbsp_filter_translation', array(&$this, 'rulesHelp'));
                
                add_filter('dopbsp_filter_translation', array(&$this, 'rulesFrontEnd'));
            }
            
            /*
             * Rules text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rules($lang){
                array_push($lang, array('key' => 'PARENT_RULES',
                                        'parent' => '',
                                        'text' => 'Rules'));
                
                array_push($lang, array('key' => 'RULES_TITLE',
                                        'parent' => 'PARENT_RULES',
                                        'text' => 'Rules'));
                array_push($lang, array('key' => 'RULES_CREATED_BY',
                                        'parent' => 'PARENT_RULES',
                                        'text' => 'Created by'));
                array_push($lang, array('key' => 'RULES_LOAD_SUCCESS',
                                        'parent' => 'PARENT_RULES',
                                        'text' => 'Rules list loaded.'));
                array_push($lang, array('key' => 'RULES_NO_RULES',
                                        'parent' => 'PARENT_RULES',
                                        'text' => 'No rules. Click the above "plus" icon to add a new one.'));
                
                return $lang;
            }
            
            /*
             * Rules - Rule text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesRule($lang){
                array_push($lang, array('key' => 'PARENT_RULES_RULE',
                                        'parent' => '',
                                        'text' => 'Rules - Rule'));
                
                array_push($lang, array('key' => 'RULES_RULE_NAME',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Name'));
                
                array_push($lang, array('key' => 'RULES_RULE_TIME_LAPSE_MIN',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Minimum time lapse'));
                array_push($lang, array('key' => 'RULES_RULE_TIME_LAPSE_MAX',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Maximum time lapse'));
                
                array_push($lang, array('key' => 'RULES_RULE_LOADED',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Rule loaded.'));
                
                return $lang;
            }
            
            /*
             * Rules - Add rule text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesAddRule($lang){
                array_push($lang, array('key' => 'PARENT_RULES_ADD_RULE',
                                        'parent' => '',
                                        'text' => 'Rules - Add rule'));
                
                array_push($lang, array('key' => 'RULES_ADD_RULE_NAME',
                                        'parent' => 'PARENT_RULES_ADD_RULE',
                                        'text' => 'New rule'));
                array_push($lang, array('key' => 'RULES_ADD_RULE_SUBMIT',
                                        'parent' => 'PARENT_RULES_ADD_RULE',
                                        'text' => 'Add rule'));
                array_push($lang, array('key' => 'RULES_ADD_RULE_ADDING',
                                        'parent' => 'PARENT_RULES_ADD_RULE',
                                        'text' => 'Adding a new rule ...'));
                array_push($lang, array('key' => 'RULES_ADD_RULE_SUCCESS',
                                        'parent' => 'PARENT_RULES_ADD_RULE',
                                        'text' => 'You have succesfully added a new rule.'));
                
                return $lang;
            }
            
            /*
             * Rules - Delete rule text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesDeleteRule($lang){
                array_push($lang, array('key' => 'PARENT_RULES_DELETE_RULE',
                                        'parent' => '',
                                        'text' => 'Rules - Delete rule'));
                
                array_push($lang, array('key' => 'RULES_DELETE_RULE_CONFIRMATION',
                                        'parent' => 'PARENT_RULES_DELETE_RULE',
                                        'text' => 'Are you sure you want to delete this rule?'));
                array_push($lang, array('key' => 'RULES_DELETE_RULE_SUBMIT',
                                        'parent' => 'PARENT_RULES_DELETE_RULE',
                                        'text' => 'Delete rule'));
                array_push($lang, array('key' => 'RULES_DELETE_RULE_DELETING',
                                        'parent' => 'PARENT_RULES_DELETE_RULE',
                                        'text' => 'Deleting rule ...'));
                array_push($lang, array('key' => 'RULES_DELETE_RULE_SUCCESS',
                                        'parent' => 'PARENT_RULES_DELETE_RULE',
                                        'text' => 'You have succesfully deleted the rule.'));
                
                return $lang;
            }
            
            /*
             * Rules - Help text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesHelp($lang){
                array_push($lang, array('key' => 'PARENT_RULES_HELP',
                                        'parent' => '',
                                        'text' => 'Rules - Help'));
                
                array_push($lang, array('key' => 'RULES_HELP',
                                        'parent' => 'PARENT_RULES_HELP',
                                        'text' => 'Click on a rule item to open the editing area.'));
                array_push($lang, array('key' => 'RULES_ADD_RULE_HELP',
                                        'parent' => 'PARENT_RULES_HELP',
                                        'text' => 'Click on the "plus" icon to add a rule.'));
                
                /*
                 * Rule help.
                 */
                array_push($lang, array('key' => 'RULES_RULE_TIME_LAPSE_MIN_HELP',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Enter minimum booking time lapse. Default value is 1.'));
                array_push($lang, array('key' => 'RULES_RULE_TIME_LAPSE_MAX_HELP',
                                        'parent' => 'PARENT_RULES_RULE',
                                        'text' => 'Enter maximum booking time lapse. Add 0 for unlimited period.'));
                
                return $lang;
            }
            
            
            
            /*
             * Rules front end text.
             * 
             * @param lang (array): current translation
             * 
             * @return array with updated translation
             */
            function rulesFrontEnd($lang){
                array_push($lang, array('key' => 'PARENT_RULES_FRONT_END',
                                        'parent' => '',
                                        'text' => 'Rules - Front end'));
                
                array_push($lang, array('key' => 'RULES_FRONT_END_MIN_TIME_LAPSE_DAYS_WARNING',
                                        'parent' => 'PARENT_RULES_FRONT_END',
                                        'text' => 'You need to book a minimum number of %d days.',
                                        'de' => 'Sie müssen zumindest %d tag buchen.',
                                        'nl' => 'U dient een minimaal aantal %d dagen te reserveren.',
                                        'fr' => 'Vous avez besoin de réserver un nombre minimum de %d jours.',
                                        'pl' => 'Oferta dotyczy minimalnej liczby %d dni.'));
                array_push($lang, array('key' => 'RULES_FRONT_END_MAX_TIME_LAPSE_DAYS_WARNING',
                                        'parent' => 'PARENT_RULES_FRONT_END',
                                        'text' => 'You can book only a maximum number of %d days.',
                                        'de' => 'Sie können maximal %d tage buchen.',
                                        'nl' => 'U kunt een maximum aantal %d dagen boeken.',
                                        'fr' => 'Vous avez besoin de réserver un nombre maximum de %d jours.',
                                        'pl' => 'Można zarezerwować tylko max liczbę %d dni.'));
                array_push($lang, array('key' => 'RULES_FRONT_END_MIN_TIME_LAPSE_HOURS_WARNING',
                                        'parent' => 'PARENT_RULES_FRONT_END',
                                        'text' => 'You need to book a minimum number of %d hours.'));
                array_push($lang, array('key' => 'RULES_FRONT_END_MAX_TIME_LAPSE_HOURS_WARNING',
                                        'parent' => 'PARENT_RULES_FRONT_END',
                                        'text' => 'You can book only a maximum number of %d hours.'));
                
                return $lang;
            }
        }
    }