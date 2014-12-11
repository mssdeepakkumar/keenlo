<?php
/*
Plugin Name: Tweetable Text
Original Plugin URI: http://wordpress.org/extend/plugins/tweetable-text/
Description: Make your posts more shareable. Add a Tweet and Buffer button to key sentences right inside each blog post with a simple [tweetable] tag.
Version: 1.1
Author: Salim Virani (original), updated by Joshua Benton of Nieman Lab
*/
//Stops WordPress from converting your quote symbols into smartquotes, since they are not compatible with the Twitter Share button. (The urlencoding of single quotes / apostrophes breaks in the tweet.)
//remove_filter('the_content', 'wptexturize');
class TweetableText{
 function makeTweetable($atts, $content = "") {
   extract(shortcode_atts(array(
      'alt' => '',
      'hashtag' => '',
   ), $atts));
   global $wpdb, $post;

		$post_id = $post->ID;
		$permalink = get_permalink($post_id);

		$tweetcontent = ucfirst(strip_tags($content));

		if ($alt != '') $tweetcontent = $alt;
		if ($hashtag != '') $tweetcontent .= " " . $hashtag;

		$ret = "<span class='tweetable'>";
		$ret .= "<a href='https://twitter.com/intent/tweet?original_referer=".urlencode($permalink)."&source=tweetbutton&text=".rawurlencode(($tweetcontent)) ."&url=".urlencode($permalink)."'>$content&thinsp;<i class='icon-twitter tweetable-icon'></i>";
		$ret .= "</a>";
		$ret .= "<span class='sharebuttons'>";

		$ret .= "<a href='https://twitter.com/intent/tweet?original_referer=".urlencode($permalink)."&source=tweetbutton&text=".rawurlencode(($tweetcontent)) ."&url=".urlencode($permalink)."'>Tweet";
		$ret .= "</a>";


		$ret .= "</span>";
		$ret .= "</span>";
            return $ret;
     }
}

add_shortcode( 'tweetable', array('TweetableText', 'makeTweetable') );

function tweetabletext_header() {
?>

<style>

</style>
<?php
}

if (!is_admin()) {
	add_action(  'wp_head', 'tweetabletext_header' ); 
}
?>
