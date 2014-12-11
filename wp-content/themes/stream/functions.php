<?php
/**
 *
 * @author Heath Taskis | http://fdthemes.com
 * @package FD Framework 0.1
 */

if (!isset($content_width)) $content_width = 770;

/**
 * upbootwp_setup function.
 * 
 * @access public
 * @return void
 */
function upbootwp_setup() {

	require 'inc/general/class-Upbootwp_Walker_Nav_Menu.php';

	load_theme_textdomain( 'stream', get_template_directory().'/languages');

	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );


	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'Bootstrap WP Primary' ),
        'catnav' => __( 'Tabloid Category Menu', 'Category Menu' ),        
        'secondary' => __( 'Secondary Menu', 'Stream' )));

	/**
	 * Enable support for Post Formats
	 */
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ));


	/**
	 * Setup the WordPress core custom background feature.
	 */
	add_theme_support( 'custom-background', apply_filters( 'upbootwp_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => ''
	)));	
}


add_action( 'after_setup_theme', 'upbootwp_setup');

/**
 * Register widgetized area and update sidebar with default widgets
 */
function upbootwp_widgets_init() {
	register_sidebar(array(
		'name'          => __('Sidebar','upbootwp'),
		'id'            => 'sidebar-1',
        'description' => __( 'Widgets in this area will be shown on the right-hand side of a page.', 'fd' ),        
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>'
	));
    register_sidebar( array(
        'name' => 'Above Content',
        'id' => 'above_content',
        'description' => __( 'Widgets in this area will be shown above the content.', 'fd' ),        
        'before_widget' => '<div id="above-content">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));    
    register_sidebar( array(
        'name' => 'Below Blog/Index',
        'id' => 'below_blog',
        'description' => __( 'Widgets in this area will be shown below the blog content.', 'fd' ),        
        'before_widget' => '<div id="below-content">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>'
    ));
    register_sidebar( array(
       'name' => 'Sidebar Post',
       'id' => 'landingpage',
       'description' => __( 'Display widgets on the right-hand side of a post.', 'fd' ),
       'before_widget' => '<aside id="%1$s" class="widget %2$s">',
       'after_widget' => "</aside>",
       'before_title' => '<h4 class="widget-title">',
       'after_title' => '</h4>'
   ));
    register_sidebar( array(
        'name' => 'Below Post Content',
        'id' => 'below_post',
        'description' => __( 'Display widgets below the post content.', 'fd' ),        
        'before_widget' => '<div id="below-post-content">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>'
    ));
    register_sidebar( array(
        'name' => 'Footer Slot 1',
        'id' => 'footer_one',
        'description' => __( 'Widgets in this area will be shown in the first column of the footer.', 'fd' ),        
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));    
    register_sidebar( array(
        'name' => 'Footer Slot 2',
        'id' => 'footer_two',
        'description' => __( 'Widgets in this area will be shown in the second column of the footer.', 'fd' ),        
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));    
         register_sidebar( array(
        'name' => 'Footer Slot 3',
        'id' => 'footer_three',
        'description' => __( 'Widgets in this area will be shown in the third column of the footer.', 'fd' ),        
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));  
         register_sidebar( array(
        'name' => 'Footer Slot 4',
        'id' => 'footer_four',
        'description' => __( 'Widgets in this area will be shown in the fourth column of the footer.', 'fd' ),        
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));           
          
}
add_action( 'widgets_init', 'upbootwp_widgets_init' );


function upbootwp_scripts() {

    // ========================  JS
    //wp_enqueue_script( 'upbootwp-jQuery', get_template_directory_uri().'/js/jquery.js',array(),'2.0.3',false);
    wp_enqueue_script( 'upbootwp-basefile', get_template_directory_uri().'/js/bootstrap.min.js',array(),'20130905',true);
    wp_enqueue_script( 'bootstrap-tabdrop', get_template_directory_uri().'/js/bootstrap-tabdrop.js',array(),'20131002',true);      
    wp_enqueue_script( 'fd-global-js', get_template_directory_uri().'/js/fd-global.js',array(),'20131002',true);          
    wp_enqueue_script( 'unveil-js', get_template_directory_uri().'/js/jquery.unveilEffects.min.js',array(),'20131002',true);         
    wp_enqueue_script( 'colorpicker-js', get_template_directory_uri().'/js/colorpicker.js',array(),'20131031',true);        
    wp_enqueue_script( 'masterslider-js', get_template_directory_uri().'/js/masterslider.min.js',array(),'20131031',true);         
    wp_enqueue_script( 'fitvid-js', get_template_directory_uri().'/js/fitvid.js',array(),'20140205',true);    


    // END JS

	// ========================     CSS
	wp_enqueue_style( 'fd-css', get_template_directory_uri().'/css/bootstrap-fd.css', array(), '20131002');	
	wp_enqueue_style( 'bootstrap_admin', get_template_directory_uri().'/css/bootstrap_admin.css', array(), '20131002');		
	wp_enqueue_style( 'jquery-fancybox-css', get_template_directory_uri().'/css/jquery.fancybox.css', array(), '20131002');	
	wp_enqueue_style( 'colorpicker', get_template_directory_uri().'/css/colorpicker.css', array(), '20131002');		      
    wp_enqueue_style( 'masterslider', get_template_directory_uri().'/css/masterslider.css', array(), '20131002');    
    wp_enqueue_style( 'masterslider-skins', get_template_directory_uri().'/css/skins/default/style.css', array(), '20131002');  
    wp_enqueue_style( 'fd-icons-skins', get_template_directory_uri().'/css/fd-icons.css', array(), '20131002');    
    wp_enqueue_style( 'nav-css', get_template_directory_uri().'/css/nav-css.php', array(), '20131002');     
    // END CSS



}
add_action( 'wp_enqueue_scripts', 'upbootwp_scripts' );


/**
 *	Custom Widgets
 */
include('widgets/rpwe.php');
include('widgets/rpgw.php');
include('widgets/rpwe-sidebar.php');
include('widgets/author-profile.php');
include('widgets/post-tabs.php');
include('widgets/most-popular.php');
include('widgets/next-post-widget.php');
include('widgets/posted-in-widget.php');
include('widgets/better-recent-comments-widget.php');
include('widgets/post-tags-widget.php');
include('widgets/editor-message-widget.php');
include('widgets/feedburner-subscription-widget.php');
include('widgets/recent-images-gallery-widget.php');
include('widgets/vine-widget.php');
include('widgets/ad-widget.php');


/**
 *  Custom CSS
 */
include('inc/custom-css.php');


/**
 *  Views Counter
 */
include('inc/views-count.php');


/**
 *  Tweetable Text
 */
include('inc/tweetable-text.php');

/**
 *  Category Images
 */
include('inc/categories-images.php');



/**
 *	Shortcodes
 */


// Add Shortcode buttons in TinyMCE
$elements = array(
    'toggles',
    'tabs',
    'lists',
    'buttons',
    'notifications',
    'wpcolumns',
    'tables',
    'tooltip',
    'iconhead',
    'panel',
    'popover',
    'dropdown',
    'labels',
    'well',
    'thumbnail',
    'icon',
    'image',
    'slidetastic',
    'progressbar'
);

foreach ($elements as $element){
    include( 'inc/shortcodes/' .  $element . '/plugin_shortcode.php');
}


// --------------------------------------------------------------------------------------------------------------

add_action('init', 'add_custom_button');

function add_custom_button() {
    //global $elements;
    // Don't bother doing this stuff if the current user lacks permissions
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages'))
        return;

    // Add only in Rich Editor mode
    if (get_user_option('rich_editing') == 'true') {

        add_filter("mce_external_plugins", "add_custom_plugin");
        add_filter('mce_buttons_3', 'register_custom_button');
    wp_enqueue_script('jquery.fancybox',  get_template_directory_uri() .'/js/jquery.fancybox.js',array(),'20140205',true); 
        wp_enqueue_style('fancyboxcss',  get_template_directory_uri() .'/css/jquery.fancybox.css', __FILE__);
        wp_enqueue_style('bootstrap-icon',  get_template_directory_uri() .'/css/bootstrap-icon.css', __FILE__);
        wp_enqueue_style('bootstrap_admin', get_template_directory_uri() .'/css/bootstrap_admin.css', __FILE__);
    }
}

function register_custom_button($buttons) {
    global $elements;
    foreach ($elements as $element) {
        $buttons[] = 'oscitas' . $element;
    }
    return $buttons;
}

// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_custom_plugin($plugin_array) {
    //print_r($elements); exit;
    global $elements;
    foreach ($elements as $element) {
        $plugin_array['oscitas' . $element] = get_template_directory_uri() . '/inc/shortcodes/' . $element . '/' . $element . '_plugin.js';
		//$plugin_array['oscitas' . $element] = plugins_url('', __FILE__) . '/' . $element . '/' . $element . '_plugin.js';        
    }
    /// return $buttons;
    return $plugin_array;
}


/**
 *  MAKE CUSTOM POST TYPES SEARCHABLE
 */ 
function searchAll( $query ) {
 if ( $query->is_search ) { $query->set( 'post_type', array( 'site', 'plugin', 'theme', 'person' )); } 
 return $query;
}
add_filter( 'the_search_query', 'searchAll' );


// shortcode in widgets
if ( !is_admin() ){
    add_filter('widget_text', 'do_shortcode', 11);
}





/**
 * Custom template tags for this theme.
 */
require get_template_directory().'/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory().'/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory().'/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory().'/inc/jetpack.php';





/**
*
* THEME SETTINGS
*
**/
include('inc/settings/social.php');

// Default comment form includes name, email address and website URL
// Default comment form elements are hidden when user is logged in

add_filter('comment_form_default_fields', 'fd_custom_fields');
function fd_custom_fields($fields) {

        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '');

        $fields[ 'author' ] = '<div class="comment-form-author">'.
            '<label for="author">' . __( '', 'fdthemes' ) . '</label>'.
            ( $req ? '<span class="required"></span>' : '' ).
            '<div class="input-prepend">
                <input id="author" name="author" class="input-xlarge" type="text" placeholder="Your Name *" value="'. esc_attr( $commenter['comment_author'] ) .
            '" size="30" tabindex="1"' . $aria_req . ' style="width:100%;" />
            </div></div>';
            
        $fields[ 'email' ] = '<div class="comment-form-email">'.
            '<label for="email">' . __( '', 'fdthemes' ) . '</label>'.
            ( $req ? '<span class="required"></span>' : '' ).
            '<div class="input-prepend">
                        <input id="email" name="email" class="input-xlarge" placeholder="Your Email *" type="text" value="'. esc_attr( $commenter['comment_author_email'] ) .
            '" size="30"  tabindex="2"' . $aria_req . ' style="width:100%;"/>
                        </div></div>';

        $fields[ 'url' ] = '<div class="comment-form-url">'.
            '<label for="url">' . __( '', 'fdthemes' ) . '</label>'.
            '<div class="input-prepend">
                       <input id="url" name="url" type="text" class="input-xlarge" placeholder="Website" value="'. esc_attr( $commenter['comment_author_url'] ) .
            '" size="30"  tabindex="3" style="width:100%;"/>
                        </div></div>';
    return $fields;
}

