<?php
/*
Plugin Name: Vine Widget
Plugin URI: http://f-d.com.au/
Description: Embed Vine Videos into your theme
Author: Heath Taskis
Version: 1
Author URI: http://f-d.com.au/
*/
class VineWidget extends WP_Widget
{
  function VineWidget()
  {
    $widget_ops = array('classname' => 'VineWidget', 'description' => 'Displays the latest images' );
    $this->WP_Widget('VineWidget', '&raquo; Vine Video Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 
      'title' => '',
      'height' => '',
      'url' => '',
       ) );
    $title = $instance['title'];
    $url = $instance['url'];
    $height = $instance['height'];
    $height = $instance['height'];    
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('url'); ?>">url: <input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('height'); ?>">Height: <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo esc_attr($height); ?>" /></label></p>

<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['url'] = $new_instance['url'];   
    $instance['height'] = $new_instance['height'];  
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $url = empty($instance['url']) ? ' ' : apply_filters('url', $instance['url']);
    $height = empty($instance['height']) ? ' ' : apply_filters('height', $instance['height']);  
    $iframe = "iframe";





        // Display the widget title 
    if ( $title )
      echo $before_title . $title . $after_title;


    echo '<' . $iframe . ' class="vine-embed loaded playing" src="'.$url.'" width="600" height="'.$height.'" frameborder="0" style="width: 100%;"></iframe> ';


    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("VineWidget");') );?>