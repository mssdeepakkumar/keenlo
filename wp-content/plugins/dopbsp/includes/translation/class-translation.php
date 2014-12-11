<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/translation/class-translation.php
* File Version            : 1.0
* Created / Last Modified : 26 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO translation PHP class.
*/

    if (!class_exists('DOPBSPTranslation')){
        class DOPBSPTranslation{
            /*
             * Supported languages, code & name.
             */
            public $languages = array();
            
            /*
             * The text.
             */
            private $lang = array();
            
            /*
             * Constructor
             */
            function DOPBSPTranslation(){
                /*
                 * Get languages list.
                 */
                $this->languages = apply_filters('dopbsp_filter_languages', $this->languages);
                        
                /*
                 * Initialize text if it has not been done.
                 */     
                if (count($this->lang) == 0){
                    $this->setText();
                }
                
                /*
                 * Reset database translation.
                 */
                if (DOPBSP_CONFIG_REPAIR_TRANSLATION_DATABASE){
                    $this->reset();
                }
            }
            
            /*
             * Prints out the translation page.
             * 
             * @return translation HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->translation->template();
            }
            
            /*
             * Set translation text.
             */
            function setText(){
                /*
                 * 1. Initialize general text.
                 */
                new DOPBSPTranslationTextGeneral();
                
                /*
                 * 2. Initialize dashboard text.
                 */
                new DOPBSPTranslationTextDashboard();
                
                /*
                 * 3. Initialize calendars text.
                 */
                new DOPBSPTranslationTextCalendars();
                
                /*
                 * 4. Initialize events text.
                 */
                new DOPBSPTranslationTextEvents();
                
                /*
                 * 5. Initialize reservations text.
                 */
                new DOPBSPTranslationTextReservations();
                
                /*
                 * 6. Initialize locations text.
                 */
                new DOPBSPTranslationTextLocations();
                
                /*
                 * 7. Initialize rules text.
                 */
                new DOPBSPTranslationTextRules();
                
                /*
                 * 8. Initialize extras text.
                 */
                new DOPBSPTranslationTextExtras();
                
                /*
                 * 9. Initialize discounts text.
                 */
                new DOPBSPTranslationTextDiscounts();
                
                /*
                 * 10. Initialize fees text.
                 */
                new DOPBSPTranslationTextFees();
                
                /*
                 * 11. Initialize coupons text.
                 */
                new DOPBSPTranslationTextCoupons();
                
                /*
                 * 12. Initialize forms text.
                 */
                new DOPBSPTranslationTextForms();
                
                /*
                 * 13. Initialize templates text.
                 */
                new DOPBSPTranslationTextTemplates();
                
                /*
                 * 14. Initialize emails text.
                 */
                new DOPBSPTranslationTextEmails();
                
                /*
                 * 15. Initialize translation text.
                 */
                new DOPBSPTranslationTextTranslation();
                
                /*
                 * 16. Initialize settings text.
                 */
                new DOPBSPTranslationTextSettings();
                
                /*
                 * 17. Initialize PayPal text.
                 */
                new DOPBSPTranslationTextPayPal();
                
                /*
                 * 18. Initialize WooCommerce text.
                 */
                new DOPBSPTranslationTextWooCommerce();
                
                /*
                 * 19. Initialize custom posts text.
                 */
                new DOPBSPTranslationTextCustomPosts();
                
                /*
                 * 20. Initialize widgets text.
                 */
                new DOPBSPTranslationTextWidgets();
                
                /*
                 * 21. Initialize search text.
                 */
                new DOPBSPTranslationTextSearch();
                
                /*
                 * 22. Initialize cart text.
                 */
                new DOPBSPTranslationTextCart();
                
                /*
                 * 23. Initialize order text.
                 */
                new DOPBSPTranslationTextOrder();
                
                $this->lang = apply_filters('dopbsp_filter_translation', $this->lang);
            }
            
            /*
             * Initialize/update database content.
             * 
             * @param lang_code (string): language code, default "all"
             */
            function setDatabase($lang_code = 'all'){
                global $wpdb;
                global $DOPBSP;
                
                $query_values = array();
                $languages_codes = array();
                
                /*
                 * Add languages to database.
                 */
                if ($lang_code == 'all'){
                    $control_data = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->languages);

                    if ($wpdb->num_rows == 0){
                        for ($i=0; $i<count($this->languages); $i++){
                            array_push($query_values, '(\''.$this->languages[$i]['name'].'\', \''.$this->languages[$i]['code'].'\', \''.(strpos(DOPBSP_CONFIG_TRANSLATION_LANGUAGES_TO_INSTALL, $this->languages[$i]['code']) !== false ? 'true':'false').'\')');
                        }

                        if (count($query_values) > 0){
                            $wpdb->query('INSERT INTO '.$DOPBSP->tables->languages.' (name, code, enabled) VALUES '.implode(', ', $query_values));
                        }
                    }

                    $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');

                    foreach ($languages as $language){
                        array_push($languages_codes, $language->code);
                    }
                }
                else{
                    array_push($languages_codes, $lang_code);
                }
                
                /*
                 * Check what text should be added or not to database.
                 */
                for ($i=0; $i<count($this->lang); $i++){
                    $control_data = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->translation.'_'.($lang_code == 'all' ? DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE:$lang_code).' WHERE key_data="'.$this->lang[$i]['key'].'"');

                    if ($wpdb->num_rows == 0){
                        $this->lang[$i]['add'] = true;
                    }
                    else{
                        $this->lang[$i]['add'] = false;
                    }
                }
                
                /*
                 *  Add data to database.
                 */
                for ($l=0; $l<count($languages_codes); $l++){
                    unset($query_values);
                    $query_values = array();
                            
                    for ($i=0; $i<count($this->lang); $i++){
                        if ($this->lang[$i]['add']){
                            array_push($query_values, '(\''.$this->lang[$i]['key'].'\', \''.($i+1).'\', \''.$this->lang[$i]['parent'].'\', \''.$this->lang[$i]['text'].'\', \''.(isset($this->lang[$i][$languages_codes[$l]]) ? $this->lang[$i][$languages_codes[$l]]:$this->lang[$i]['text']).'\')');
                        }
                    }
                    
                    if (count($query_values) > 0){
                        $wpdb->query('INSERT INTO '.$DOPBSP->tables->translation.'_'.$languages_codes[$l].' (key_data, position, parent_key, text_data, translation) VALUES '.implode(', ', $query_values));
                    }
                }
            }
            
            /*
             * Reset translation database.
             */
            function reset(){
                global $wpdb;
                global $DOPBSP;
                
                $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages);
                
                /*
                 * Delete or empty translation tables.
                 */
                foreach ($languages as $language){
                    if ($language->enabled == 'true'){
                        $wpdb->query('TRUNCATE TABLE '.$DOPBSP->tables->translation.'_'.$language->code);
                    }
                    else{
                        $wpdb->query('DROP TABLE IF EXISTS '.$DOPBSP->tables->translation.'_'.$language->code);
                    }
                }
                
                /*
                 * Reinitialize database content.
                 */
                $this->setDatabase();
                
                if (isset($_POST['ajax_request'])){
                    die();
                }
            }
            
            /*
             * Set PHP translation constants.
             * 
             * @param language (string): language code to be used, default "DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE"
             */
            function setTranslation($language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE){
                global $wpdb;
                global $DOPBSP;
                /*
                 * Get back end language.
                 */
                if (is_admin()){
                    $language = $this->get();
                }
                
                $translation = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language);
                
                foreach ($translation as $item){
                    $DOPBSP->vars->translation_text[$item->key_data] = str_replace('<<single-quote>>', "'", stripslashes($item->translation));
                }
            }
            
            /*
             * Change back end translation.
             * 
             * @post language (string): language in which the back end translation will be changed
             */
            function change(){
                $user_id = wp_get_current_user()->ID;
                $language = $_POST['language'];
                $current_backend_language = get_user_meta($user_id, 'DOPBSP_backend_language', true);
                
                if ($current_backend_language == ''){
                    add_user_meta($user_id, 'DOPBSP_backend_language', $language, true);
                }
                else{
                    update_user_meta($user_id, 'DOPBSP_backend_language', $language);
                }
                
                die();
            }
            
            /*
             * Get back end language.
             * 
             * @return backend language
             */
            function get(){
                $user_id = wp_get_current_user()->ID;
                        
                if (!is_network_admin() 
                        && $user_id != 0){
                    $language = get_user_meta($user_id, 'DOPBSP_backend_language', true);

                    if ($language == ''){
                        add_user_meta($user_id, 'DOPBSP_backend_language', DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE, true);
                        $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE;
                    }
                }
                else{
                    $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE;
                }
                
                return $language;
            }
            
            /*
             * Display translation.
             * 
             * @post language (string): language (code) to be displayed
             * @post text_group (string): text group to be displayed
             * 
             * @return HTML translations list
             */
            function display(){
                global $wpdb;
                global $DOPBSP;
                
                $HTML = array();
                $language = $_POST['language'];
                $text_group = $_POST['text_group'];
                
                if ($text_group == 'all'){
                    $translation = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language.' ORDER BY position ASC');
                }
                else{
                    $translation = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language.' WHERE parent_key="%s" OR key_data="%s" ORDER BY position ASC',
                                                                     $text_group, $text_group));
                }
                
                array_push($HTML, '<table class="translation">');
                array_push($HTML, '  <colgroup>');
                array_push($HTML, '      <col />');
                array_push($HTML, '      <col class="separator" />');
                array_push($HTML, '      <col />');
                array_push($HTML, '  </colgroup>');
                array_push($HTML, '  <tbody>');
                
                foreach ($translation as $item){
                    $translation_text = stripslashes($item->translation);
                    $translation_text = str_replace('<<single-quote>>', "'", $translation_text);
                    $translation_text = str_replace('<br />', "\n", $translation_text);
                    
                    array_push($HTML, '<tr>');
                    array_push($HTML, '  <td>');
                    array_push($HTML, ($item->parent_key == 'none' || $item->parent_key == '' ? '':'<span class="hint">['.$DOPBSP->text($item->parent_key).']</span>').' '.str_replace('<<single-quote>>', "'", stripslashes($item->text_data)));
                    array_push($HTML, '  </td>');
                    array_push($HTML, '  <td class="separator"></td>');
                    array_push($HTML, '  <td>');
                    array_push($HTML, '      <textarea name="DOPBSP-translation-'.$item->id.'" id="DOPBSP-translation-'.$item->id.'" rows="1" cols="" onkeyup="if ((event.keyCode||event.which) != 9){DOPBSPTranslation.edit('.$item->id.', \''.$language.'\', this.value);}" onpaste="DOPBSPTranslation.edit('.$item->id.', \''.$language.'\', this.value)" onblur="DOPBSPTranslation.edit('.$item->id.', \''.$language.'\', this.value, true)">'.$translation_text.'</textarea>');
                    array_push($HTML, '  </td>');
                    array_push($HTML, '</tr>');
                }
                
                array_push($HTML, '  </tbody>');
                array_push($HTML, '</table>');
                
                echo implode('', $HTML);
                
            	die();                
            }
               
            /*
             * Edit translation.
             * 
             * @post id (integer): translation id to modified
             * @post language (string): language (code) to be modified
             * @post value (string): the value with which the translation will be modified
             */
            function edit(){
                global $wpdb;
                global $DOPBSP;
                
                $value = str_replace("\'", '<<single-quote>>', $_POST['value']);
                $value = str_replace("\n", '<br />', $value);
                
                $wpdb->update($DOPBSP->tables->translation.'_'.$_POST['language'], array('translation' => $value), 
                                                                                   array('id' => $_POST['id']));
                
                die();
            }
            
            /*
             * Set translation JSON.
             */
            function encodeJSON($key,
                                $text = '',
                                $pref_text = '',
                                $suff_text = ''){
                global $wpdb;
                global $DOPBSP;
                
                $json = array();
                
                $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' WHERE enabled="true"');

                foreach ($languages as $language){
                    if ($key != ''){
                        $translation = $wpdb->get_row('SELECT * FROM '.$DOPBSP->tables->translation.'_'.$language->code.' WHERE key_data="'.$key.'"');
                        array_push($json, '"'.$language->code.'": "'.$pref_text.utf8_encode($translation->text_data).$suff_text.'"' );
                    }
                    else{
                        array_push($json, '"'.$language->code.'": "'.$pref_text.utf8_encode($text).$suff_text.'"' );
                    }
                }
                
                return '{'.implode(',', $json).'}';
            }
            
            /*
             * Get text from translation JSON.
             * 
             * @param json (string): JSON string
             * @param language (string): language code
             * 
             * @return translation text
             */
            function decodeJSON($json,
                                $language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE){
                $translation = json_decode($json);
                $default_language = DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE;
                
                $text = isset($translation->$language) ? $translation->$language:$translation->$default_language;
                $text = utf8_decode($text);
                $text = stripslashes($text);
                $text = str_replace('<<new-line>>', "\n", $text);
                $text = str_replace('<<single-quote>>', "'", $text);
                
                return $text;
            }
            
            /*
             * Display all languages.
             * 
             * @return HTML languages list
             */
            function displayLanguages(){
                global $wpdb;
                global $DOPBSP;
                
                $HTML = array();
                $i = 0;
                
                $languages = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->languages.' ORDER BY id ASC');
                
                array_push($HTML, '<table class="languages">');
                array_push($HTML, '  <colgroup>');
                array_push($HTML, '      <col />');
                array_push($HTML, '      <col class="separator" />');
                array_push($HTML, '      <col />');
                array_push($HTML, '      <col class="separator" />');
                array_push($HTML, '      <col />');
                array_push($HTML, '      <col class="separator" />');
                array_push($HTML, '      <col />');
                array_push($HTML, '  </colgroup>');
                array_push($HTML, '  <tbody>');
                
                foreach ($languages as $language){
                    $i++;
                    
                    if ($i%4 == 1){
                        array_push($HTML, '     <tr>');
                    }
                    
                    if ($i%4 != 1){
                        array_push($HTML, '         <td class="separator"></td>');
                    
                    }
                    array_push($HTML, '         <td>');
                    array_push($HTML, '             <div class="input-wrapper">');
                    array_push($HTML, '                 <label class="for-switch">'.$language->name.'</label>');
                    
                    if ($language->code != DOPBSP_CONFIG_TRANSLATION_DEFAULT_LANGUAGE){
                        array_push($HTML, '                 <div class="switch">');
                        array_push($HTML, '                     <input type="checkbox" name="DOPBSP-translation-language-'.$language->code.'" id="DOPBSP-translation-language-'.$language->code.'" class="switch-checkbox"'.($language->enabled == 'true' ? ' checked="checked"':'').' onchange="DOPBSPTranslation.setLanguage(\''.$language->code.'\')" />');
                        array_push($HTML, '                     <label class="switch-label" for="DOPBSP-translation-language-'.$language->code.'">');
                        array_push($HTML, '                         <div class="switch-inner"></div>');
                        array_push($HTML, '                         <div class="switch-switch"></div>');
                        array_push($HTML, '                     </label>');
                        array_push($HTML, '                 </div>');
                    }
                    array_push($HTML, '             </div>');
                    array_push($HTML, '         </td>');
                    
                    if ($i%4 == 0){
                        array_push($HTML, '     </tr>');
                    }
                }
                
                switch ($i%4){
                    case 0:
                        array_push($HTML, '     </tr>');
                        break;
                    case 1:
                        array_push($HTML, '         <td class="separator"></td>');
                        array_push($HTML, '         <td></td>');
                        array_push($HTML, '         <td class="separator"></td>');
                        array_push($HTML, '         <td></td>');
                        array_push($HTML, '         <td class="separator"></td>');
                        array_push($HTML, '         <td></td>');
                        array_push($HTML, '     </tr>');
                        break;
                    case 2:
                        array_push($HTML, '         <td class="separator"></td>');
                        array_push($HTML, '         <td></td>');
                        array_push($HTML, '         <td class="separator"></td>');
                        array_push($HTML, '         <td></td>');
                        array_push($HTML, '     </tr>');
                        break;
                    case 3:
                        array_push($HTML, '         <td class="separator"></td>');
                        array_push($HTML, '         <td></td>');
                        array_push($HTML, '     </tr>');
                        break;
                }
                
                array_push($HTML, '  </tbody>');
                array_push($HTML, '</table>');
                array_push($HTML, '<style type="text/css">');
                array_push($HTML, '    .DOPBSP-admin .input-wrapper .switch .switch-inner:before{content: "'.$DOPBSP->text('SETTINGS_ENABLED').'";}');
                array_push($HTML, '    .DOPBSP-admin .input-wrapper .switch .switch-inner:after{content: "'.$DOPBSP->text('SETTINGS_DISABLED').'";}');
                array_push($HTML, '</style>');
                
                echo implode('', $HTML);
                
            	die();
            }
            
            /*
             * Enable/disable language.
             * 
             * @post language (string): language (code) to be enabled/disabled
             * @post value (string): "false" if language is to be disabled
             *                       "true" if language is to be enabled
             */
            function setLanguage(){
                global $wpdb;
                global $DOPBSP;
                
                $language = $_POST['language'];
                $value = $_POST['value'];
                
                $wpdb->update($DOPBSP->tables->languages, array('enabled' => $value), 
                                                          array('code' => $language));
                
                /*
                 * If language is to be enabled create the database table and add data to it.
                 */
                if ($value == 'true'){
                    require_once(str_replace('\\', '/', ABSPATH).'wp-admin/includes/upgrade.php');
                    
                    $sql_translation = "CREATE TABLE ".$DOPBSP->tables->translation."_".$language." (
                                        id INT NOT NULL AUTO_INCREMENT,
                                        key_data VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_KEY_DATA."' COLLATE utf8_unicode_ci NOT NULL,
                                        position INT DEFAULT ".DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_POSITION." NOT NULL,
                                        parent_key VARCHAR(128) DEFAULT '".DOPBSP_CONFIG_DATABASE_TRANSLATION_DEFAULT_PARENT_KEY."' COLLATE utf8_unicode_ci NOT NULL,
                                        text_data TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        translation TEXT COLLATE utf8_unicode_ci NOT NULL,
                                        UNIQUE KEY id (id)
                                    );";
                    dbDelta($sql_translation);
                    $this->setDatabase($language);
                }
                
                die();
                
            }
            
