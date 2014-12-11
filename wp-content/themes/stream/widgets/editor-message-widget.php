<?php
/**
 * Plugin Name: From The Editor Widget
 * Description: Give users a message from the editor.
 * Version: 0.1
 * Author: Heath Taskis
 * Author URI: http://f-d.com.au
 */
add_action( 'widgets_init', 'editor_widget' );
function editor_widget() {
	register_widget( 'Editor_Widget' );
}

class editor_widget extends WP_Widget {

	function Editor_Widget() {
		$widget_ops = array( 'classname' => 'editor', 'description' => __('A widget that displays the a message from the editor name ', 'editor') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'editor-widget' );
		
		$this->WP_Widget( 'editor-widget', __('&raquo;  Editor Widget', 'editor'), $widget_ops, $control_ops, '<div class="uploader">
  <input type="text" name="settings[_unique_name]" id="_unique_name" />
  <input class="button" name="_unique_name_button" id="_unique_name_button" value="Upload" />
</div>' );


	}
	
	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$name = $instance['name'];


		echo $before_widget;


			
		
		// Display the widget title 
		if ( $title )
			echo '<span class="from-editor-title">' . $title . '</span>';

		//Display the name 
		if ( $name )
			printf( '<div class="from-editor-wrap">' . __(' %1$s.', 'editor') . '</div>', $name );

		
		//if ( $show_info )
			//printf( $name );




		
		echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );


		return $instance;
	}

	
	function form( $instance ) {

		//Set up some default widget settings.
		$defaults = array( 'title' => __('FROM THE EDITOR', 'editor'), 'name' => __('', 'editor'), 'show_info' => true );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<?php //Title. ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'editor'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<?php //Message. ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php _e('Message:', 'editor'); ?></label>
			<input id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" value="<?php echo $instance['name']; ?>" style="width:100%;" />
		</p>



	<?php
	}
}

?>