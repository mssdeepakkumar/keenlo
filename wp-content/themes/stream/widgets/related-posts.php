<?php
/**
 * 
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package Stream 0.1
 */
class widget_related_posts extends WP_Widget {
	
	function widget_related_posts() {
		$widget_ops = array('classname' => 'widget_related_posts', 'description' => 'Show related posts on a single post page' );
		$this->WP_Widget('widget_related_posts', 'Related Posts - Single Post - fd', $widget_ops);
	}

	function widget($args, $instance) {
		
			extract($args, EXTR_SKIP);
			
			$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
			$number_posts = empty($instance['number_posts']) ? 4 : apply_filters('widget_number_posts', $instance['number_posts']);
			$thumbnail = $instance['thumbnail'] ? '1' : '0';
			
			
			?>
			<div class="widget related-post-widget container">
				<div class="row">
            	<?php
            	if ( !empty( $title ) ) { echo "<h2>" . $title . "</h2>"; }; 
				?>
				<?php
				global $wp_query;
				$thePostID = $wp_query->post->ID;
				//get post categories and set $cat to first category
				$cat = get_the_category(); 
				if (!empty($cat)) {
				
					$cat = $cat[0];
					//set arguments for the get_posts function more options found at wordpress codex
					$args = array(
						'numberposts' => $number_posts,
						'offset' => '0',
						'category' => $cat->cat_ID, //calls category ID number
						'exclude'  => $thePostID
						);  ?>
				
				<?php
					global $post;
					$myposts = get_posts($args); //gets arguments from array above
					$counti = 0; //counter
					
					foreach($myposts as $post) : //loops through posts
						setup_postdata($post); //sets up posts
						
						
						if($counti == 2 or $counti == 5 or $counti == 8){
						?>
							<div class="col-sm-6 col-xs-6 col-lg-4 col-md-6 related_post post_last">
						<?php
						}else{
						?>
                        	<div class="col-sm-6 col-xs-6 col-lg-4 col-md-6 related_post">
                        <?php
						}
						
						
						$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'tiny-thumb');
						if($thumbnail){
						?>

							<a href="<?php the_permalink(); ?>">			
                            <img src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>" />
                            </a>
                            <?php
						}
							?>
                            
                            <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                            </div>
                            
						<?php 
						if($counti == 3 or $counti == 7){
							?>
                            <div class="clear"></div>
                            <?php
						}
						
						$counti++;
					endforeach; 
					
					// Reset the global $wp_query as this query will have stomped on it
					wp_reset_query();

				}				
				?>
				</div>
			</div>
			<div class="clear"></div>
			<?php
		}
		
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number_posts'] = strip_tags($new_instance['number_posts']);
			$instance['thumbnail'] = !empty($new_instance['thumbnail']) ? 1 : 0;

			return $instance;
		}
		
		
		function form($instance) {

			
			$instance = wp_parse_args( (array) $instance, array( 'number_posts' => '', 'thumbnail' => '', 'title' => '') );
			
			$number_posts = strip_tags($instance['number_posts']);
			$title = strip_tags($instance['title']);
			$thumbnail = isset( $instance['thumbnail'] ) ? (bool) $instance['thumbnail'] : false;
			
			?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('number_posts'); ?>">Number of posts to show: <input id="<?php echo $this->get_field_id('number_posts'); ?>" name="<?php echo $this->get_field_name('number_posts'); ?>" type="text" value="<?php echo esc_attr($number_posts); ?>" size="3" /></label></p>
			<p><label for="<?php echo $this->get_field_id('rss_link'); ?>">Disable Thumbnail?: <input id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>" type="checkbox" class="checkbox" <?php checked( $thumbnail ); ?> /></label></p>
			
			<?php
		}
}

register_widget('widget_related_posts');
?>