// Check translation to see what keys are used.
            
            /*
             * Check translations keys.
             * 
             * @return HTML of unused translation keys
             */
            function check(){
                global $DOPBSP;
                
                for ($i=0; $i<count($this->lang); $i++){
                    $this->lang[$i]['check'] = false;
                }
                        
                $this->checkFolder($DOPBSP->paths->abs);
                
                for ($i=0; $i<count($this->lang); $i++){
                    if (strpos($this->lang[$i]['key'], 'PARENT_') === false){
                        if ($this->lang[$i]['check'] == true){
                            // echo '<span class="used">'.$this->lang[$i]['key'].'</span><br />';
                        }
                        else{
                            echo '<span class="unused">'.$this->lang[$i]['key'].'</span><br />';
                        }
                    }
                }
                
                die();
            }
            
            /*
             * Check files for translation keys.
             * 
             * @param folder (string): folder to be checked
             */
            function checkFolder($folder){
                $folderData = opendir($folder);
                
                while (($file = readdir($folderData)) !== false){
                    if ($file != '.' 
                            && $file != '..'){
                        if (filetype($folder.$file) == 'file'){
                            $ext = pathinfo($folder.$file, PATHINFO_EXTENSION);
                            
                            if (($ext == 'js' 
                                            || $ext == 'php') 
                                    && strrpos($file, 'class-translation') === false){
                                $file_data = file_get_contents($folder.$file);
                                
                                for ($i=0; $i<count($this->lang); $i++){
                                    if (strpos($file_data, $this->lang[$i]['key']) !== false){
                                        $this->lang[$i]['check'] = true;
                                    }
                                }
                            }
                        }
                        elseif (filetype($folder.$file) == 'dir'){
                            $this->checkFolder($folder.$file.'/');
                        }
                    }
                }
                closedir($folderData);
            }
        }
    }