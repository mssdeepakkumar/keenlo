<?php
/*
Description: Provides a better recent comments widget, including gravatars, post titles, comment excerpts, and more
Version: 1.1.3
Author: Pippin Williamson
Author URI: http://pippinsplugins.com
Contributors: mordauk, wpsmith
*/


/**
 * Recent Posts Widget Class
 */
class brcwp_wrapper extends WP_Widget {
    /** constructor */
    function brcwp_wrapper() {
		$widget_ops = array('classname' => 'brcwp_widget', 'description' => 'Displays recent comments, including gravatars and other options' );
		$this->WP_Widget('brcwp_wrapper', '&raquo; Recent Comments', $widget_ops);
    }
	
	function getUsersWithRole($role) {
		$wp_user_search = new WP_User_Query( array( 'role' => $role) );
		return $wp_user_search->get_results();
	}

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
		
		global $wpdb;
		
        $title 				= apply_filters('widget_title', $instance['title']);
        $comments_num 		= $instance['comments_num'];
        $exclude_admin 		= $instance['exclude_admin'];
        $avatar 			= $instance['avatar'];
        $avatar_size 		= $instance['avatar_size'];
        $float		 		= $instance['float'];
        $author 			= $instance['author'];
        $post_title 		= $instance['post_title'];
        $date 				= $instance['date'];
        $time_format 		= $instance['time_format'];
        $comment_excerpt 	= $instance['comment_excerpt'];
        $comment_length 	= $instance['comment_length'];
		$posttype 			= $instance['posttype'];
		
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
						<?php
						
							if( $comments_num == '' ) { $comments_num = 4; }
							if(!$avatar_size) { $avatar_size = 40; }
							if(!$comment_length) { $comment_length = 80; }
							
							if($posttype != 'all') {
								$post_type = "AND post_type = '$posttype'";
							}
							if ($exclude_admin)
								$users = self::getUsersWithRole('administrator');

							$request = "SELECT * FROM $wpdb->comments"; 
							$request .= " JOIN $wpdb->posts ON ID = comment_post_ID";
						//	$request .= " WHERE comment_approved = '1' AND comment_type != 'trackback' AND post_status = 'publish' $post_type AND post_password =''";
							if ($exclude_admin) {
								foreach ( $users as $user ) {
									$request .= " AND comment_author_email != '$user->user_email'";
								}
							}
							$request .= " ORDER BY comment_date DESC LIMIT $comments_num";
							$comments = $wpdb->get_results($request);
							
							
							echo '<ul class="better-recent-comments">';
							
