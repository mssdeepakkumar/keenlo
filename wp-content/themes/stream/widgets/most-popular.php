<?php
global $defaults;
add_action("widgets_init", create_function('', 'return register_widget("Popular_Posts");'));

// default values
$defaults = array(
				'title' => 'Popular Posts',
				'number_posts' => 4				
				);


class Popular_Posts extends WP_Widget {
	function Popular_Posts() {
		$widget_ops = array('description' => __( "Displays links to the posts with the most comments.", 'fdthemes' ) );
		$this->WP_Widget('popular_posts', __('Popular Posts - fd', 'fdthemes'), $widget_ops);
	}

	function form($instance) {
		global $defaults;

		// check if options are saved, otherwise use defaults
		if (mpm_isEmpty($instance))
			$instance = $defaults;
			
	$title = esc_attr($instance['title']);
	$number_posts = esc_attr($instance['number_posts']);
	
//create widget configuration panel
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        
      <!-- <p><label for="<?php echo $this->get_field_id('number_posts'); ?>">Number of posts to show: <input id="<?php echo $this->get_field_id('number_posts'); ?>" name="<?php echo $this->get_field_name('number_posts'); ?>" type="text" value="<?php echo esc_attr($number_posts); ?>" size="3" /></label></p> -->
  

<?php
	}


	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number_posts'] = strip_tags($new_instance['number_posts']);

        return $instance;
	}

	function widget($args, $instance) {
		
		extract($args, EXTR_SKIP);
			
			$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
			$number_posts = empty($instance['number_posts']) ? 4 : apply_filters('widget_number_posts', $instance['number_posts']);
		
		if (mpm_isEmpty($instance))
			$instance = $defaults;



	// start widget output
	echo $before_widget . "\n";
	$countCol = '';
	echo '<div class="container pop-post-widget"><!-- Container -->';
	echo $before_title . $instance['title'] . $after_title . "\n";	
	echo '<ul style="list-style:none; padding:0;">';
	//function filter_where( $where ) {
	//  $where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
    // return $where;
	//	}
    //add_filter( 'posts_where', 'filter_where' );

	$query = array('showposts' => $number_posts, 'nopaging' => 0, 'orderby'=> 'comment_count', 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
		$r = new WP_Query($query);
		if ($r->have_posts()) :
		


	while ($r->have_posts()) : $r->the_post();

	$countCol++;

	echo "\t" . '<li class="col-xs-6 col-sm- 3 col-md-3 offset-0 ">';
	
	
	
	$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
						
						?>
								
                                    <?php 
                                    if(!get_post_format()) {
                                           //Display the Post Image by default

															$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'post-image');
															if($thumbnail){
															?>
															<div class="pop-post-thumb">
																<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="img_post">
																<div class="post_img" style="background:url(<?php echo $thumbnail[0]; ?>) no-repeat  top  center ; -webkit-background-size: cover;	-moz-background-size: cover;	-o-background-size: cover;	background-size: cover; width: 100%; "	alt="<?php the_title(); ?>">
																	<div class="popular-img"></div>
																</div>

																</a>
																                            

															</div><!-- / Pop-Post-Thumb -->

															<?php 
															}

                                      } else {
                                           get_template_part('format', get_post_format());
                                      }
									  ?><div class="popular-summary">
									  		<p class="post_tnDate">
									  			<time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time>
									  		</p>
									  		<?php get_template_part( "post_title", "archive" ); ?>                   					
											<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
																		<div class="readtime">
																				<?php 
																				if( function_exists( 'post_read_time' ) ) {
																					echo '<i class="icon-bookmark" style="margin-right: 5px;"></i>';
																					post_read_time();
																				} ?>
															        	</div><!-- / Read Time -->													
											<?php the_excerpt(); ?>
										<a href="<?php echo the_permalink(); ?> " class="rpwe-reply">Read</a>
										</div><!-- / Popular Summary -->
								

                        

                        <div class="clear"></div>
                        </li>
	                    <?php 

						if($countCol == 2){ 
							echo '<div class="clearfix visible-xs visible-sm"></div> ';
						} 
                        
	endwhile;
	remove_filter( 'posts_where', 'filter_where' );
	// Reset the global $the_post as this query will have stomped on it
		wp_reset_query();

		endif;
?>
</ul>
</div><!-- / Container -->
<?php
echo $after_widget . "\n";
	}
}

function mpm_isEmpty($array) {
	$i = 0;
	foreach ($array as $elements) {
		if (strlen($elements) == 0)
			$i++;
	}	
	if ($i == count($array))
		return true;
	else
		return false;
}
?>