<?php
/*
Plugin Name: Post Tags Widget
Plugin URI: http://f-d.com.au/
Description: Displays the category with a thumbnail and link
Author: Heath Taskis
Version: 1
Author URI: http://f-d.com.au/
*/
class PostTagsWidget extends WP_Widget
{
  function PostTagsWidget()
  {
    $widget_ops = array('classname' => 'PostTagsWidget', 'description' => 'Displays the tags related to the post' );
    $this->WP_Widget('PostTagsWidget', 'Post Tags', $widget_ops);
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
 
    
    // WIDGET TITLE
    // 
  	if (!empty($title))
      echo $before_title . $title . $after_title;;



?>

<?php
$tags = get_the_tags();

$separator = ' / ';
$output = '';
if($tags){
  foreach($tags as $tag) {

$tagname =  $tag->name;
$output .= '<a href="'. get_tag_link( $tag ) .' " class="tag-name">'.$tagname.'</a> ';

  }
  echo trim($output, $separator);
}
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("PostTagsWidget");') );?>