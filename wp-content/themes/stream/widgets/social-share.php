<?php
/*Social Share Widget***********/
class social_share_widget extends WP_Widget {
		function social_share_widget() {
		$widget_ops = array('classname' => 'social_share_widget', 'description' => 'Add a social share widget' );
		$this->WP_Widget('social_share_widget', 'Social Share - fd', $widget_ops);
	}

	function widget($args, $instance) {
		
			extract($args, EXTR_SKIP);
			
			echo "<div class='widget share-widget'>";
			
			 $facebook = get_option('general_setting_facebook');
			 $twitter = get_option('general_setting_twitter');
			 $googleplus = get_option('general_setting_googleplus');			
			 $youtube = get_option('general_setting_youtube');			
			 $linkedin = get_option('general_setting_linkedin');				
		
			
			$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
			
			if ( !empty( $title ) ) { echo '<h4 class="widget-title">' . $title . '</h4>'; }; ?>
            
			<ul class="widget-social">
               <?php if( $facebook != ""){ ?>				
                <li>
                    <a title="Facebook" href="http://www.facebook.com/share.php?u=<?php echo get_option('general_setting_facebook'); ?>" >
                        <button class="moreCta"><i class="icon-facebook"></i></button>
                    </a>
                </li>
                <?php } ?>                  
                <li>
                <?php if( $twitter != ""){ ?>
                    <a title="Twitter" href="http://twitter.com/home?status=<?php echo get_option('general_setting_twitter'); ?>">
                        <button class="moreCta"><i class="icon-twitter"></i></button>
                    </a>
                </li>
                <?php } ?>      
              	<?php if( $googleplus != ""){ ?>	                          
				<li>
                    <a title="Google+" href="https://plus.google.com/share?url=<?php echo get_option('general_setting_googleplus'); ?>">
                        <button class="moreCta"><i class="icon-google-plus"></i></button>
                    </a>
                </li>
                <?php } ?>      
              	<?php if( $youtube != ""){ ?>	                
                <li>
                    <a title="Youtube" href="mailto:?body=<?php echo get_option('general_setting_youtube'); ?>">
                       <button class="moreCta"> <i class="icon-youtube"></i></button>
                    </a>
                </li>
                <?php } ?>      
              	<?php if( $linkedin != ""){ ?>	                
                <li>
                    <a title="Youtube" href="mailto:?body=<?php echo get_option('general_setting_linkedin'); ?>">
                       <button class="moreCta"> <i class="icon-linkedin"></i></button>
                    </a>
                </li>    
                <?php } ?>                                 
			</ul>
            <div class="clear"></div>
            
            </div>
			<?php 
		}
		
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}
		
		
		function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
			$title = strip_tags($instance['title']);
			?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			
			<?php
		}
}

register_widget('social_share_widget');
?>