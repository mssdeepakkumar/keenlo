<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooSlider Instagram Class
 *
 * @package WordPress
 * @subpackage Wooslider_Instagram
 * @category Core
 * @author WooThemes
 * @since 1.0.0
 */
class Wooslider_Instagram {
    private $_token;
	private $_file;
    private $_has_video;
	public $context;
	public $api;

	/**
	 * Constructor function.
	 * @access  public
	 * @since   1.0.0
	 * @return  void
	 */
	public function __construct ( $file ) {
        $this->_token = 'wooslider-instagram';
		$this->_file = $file;
        $this->_has_video = false;
		add_action( 'plugins_loaded', array( $this, 'init' ), 0 );
	} // End __construct()

	/**
     * Initialize the plugin, check the environment and make sure we can act.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function init () {
        // Make sure WooSlider is active.
        $active_plugins = apply_filters( 'active_plugins', get_option('active_plugins' ) );
        if ( ! in_array( 'wooslider/wooslider.php', $active_plugins ) ) return;

        // Add the slideshow type into WooSlider.
        add_filter( 'wooslider_slider_types', array( $this, 'add_slideshow_type' ) );
        // Add the slideshow type's fields into the WooSlider popup.
        add_action( 'wooslider_popup_conditional_fields', array( $this, 'display_fields' ) );

        // Setup the API object.
        require_once( 'class-wooslider-instagram-api.php' );
        $this->api = new Wooslider_Instagram_API( $this->_file );
        // Setup the context, based on admin/frontend.
        if ( is_admin() ) {
        	require_once( 'class-wooslider-instagram-admin.php' );
        	$this->context = new Wooslider_Instagram_Admin( $this->_file, $this->api );
        } else {
            add_filter( 'wooslider_callback_start', array( $this, 'add_video_handler_callback_start' ) );
            add_filter( 'wooslider_callback_before', array( $this, 'add_video_handler_callback_before' ) );
        }

        add_action( 'widgets_init', array( $this, 'register_widgets' ) );
        add_filter( 'wooslider_generate_conditional_fields_instagram', array( $this, 'get_fields' ) );
    } // End init()

    /**
     * Integrate the slideshow type into WooSlider.
     * @access  public
     * @since   1.0.0
     * @param   array $types Existing slideshow types.
     * @return  array $types Modified array of types.
     */
    public function add_slideshow_type ( $types ) {
        if ( is_array( $types ) ) {
            // Make sure to add an array, at our desired key, consisting of a "name" and the "callback" function to get the slides for this slideshow type.
            $types['instagram'] = array( 'name' => __( 'Instagram Photographs', 'wooslider-instagram' ), 'callback' => array( $this, 'get_slides' ) );
        }
        return $types;
    } // End add_slideshow_type()

    /**
     * Display conditional fields for this slideshow type, when generating the shortcode.
     * @since  1.0.0
     * @return  void
     */
    public function display_fields () {
        global $wooslider;

        // Get an array of the fields, and their settings, to be generated in the popup form for conditional fields for this slideshow type.
        $fields = self::get_fields();

        // Make sure that the DIV tag below has a CSS class of "conditional-slideshowtype", where "slideshowtype" is our newly added type.
?>
<div class="conditional conditional-instagram">
    <table class="form-table">
        <tbody>
<?php foreach ( $fields as $k => $v ) { ?>
            <tr valign="top">
                <th scope="row"><?php echo $v['name']; ?></th>
                <td>
                    <?php
                        // Use WooSlider's admin object to generate the desired field according to it's type.
                        $wooslider->admin->generate_field_by_type( $v['type'], $v['args'] );
                    ?>
                    <?php if ( $v['description'] != '' ) { ?><p><span class="description"><?php echo $v['description']; ?></span></p><?php } ?>
                </td>
            </tr>
<?php } ?>
        </tbody>
    </table>
</div><!--/.conditional-->
<?php
    } // End display_fields()

