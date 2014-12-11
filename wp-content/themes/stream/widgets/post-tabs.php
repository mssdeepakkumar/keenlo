<?php
/**
 * Plugin Name: Post Tabs
 * Plugin URI: http://mikemattner.com/custom-post-type-widget/
 * Description: Multi-widget for displaying recent posts of custom post types.
 * Version: 1.0
 * Author: Mike Mattner
 * Author URI: http://www.mikemattner.com/
 * Tags: custom post types, post types, latest posts, sidebar widget, plugin
 * License: GPL
 */
global $defaults;
add_action("widgets_init", create_function('', 'return register_widget("Post_Tabs");'));

// default values
$defaults = array(
				'title' => '',
				'number_posts' => 4
				
				);


class Post_Tabs extends WP_Widget {
	function Post_Tabs() {
		$widget_ops = array('description' => __( "Displays tabs with Recent and Popular posts.", 'fdthemes' ) );
		$this->WP_Widget('post_tabs', __('&raquo; Post Tabs', 'fdthemes'), $widget_ops);
	}

	function form($instance) {
		global $defaults;

		// check if options are saved, otherwise use defaults
		if (mpm_isEmpty2($instance))
			$instance = $defaults;
			
	$title = esc_attr($instance['title']);
	$number_posts = esc_attr($instance['number_posts']);
	
//create widget configuration panel
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        
        <p><label for="<?php echo $this->get_field_id('number_posts'); ?>">Number of posts to show: <input id="<?php echo $this->get_field_id('number_posts'); ?>" name="<?php echo $this->get_field_name('number_posts'); ?>" type="text" value="<?php echo esc_attr($number_posts); ?>" size="3" /></label></p>
  

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
		
		if (mpm_isEmpty2($instance))
			$instance = $defaults;



// start widget output
echo $before_widget . "\n";
if($instance['title']){echo $before_title . $instance['title'] . $after_title . "\n";}

	

	?>
	<div class="tabbable">
		<ul class="nav nav-tabs home-tab">
		<li class="active"><a href="#popular_post" data-toggle="tab"><?php _e("Popular", "fdthemes") ?></a></li>
		<li><a href="#recent_post" data-toggle="tab"><?php _e("Recent", "fdthemes") ?></a></li>
		</ul>

		<div class="tab-content">

                                    
            <div class="tab-pane active" id="popular_post">
		<?php
				echo "<ul>";
		$query = array('showposts' => $number_posts, 'nopaging' => 0, 'orderby'=> 'comment_count', 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
		$r = new WP_Query($query);
		if ($r->have_posts()) :	while ($r->have_posts()) : $r->the_post();
	

			echo "\t" . '<li>';
	
	
	
			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');

						?>
						<div class="recent-post-img">
							<a href="<?php the_permalink(); ?>">
                           
							<?php 
								  if($thumbnail){ ?>
										<?php  the_post_thumbnail(array(50,50),array('title'=>get_the_title(),'alt'=>get_the_title()));?>
                            <?php



							
							
} else {
$post_type = get_post_format();
if($post_type == "quote"){
?>                            <div class="widget_tn_holder" style="line-height: 1.15em; font-size: 70px; font-family:'Trebuchet MS';">&#8220;</div>
<?php
} else if($post_type == "audio"){
?>							 <div class="widget_tn_holder"><i class="icon-volume-up"></i></div>
<?php 
} else if($post_type == "gallery"){
?>	<div class="widget_tn_holder"><i class="icon-picture"></i></span></div>
<?php 
}
}









							?>								
                            </a>
                        </div>
                            <?php
						
						?>
                        <div class="post-tabs-content">
	                        <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h2>
	                        <time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time>
	                        <div class="clear"></div>
                    	</div>
                        </li>
                        <?php	
		endwhile;
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_query();

		endif;
?>
				</ul>
			</div><!-- /#popular_post -->


			<div class="tab-pane" id="recent_post">
		<?php
				echo "<ul>";
		$query = array('showposts' => $number_posts, 'nopaging' => 0, 'orderby'=> 'date', 'post_status' => 'publish', 'ignore_sticky_posts' => 1);
		$r = new WP_Query($query);
		if ($r->have_posts()) :	while ($r->have_posts()) : $r->the_post();
	

			echo "\t" . '<li>';	
			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
						?>
						<div class="recent-post-img">
							<a href="<?php the_permalink(); ?>">
							<?php 
								  if($thumbnail){ ?>
										<?php  the_post_thumbnail(array(50,50),array('title'=>get_the_title(),'alt'=>get_the_title()));?>
                            <?php



							
							
} else {
$post_type = get_post_format();
if($post_type == "quote"){
?>                            <div class="widget_tn_holder" style="line-height: 1.15em; font-size: 70px; font-family:'Trebuchet MS';">&#8220;</div>
<?php
} else if($post_type == "audio"){
?>							 <div class="widget_tn_holder"><i class="icon-volume-up"></i></div>
<?php 
} else if($post_type == "gallery"){
?>	<div class="widget_tn_holder"><i class="icon-picture"></i></span></div>
<?php 
}
}









							?>
                            </a>
                        </div>
                            <?php
						
						?>
                        <div class="post-tabs-content">
	                        <h6><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></h6>
	                        <time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time>
	                        <div class="clear"></div>
                   		</div>
                        </li>
                        <?php	
		endwhile;
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_query();

		endif;
?>
				</ul>
			</div><!-- /#recent_post -->

	</div><!-- /tab-content -->
	</div><!-- /tabbable -->
	<div class="clear"></div>




<?php
echo $after_widget . "\n";
	}
}

function mpm_isEmpty2($array) {
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