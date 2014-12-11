<?php
class FeedburnerEmailWidget extends WP_Widget {
    /**
     * Constructor
     */
    function FeedburnerEmailWidget() {
        $widget_ops = array(
            'classname' => 'FeedburnerEmailWidget',
            'description' => 'Allows you to add a Feedburner Email Subscription widget to one of your sidebars.',
        );
        $this->WP_Widget('FeedburnerEmailWidget', '&raquo;  Feedburner Email Widget', $widget_ops);
    }
    
    /**
     * Build the admin widget manipulation form
     * 
     * @param array $instance
     */
    function form($instance) {
        $instance = wp_parse_args((array) $instance, array(
                'title' => '',
                'uri' => '',
                'above_email' => '',
                'below_email' => '',
                'email_text_input' => '',
                'subscribe_btn' => '',
                'full_width' => '',                
                'show_link' => '',
                'background_img' => '',                
                'form_id' => ''
            )
        );
        $title = esc_attr($instance['title']);
        $uri = esc_attr($instance['uri']);
        $above_email = esc_attr($instance['above_email']);
        $below_email = esc_attr($instance['below_email']);
        $email_text_input = esc_attr($instance['email_text_input']);
        $subscribe_btn = esc_attr($instance['subscribe_btn']);
        $full_width = esc_attr($instance['full_width']);        
        $show_link = esc_attr($instance['show_link']);
        $background_img = esc_attr($instance['background_img']);        
        $form_id = esc_attr($instance['form_id']);

?>
        <a id="<?php echo $this->get_field_id('title'); ?>_div_a" style="cursor: pointer;">-</a> <span id="<?php echo $this->get_field_id('title'); ?>_div_span" style="cursor: pointer;">Basic Options</span><br />
        <div id="<?php echo $this->get_field_id('title'); ?>_div" style="display: block;">
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:' ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('uri'); ?>"><?php echo 'Feedburner feed URL:' ?> <input class="widefat" id="<?php echo $this->get_field_id('uri'); ?>" name="<?php echo $this->get_field_name('uri'); ?>" type="text" value="<?php echo $uri; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('above_email'); ?>"><?php echo 'Above input text:' ?> <input class="widefat" id="<?php echo $this->get_field_id('above_email'); ?>" name="<?php echo $this->get_field_name('above_email'); ?>" type="text" value="<?php echo $above_email; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('below_email'); ?>"><?php echo 'Below input text:' ?> <input class="widefat" id="<?php echo $this->get_field_id('below_email'); ?>" name="<?php echo $this->get_field_name('below_email'); ?>" type="text" value="<?php echo $below_email; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('email_text_input'); ?>"><?php echo 'Input placeholder text:' ?> <input class="widefat" id="<?php echo $this->get_field_id('email_text_input'); ?>" name="<?php echo $this->get_field_name('email_text_input'); ?>" type="text" value="<?php echo $email_text_input; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('subscribe_btn'); ?>"><?php echo 'Submit button caption:' ?> <input class="widefat" id="<?php echo $this->get_field_id('subscribe_btn'); ?>" name="<?php echo $this->get_field_name('subscribe_btn'); ?>" type="text" value="<?php echo $subscribe_btn; ?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('full_width'); ?>"><?php echo 'Fullwidth:' ?> <input class="widefat" id="<?php echo $this->get_field_id('full_width'); ?>" name="<?php echo $this->get_field_name('full_width'); ?>" type="checkbox"<?php echo (($full_width) ? ' checked' : ''); ?> /></label></p>
            <p><label for="<?php echo $this->get_field_id('background_img'); ?>"><?php echo 'Background Image:' ?> <input class="widefat" id="<?php echo $this->get_field_id('background_img'); ?>" name="<?php echo $this->get_field_name('background_img'); ?>" type="text" value="<?php echo $background_img; ?>" /></label></p>            
            <p><label for="<?php echo $this->get_field_id('show_link'); ?>"><?php echo 'Show feedburner link:' ?> <input class="widefat" id="<?php echo $this->get_field_id('show_link'); ?>" name="<?php echo $this->get_field_name('show_link'); ?>" type="checkbox"<?php echo (($show_link) ? ' checked' : ''); ?> /></label></p>
        </div>


        <script type="text/javascript">
            /*
             * For those wondering why I don't use jquery to toggle the different settings: I doesn't seem to work with the default functions
             * if anyway can provide me a working example I would love to hear about it but I'm not just gonne look hours and hours at
             * the problem if it can be solved like this ;).
             */
            function feedburner_email_widget_admin_toggle_visibility(id) {
                var e = document.getElementById(id);
                var e_a = document.getElementById(id + '_a');
                if(e.style.display == 'block') {
                    e.style.display = 'none';
                    e_a.innerHTML = '+';
                } else {
                    e.style.display = 'block';
                    e_a.innerHTML = '-';
                }
            }
            addLoadEvent(function() {
                jQuery('#<?php echo $this->get_field_id('title'); ?>_div_a, #<?php echo $this->get_field_id('title'); ?>_div_span').click(function() {
                    feedburner_email_widget_admin_toggle_visibility('<?php echo $this->get_field_id('title'); ?>_div');
                    return true;
                });
                jQuery('#<?php echo $this->get_field_id('form_id'); ?>_div_a, #<?php echo $this->get_field_id('form_id'); ?>_div_span').click(function() {
                    feedburner_email_widget_admin_toggle_visibility('<?php echo $this->get_field_id('form_id'); ?>_div');
                    return true;
                });
                jQuery('#<?php echo $this->get_field_id('analytics_cat'); ?>_div_a, #<?php echo $this->get_field_id('analytics_cat'); ?>_div_span').click(function() {
                    feedburner_email_widget_admin_toggle_visibility('<?php echo $this->get_field_id('analytics_cat'); ?>_div');
                    return true;
                });
            });
        </script>
        <script type="text/javascript">
        /* <![CDATA[ */
            (function() {
                var s = document.createElement('script'), t = document.getElementsByTagName('script')[0];
                s.type = 'text/javascript';
                s.async = true;
                s.src = 'http://api.flattr.com/js/0.6/load.js?mode=auto';
                t.parentNode.insertBefore(s, t);
            })();
        /* ]]> */
        </script>
<?php
    }
    
