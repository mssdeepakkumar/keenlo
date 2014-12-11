<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/setttings/views-backend-settings.php
* File Version            : 1.0
* Created / Last Modified : 13 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end settings views class.
*/

    if (!class_exists('DOPBSPViewsSettings')){
        class DOPBSPViewsSettings extends DOPBSPViews{
            /*
             * Constructor
             */
            function DOPBSPViewsSettings(){
            }
            
            /*
             * Returns settings template.
             * 
             * @param args (array): function arguments
             * 
             * @return settings HTML page
             */
            function template($args = array()){
                global $DOPBSP;
                    
                $this->getTranslation();
?>            
    <div class="wrap DOPBSP-admin">
        
<!-- 
    Header 
-->
        <?php $this->displayHeader($DOPBSP->text('TITLE').' - '.$DOPBSP->text('SETTINGS_TITLE')); ?>

<!-- 
    Content 
-->
        <div class="main" style="display: block;">
            <table class="content-wrapper">
                <colgroup>
                    <col id="DOPBSP-col-column1" class="column1" />
                    <col id="DOPBSP-col-column-separator1" class="separator" />
                    <col id="DOPBSP-col-column2" class="column2" />
                </colgroup>
                <tbody>
                    <tr>
                        <td class="column" id="DOPBSP-column1">
                            <div class="column-header">
                                <a href="<?php echo DOPBSP_CONFIG_HELP_DOCUMENTATION_URL; ?>" target="_blank" class="button help"><span class="info help"><?php echo $DOPBSP->text('SETTINGS_HELP').'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION'); ?></span></a>
                                <br class="DOPBSP-clear" />
                            </div>
                            <div class="column-content">
                                <ul>
                                    <!--
                                    <li class="settings-item settings" onclick="DOPBSPSettings.displaySettings(0)">
                                        <div class="icon"></div>
                                        <div class="title"><?php echo $DOPBSP->text('SETTINGS_GENERAL_TITLE'); ?></div>
                                    </li>
                                    -->
                                    <li class="settings-item calendars" onclick="DOPBSPSettingsCalendar.display(0)">
                                        <div class="icon"></div>
                                        <div class="title"><?php echo $DOPBSP->text('SETTINGS_CALENDAR_TITLE'); ?></div>
                                    </li>
                                    <li class="settings-item notifications" onclick="DOPBSPSettingsNotifications.display(0)">
                                        <div class="icon"></div>
                                        <div class="title"><?php echo $DOPBSP->text('SETTINGS_NOTIFICATIONS_TITLE'); ?></div>
                                    </li>
                                    <li class="settings-item payments" onclick="DOPBSPSettingsPaymentGateways.display(0)">
                                        <div class="icon"></div>
                                        <div class="title"><?php echo $DOPBSP->text('SETTINGS_PAYMENT_GATEWAYS_TITLE'); ?></div>
                                    </li>
                                    <li class="settings-item users" onclick="DOPBSPSettingsUsers.display(0)">
                                        <div class="icon"></div>
                                        <div class="title"><?php echo $DOPBSP->text('SETTINGS_USERS_TITLE'); ?></div>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td id="DOPBSP-column-separator1" class="separator"></td>
                        <td id="DOPBSP-column2" class="column">
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
 * Form inputs.
 */
            /*
             * Create a text input field for settings.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * settings_id (integer): settings ID
             *                      * settings_type (string): settings type
             *                      * help (string): field help
             *                      * container_class (string): container class
             *                      * input_class (string): input class
             * 
             * @return text input HTML
             */
            function displayTextInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $settings_id = $args['settings_id'];
                $settings_type = $args['settings_type'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                $input_class = isset($args['input_class']) ? $args['input_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-settings-'.$id.'">'.$label.'</label>');
                array_push($html, '     <input type="text" name="DOPBSP-settings-'.$id.'" id="DOPBSP-settings-'.$id.'" class="'.$input_class.'" value="'.$value.'" onkeyup="if ((event.keyCode||event.which) != 9){DOPBSPSettings.set('.$settings_id.', \''.$settings_type.'\', \'text\', \''.$id.'\', this.value);}" onpaste="DOPBSPSettings.set('.$settings_id.', \''.$settings_type.'\', \'text\', \''.$id.'\', this.value)" onblur="DOPBSPSettings.set('.$settings_id.', \''.$settings_type.'\', \'text\', \''.$id.'\', this.value, true)" />');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');

                echo implode('', $html);
            }
            
            /*
             * Create a drop down field for settings.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * settings_id (integer): settings ID
             *                      * settings_type (string): settings type
             *                      * help (string): field help
             *                      * options (string): options labels
             *                      * options_values (string): options values
             *                      * container_class (string): container class
             * 
             * @return drop down HTML
             */
            function displaySelectInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $settings_id = $args['settings_id'];
                $settings_type = $args['settings_type'];
                $help = $args['help'];
                $options = $args['options'];
                $options_values = $args['options_values'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                
                $html = array();
                $options_data = explode(';;', $options);
                $options_values_data = explode(';;', $options_values);
                
                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label for="DOPBSP-settings-'.$id.'">'.$label.'</label>');
                array_push($html, '     <select name="DOPBSP-settings-'.$id.'" id="DOPBSP-settings-'.$id.'" class="DOPBSP-left" onchange="DOPBSPSettings.set('.$settings_id.', \''.$settings_type.'\', \'select\', \''.$id.'\')">');
                
                for ($i=0; $i<count($options_data); $i++){
                    if ($value == $options_values_data[$i]){
                        array_push($html, '     <option value="'.$options_values_data[$i].'" selected="selected">'.$options_data[$i].'</option>');
                    }
                    else{
                        array_push($html, '     <option value="'.$options_values_data[$i].'">'.$options_data[$i].'</option>');
                    }
                }
                array_push($html, '     </select>');
                array_push($html, '     <script type="text/JavaScript">jQuery(\'#DOPBSP-settings-'.$id.'\').DOPSelect();</script>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                
                echo implode('', $html);
            }
            
            /*
             * Create a switch field for settings.
             * 
             * @param args (array): function arguments
             *                      * id (integer): field ID
             *                      * label (string): field label
             *                      * value (string): field current value
             *                      * settings_id (integer): settings ID
             *                      * settings_type (string): settings type
             *                      * help (string): field help
             *                      * container_class (string): container class
             * 
             * @return switch HTML
             */
            function displaySwitchInput($args = array()){
                global $DOPBSP;
                
                $id = $args['id'];
                $label = $args['label'];
                $value = $args['value'];
                $settings_id = $args['settings_id'];
                $settings_type = $args['settings_type'];
                $help = $args['help'];
                $container_class = isset($args['container_class']) ? $args['container_class']:'';
                    
                $html = array();

                array_push($html, ' <div class="input-wrapper '.$container_class.'">');
                array_push($html, '     <label class="for-switch">'.$label.'</label>');
                array_push($html, '     <div class="switch">');
                array_push($html, '         <input type="checkbox" name="DOPBSP-settings-'.$id.'" id="DOPBSP-settings-'.$id.'" class="switch-checkbox" onchange="DOPBSPSettings.set('.$settings_id.', \''.$settings_type.'\', \'switch\', \''.$id.'\')"'.($value == 'true' ? ' checked="checked"':'').' />');
                array_push($html, '         <label class="switch-label" for="DOPBSP-settings-'.$id.'">');
                array_push($html, '             <div class="switch-inner"></div>');
                array_push($html, '             <div class="switch-switch"></div>');
                array_push($html, '         </label>');
                array_push($html, '     </div>');
                array_push($html, '     <a href="'.DOPBSP_CONFIG_HELP_DOCUMENTATION_URL.'" target="_blank" class="button help switch-help"><span class="info help">'.$help.'<br /><br />'.$DOPBSP->text('HELP_VIEW_DOCUMENTATION').'</span></a>');
                array_push($html, ' </div>');
                array_push($html, ' <style type="text/css">');
                array_push($html, '     .DOPBSP-admin .input-wrapper .switch .switch-inner:before{content: "'.$DOPBSP->text('SETTINGS_ENABLED').'";}');
                array_push($html, '     .DOPBSP-admin .input-wrapper .switch .switch-inner:after{content: "'.$DOPBSP->text('SETTINGS_DISABLED').'";}');
                array_push($html, ' </style>');
                
                echo implode('', $html);
            }
        }
    }