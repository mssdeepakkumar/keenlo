<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/custom-posts/class-backend-custom-posts.php
* File Version            : 1.0
* Created / Last Modified : 18 July 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end custom posts PHP class.
*/

    if (!class_exists('DOPBSPCustomPostsMeta')){
        class DOPBSPCustomPostsMeta extends DOPBSPCustomPosts{
            /*
             * Constructor
             */
            function DOPBSPCustomPostsMeta(){
                add_action('add_meta_boxes_'.DOPBSP_CONFIG_CUSTOM_POSTS_SLUG, array(&$this, 'init'));
            }
            
            /*
             * Initialize meta box for custom posts.
             * 
             * @param post (object): post data
             */
            function init($post){
                global $DOPBSP;
                
                if ($post->post_status == 'publish'){
                    $meta = array('id' => 'dopsbsp-custom-post-meta',
                                  'title' => $DOPBSP->text('CUSTOM_POSTS_BOOKING_SYSTEM'),
                                  'description' => '',
                                  'post_type' => DOPBSP_CONFIG_CUSTOM_POSTS_SLUG,
                                  'context' => 'normal',
                                  'priority' => 'high');
                    
                    $DOPBSP->classes->custom_posts->add($post->ID);
                    
                    $callback = create_function('$post, $meta', 
                                                'DOPBSPCustomPostsMeta::set($post, $meta["args"]);');
                    add_meta_box($meta['id'], 
                                 $meta['title'], 
                                 $callback, 
                                 $meta['post_type'], 
                                 $meta['context'], 
                                 $meta['priority'], 
                                 $meta);
                }
            }
            
            /*
             * Get custom post calendar ID.
             * 
             * @post post_id (integer): post ID
             */
            function get(){
                global $wpdb;
                global $DOPBSP;
                
                $calendar = $wpdb->get_row($wpdb->prepare('SELECT * FROM '.$DOPBSP->tables->calendars.' WHERE post_id=%d ORDER BY id',
                                                          $_POST['post_id']));
                echo $calendar->id;
                
                die();
            }
            
            /*
             * Initialize meta box content for custom posts.
             * 
             * @param post (object): post data
             * @param meta (object): meta box arguments
             */
            public static function set($post, 
                                       $meta){
//                new DOPBSPViewsCalendars();    
                DOPBSPCustomPostsMeta::display();
            }
            
            /*
             * Display custom post meta box content.
             * 
             * @param post (object): post data
             * @param meta (object): meta box arguments
             * 
             * @return meta box HTML page
             */
            public static function display(){
                global $DOPBSP;
                
                require_once($DOPBSP->paths->abs.'/views/views-backend-calendars.php');                
                $DOPBSP->views->calendars->template();
            }
        }
    }