/*Add Social URLs*/
function author_spotlight_contactmethods( $contactmethods ) {
    if ( !isset( $contactmethods['twitter'] ) )
        $contactmethods['twitter'] = 'Twitter';
    if ( !isset( $contactmethods['facebook'] ) )
        $contactmethods['facebook'] = 'Facebook';
    if ( !isset( $contactmethods['linkedin'] ) )
        $contactmethods['linkedin'] = 'LinkedIn';   
    if ( !isset( $contactmethods['flickr'] ) )
        $contactmethods['flickr'] = 'Flickr';   
    if ( !isset( $contactmethods['myspace'] ) )
        $contactmethods['myspace'] = 'MySpace';     
    if ( !isset( $contactmethods['friendfeed'] ) )
        $contactmethods['friendfeed'] = 'Friendfeed';   
    if ( !isset( $contactmethods['delicious'] ) )
        $contactmethods['delicious'] = 'Delicious';     
    if ( !isset( $contactmethods['digg'] ) )
        $contactmethods['digg'] = 'Digg';   
    if ( !isset( $contactmethods['feed'] ) )
        $contactmethods['feed'] = 'XML Feed';   
    if ( !isset( $contactmethods['tumblr'] ) )
        $contactmethods['tumblr'] = 'Tumblr';   
    if ( !isset( $contactmethods['youtube'] ) )
        $contactmethods['youtube'] = 'YouTube'; 
    if ( !isset( $contactmethods['blogger'] ) )
        $contactmethods['blogger'] = 'Blogger'; 
    if ( !isset( $contactmethods['googleplus'] ) )
        $contactmethods['googleplus'] = 'Google+'; 
    if ( !isset( $contactmethods['instagram'] ) )
        $contactmethods['instagram'] = 'Instagram'; 
    if ( !isset( $contactmethods['slideshare'] ) )
        $contactmethods['slideshare'] = 'Slideshare'; 
    if ( !isset( $contactmethods['stackoverflow'] ) )
        $contactmethods['stackoverflow'] = 'Stackoverflow'; 
    if ( !isset( $contactmethods['posterous'] ) )
        $contactmethods['posterous'] = 'Posterous'; 
            
    return $contactmethods;
}

