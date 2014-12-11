<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/custom-posts/class-custom-posts.php
* File Version            : 1.0
* Created / Last Modified : 18 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO custom posts PHP class.
*/

    if (!class_exists('DOPBSPCustomPosts')){
        class DOPBSPCustomPosts extends DOPBSPFrontEnd{
            /*
             * Constructor
             */
            function DOPBSPCustomPosts(){
                add_action('init', array(&$this, 'init'));
            }
            
            /*
             * Initialize custom posts.
             * 
             * @param post (object): post data
             */
            function init($post){
                global $DOPBSP;
                
                if (is_admin()
                        && $DOPBSP->classes->backend_settings_users->permission(wp_get_current_user()->ID, 'use-custom-posts')
                        || !is_admin()){
                    $postdata = array('exclude_from_search' => false,
                                      'has_archive' => true,
                                      'labels' => array('name' => $DOPBSP->text('CUSTOM_POSTS'),
                                                        'singular_name' => $DOPBSP->text('CUSTOM_POSTS'),
                                                        'menu_name' => $DOPBSP->text('CUSTOM_POSTS'),
                                                        'all_items' => $DOPBSP->text('CUSTOM_POSTS_ADD_ALL'),
                                                        'add_new_item' => $DOPBSP->text('CUSTOM_POSTS_ADD'),
                                                        'edit_item' => $DOPBSP->text('CUSTOM_POSTS_EDIT')),
                                      'menu_icon' => $DOPBSP->paths->url.'assets/gui/images/icon-hover.png',
                                      'public' => true,
                                      'publicly_queryable' => true,
                                      'rewrite' => true,
                                      'taxonomies' => array('category', 
                                                            'post_tag'),
                                      'show_in_nav_menus' => true,
                                      'supports' => array('title', 
                                                          'editor', 
                                                          'author', 
                                                          'thumbnail', 
                                                          'excerpt', 
                                                          'trackbacks', 
                                                          'custom-fields', 
                                                          'comments', 
                                                          'revisions'));
                    register_post_type(DOPBSP_CONFIG_CUSTOM_POSTS_SLUG, $postdata);
                }
            }
            
            /*
             * Add a calendar if none is attached to the custom post.
             * 
             * @param post_id (integer): posts ID
             */
            function add($post_id){
                global $wpdb;
                global $DOPBSP;
                    
                $control_data = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE post_id='.$post_id);
                $user = wp_get_current_user();

                /*
                 * Create calendar if none is attached to the custom post.
                 */
                if ($wpdb->num_rows == 0){
                    $wpdb->insert($DOPBSP->tables->calendars, array('post_id' => $post_id,
                                                                    'user_id' => $user->data->ID,
                                                                    'name' => get_the_title($post_id),
                                                                    'availability' => ''));
                    $wpdb->insert($DOPBSP->tables->settings, array('calendar_id' => $wpdb->insert_id,
                                                                   'hours_definitions' => '[{"value": "00:00"}]',
                                                                   'post_id' => get_permalink($post_id)));
                }
            }
        }
    }