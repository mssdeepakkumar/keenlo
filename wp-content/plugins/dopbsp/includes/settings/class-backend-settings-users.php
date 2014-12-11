<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/settings/class-backend-settings-users.php
* File Version            : 1.0
* Created / Last Modified : 17 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end settings PHP class.
*/

    if (!class_exists('DOPBSPBackEndSettingsUsers')){
        class DOPBSPBackEndSettingsUsers extends DOPBSPBackEndSettings{
            /*
             * Constructor
             */
            function DOPBSPBackEndSettingsUsers(){
            }
            
            /*
             * Display users settings.
             * 
             * @return users settings HTML
             */
            function display(){
                global $DOPBSP;
                
                $DOPBSP->views->settings_users->template();
                
                die();
            }
            
            /*
             * Initialize users permissions.
             */
            function init(){
                global $wp_roles;
                
                $roles = $wp_roles->get_names();
                
                while ($data = current($roles)){
                    switch (key($roles)){
                        case 'administrator':
                            get_option('DOPBSP_users_permissions_administrator') == '' ? add_option('DOPBSP_users_permissions_administrator', DOPBSP_CONFIG_USERS_PERMISSIONS_ADMINISTRATORS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_administrator') == '' ? add_option('DOPBSP_users_permissions_custom_posts_administrator', DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_ADMINISTRATORS):'';
                            break;
                        case 'author':
                            get_option('DOPBSP_users_permissions_author') == '' ? add_option('DOPBSP_users_permissions_author', DOPBSP_CONFIG_USERS_PERMISSIONS_AUTHORS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_author') == '' ? add_option('DOPBSP_users_permissions_custom_posts_author', DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_AUTHORS):'';
                            break;
                        case 'contributor':
                            get_option('DOPBSP_users_permissions_contributor') == '' ? add_option('DOPBSP_users_permissions_contributor', DOPBSP_CONFIG_USERS_PERMISSIONS_CONTRIBUTORS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_contributor') == '' ? add_option('DOPBSP_users_permissions_custom_posts_contributor', DOPBSP_CONFIG_USERS_PERMISSIONS_CONTRIBUTORS):'';
                            break;
                        case 'editor':
                            get_option('DOPBSP_users_permissions_editor') == '' ? add_option('DOPBSP_users_permissions_editor', DOPBSP_CONFIG_USERS_PERMISSIONS_EDITORS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_editor') == '' ? add_option('DOPBSP_users_permissions_custom_posts_editor', DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_EDITORS):'';
                            break;
                        case 'subscriber':
                            get_option('DOPBSP_users_permissions_subscriber') == '' ? add_option('DOPBSP_users_permissions_subscriber', DOPBSP_CONFIG_USERS_PERMISSIONS_SUBSCRIBERS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_subscriber') == '' ? add_option('DOPBSP_users_permissions_custom_posts_subscriber', DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_SUBSCRIBERS):'';
                            break;
                        default:
                            get_option('DOPBSP_users_permissions_'.key($roles)) == '' ? add_option('DOPBSP_users_permissions_'.key($roles), DOPBSP_CONFIG_USERS_PERMISSIONS_OTHERS):'';
                            get_option('DOPBSP_users_permissions_custom_posts_'.key($roles)) == '' ? add_option('DOPBSP_users_permissions_custom_posts_'.key($roles), DOPBSP_CONFIG_USERS_PERMISSIONS_CUSTOM_POSTS_OTHERS):'';
                    }
                    next($roles);                        
                }
            }
            
            /*
             * Get users list.
             * 
             * @post order ():
             * @post orderby ():
             * @post role ():
             * @post search (string):
             * 
             * @return HTML users list
             */
            function get(){
                global $wp_roles;
                $HTML = array();
                
                $users = get_users(array('number' => '',
                                         'offset' => '',
                                         'order' => $_POST['order'],
                                         'orderby' => $_POST['orderby'],
                                         'role' => $_POST['role'],
                                         'search' => $_POST['search']));
                
                foreach ($users as $user){
                    $roles = array();
                    $checkbox_view = array();
                    $checkbox_use = array();
                    $checkbox_use_custom_posts = array();
                    
                    foreach ($user->roles as $role){
                        array_push($roles, $wp_roles->roles[$role]['name']);
                    }
                    
                    if ($user->roles[0] == 'administrator'){
                        array_push($checkbox_view, '<div class="input-wrapper">');
                        array_push($checkbox_view, '    <input type="checkbox" name="DOPBSP-settings-users-permissions-view-'.$user->ID.'" id="DOPBSP-settings-users-permissions-view-'.$user->ID.'" onclick="DOPBSPSettingsUsers.set('.$user->ID.', \'view\')" '.($this->permission($user->ID, 'view-all-calendars') ? 'checked="checked"':'').' />');
                        array_push($checkbox_view, '</div>');
                    }
                    else{
                        array_push($checkbox_use, '<div class="input-wrapper">');
                        array_push($checkbox_use, '     <input type="checkbox" name="DOPBSP-settings-users-permissions-use-'.$user->ID.'" id="DOPBSP-settings-users-permissions-use-'.$user->ID.'" onclick="DOPBSPSettingsUsers.set('.$user->ID.', \'use\')" '.($this->permission($user->ID, 'use-booking-system') ? 'checked="checked"':'').' />');
                        array_push($checkbox_use, '</div>');
                    }
                    array_push($checkbox_use_custom_posts, '<div class="input-wrapper">');
                    array_push($checkbox_use_custom_posts, '    <input type="checkbox" name="DOPBSP-settings-users-permissions-custom_posts-'.$user->ID.'" id="DOPBSP-settings-users-permissions-custom_posts-'.$user->ID.'" onclick="DOPBSPSettingsUsers.set('.$user->ID.', \'custom_posts\')" '.($this->permission($user->ID, 'use-custom-posts') ? 'checked="checked"':'').' />');
                    array_push($checkbox_use_custom_posts, '</div>');
                    
                    array_push($HTML, '<tr>');
                    // array_push($HTML, ' <td>');
                    // array_push($HTML, '     <div class="input-wrapper">');
                    // array_push($HTML, '         <input type="checkbox" name="DOPBSP-settings-users-permissions-user-id-'.$user->ID.'" id="DOPBSP-settings-users-permissions-user-id-'.$user->ID.'" />');
                    // array_push($HTML, '     </div>');
                    // array_push($HTML, ' </td>');
                    array_push($HTML, ' <td>'.$user->ID.'</td>');
                    array_push($HTML, ' <td>'.get_avatar($user->ID, 18, '', $user->first_name.' '.$user->last_name).$user->user_login.'<br />'.$user->first_name.' '.$user->last_name.'</td>');
                    array_push($HTML, ' <td>'.$user->user_email.'</td>');
                    array_push($HTML, ' <td>'.implode('<br />', $roles).'</td>');
                    array_push($HTML, ' <td>'.implode('', $checkbox_view).'</td>');
                    array_push($HTML, ' <td>'.implode('', $checkbox_use).'</td>');
                    array_push($HTML, ' <td>'.implode('', $checkbox_use_custom_posts).'</td>');
                    array_push($HTML, '</tr>');
                }
                
                echo implode('', $HTML);
                
                die();
            }
            
            /*
             * Set user permissions.
             * 
             * @post id (integer): user ID; 0 for general settings
             * @post slug (string): option/meta slug
             * @post value (integer): permissions value "0" and/or "1"
             */
            function set(){
                $id = $_POST['id'];
                $slug = $_POST['slug'];
                $value = $_POST['value'];
                
                if ($id == 0){
                    update_option('DOPBSP_users_permissions_'.$slug, (int)$value);
                }
                else{
                    if (get_user_meta($id, 'DOPBSP_permissions_'.$slug, true) == ''){
                        add_user_meta($id, 'DOPBSP_permissions_'.$slug, (int)$value, true);
                    }
                    else{
                        update_user_meta($id, 'DOPBSP_permissions_'.$slug, (int)$value);
                    }
                }
                
                die();
            }
            
            /*
             * Check if user has permission.
             * 
             * @param id (integer): user ID
             * @param $do (string): user permission
             *                      "use-booking-system": user can use the plugin
             *                      "use-custom-posts": user can use custom posts
             *                      "use-calendars": user can use calendars set by an administrtor
             *                      "view-all-calendars": administrator can view all calendars
             * 
             * @return: true/false
             */
            function permission($id, 
                                $do){
                if ($id == 0){
                    return false;
                }
                
                $user = get_userdata($id);
                
                switch ($do){
                    case 'view-all-calendars':
                        if ($user->roles[0] == 'administrator'){
                            if (get_user_meta($id, 'DOPBSP_permissions_view', true) != ''){
                                if (get_user_meta($id, 'DOPBSP_permissions_view', true) == 1){
                                    return true;
                                }
                                else{
                                    return false;
                                }
                            }
                            else{
                                if (get_option('DOPBSP_users_permissions_administrator') == 1){
                                    return true;
                                }
                                else{
                                    return false;
                                }
                            }
                        }
                        else{
                            return false;
                        }
                        break;
                    case 'use-booking-system':
                        if ($user->roles[0] == 'administrator'){
                            return true;
                        }
                        else{
                            if (get_user_meta($id, 'DOPBSP_permissions_use', true) != ''){
                                if (get_user_meta($id, 'DOPBSP_permissions_use', true) == 1){
                                    return true;
                                }
                                else{
                                    return false;
                                }
                            }
                            else{
                                foreach ($user->roles as $role){
                                    if (get_option('DOPBSP_users_permissions_'.$role) == 1){
                                        return true;
                                    }
                                }
                                return false;
                            }
                        }
                        break;
                    case 'use-custom-posts':
                        if (get_user_meta($id, 'DOPBSP_permissions_custom_posts', true) != ''){
                            if (get_user_meta($id, 'DOPBSP_permissions_custom_posts', true) == 1){
                                return true;
                            }
                            else{
                                return false;
                            }
                        }
                        else{
                            foreach ($user->roles as $role){
                                if (get_option('DOPBSP_users_permissions_custom_posts_'.$role) == 1){
                                    return true;
                                }
                            }
                            return false;
                        }
                        break;
                    case 'use-calendars':
                        if (get_user_meta($id, 'DOPBSP_permissions_calendars', true) != ''){
                            return true;
                        }
                        else{
                            return false;
                        }
                        break;
                }
                
                return false;
            }
        }
    }