add_filter('user_contactmethods','author_spotlight_contactmethods');

function create_my_cat () {
    if (file_exists (ABSPATH.'/wp-admin/includes/taxonomy.php')) {
        require_once (ABSPATH.'/wp-admin/includes/taxonomy.php'); 
        if ( ! get_cat_ID( 'Featured' ) ) {
            wp_create_category( 'Featured' );
        }
    }
}
add_action ( 'after_setup_theme', 'create_my_cat' );

function stream_theme_add_editor_styles() {
    add_editor_style( '/css/custom-editor-style.css' );
}
add_action( 'init', 'stream_theme_add_editor_styles' );

//Comments - Add extra layer of protection from Spam
function check_referrer() {
    if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == '') {
        wp_die( __('Please enable referrers in your browser, or, if you\'re a spammer, get out of here!') );
    }
}
 
add_action('check_comment_flood', 'check_referrer');




/*  Add responsive container to embeds
/* ------------------------------------ */ 
function alx_embed_html( $html ) {
    return '<div class="video-container">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'alx_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'alx_embed_html' ); // Jetpack

/*  Get the first image from each post
/* ------------------------------------ */ 
function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];

  if(empty($first_img)) {
    $first_img = "/path/to/default.png";
  }
  return $first_img;
}

//Limit Tag Cloud
add_filter('widget_tag_cloud_args', 'tag_widget_limit');

