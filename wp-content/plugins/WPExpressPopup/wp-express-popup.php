<?php
   /*
   Plugin Name: wp express popup
   Plugin URI: http://wpexpresspopup.com/
   Description: a plugin to create professionally custom popup quickly in your wordpress website to increase your business 
   Version: 1.0
   Author: hamza najih
   Author URI: http://najih.info
   */
?>
<?php

	
	function show_popup($id){

			$post=get_post($id);

			//$show=get_post_meta($id,'wpep_show',true);

			$open_effect=get_post_meta($id,'wpep_open_effect',true);
			$close_effect=get_post_meta($id,'wpep_close_effect',true);

			$show_delay=get_post_meta($id,'wpep_show_delay',true);
			if(empty($show_delay)){$show_delay=0;}
			$hide_delay=get_post_meta($id,'wpep_hide_delay',true);
			if(empty($hide_delay)){$hide_delay=0;}

			$type=get_post_meta($id,'wpep_type',true);
			if(empty($type)){$type='custom';}

			$width=get_post_meta($id,'wpep_width',true);


			$hide_header=get_post_meta($id,'wpep_hide_header',true);
			if(empty($hide_header)){$hide_header=0;}
			$hide_footer=get_post_meta($id,'wpep_hide_footer',true);
			if(empty($hide_footer)){$hide_footer=0;}
			$hide_close=get_post_meta($id,'wpep_hide_close',true);
			if(empty($hide_close)){$hide_close=0;}
			$auto_hide=get_post_meta($id,'wpep_auto_hide',true);
			if(empty($auto_hide)){$auto_hide=0;}

			$show_on=get_post_meta($id,'wpep_show_on',true);
			if(empty($show_on)){$show_on='onload1';}
			$click_on=get_post_meta($id,'wpep_click_on',true);
			if(empty($click_on)){$click_on='';}
			
			$close_icon=wp_get_attachment_image_src(get_post_meta($id,'wpep_close_icon',true));
	    	$icon_width=get_post_meta($id,'wpep_close_icon_width',true);
	    	$icon_height=get_post_meta($id,'wpep_close_icon_height',true);

	    	$custom_css=get_post_meta($id,'wpep_custom_css',true);

	    	$show_time=get_post_meta($id,'wpep_show_time',true);
	    	if(empty($show_time)){$show_time=0;}
			
			if($type=='signin' && is_user_logged_in()){
				
			}else{
			echo '<style>#wpep_popup_'.$id.'{width:'.$width.'}';
			echo $custom_css;
			if($close_icon!=''){
				echo '.wpep_popup > .wpep_close{background:url("'.$close_icon[0].'");width:'.$icon_width.';height:'.$icon_height.';}';
			}
			echo '</style>';


			echo '<div class="wpep_back" id="wpep_back_'.$id.'" >
			<div id="wpep_popup_'.$id.'" class="wpep_popup ">';

				if($hide_close[0]!='yes'){
					echo '<div class="wpep_close" id="wpep_close_'.$id.'"></div>';
				}
				
				if($hide_header[0]!='yes'){
					echo '<div class="header">';
					echo $post->post_title;
					echo '</div>';					
				}

				echo '<div class="content">';

				switch ($type) {
				    case 'signin':
					    if ( is_user_logged_in() ) {
						    global $current_user;
      						get_currentuserinfo();
      						echo 'Hello : ' . $current_user->user_login ;
						} else {
						    wp_login_form();
						}
				        break;
				    case 'video':

				    	$ywidth=get_post_meta($id,'wpep_video_width',true);
				    	if(empty($ywidth)){$ywidth='400px';}
				    	$yheight=get_post_meta($id,'wpep_video_height',true);
				    	if(empty($yheight)){$yheight='300px';}
				    	$yid=get_post_meta($id,'wpep_video_id',true);
				    	if(empty($yid)){
				    		echo _("missed youtube video ID");
				    	}else{
				   		    echo '<div style="width='.$ywidth.'"><iframe width="100%" height="'.$yheight.'"  src="//www.youtube.com/embed/'.$yid.'" frameborder="0" allowfullscreen></iframe></div>';			    		
				    	}
				        break;
				    case 'image':

				    	/*
				    	$iwidth=get_post_meta($id,'wpep_image_width',true);
				    	$iheight=get_post_meta($id,'wpep_image_height',true);
				    	*/

				    	$image = wp_get_attachment_image_src(get_post_meta($id,'wpep_image',true), 'full-size');

				        echo '<img class="wpep_img" src="'.$image[0].'"/>';
				        break;
				    case 'facebook':

				    	/*
				    	$fbwidth=get_post_meta($id,'wpep_fb_width',true);
				    	*/
				    	
				    	$fblink=get_post_meta($id,'wpep_fb_link',true);
				    	$fbheight=get_post_meta($id,'wpep_fb_height',true);
				    	if(empty($fblink)){
				    		echo _("missed facebook url");
				    	}else{
				        	echo '<iframe class="fb_widget" src="//www.facebook.com/plugins/likebox.php?href='.$fblink.'&amp;width=&amp;height='.$fbheight.'&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:'.$fbheight.'px;background:#fff" allowTransparency="true"></iframe>';		
				    	}
				        break;
				    case 'iframe':
				    	$iframe_url=get_post_meta($id,'wpep_iframe_url',true);
				    	$iframe_height=get_post_meta($id,'wpep_iframe_height',true);
				    	if(empty($iframe_url)){
				    		echo _("missed iframe url");
				    	}else{
				    		echo '<iframe style="width:100%;height:'.$iframe_height.'" src="'.$iframe_url.'"></iframe>';
				    	}
				    
				    	break;
				    default:
				    	$content=get_post_meta($id,'wpep_custom_content',true);
				    	$content=apply_filters('the_content',$content);
				    	echo "<div style='padding:2em'>".$content."</div>";
				    	break;
				}

				echo '</div>';

				if($hide_footer[0]!='yes'){
					echo '<div class="footer"><div class="wpep_time"></div></div>';					
				}

				echo '</div>';
			echo '</div>';
			

		
			
			echo '<script type="text/javascript">
				jQuery(function(){
				';

			if($show_on=='onclick'){

				echo 'jQuery("'.$click_on.'").click(function(){		
						open_popup('.$id.',"'.$open_effect.'");';

				if($hide_delay>0 && $auto_hide[0]=='yes'){
					echo 'hide_delay('.$id.',"'.$close_effect.'",'.$hide_delay.');';				
				}

				echo '
					  });
					';				

			}
			elseif($show_on=='onload2'){

				echo 'if(!getCookie("popup_'.$id.'")){
					setCookie("popup_'.$id.'",0,1);
				}';

				echo 'v=getCookie("popup_'.$id.'");';
				echo 'setCookie("popup_'.$id.'",parseInt(getCookie("popup_'.$id.'"))+1,1);';

				echo '	
					if('.$show_time.'>=v){
						open_popup('.$id.',"'.$open_effect.'");
					}';

			}else{
			
				echo '		
					open_popup('.$id.',"'.$open_effect.'");	
					';
			
				if($hide_delay>0 && $auto_hide[0]=='yes'){
					echo 'hide_delay('.$id.',"'.$close_effect.'",'.$hide_delay.');';				
				}

			}
				
			echo '
				jQuery("#wpep_close_'.$id.' ';

			if($auto_hide[0]!='yes'){
				echo ',#wpep_back_'.$id;
			}
			
			echo '").click(function(event){
					if(jQuery(event.target).attr("id")=="wpep_close_'.$id.'" || jQuery(event.target).attr("id")=="wpep_back_'.$id.'"){
						close_popup('.$id.',"'.$close_effect.'");
					}
				})
			});
			</script>';
			}
		
	}

	function popup_post() {

	$labels = array(
		'name'               => _x( 'Popups', 'post type general name', 'wpep' ),
		'singular_name'      => _x( 'Popup', 'post type singular name', 'wpep' ),
		'menu_name'          => _x( 'Popups', 'admin menu', 'wpep' ),
		'name_admin_bar'     => _x( 'Popup', 'add new on admin bar', 'wpep' ),
		'add_new'            => _x( 'Add New', 'Popup', 'wpep' ),
		'add_new_item'       => __( 'Add New Popup', 'wpep' ),
		'new_item'           => __( 'New Popup', 'wpep' ),
		'edit_item'          => __( 'Edit Popup', 'wpep' ),
		'view_item'          => __( 'View Popup', 'wpep' ),
		'all_items'          => __( 'All Popups', 'wpep' ),
		'search_items'       => __( 'Search Popups', 'wpep' ),
		'parent_item_colon'  => __( 'Parent Popups:', 'wpep' ),
		'not_found'          => __( 'No Popups found.', 'wpep' ),
		'not_found_in_trash' => __( 'No Popups found in Trash.', 'wpep' ),
	);

	$args = array(
	      'public' => true,
	      'label'  => 'Popups',
	      'labels' => $labels,
	      'supports' => array('title')
	    );
	    register_post_type( 'popup', $args );
	}
	add_action( 'init', 'popup_post' );

	function head_scripts(){

		wp_enqueue_style('animate.css',plugins_url( 'css/animate.min.css', __FILE__ ));
		wp_enqueue_style('wpep_style.css',plugins_url( 'css/style.css', __FILE__ ));
		
		if(!wp_script_is('jquery')){
			wp_enqueue_script('jquery');		
		}
	}

	add_action('wp_head','head_scripts',0);

	function footer_scripts(){

		$args = array(
				'post_type' => 'popup'
			);

		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) {

		
			while ( $the_query->have_posts() ) {

				$the_query->the_post();
				
				$show_in=get_post_meta(get_the_ID(),'wpep_show_in',false);

				if($show_in){
					$show_in=$show_in[0];
				}else{
					$show_in=array();
				}

				if(in_array('all',$show_in)){

					show_popup(get_the_ID());

				}
				elseif(is_home() && in_array('home',$show_in)){

					show_popup(get_the_ID());

				}
				elseif(is_front_page() && in_array('front',$show_in)){

					show_popup(get_the_ID());

				}
				elseif(is_page() && in_array('page',$show_in)){

					show_popup(get_the_ID());

				}
				elseif(is_single() && in_array('single',$show_in)){

					show_popup(get_the_ID());

				}

				

			}

		  

		} else {
			
		}
		
		wp_reset_postdata();
		
		wp_enqueue_script('wpep_script',plugins_url( 'js/script.js', __FILE__ ));
	}

	add_action('wp_footer','footer_scripts');

	function admin_scripts($hook) {
	    if( 'post.php' != $hook && 'post-new.php' != $hook)
	        return;
	    wp_enqueue_script( 'wpep_admin_script', plugin_dir_url( __FILE__ ) . 'js/wpep_admin_script.js' );
	}
	add_action( 'admin_enqueue_scripts', 'admin_scripts' );


	function wpep_shortcode( $atts ) {
		show_popup($atts['id']);
	}
	add_shortcode('wpep', 'wpep_shortcode');

	include 'functions/meta_box.php';
?>
