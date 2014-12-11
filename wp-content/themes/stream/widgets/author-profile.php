<?php
add_action('widgets_init', create_function('', 'return register_widget("AuthorSpotlight_Widget");'));

class AuthorSpotlight_Widget extends WP_Widget {

	var $icon_image_url;

	function __construct() {	   
		$widget_ops = array('classname' => 'AuthorSpotlight_Widget', 'description' => "Sidebar widget to display Author(s)' profile on a post page." );
		/* Widget control settings. */
		$control_ops = array('width' => 200, 'height' => 300);
		parent::__construct('authorspotlight', '&raquo;  Author Spotlight', $widget_ops, $control_ops);
		$this->icon_image_url = get_template_directory().'/ico/';
	}

	function widget( $args, $instance ) {		
		// If Co-Authors plus plugin exists display all co-aothor profiles one after another
		if(function_exists('coauthors_posts_links')) {
			$i = new CoAuthorsIterator(); 
			$cnt = 1;			
			while($i->iterate()){
				// the iterator overwrites the global authordata variable on each iteration
				$instance['seq'] = $cnt++;
				$instance['isLast'] = $i->is_last();
				$this->_displayAuthor($args, $instance);
			}
		}
		else {
			// Normal behavior, one author per blog post
			$instance['seq'] = 1;
			$instance['isLast'] = true;
			$this->_displayAuthor( $args, $instance);	
		}
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Author Spotlight', 'readfulltext' => 'Read Full', 'moretext' => 'More posts by the Author &raquo;', 'websitetext' => 'Website: ', 'charlimit' => '1000') );
		$title = strip_tags($instance['title']);
		$readfulltext = strip_tags($instance['readfulltext']);
		$moretext = strip_tags($instance['moretext']);
		$websitetext = strip_tags($instance['websitetext']);
		$charlimit = strip_tags($instance['charlimit']);		
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php  'Title:'  ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('moretext'); ?>"><i>"More articles by author"</i> text: </label>
			<input class="widefat" id="<?php echo $this->get_field_id('moretext'); ?>" name="<?php echo $this->get_field_name('moretext'); ?>" type="text" value="<?php echo esc_attr($moretext); ?>" />			
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('readfulltext'); ?>"><i>"Read full profile"</i> text: </label>
			<input class="widefat" id="<?php echo $this->get_field_id('readfulltext'); ?>" name="<?php echo $this->get_field_name('readfulltext'); ?>" type="text" value="<?php echo esc_attr($readfulltext); ?>" />			
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('charlimit'); ?>">Author profile character limit: </label>
			<input class="widefat" id="<?php echo $this->get_field_id('charlimit'); ?>" name="<?php echo $this->get_field_name('charlimit'); ?>" size="4" type="text" value="<?php echo esc_attr($charlimit); ?>" />			
		</p>		
		<p>
		    Which social icons should be displayed for the author(s)?<br/>
			<?php
			foreach ( $this->_getIconsAsArray() as $key => $data ) {
				printf('<div><input type="checkbox" value="1" id="%s" name="%s"', $this->get_field_id($key), $this->get_field_name($key));
				printf("%s", checked( 1, $instance[$key] ));
				echo(' />'. $data['img_title'] .'</div>&nbsp;');
				printf('%s', $data['img_seperator']);
			}
			?>		
		</p>

		
		<?php	  
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['readfulltext'] = strip_tags($new_instance['readfulltext']);
		$instance['moretext'] = strip_tags($new_instance['moretext']);
		$instance['charlimit'] = strip_tags($new_instance['charlimit']);		
		foreach ( $this->_getIconsAsArray() as $key => $data ) {
			$instance[$key] = strip_tags($new_instance[$key]);
		}
		return $instance;
	}
	
	// Does the actual work of preparing the profile markup
	private function _displayAuthor($args, $instance){
		global $authordata;
		extract( $args ); // extract arguments
		$isHome = is_home() || is_front_page(); //Don't show the Widget on home page

		if(!$isHome && (is_single() || is_page()) && $authordata->ID){			
			if($instance['seq'] == 1){
				echo $before_widget;
				echo $before_title . $instance['title'] . $after_title;
			}			

						//Display User photo OR the Gravatarv
			echo '<div class="author-tn">';
			if(function_exists('userphoto_exists') && userphoto_exists($authordata)){
				
					userphoto_thumbnail($authordata);
							
			}
			else {
				echo get_avatar($authordata->ID, 96);	
			}	
			echo "</div><!--author-tn-->";	

			echo '<div id="author-spotlight">';			
			echo '<div id="author-profile">';
			// Display author's name
			echo '<a href="'.get_author_posts_url($authordata->ID, $authordata->user_nicename ).'"><h5>'.get_the_author_meta('first_name').' '.get_the_author_meta('last_name').'</h5></a>';


			//Display the social icons?
			$socialDiv = "";			
			$iconCount = 0;
			$style = "";


			
			foreach ( $this->_getIconsAsArray() as $key => $data ) {	
                                $print_img = false;
				$social_url = get_the_author_meta( $key, $authordata->ID );	
				
				// Other Social URLs come from Author meta, we added
				if($social_url != "") {
					$print_img = true;
				}
				
				// The Website or Homepahge URL should be read from Author-Data					
				if($data['img_title'] == 'Homepage' && $authordata->user_url){
					$social_url = $authordata->user_url;
					$print_img = true;
				}
				
				// If the URL is available & the Icon is enabled from Widget Admin, display it
				if($print_img && $instance[$key]){
					$socialDiv .= '<a href="'.$social_url.'" target="_blank" title="'.$data['img_title'].'">';
					//$socialDiv .= '<img src="'.$data['img_src'].'" title="'.$data['img_title'].'" alt="'.$data['img_title'].'" />';
					$socialDiv .= '<i class="icon-'.$data['img_title'].'"></i>';					
					$socialDiv .= '</a>';
					++$iconCount;
				}

			}
			
			if($iconCount <= 0){
				$style = "display:none;";
			}
			else if($iconCount > 6 && $iconCount <= 12){
				$style = "";
			}
			else if($iconCount > 12){
				$style = "";
			}
			
		
			

			
			//Display author profile, with link to full profile
			$author_posts_link = get_author_posts_url($authordata->ID, $authordata->user_nicename );
			$auth_post_count = get_the_author_posts();
			echo '<div id="author-description">';
			echo $this->_getSnippet(get_the_author_meta('description'),$instance['charlimit'],'...').'&nbsp;';			
			echo "</div><!--#author-description-->";
			//echo '<div id="author-link"><a href="'.$author_posts_link.'" title="More articles by this author">'.$instance['moretext'] .'</a></div>';
			//HR
			echo '<div class="author-profile-hr"></div>';
			printf('<div id="social-icons" style="%s">', $style);
			echo $socialDiv;
			echo "</div><!--#social-icons-->";

			echo '<span class="author-profile-also"><a href="'.$author_posts_link.'">'.'Also by ' .get_the_author(). ' (' .$auth_post_count. ')</a></span>';
			echo "</div><!--#author-profile-->";
			echo "</div><!--#author-spotlight-->";

			
			if($instance['isLast']){
				echo $after_widget;  
			}


		}
	}
	
