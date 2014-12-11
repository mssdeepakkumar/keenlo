<?php
/*
Plugin Name: Next Post Widget
Plugin URI: http://f-d.com.au/
Description: Grabs the next post and displays a call to action
Author: Heath Taskis
Version: 1
Author URI: http://f-d.com.au/
*/
class RandomPostWidget extends WP_Widget
{
  function RandomPostWidget()
  {
    $widget_ops = array('classname' => 'RandomPostWidget', 'description' => 'Displays the next post with thumbnail and excerpt' );
    $this->WP_Widget('RandomPostWidget', '&raquo; Next Post', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    
  echo '<hr style="margin: 30px 11px 50px 11px;"/>';
    // WIDGET CODE GOES HERE


  
  $next_post = get_next_post();
  if (!empty( $next_post )){ ?>
  <div style="position: relative">
  <a href="<?php echo get_permalink( $next_post->ID ); ?>"></a>
  <?php

  $next_post_thumbnail_id = get_post_thumbnail_id($next_post->ID);
  $next_post_thumbnail_url = wp_get_attachment_url( $next_post_thumbnail_id );


  $next_author_id = $next_post->post_author; 

  echo '<div class="next-post-widget" style="
  width: 100%; 
  /*background-color: #ccc; 
  background-image: url('.$next_post_thumbnail_url. ');
  background-repeat: no-repeat;
  background-size: cover;
  -webkit-background-size: cover;
  opacity: 0.95; 
  border-top: #63b76c solid 3px;
  */
  ">';
  ?>
  <div style="padding: 5% 10% 8% 10%; left: auto; right: auto;";>
  <?php
  if (!empty($title))
      echo $before_title . $title . $after_title;;
  ?>
  </h4>  <h2 class="next-post-title"><?php next_post_link('%link'); ?> </h2>
  <h4 class="next-author-id">
    <?php
      echo '<span class="next-post-author-tn">';
      if(function_exists('userphoto_exists') && userphoto_exists($next_author_id)){
        
          userphoto_thumbnail($next_author_id);
              
      }
      else {
        echo get_avatar($next_author_id); 
      } 
      echo "</span><!--author-tn-->";  

?>
  by <?php echo the_author_meta( 'display_name' , $next_author_id ); ?>
  </h4>
  
  </div></div>
  <style>
    .next-post-widget:before{

      <?php echo 'background-image: url('.$next_post_thumbnail_url. ');';?>

    }

  </style>
</div>
  <?php


}else{


  $prev_post = get_previous_post();
?>
  <div style="position: relative">
  <a href="<?php echo get_permalink( $prev_post->ID ); ?>"></a>
  <?php
  

  $prev_post_thumbnail_id = get_post_thumbnail_id($prev_post->ID);
  $prev_post_thumbnail_url = wp_get_attachment_url( $prev_post_thumbnail_id );


  $prev_author_id = $prev_post->post_author; 

  echo '<div class="next-post-widget" style=" width: 100%;   ">';
  ?>
  <div style="padding: 5% 10% 8% 10%; left: auto; right: auto;";>
  <?php
  if (!empty($title))
      echo $before_title . $title . $after_title;;
  ?>
  </h4>  <h2 class="next-post-title"><?php previous_post_link('%link'); ?> </h2>
  <h4 class="next-author-id">
    <?php
      echo '<span class="next-post-author-tn">';
      if(function_exists('userphoto_exists') && userphoto_exists($prev_author_id)){
        
          userphoto_thumbnail($prev_author_id);
              
      }
      else {
        echo get_avatar($prev_author_id); 
      } 
      echo "</span><!--author-tn-->";  

?>
  by <?php echo the_author_meta( 'display_name' , $prev_author_id ); ?>
  </h4>
  
  </div></div>
  <style>
    .next-post-widget:before{

      <?php echo 'background-image: url('.$prev_post_thumbnail_url. ');';?>

    }

  </style>
</div>
  <?php

}; 

  


 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("RandomPostWidget");') );?>