    /**
     * 
     * @param unknown $new_instance
     * @param unknown $old_instance
     * @return unknown
     */
    function update($new_instance, $old_instance) {
        return $new_instance;
    }

    /**
     * 
     * @param array $args
     * @param array $instance
     */
    function widget($args, $instance) {
        echo $this->generate($args, $instance);
    }
    
    /**
     * Generate the widget
     * 
     * @param array $args Arguments
     * @param array $instance 
     * @return string Generated HTML
     */
    function generate($args, $instance) {
        extract($args, EXTR_SKIP);
        $html = $before_widget;
        // Grab the settings from $instance and full them with default values if we can't find any
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        $uri = empty($instance['uri']) ? false : $instance['uri'];
        $above_email = empty($instance['above_email']) ? false : $instance['above_email'];
        $below_email = empty($instance['below_email']) ? false : $instance['below_email'];
        $subscribe_btn = empty($instance['subscribe_btn']) ? 'Subscribe' : $instance['subscribe_btn'];
        $email_text_input = empty($instance['email_text_input']) ? '' : $instance['email_text_input'];
        $full_width = (isset($instance['full_width']) && $instance['full_width']) ? true : false;        
        $show_link = (isset($instance['show_link']) && $instance['show_link']) ? true : false;
        $background_img = empty($instance['background_img']) ? false : $instance['background_img'];        
        $form_id = empty($instance['form_id']) ? 'feedburner_email_widget_sbef' : $instance['form_id'];

            if ($full_width) {
                $html .= '</div><!-- .row --></div><!-- .container -->';

            }    

$html .= '<div class="cta-widget" style="background-image:url('.$background_img. '); background-size: cover;"><div class="cta-wrap">';
$http = "://";
        // Cut out the part we need
        $uri = parse_url($uri);
        if ($uri['host'] == 'feedburner.google.com' && !empty($uri['query'])) {
            $uri = $uri['query'];
            parse_str($uri, $queryParams);
        } else if ($uri['host'] == 'feeds.feedburner.com' && !empty($uri['path'])) {
            $uri = substr($uri['path'], 1, (strlen($uri['path']) -1));
            $queryParams = array(
                'uri' => $uri,
            );
            $uri = 'uri=' . $uri;
        } else if (!isset($uri['host']) && isset($uri['path'])) {
            $queryParams = array(
                'uri' => $uri['path'],
            );
            $uri = 'uri=' . $uri['path'];
        } else {
            $uri = false;
            $queryParams = array();
        }
        
        if ($uri && count($queryParams) > 0) {
            
            if (!isset($queryParams['loc'])) {
                $queryParams['loc'] ='en_US';
            }
            
            if (!empty($title)) {
                if(!isset($before_title)) {
                    $before_title = '';
                }
                if(!isset($after_title)) {
                    $after_title = '';
                }
                $html .= '<h2>' . trim($title) . '</h2>';
            }

            // Putting onSubmit code together
            $onsubmit = array();
            // Default feedburner window
            $onsubmit[] = 'window.open(\'http'.$http.'feedburner.google.com/fb/a/mailverify?' . $uri . '\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\');';

            $onsubmit[] = 'return true;';
            // Open Form
            $html .= '<form id="' . trim($form_id) . '" action="http'.$http.'feedburner.google.com/fb/a/mailverify" method="post" onsubmit="' . implode('', $onsubmit) . '" target="popupwindow">';
            if ($above_email) {
                $html .= '<p>' . trim($above_email) . '</p>';
            }
            $html .= '<input id="' . trim($form_id) . '_email" name="email" type="text" ';
            if(!empty($email_text_input)) {
                $html .= 'class="subscribe-field" value="" placeholder="'. htmlentities(trim($email_text_input)) . '" onclick="javascript:if(this.value==\'' . addslashes(htmlentities(trim($email_text_input))) . '\'){this.value= \'\';}" ';
            }
            $html .= '/><br/>';
            // Hidden fields
            foreach ($queryParams as $index => $queryParam) {
                $html .= '<input  type="hidden" value="' . $queryParam . '" name="' . $index . '"/>';
            }
            if ($below_email) {
                $html .= '<p class="small">' . trim($below_email) . '</p>';
            }
            $html .= '<input class="homeCta" id="' . trim($form_id) . '_submit" type="submit" value="' . htmlentities(trim($subscribe_btn)) . '" />';


            $html .= '</form>';
        }

            $html .= '</div>';
            if ($show_link) {
                $html .= '<div class="feedburner-link"><p>Delivered by <a href="http'.$http.'feedburner.google.com" target="_blank">FeedBurner</a></p></div>';
            }else{
                $html .= '</div>';
            }


        if ( $full_width != "" ){
            $html .= '</div><div class="container"><div class="row">';
        }
        $html .= $after_widget;
        // Send the widget to the browser
        return $html;
    }

}

// Tell WordPress about our widget
add_action('widgets_init', create_function('', 'return register_widget(\'FeedburnerEmailWidget\');'));

/**
 * 
 * @param array $atts Widget attributes
 * @return string Generated HTML for the widget
 */
function feedburner_email_widget_shortcode_func($atts) {
	return FeedburnerEmailWidget::generate(array(), shortcode_atts(array(
            'title' => ' ',
            'uri' => false,
            'above_email' => false,
            'below_email' => false,
            'subscribe_btn' => 'Subscribe',
            'full_width' => false,
            'show_link' => false,    
            'background_img' => false,
            'form_id' => 'feedburner_email_widget_sbef',
	), $atts));
}
// Add shortcode
add_shortcode('feedburner_email_widget', 'feedburner_email_widget_shortcode_func');