//Limit number of tags inside widget
function tag_widget_limit($args){

 //Check if taxonomy option inside widget is set to tags
 if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
  $args['number'] = 20; //Limit number of tags
 }

 return $args;
}


/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';
 
add_action( 'tgmpa_register', 'stream_theme_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function stream_theme_register_required_plugins() {
 
   /**
    * Array of plugin arrays. Required keys are name and slug.
    * If the source is NOT from the .org repo, then source is also required.
    */
   $plugins = array(
      /** This is an example of how to include a plugin pre-packaged with a theme */
      array(
         'name'     => 'Taqyeem', // The plugin name
         'slug'     => 'taqyeem', // The plugin slug (typically the folder name)
         'source'   => get_stylesheet_directory() . '/inc/plugins/taqyeem.zip', // The plugin source
         'required' => false,
      ),
      array(
         'name'     => 'Arqam', // The plugin name
         'slug'     => 'arqam', // The plugin slug (typically the folder name)
         'source'   => get_stylesheet_directory() . '/inc/plugins/arqam.zip', // The plugin source
         'required' => false,
      ),    
      array(
         'name'     => 'Photomosaic', // The plugin name
         'slug'     => 'photomosaic-for-wordpress', // The plugin slug (typically the folder name)
         'source'   => get_stylesheet_directory() . '/inc/plugins/photomosaic-for-wordpress.zip', // The plugin source
         'required' => false,
      ),       
      array(
         'name'     => 'Ultimate Social Deux', // The plugin name
         'slug'     => 'ultimate-social-deux', // The plugin slug (typically the folder name)
         'source'   => get_stylesheet_directory() . '/inc/plugins/ultimate-social-deux.zip', // The plugin source
         'required' => false,
      ),    
      array(
         'name'     => 'Post Read Time', // The plugin name
         'slug'     => 'post-reading-time', // The plugin slug (typically the folder name)
         'source'   => get_stylesheet_directory() . '/inc/plugins/post-reading-time.zip', // The plugin source
         'required' => false,
      ),                 
      /** This is an example of how to include a plugin from the WordPress Plugin Repository */
      array(
         'name' => 'Easy Google Fonts',
         'slug' => 'easy-google-fonts',
      ),
   );
 
   /** Change this to your theme text domain, used for internationalising strings */
   $theme_text_domain = 'tgmpa';
 
   /**
    * Array of configuration settings. Uncomment and amend each line as needed.
    * If you want the default strings to be available under your own theme domain,
    * uncomment the strings and domain.
    * Some of the strings are added into a sprintf, so see the comments at the
    * end of each line for what each argument will be.
    */
   $config = array(
      /*'domain'       => $theme_text_domain,         // Text domain - likely want to be the same as your theme. */
      /*'default_path' => '',                         // Default absolute path to pre-packaged plugins */
      /*'menu'         => 'install-my-theme-plugins', // Menu slug */
      'strings'          => array(
         /*'page_title'             => __( 'Install Required Plugins', $theme_text_domain ), // */
         /*'menu_title'             => __( 'Install Plugins', $theme_text_domain ), // */
         /*'instructions_install'   => __( 'The %1$s plugin is required for this theme. Click on the big blue button below to install and activate %1$s.', $theme_text_domain ), // %1$s = plugin name */
         /*'instructions_activate'  => __( 'The %1$s is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
         /*'button'                 => __( 'Install %s Now', $theme_text_domain ), // %1$s = plugin name */
         /*'installing'             => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name */
         /*'oops'                   => __( 'Something went wrong with the plugin API.', $theme_text_domain ), // */
         /*'notice_can_install'     => __( 'This theme requires the %1$s plugin. <a href="%2$s"><strong>Click here to begin the installation process</strong></a>. You may be asked for FTP credentials based on your server setup.', $theme_text_domain ), // %1$s = plugin name, %2$s = TGMPA page URL */
         /*'notice_cannot_install'  => __( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', $theme_text_domain ), // %1$s = plugin name */
         /*'notice_can_activate'    => __( 'This theme requires the %1$s plugin. That plugin is currently inactive, so please go to the <a href="%2$s">plugin administration page</a> to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
         /*'notice_cannot_activate' => __( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', $theme_text_domain ), // %1$s = plugin name */
         /*'return'                 => __( 'Return to Required Plugins Installer', $theme_text_domain ), // */
      ),
   );
 
   tgmpa( $plugins, $config );
 
}

//Set the excerpt length
function fd_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'fd_custom_excerpt_length', 999 );
function new_excerpt_more( $more ) {
    return '.....';
}
add_filter('excerpt_more', 'new_excerpt_more');





function excerpt($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
    }

    function content($limit) {
      $content = explode(' ', get_the_content(), $limit);
      if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
      } else {
        $content = implode(" ",$content);
      } 
      $content = preg_replace('/\[.+\]/','', $content);
      $content = apply_filters('the_content', $content); 
      $content = str_replace(']]>', ']]&gt;', $content);
      return $content;
    }