    /**
     * Generate an array of the data to be used to generate the fields for display in the WooSlider admin.
     * @since  1.0.0
     * @return array Field data.
     */
    public function get_fields () {
        global $wooslider;

        $images_url = $wooslider->plugin_url . '/assets/images/';
        $fields = array();

        $layout_types = WooSlider_Utils::get_posts_layout_types();
        $layout_options = array();

        foreach ( (array)$layout_types as $k => $v ) {
            $layout_options[$k] = $v['name'];
        }

        $layout_images = array(
                                'text-left' => esc_url( $images_url . 'text-left.png' ),
                                'text-right' => esc_url( $images_url . 'text-right.png' ),
                                'text-top' => esc_url( $images_url . 'text-top.png' ),
                                'text-bottom' => esc_url( $images_url . 'text-bottom.png' )
                            );
        $layouts_args = array( 'key' => 'layout', 'data' => array( 'options' => $layout_options, 'images' => $layout_images ) );

        $overlay_images = array(
                                'none' => esc_url( $images_url . 'default.png' ),
                                'full' => esc_url( $images_url . 'text-bottom.png' ),
                                'natural' => esc_url( $images_url . 'overlay-natural.png' )
                            );

        $overlay_options = array( 'none' => __( 'None', 'wooslider-instagram' ), 'full' => __( 'Full', 'wooslider-instagram' ), 'natural' => __( 'Natural', 'wooslider-instagram' ) );

        $overlay_args = array( 'key' => 'overlay', 'data' => array( 'options' => $overlay_options, 'images' => $overlay_images ) );

        $limit_options = array();
        for ( $i = 1; $i <= 20; $i++ ) {
            $limit_options[$i] = $i;
        }
        $limit_args = array( 'key' => 'limit', 'data' => array( 'options' => $limit_options, 'default' => 5 ) );
        $thumbnails_args = array( 'key' => 'thumbnails', 'data' => array() );
        $display_featured_image_args = array( 'key' => 'display_featured_image', 'data' => array() );

        // Create final array.
        $fields['limit'] = array( 'name' => __( 'Number of Photographs', 'wooslider-instagram' ), 'type' => 'select', 'args' => $limit_args, 'description' => __( 'The maximum number of photographs to display', 'wooslider-instagram' ) );
        $fields['layout'] = array( 'name' => __( 'Layout', 'wooslider-instagram' ), 'type' => 'images', 'args' => $layouts_args, 'description' => __( 'The layout to use when displaying photographs', 'wooslider-instagram' ) );
        $fields['overlay'] = array( 'name' => __( 'Overlay', 'wooslider-instagram' ), 'type' => 'images', 'args' => $overlay_args, 'description' => __( 'The type of overlay to use when displaying the photograph caption', 'wooslider-instagram' ) );
        $fields['thumbnails'] = array( 'name' => __( 'Use thumbnails for Pagination', 'wooslider-instagram' ), 'type' => 'checkbox', 'args' => $thumbnails_args, 'description' => __( 'Use thumbnails for pagination, instead of "dot" indicators (uses featured image)', 'wooslider-instagram' ) );

        return $fields;
    } // End get_fields()

