<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/views-backend-translation.php
* File Version            : 1.0
* Created / Last Modified : 29 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end translation views class.
*/

    if (!class_exists('DOPBSPViewsTranslation')){
        class DOPBSPViewsTranslation extends DOPBSPViews{
            /*
             * Constructor
             */
            function DOPBSPViewsTranslation(){
            }
            
            /*
             * Returns translation template.
             * 
             * @return translation HTML page
             */
            function template(){
                global $wpdb;
                global $DOPBSP;
                
                $text_groups_options_HTML = array();
                
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">

<!--
    Header
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE').' - '.$DOPBSP->text('TRANSLATION_TITLE')); ?>

<!--
    Content
-->
        <div class="main">
            <div class="translation-header">
                
                <!-- 
                    Buttons
                -->
                <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help DOPBSP-right"><span class="info help"><?php echo $DOPBSP->text('TRANSLATION_HELP').'<br /><br />'.$DOPBSP->text('TRANSLATION_SEARCH_HELP').'<br /><br />'.$DOPBSP->text('TRANSLATION_MANAGE_LANGUAGES_HELP').'<br /><br />'.$DOPBSP->text('TRANSLATION_RESET_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                <input type="button" name="DOPBSP-translation-check" id="DOPBSP-translation-check" class="DOPBSP-right" value="Check translation" onclick="DOPBSPTranslation.check()" />
                <input type="button" name="DOPBSP-translation-reset" id="DOPBSP-translation-reset" class="DOPBSP-right" value="<?php echo $DOPBSP->text('TRANSLATION_RESET'); ?>" onclick="DOPBSP.confirmation('TRANSLATION_RESET_CONFIRMATION', 'DOPBSPTranslation.reset()')" />
                <input type="button" name="DOPBSP-translation-manage-languages" id="DOPBSP-translation-manage-languages" class="DOPBSP-right" value="<?php echo $DOPBSP->text('TRANSLATION_MANAGE_LANGUAGES'); ?>" onclick="DOPBSPTranslation.displayLanguages()" />
                <input type="button" name="DOPBSP-translation-manage-translation" id="DOPBSP-translation-manage-translation" value="<?php echo $DOPBSP->text('TRANSLATION_SUBMIT'); ?>" onclick="DOPBSPTranslation.display()" />
                
                <!-- 
                    Language select.
                -->
                <div id="DOPBSP-translation-manage-language" class="input-wrapper DOPBSP-left">
                    <label for="DOPBSP-translation-language"><?php echo $DOPBSP->text('TRANSLATION_LANGUAGE'); ?></label>
                    <?php echo  $this->getLanguages('DOPBSP-translation-language',
                                                    'DOPBSPTranslation.display()',
                                                    '',
                                                    'DOPBSP-left'); ?>
                </div>
                
                <!-- 
                    Text group select.
                -->
                <div id="DOPBSP-translation-manage-text-group" class="input-wrapper DOPBSP-left">
                    <label for="DOPBSP-translation-location"><?php echo $DOPBSP->text('TRANSLATION_TEXT_GROUP'); ?></label>
                    <select name="DOPBSP-translation-text-group" id="DOPBSP-translation-text-group" class="DOPBSP-left" onchange="DOPBSPTranslation.display()">
                        <option value="all">All</option>
<?php
                $language = $DOPBSP->classes->translation->get();
                
                $text_groups = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language.' WHERE parent_key="" ORDER BY position ASC');
                
                foreach ($text_groups as $text_group){
                    array_push($text_groups_options_HTML, '<option value="'.$text_group->key_data.'">'.$text_group->translation.'</option>');
                }
                echo implode('', $text_groups_options_HTML);
?>
                    </select>
                    <script type="text/JavaScript">jQuery('#DOPBSP-translation-text-group').DOPSelect();</script>
                </div>
                
                <!-- 
                    Search
                -->
                <div id="DOPBSP-translation-manage-search" class="input-wrapper DOPBSP-left">
                    <label for="DOPBSP-translation-search"><?php echo $DOPBSP->text('TRANSLATION_SEARCH'); ?></label>
                    <input type="text" name="DOPBSP-translation-search" id="DOPBSP-translation-search" class="DOPBSP-left" value="" onkeyup="DOPBSPTranslation.search()" />
                </div>
            </div>
            <div class="translation-content" id="DOPBSP-translation-content"></div>
        </div>
    </div>
<?php
            }
        }
    }