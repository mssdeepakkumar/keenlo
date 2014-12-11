<?php
/*
Plugin Name: Recent Images Gallery Widget
Plugin URI: http://f-d.com.au/
Description: Displays the latest Media Attachments
Author: Heath Taskis
Version: 1
Author URI: http://f-d.com.au/
*/
class RecentImagesWidget extends WP_Widget
{
  function RecentImagesWidget()
  {
    $widget_ops = array('classname' => 'RecentImagesWidget', 'description' => 'Displays the latest images' );
    $this->WP_Widget('RecentImagesWidget', 'Recent Images Gallery', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 
      'title' => '',
      'height' => '',
      'message' => '',
       ) );
    $title = $instance['title'];
    $message = $instance['message'];
    $height = $instance['height'];
    $amount = $instance['amount'];    
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('message'); ?>">Message: <input class="widefat" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>" type="text" value="<?php echo esc_attr($message); ?>" /></label></p>
  <p><label for="<?php echo $this->get_field_id('amount'); ?>">Number of images to show: (ie, 12, 15, etc) <input class="widefat" id="<?php echo $this->get_field_id('amount'); ?>" name="<?php echo $this->get_field_name('amount'); ?>" type="text" value="<?php echo esc_attr($amount); ?>" /></label></p>

<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    $instance['message'] = $new_instance['message'];   
    $instance['amount'] = $new_instance['amount'];  
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
    $message = empty($instance['message']) ? ' ' : apply_filters('widget_title', $instance['message']);
    $amount = empty($instance['amount']) ? ' ' : apply_filters('widget_title', $instance['amount']);  



 $slide_count = 0;
 $args = array(
  'post_type'   => 'attachment',
  'numberposts' => $amount,
  'post_status' => 'any',
  'post_date' => 'date',
  'exclude'     => get_post_thumbnail_id()

  );

$attachments = get_posts( $args );

if ( $attachments ) {
  echo '<div class="row recent-gallery-wrapper">';
  echo '<div class="col-lg-7 col-md-7 carousel slide recent-gallery" id="myCarousel" >';
  echo '<div class="master-slider ms-skin-default " id="masterslider2">';

  foreach ( $attachments as $attachment ) {

        $thisImg = wp_get_attachment_image_src( $attachment->ID, 'large');

        
?>
    <!-- new slide -->
    <div class="ms-slide">
        <!-- slide background -->
        <img src="<?php echo get_template_directory_uri() ?>/ico/blank.gif" data-src="<?php echo $thisImg[0]; ?>" alt="lorem ipsum dolor sit"/>     
        <!-- slide text layer -->
        <div class="ms-layer ms-caption" style="bottom:90px; left:20px;">
          <?php
          echo '<div class="attachment-meta"><p>'.get_post_field("post_title", $attachment->ID).' / '. get_post_field("post_excerpt", $attachment->ID).'</p></div>';
        ?>
        </div>
    </div>
    <!-- end of slide -->

<?php

  }
}

    echo '</div>';
 
    echo '</div>'; 
    wp_enqueue_script( 'masterslider-settings-recent-js', get_template_directory_uri().'/js/masterslider-showcase.settings.js',array(),'20131031',true);  
    echo '<div class="col-lg-5 col-md-5 recent-gallery-meta">';
        // WIDGET TITLE
    // 
    if (!empty($title))
    echo '<h2>' . $title . '</h2>';;
    echo '<div class=" ">';
    echo '<p>'.$message.'</p>';

     
    echo '</div>';
    echo '</div>';   
    echo '</div>';
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("RecentImagesWidget");') );?>