	// Returns a trimmed String of specified length
	function _getSnippet($text, $length=1000, $tail="...") {
		$text = trim($text);
		$txtl = strlen($text);
		if($txtl > $length) {
			for($i=1;$text[$length-$i]!=" ";$i++) {
				if($i == $length) {
					return substr($text,0,$length) . $tail;
				}
			}
			$text = substr($text,0,$length-$i+1) . $tail;
		}
		return $text;
	}
	
	function _getIconsAsArray() {
		return array(
			'home' => array(
				//'img_src' => $this->icon_image_url . 'home.png',
				'img_title' => 'homepage',
				'img_seperator' => '&nbsp;'
			),
			'facebook' => array(
				//'img_src' => $this->icon_image_url . 'facebook.png',
				'img_title' => 'facebook',
				'img_seperator' => '&nbsp;'
			),
			'twitter' => array(
				//'img_src' => $this->icon_image_url . 'twitter.png',
				'img_title' => 'twitter',
				'img_seperator' => '&nbsp;'
			),
			'linkedin' => array(
				//'img_src' => $this->icon_image_url . 'linkedin.png',
				'img_title' => 'linkedin',
				'img_seperator' => '&nbsp;'
			),
			'flickr' => array(
				//'img_src' => $this->icon_image_url . 'flickr.png',
				'img_title' => 'flickr',
				'img_seperator' => '&nbsp;'
			),
			'myspace' => array(
				//'img_src' => $this->icon_image_url . 'myspace.png',
				'img_title' => 'myspace',
				'img_seperator' => '<br/>'
			),
			'friendfeed' => array(
				//'img_src' => $this->icon_image_url . 'friendfeed.png',
				'img_title' => 'friendfeed',
				'img_seperator' => '&nbsp;'
			),
			'delicious' => array(
				//'img_src' => $this->icon_image_url . 'delicious.png',
				'img_title' => 'delicious',
				'img_seperator' => '&nbsp;'
			),
			'digg' => array(
				//'img_src' => $this->icon_image_url . 'digg.png',
				'img_title' => 'digg',
				'img_seperator' => '&nbsp;'
			),			
			'feed' => array(
				//'img_src' => $this->icon_image_url . 'feed.png',
				'img_title' => 'rss',
				'img_seperator' => '&nbsp;'
			),
			'tumblr' => array(
				//'img_src' => $this->icon_image_url . 'tumblr.png',
				'img_title' => 'tumblr',
				'img_seperator' => '&nbsp;'
			),
			'youtube' => array(
				//'img_src' => $this->icon_image_url . 'youtube.png',
				'img_title' => 'youtube',
				'img_seperator' => '<br/>'
			),
			'blogger' => array(
				//'img_src' => $this->icon_image_url . 'blogger.png',
				'img_title' => 'blogger',
				'img_seperator' => '&nbsp;'
			),
			'googleplus' => array(
				//'img_src' => $this->icon_image_url . 'googleplus.png',
				'img_title' => 'google-plus',
				'img_seperator' => '&nbsp;'
			),
			'instagram' => array(
				//'img_src' => $this->icon_image_url . 'instagram.png',
				'img_title' => 'instagram',
				'img_seperator' => '&nbsp;'
			),
			'slideshare' => array(
				//'img_src' => $this->icon_image_url . 'slideshare.png',
				'img_title' => 'Slide Share',
				'img_seperator' => '&nbsp;'
			),
			'stackoverflow' => array(
				//'img_src' => $this->icon_image_url . 'stackoverflow.png',
				'img_title' => 'Stackoverflow',
				'img_seperator' => '&nbsp;'
			),
			'posterous' => array(
				//'img_src' => $this->icon_image_url . 'posterous.png',
				'img_title' => 'Posterous',
				'img_seperator' => ''
			),
		);
	}
}
?>