							if ($comments) {						
								foreach ($comments as $comment) {
									ob_start();
									?>	
										<li>
											<?php if($float != 'none' && $avatar == true) {
												if($float == 'left') { $margin = 'right'; } else { $margin = 'left'; }
												echo '<div style="float: ' . $float . '; height: ' . $avatar_size . 'px; margin-' . $margin . ': 5px;">';
											} ?>
											<?php if($avatar == true) { ?>
												<div class="better-recent-comments-avatar"><?php echo get_avatar($comment->comment_author_email, $avatar_size ); ?></div>
											<?php } ?>
											<?php if($float != 'none' && $avatar == true) {
												echo '</div>';
											} ?>
											<?php if($author == true) { ?>
												<a class="better-recent-comments-author" href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>">
													<?php echo brcwp_get_author($comment); ?>
												</a>
											<?php } ?>

											<?php if($post_title == true) { ?>
												on <a href="<?php echo get_permalink( $comment->comment_post_ID ) . '#comment-' . $comment->comment_ID; ?>"><?php echo get_the_title( $comment->comment_post_ID );?></a> <br/>
											<?php } ?>
											<?php if($date == true) { ?>
												<?php if($time_format == 'Human Readable') { ?>											
													<span class="better-recent-comments-time"><?php echo human_time_diff(strtotime($comment->comment_date, time()), current_time('timestamp')) . ' ago'; ?></span><br/>
												<?php } else {  ?>
													<span class="better-recent-comments-time"><?php comment_date( 'F j, Y', $comment->comment_ID); ?></span><br/>
												<?php } ?>
											<?php } ?>
											<?php if($comment_excerpt == true) { ?>
												<div class="better-recent-comments-text" style="padding-bottom:8px;"><?php echo strip_tags(substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_length)) . '...'; ?></div>
											<?php } ?>
										</li>
									<?php
									ob_end_flush();
								}
							} else {
								echo '<li>' .__('No comments') . '</li>';
							}
							echo '</ul>'; ?>
              <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['comments_num'] 		= $new_instance['comments_num'];
		$instance['exclude_admin'] 		= $new_instance['exclude_admin'];
		$instance['avatar'] 			= $new_instance['avatar'];
		$instance['avatar_size'] 		= $new_instance['avatar_size'];
		$instance['float'] 				= $new_instance['float'];
		$instance['author'] 			= $new_instance['author'];
		$instance['post_title'] 		= $new_instance['post_title'];
		$instance['date'] 				= $new_instance['date'];
		$instance['time_format'] 		= $new_instance['time_format'];
		$instance['comment_excerpt'] 	= $new_instance['comment_excerpt'];
		$instance['comment_length'] 	= $new_instance['comment_length'];
		$instance['posttype'] 			= $new_instance['posttype'];
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {		
	
		$posttypes = get_post_types('', 'objects');
	
        $title 				= esc_attr($instance['title']);
        $comments_num 		= esc_attr($instance['comments_num']);
        $author 			= esc_attr($instance['author']);
        $exclude_admin 		= esc_attr($instance['exclude_admin']);
        $avatar 			= esc_attr($instance['avatar']);
        $avatar_size		= esc_attr($instance['avatar_size']);
        $float				= esc_attr($instance['float']);
        $post_title			= esc_attr($instance['post_title']);
        $date				= esc_attr($instance['date']);
        $time_format		= esc_attr($instance['time_format']);
        $comment_excerpt	= esc_attr($instance['comment_excerpt']);
        $comment_length		= esc_attr($instance['comment_length']);
		$posttype			= esc_attr($instance['posttype']);
        ?>

		<p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Widget Title:', 'title' ); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <input style="width: 30px;" id="<?php echo $this->get_field_id('comments_num'); ?>" name="<?php echo $this->get_field_name('comments_num'); ?>" type="text" value="<?php echo $comments_num; ?>" />
          <label for="<?php echo $this->get_field_id('comments_num'); ?>"><?php _e( 'The number of comments to show', 'comments_num' ); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('exclude_admin'); ?>" name="<?php echo $this->get_field_name('exclude_admin'); ?>" type="checkbox" value="1" <?php checked( '1', $exclude_admin ); ?>/>
          <label for="<?php echo $this->get_field_id('exclude_admin'); ?>"><?php _e( 'Exclude Admin Comments?', 'exclude_admin' ); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('author'); ?>" name="<?php echo $this->get_field_name('author'); ?>" type="checkbox" value="1" <?php checked( '1', $author ); ?>/>
          <label for="<?php echo $this->get_field_id('author'); ?>"><?php _e( 'Display Comment Author?' , 'author' ); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('avatar'); ?>" name="<?php echo $this->get_field_name('avatar'); ?>" type="checkbox" value="1" <?php checked( '1', $avatar ); ?>/>
          <label for="<?php echo $this->get_field_id('avatar'); ?>"><?php _e('Display Author Gravatar?', 'avatar'); ?></label> 
        </p>
		<p>
          <input style="width: 30px;" id="<?php echo $this->get_field_id('avatar_size'); ?>" name="<?php echo $this->get_field_name('avatar_size'); ?>" type="text" value="<?php echo $avatar_size; ?>" />
          <label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e('Gravatar size in pixels - <em>Default: 40</em>', 'avatar_size'); ?></label> 
        </p>
		<p>	
			<label for="<?php echo $this->get_field_id('float'); ?>"><?php _e('Float the gravatar?', 'float'); ?></label> 
			<select name="<?php echo $this->get_field_name('float'); ?>" id="<?php echo $this->get_field_id('float'); ?>" class="widefat">
				<?php
				$floats = array('left', 'right', 'none');
				foreach ($floats as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $float == $option ? ' selected="selected"' : '', '>', $option, '</option>';
				}
				?>
			</select>		
		</p>
		<p>
          <input id="<?php echo $this->get_field_id('post_title'); ?>" name="<?php echo $this->get_field_name('post_title'); ?>" type="checkbox" value="1" <?php checked( '1', $post_title ); ?>/>
          <label for="<?php echo $this->get_field_id('post_title'); ?>"><?php _e('Display Post Title?', 'post_title'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="checkbox" value="1" <?php checked( '1', $date ); ?>/>
          <label for="<?php echo $this->get_field_id('date'); ?>"><?php _e('Display Comment Date?', 'date'); ?></label> 
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('time_format'); ?>"><?php _e('Choose the Time Format', 'time_format'); ?></label> 
			<select name="<?php echo $this->get_field_name('time_format'); ?>" id="<?php echo $this->get_field_id('time_format'); ?>" class="widefat">
				<?php
				$formats = array('Human Readable', 'Standard');
				foreach ($formats as $format) {
					echo '<option value="' . $format . '" id="' . $format . '"', $time_format == $format ? ' selected="selected"' : '', '>', $format, '</option>';
				}
				?>
			</select>	
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('comment_excerpt'); ?>" name="<?php echo $this->get_field_name('comment_excerpt'); ?>" type="checkbox" value="1" <?php checked( '1', $comment_excerpt ); ?>/>
          <label for="<?php echo $this->get_field_id('comment_excerpt'); ?>"><?php _e('Show comment excerpts?', 'comment_excerpt'); ?></label> 
        </p>
		<p>
          <input style="width: 30px;" id="<?php echo $this->get_field_id('comment_length'); ?>" name="<?php echo $this->get_field_name('comment_length'); ?>" type="text" value="<?php echo $comment_length; ?>"  />
          <label for="<?php echo $this->get_field_id('comment_length'); ?>"><?php _e('Length of excerpts, in characters', 'comment_length'); ?></label> 
        </p>
		<p>	
			<label for="<?php echo $this->get_field_id('posttype'); ?>"><?php _e('Choose the Post Type to Display', 'posttype'); ?></label> 
			<select name="<?php echo $this->get_field_name('posttype'); ?>" id="<?php echo $this->get_field_id('posttype'); ?>" class="widefat">
				<?php
				echo '<option id="posttype-all"', $posttype == 'all' ? ' selected="selected"' : '', '>', 'all', '</option>';
				foreach ($posttypes as $option) {
					echo '<option id="' . $option->name . '"', $posttype == $option->name ? ' selected="selected"' : '', '>', $option->name, '</option>';
				}
				?>
			</select>		
		</p>
        <?php 
    }


} // class brcwp_wrapper
// register Recent Comments widget
add_action('widgets_init', create_function('', 'return register_widget("brcwp_wrapper");'));


// get author for recent comments
function brcwp_get_author($comment) {
	$author = "";
	if ( empty($comment->comment_author) )
		$author = __('Anonymous', 'banago');
	else
		$author = $comment->comment_author;
	return $author;
}

?>