<?php
/*
Plugin Name: Posted In Widget
Plugin URI: http://f-d.com.au/
Description: Displays the category with a thumbnail and link
Author: Heath Taskis
Version: 1
Author URI: http://f-d.com.au/
*/
class PostedInWidget extends WP_Widget
{
  function PostedInWidget()
  {
    $widget_ops = array('classname' => 'PostedInWidget', 'description' => 'Displays the category of a post with thumbnail and link' );
    $this->WP_Widget('PostedInWidget', '&raquo; Posted In', $widget_ops);
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
$categories = get_the_category();
$separator = ' ';
$output = '';
if($categories){
  foreach($categories as $category) {

$thisCat = $category->name;

    if($thisCat != 'Featured'){
        $output .= '<div class="posted-in-thumb" style=" background: url(' .z_taxonomy_image_url($category->term_id). ')center center;"></div>';
        $output .= '<div class="posted-in-desc"><h5><a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf(  "View all posts in %s" , $category->name ) ) . '">'.$category->cat_name.'</a></h5>'.$separator;
        $output .= '' .category_description($category->term_id). '<div class="posted-in-hr"></div></div>';
    } 
  }
  echo trim($output, $separator);
}
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("PostedInWidget");') );?>