    /**
     * Get the slides for the "slides" slideshow type.
     * @since  1.0.0
     * @param  array $args Array of arguments to determine which slides to return.
     * @return array       An array of slides to render for the slideshow.
     */
    public function get_slides ( $args = array() ) {
        global $post;
        $slides = array();

        $defaults = array(
                        'limit' => '5',
                        'thumbnails' => '',
                        'size' => 'large'
                        );

        $args = wp_parse_args( $args, $defaults );

        // Determine and validate the layout type.
        $supported_layouts = WooSlider_Utils::get_posts_layout_types();
        if ( ! in_array( $args['layout'], array_keys( $supported_layouts ) ) ) { $args['layout'] = $defaults['layout']; }

        // Determine and validate the overlay setting.
        if ( ! in_array( $args['overlay'], array( 'none', 'full', 'natural' ) ) ) { $args['overlay'] = $defaults['overlay']; }

        $items = $this->api->get_self_media_recent( array( 'count' => intval( $args['limit'] ) ) );

        if ( ! is_wp_error( $items ) && ( 0 < count( $items->data ) ) && ( 200 == $items->meta->code ) ) {
            $class = 'layout-' . esc_attr( $args['layout'] ) . ' overlay-' . esc_attr( $args['overlay'] );

            foreach ( $items->data as $k => $v ) {
                $link = $v->link;
                if ( true == apply_filters( 'wooslider_instagram_link_to_image', false ) ) $link = $v->images->standard_resolution->url;

                $content = wpautop( $v->caption->text );

                if ( 'video' == $v->type ) {
                    $this->_has_video = true; // Set to true to ensure our caption handling JavaScript is loaded.
                    $item_class = ' instagram-type-video';
                    $video_data = $v->videos->low_resolution;
                    if ( isset( $v->videos->high_resolution ) ) $video_data = $v->videos->high_resolution;
                    $image = '<div class="' . esc_attr( $item_class ) . '">' . do_shortcode( '[video src="' . esc_url( $video_data->url ) . '" width="' . esc_attr( $video_data->width ) . '" height="' . esc_attr( $video_data->height ) . '"]' ) . '</div>';
                } else {
                    $item_class = ' instagram-type-image';
                    $image = '<div class="' . esc_attr( $item_class ) . '">' . '<a href="' . esc_url( $link ) . '" title="' . esc_attr( strip_tags( $content ) ) . '"><img src="' . esc_url( $v->images->standard_resolution->url ) . '" alt="' . esc_attr( strip_tags( $content ) ) . '" /></a>' . '</div>';
                }

                if ( '' == $image ) { $image = '<img src="' . esc_url( WooSlider_Utils::get_placeholder_image() ) . '" />'; }

                $content = $image . '<div class="slide-excerpt">' . $content . '</div>';
                if ( $args['layout'] == 'text-top' ) {
                    $content = '<div class="slide-excerpt">' . $content . '</div>' . $image;
                }

                $content = '<div class="' . esc_attr( $class ) . '">' . $content . '</div>' . "\n";

                $data = array( 'content' => $content );
                if ( 'true' == $args['thumbnails'] || 1 == $args['thumbnails'] ) {
                    $thumb_url = $v->images->thumbnail->url;
                    if ( '' != $thumb_url ) {
                        $data['attributes'] = array( 'data-thumb' => esc_url( $thumb_url ) );
                    } else {
                        $data['attributes'] = array( 'data-thumb' => esc_url( WooSlider_Utils::get_placeholder_image() ) );
                    }
                }
                $slides[] = $data;
            }
        }

        return $slides;
    } // End get_slides()

    /**
     * Add JavaScript on start, to handle the videos, if they are present.
     * @access  public
     * @since   1.0.0
     * @param   string $start Existing JavaScript.
     * @return  string
     */
    public function add_video_handler_callback_start ( $start ) {
        $start .= "\n" . 'if ( jQuery( slider ).find( \'video\' ).length ) {' . "\n";
        $start .= 'jQuery( slider ).find( \'video\' ).each( function ( i ) {' . "\n";
            $start .= 'jQuery( this ).on( \'play\', function ( e ) {' . "\n";
                $start .= 'jQuery( slider ).flexslider2( \'pause\' );' . "\n";
            $start .= '});' . "\n";
            $start .= 'jQuery( this ).on( \'pause\', function ( e ) {' . "\n";
                $start .= 'jQuery( slider ).flexslider2( \'play\' );' . "\n";
            $start .= '});' . "\n";
        $start .= '});' . "\n";
        $start .= '}';
        return $start;
    } // End add_video_handler_callback_start()

    /**
     * Add JavaScript on before, to handle the videos, if they are present.
     * @access  public
     * @since   1.0.0
     * @param   string $before Existing JavaScript.
     * @return  string
     */
    public function add_video_handler_callback_before ( $before ) {
        $before .= "\n" . 'if ( jQuery( slider ).find( \'video\' ).length ) {' . "\n";
        $before .= 'jQuery( slider ).find( \'video\' ).each( function ( i ) {' . "\n";
            $before .= 'jQuery( this ).trigger( \'pause\' );' . "\n";
        $before .= '});' . "\n";
        $before .= '}';
        return $before;
    } // End add_video_handler_callback_before()

    /**
     * Register the widget.
     * @access  public
     * @since   1.0.0
     * @return  void
     */
    public function register_widgets () {
        require_once( 'class-wooslider-instagram-widget.php' );
        register_widget( 'Wooslider_Instagram_Widget' );
    } // End register_widgets()
} // End Class
?>