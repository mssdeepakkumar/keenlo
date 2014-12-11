<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : views/setttings/views-backend-settings-users.php
* File Version            : 1.0
* Created / Last Modified : 05 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end users settings views class.
*/

    if (!class_exists('DOPBSPViewsSettingsUsers')){
        class DOPBSPViewsSettingsUsers extends DOPBSPViewsSettings{
            /*
             * Constructor
             */
            function DOPBSPViewsSettingsUsers(){
            }
            
            /*
             * Returns users settings template.
             * 
             * @param args (array): function arguments
             * 
             * @return users settings HTML
             */
            function template($args = array()){
                global $wp_roles;
                global $DOPBSP;
                
                $roles_step1 = $wp_roles->get_names();
                $roles_step2 = $roles_step1;
                $roles_step3 = $roles_step1;
?>                    
                
<!-- 
    Users permissions.
-->
                <div class="inputs-header display">
                    <h3><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('users-permissions')" id="DOPBSP-inputs-button-users-permissions" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-users-permissions" class="inputs-wrapper hidden">
<?php
                while ($data = current($roles_step1)){
?>                      
                    <div class="input-wrapper">
                        <input type="checkbox" name="DOPBSP-settings-users-permissions-<?php echo key($roles_step1); ?>" id="DOPBSP-settings-users-permissions-<?php echo key($roles_step1); ?>" onclick="DOPBSPSettingsUsers.set(0, '<?php echo key($roles_step1); ?>')" <?php echo get_option('DOPBSP_users_permissions_'.key($roles_step1)) > 0 ? ' checked=checked':''; ?> />
                        <label class="for-checkbox" for="DOPBSP-settings-users-permissions-<?php echo key($roles_step1); ?>"><?php printf(key($roles_step1) == 'administrator' ? $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_ADMINISTRATORS_LABEL'):$DOPBSP->text('SETTINGS_USERS_PERMISSIONS_LABEL'), '<strong>'.__(strtolower($data)).'</strong>'); ?></label>
                    </div>
<?php                        
                    next($roles_step1);                        
                }
?>
                </div>

<!-- 
    Users custom posts permissions.
-->
                <div class="inputs-header display">
                    <h3><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_CUSTOM_POSTS'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('users-permissions-custom-posts')" id="DOPBSP-inputs-button-users-permissions-custom-posts" class="button"></a>
                </div>
                <div id="DOPBSP-inputs-users-permissions-custom-posts" class="inputs-wrapper hidden">
<?php           
                while ($data = current($roles_step2)){
?>                      
                    <div class="input-wrapper">
                        <input type="checkbox" name="DOPBSP-settings-users-permissions-custom_posts_<?php echo key($roles_step2); ?>" id="DOPBSP-settings-users-permissions-custom_posts_<?php echo key($roles_step2); ?>" onclick="DOPBSPSettingsUsers.set(0, 'custom_posts_<?php echo key($roles_step2); ?>')" <?php echo get_option('DOPBSP_users_permissions_custom_posts_'.key($roles_step2)) > 0 ? ' checked=checked':''; ?> />
                        <label class="for-checkbox" for="DOPBSP-settings-users-permissions-custom_posts_<?php echo key($roles_step2); ?>"><?php printf($DOPBSP->text('SETTINGS_USERS_PERMISSIONS_CUSTOM_POSTS_LABEL'), '<strong>'.__(strtolower($data)).'</strong>'); ?></label>
                    </div>
<?php                        
                    next($roles_step2);                        
                }
?>
                </div>
                
<!-- 
    Users
-->
                <div class="inputs-header last display">
                    <h3><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_INDIVIDUAL'); ?></h3>
                    <a href="javascript:DOPBSP.toggleInputs('users')" id="DOPBSP-inputs-button-users" class="button"></a>
                </div>

                <div id="DOPBSP-inputs-users" class="inputs-wrapper last hidden">
                    
                    <!-- 
                        Search by role.
                    -->
                    <div class="input-wrapper DOPBSP-left">
                        <label for="DOPBSP-settings-users-permissions-filters-role"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ROLE'); ?></label>
                        <select name="DOPBSP-settings-users-permissions-filters-role" id="DOPBSP-settings-users-permissions-filters-role" onchange="DOPBSPSettingsUsers.get()">
                            <option value=""><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ROLE_ALL'); ?></option>
<?php           
                while ($data = current($roles_step3)){
                    echo '<option value="'.key($roles_step3).'">'.$data.'</option>';
                    next($roles_step3);                        
                }
?>
                        </select>
                        <script type="text/JavaScript">jQuery('#DOPBSP-settings-users-permissions-filters-role').DOPSelect();</script>
                    </div>
                    
                    <!--
                        Order by.
                    -->
                    <div class="input-wrapper DOPBSP-left">
                        <label for="DOPBSP-settings-users-permissions-filters-order-by"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY'); ?></label>
                        <select name="DOPBSP-settings-users-permissions-filters-order-by" id="DOPBSP-settings-users-permissions-filters-order-by" onchange="DOPBSPSettingsUsers.get()">
                            <option value="email"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_EMAIL'); ?></option>
                            <option value="ID"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_ID'); ?></option>
                            <option value="login" selected="selected"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_BY_USERNAME'); ?></option>
                        </select>
                        <script type="text/JavaScript">jQuery('#DOPBSP-settings-users-permissions-filters-order-by').DOPSelect();</script>
                    </div>
                    
                    <!--
                        Order
                    -->
                    <div class="input-wrapper DOPBSP-left">
                        <label for="DOPBSP-settings-users-permissions-filters-order"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER'); ?></label>
                        <select name="DOPBSP-settings-users-permissions-filters-order" id="DOPBSP-settings-users-permissions-filters-order" onchange="DOPBSPSettingsUsers.get()">
                            <option value="ASC"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_ASCENDING'); ?></option>
                            <option value="DESC"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_ORDER_DESCENDING'); ?></option>
                        </select>
                        <script type="text/JavaScript">jQuery('#DOPBSP-settings-users-permissions-filters-order').DOPSelect();</script>
                    </div>
                    
                    <!-- 
                        Search by text.
                    -->
                    <div class="input-wrapper DOPBSP-left">
                        <label for="DOPBSP-settings-users-permissions-filters-search"><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_FILTERS_SEARCH'); ?></label>
                        <input type="text" name="DOPBSP-settings-users-permissions-filters-search" id="DOPBSP-settings-users-permissions-filters-search" value="" onkeyup="if ((event.keyCode||event.which) !== 9){DOPBSPSettingsUsers.get();}" onpaste="if ((event.keyCode||event.which) != 9){DOPBSPSettings.getUsers();}" />
                    </div>
                    
                    <!--
                        Users list.
                    -->
                    <table class="users-table">
                        <colgroup>
                            <!--<col class="column1" />-->
                            <col class="column2" />
                            <col class="column3" />
                            <col class="column4" />
                            <col class="column5" />
                            <col class="column6" />
                            <col class="column7" />
                            <col class="column8" />
                        </colgroup>
                        <thead>
                            <tr>
                                <!--<th></th>-->
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_LIST_ID'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_USERNAME'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_EMAIL'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_ROLE'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_VIEW'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_USE'); ?></th>
                                <th><?php echo $DOPBSP->text('SETTINGS_USERS_PERMISSIONS_USE_CUSTOM_POSTS'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="DOPBSP-users-list"></tbody>
                    </table>
                </div>
<?php            
            }
        }
    }