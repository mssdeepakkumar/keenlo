<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/custom-posts/class-custom-posts-loop.php
* File Version            : 1.0
* Created / Last Modified : 18 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO custom posts loop PHP class.
*/

    if (!class_exists('DOPBSPCustomPostsLoop')){
        class DOPBSPCustomPostsLoop extends DOPBSPCustomPosts{
            /*
             * Constructor
             */
            function DOPBSPCustomPostsLoop(){
                if (DOPBSP_CONFIG_CUSTOM_POSTS_OVERWRITE_POSTS_LOOP){
                    add_filter('pre_get_posts', array(&$this, 'set'));
                }
                add_filter('the_content', array(&$this, 'display'));
            }
            
            /*
             * Set allowed posts types in loop.
             * 
             * @param $query (object): posts query 
             * 
             * @return list of allowed custom posts
             */
            function set($query){
                if ((is_home() 
                        && $query->is_main_query())){
                    $not_allowed_post_types = explode(',', DOPBSP_CONFIG_CUSTOM_POSTS_NOT_ALLOWED_POST_TYPES_IN_LOOP);
                    $post_types = array();
                    $curr_post_types = get_post_types();

                    foreach ($curr_post_types as $post_type){
                        if (!in_array($post_type, $not_allowed_post_types)){
                            array_push($post_types, $post_type);
                        }
                    }	

                    array_push($post_types, DOPBSP_CONFIG_CUSTOM_POSTS_SLUG);
                    $query->set('post_type', $post_types);
                }
                        
                return $query;
            }
            
            /*
             * Display calednar in custom post content.
             * 
             * @param content (string): post content
             * 
             * @return page/post content with calendar attached
             */
            function display($content){
                global $wpdb;
                global $DOPBSP;
                
                $post_type = get_post_type();
                
                if ($post_type == DOPBSP_CONFIG_CUSTOM_POSTS_SLUG){
                    $custom_content = $content;
                    
                    $calendar = $wpdb->get_results('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE post_id='.get_the_ID().' ORDER BY id');

                    if (isset($calendar[0]->id)){
                        $custom_content .= do_shortcode('[dopbsp id="'.$calendar[0]->id.'"]');
                    }
                    return $custom_content;
                }
                else{
                    return $content;
                }
            }

        }
    }