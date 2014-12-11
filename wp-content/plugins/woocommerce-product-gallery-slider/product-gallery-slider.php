<?php
/*
Plugin Name: WooCommerce Product Gallery Slider
Plugin URI: http://woothemes.com/woocommerce
Description: Transforms product galleries into a responsive jQuery slider.
Version: 1.3.1
Author: WooThemes
Author URI: http://woothemes.com
Requires at least: 3.1
Tested up to: 3.5

	Copyright: © 2009-2011 WooThemes.
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Required functions
 */
if ( ! function_exists( 'woothemes_queue_update' ) )
	require_once( 'woo-includes/woo-functions.php' );

/**
 * Plugin updates
 */
woothemes_queue_update( plugin_basename( __FILE__ ), '9349fd0295bd443b4374277b99b7b9a3', '18655' );

if ( is_woocommerce_active() ) {

	/**
	 * Localisation
	 **/
	load_plugin_textdomain( 'wc_product_gallery_slider', false, dirname( plugin_basename( __FILE__ ) ) . '/' );

	/**
	 * woocommerce_product_gallery_slider class
	 **/
	if ( ! class_exists( 'WC_Product_Gallery_slider' ) ) {

		class WC_Product_Gallery_slider {

			public function __construct() {

				// Init settings
				$this->settings = array(
					array(
						'name' 		=> __( 'Product Gallery Slider', 'wc_product_gallery_slider' ),
						'type' 		=> 'title',
						'desc' 		=> '',
						'id' 		=> 'wc_product_gallery_slider_options'
					),
					array(
						'name' 		=> __( 'Enable on product detail pages', 'wc_product_gallery_slider' ),
						'desc' 		=> __( 'Display a gallery slider on all product detail pages. This setting can be overridden on a per-product basis.', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_enabled',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Enable on product archives', 'wc_product_gallery_slider' ),
						'desc' 		=> __( 'Display all product thumbs as gallery sliders on product archives. This setting can be overridden on a per-product basis.', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_archives_enabled',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Slideshow', 'wc_product_gallery_slider' ),
						'desc' 		=> __( 'Automatically rotate through product imagery.', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_slideshow',
						'type' 		=> 'checkbox'
					),
					array(
						'name' 		=> __( 'Navigation Style', 'wc_product_gallery_slider' ),
						'desc_tip' 	=> __( 'Style of the slider navigation', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_navigation_style',
						'css' 		=> 'min-width:175px;',
						'type' 		=> 'select',
						'options' 	=> array(
							'thumbnails'  	=> __( 'Thumbnails', 'wc_product_gallery_slider' ),
							'radios' 		=> __( 'Radio buttons', 'wc_product_gallery_slider' )
						)
					),
					array(
						'name' 		=> __( 'Transition Effect', 'wc_product_gallery_slider' ),
						'desc_tip' 	=> __( 'Effect for the product gallery slider.', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_effect',
						'css' 		=> 'min-width:175px;',
						'type' 		=> 'select',
						'options' 	=> array(
							'fade'  => __( 'Fade', 'wc_product_gallery_slider' ),
							'slide' => __( 'Slide', 'wc_product_gallery_slider' )
						)
					),
					array(
						'name' 		=> __( 'Slide Direction', 'wc_product_gallery_slider' ),
						'desc_tip' 	=> __( 'Slide animation direction. (Requires "slide" animation style)', 'wc_product_gallery_slider' ),
						'id' 		=> 'woocommerce_product_gallery_slider_direction',
						'css' 		=> 'min-width:175px;',
						'type' 		=> 'select',
						'options' 	=> array(
							'horizontal'  	=> __( 'Horizontal', 'wc_product_gallery_slider' ),
							'vertical' 		=> __( 'Vertical', 'wc_product_gallery_slider' )
						)
					),
					array( 'type' => 'sectionend', 'id' => 'wc_product_gallery_slider_options'),
				);

				// Default options
				add_option( 'woocommerce_product_gallery_slider_effect', 'fade' );
				add_option( 'woocommerce_product_gallery_slider_navigation_style', 'thumbnails' );
				add_option( 'woocommerce_product_gallery_slider_enabled', 'yes' );
				add_option( 'woocommerce_product_gallery_slider_slideshow', 'yes' );
				add_option( 'woocommerce_product_gallery_slider_archives_enabled', 'yes' );
				add_option( 'woocommerce_product_gallery_slider_direction', 'horizontal' );

				// Hooks
  				add_action( 'wp', array( $this, 'setup_gallery_single' ), 20 );
  				add_action( 'wp', array( $this, 'setup_gallery_archives' ), 20 );

				// Admin
				add_action( 'woocommerce_settings_image_options_after', array( $this, 'admin_settings' ) );
				add_action( 'woocommerce_update_options_catalog', array( $this, 'save_admin_settings' ) );

				/* 2.1 */
				add_action( 'woocommerce_update_options_products', array( $this, 'save_admin_settings' ) );

				add_action( 'woocommerce_product_options_general_product_data', array( $this, 'write_panel' ) );
				add_action( 'woocommerce_process_product_meta', array( $this, 'write_panel_save' ) );
			}

	        /*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/

			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}

			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}

		    function write_panel() {
		    	echo '<div class="options_group">';

		    	woocommerce_wp_select( array( 'id' => '_woocommerce_product_gallery_slider_enabled', 'label' => __('Enable Gallery Slider (product page)', 'wc_product_gallery_slider'), 'description' => __('Choose whether to enable the slider for this product on product detail pages.', 'wc_product_gallery_slider'), 'options' => array(
		    		''  	=> __( 'Default', 'wc_product_gallery_slider' ),
					'yes'  	=> __( 'Yes', 'wc_product_gallery_slider' ),
					'no' 	=> __( 'No', 'wc_product_gallery_slider' )
		    	) ) );

		    	woocommerce_wp_select( array( 'id' => '_woocommerce_product_gallery_slider_archives_enabled', 'label' => __('Enable Gallery Slider (archives)', 'wc_product_gallery_slider'), 'description' => __('Choose whether to enable the slider for this product on product archives', 'wc_product_gallery_slider'), 'options' => array(
		    		''  	=> __( 'Default', 'wc_product_gallery_slider' ),
					'yes'  	=> __( 'Yes', 'wc_product_gallery_slider' ),
					'no' 	=> __( 'No', 'wc_product_gallery_slider' )
		    	) ) );

		    	echo '</div>';
		    }

		    function write_panel_save( $post_id ) {
		    	$woocommerce_product_gallery_slider_enabled 			= esc_attr( $_POST['_woocommerce_product_gallery_slider_enabled'] );
		    	$woocommerce_product_gallery_slider_archives_enabled 	= esc_attr( $_POST['_woocommerce_product_gallery_slider_archives_enabled'] );
		    	update_post_meta( $post_id, '_woocommerce_product_gallery_slider_enabled', $woocommerce_product_gallery_slider_enabled );
		    	update_post_meta( $post_id, '_woocommerce_product_gallery_slider_archives_enabled', $woocommerce_product_gallery_slider_archives_enabled );
		    }

			// Remove the WC product gallery and add our own
			function setup_gallery_single() {
				if ( is_product() ) {
					global $post;

					$enabled 			= get_option( 'woocommerce_product_gallery_slider_enabled' );
					$enabled_for_post 	= get_post_meta( $post->ID, '_woocommerce_product_gallery_slider_enabled', true );

					if ( $enabled_for_post == 'no' ) return;

					if ( ( $enabled == 'yes' && $enabled_for_post !== 'no' ) || ( $enabled == 'no' && $enabled_for_post == 'yes' ) ) {

						add_action( 'get_header', array( $this, 'setup_scripts_styles' ), 20 );

						remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
		  				remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

						add_action( 'woocommerce_before_single_product_summary', array( $this, 'show_product_gallery' ), 30 );

						if ( in_array( 'woocommerce-image-zoom/woocommerce-professor-cloud.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && get_option( 'woocommerce_cloud_enableCloud' ) == 'true' ) :

		  					remove_action( 'woocommerce_before_single_product_summary', array( $this, 'show_product_gallery' ), 30 );

						endif;

		  			}
		  		}
			}

			// Galleries on archives
			function setup_gallery_archives() {
				if ( is_product_category() || is_shop() ) {
					global $post, $woocommerce;

					add_action( 'get_header', array( $this, 'setup_scripts_styles' ), 20);

					add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'show_product_gallery_archive' ), 10);

					remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

		  		}
			}

			function show_product_gallery_archive() {
				global $post, $product, $woocommerce;

				$small_thumbnail_size     = apply_filters('single_product_small_thumbnail_size', 'shop_catalog');
				$enabled_archives         = get_option( 'woocommerce_product_gallery_slider_archives_enabled' );
				$enabled_for_post_archive = get_post_meta( $post->ID, '_woocommerce_product_gallery_slider_archives_enabled', true );

				if ( ( $enabled_archives == 'yes' && $enabled_for_post_archive !== 'no' ) || ( $enabled_archives == 'no' && $enabled_for_post_archive == 'yes' ) ) {

					$attachments 	= $product->get_gallery_attachment_ids();
					$post_title 	= esc_attr( get_the_title( $post->ID ) );

					if ( $attachments ) {
						$loop = 0;
						$columns = apply_filters('woocommerce_product_thumbnails_columns', 3);
						echo '<div class="product-gallery"><ul class="slides">';

						if ( has_post_thumbnail()) {
						   $small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_thumbnail');
						   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_single');
						   echo '<li data-thumb="' . $small_image_url[0] . '"><a href="' . $large_image_url[0] . '" title="' . $post_title . '" rel="thumbnails" class="zoom ">' . get_the_post_thumbnail( $post->ID, 'shop_single' ) . '</a></li>';
	 					}

						foreach ( $attachments as $attachment_id ) {

							if ( get_post_meta( $attachment_id, '_woocommerce_exclude_image', true) == 1 )
								continue;

							$url 	= wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail');
							$image 	= wp_get_attachment_image( $attachment_id, $small_thumbnail_size);

							echo '<li data-thumb="' . $url[0] . '">' . $image . '</li>';

						}
						echo '</ul></div>';
					} else {
						woocommerce_template_loop_product_thumbnail();
					}

				} elseif ( $enabled_archives == 'yes' && $enabled_for_post_archive == 'no' ) {
					woocommerce_template_loop_product_thumbnail();
				} elseif ( $enabled_archives == 'no' ) {
					woocommerce_template_loop_product_thumbnail();
				}
			}

			// Show all single product images in a <ul>
			function show_product_gallery() {
				global $post, $product, $woocommerce;

				$small_thumbnail_size 	= apply_filters( 'single_product_small_thumbnail_size', 'shop_single' );
				$attachments 			= $product->get_gallery_attachment_ids();

				if ( $attachments ) {
					$loop 		= 0;
					$columns 	= apply_filters('woocommerce_product_thumbnails_columns', 3);
					$post_title = esc_attr( get_the_title( $attachment_id ) );
					echo '<div class="product-gallery images"><ul class="slides">';

					if ( has_post_thumbnail()) {
					   $small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_thumbnail');
					   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_single');
					   echo '<li data-thumb="' . $small_image_url[0] . '"><a href="' . $large_image_url[0] . '" title="' . $post_title . '" rel="thumbnails" class="zoom ">' . get_the_post_thumbnail( $post->ID, 'shop_single' ) . '</a></li>';
 					}

					foreach ( $attachments as $attachment_id ) {

						if ( get_post_meta( $attachment_id, '_woocommerce_exclude_image', true ) == 1 )
							continue;

						$loop++;

						$url        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
						$url_large  = wp_get_attachment_image_src( $attachment_id, 'shop_single' );
						$image      = wp_get_attachment_image( $attachment_id, $small_thumbnail_size );

						echo '<li data-thumb="' . $url[0] . '"><a href="' . $url_large[0] . '" title="'.$post_title.'" rel="thumbnails" class="zoom ';
						if ( $loop == 1 || ( $loop-1 ) % $columns == 0 ) echo 'first';
						if ( $loop % $columns == 0 ) echo 'last';
						echo '">' . $image . '</a></li>';
					}

					echo '</ul></div>';

				} else {
					woocommerce_show_product_images();
				}
			}

			// Setup scripts & styles
			function setup_scripts_styles() {
				wp_enqueue_script( 'flexslider', plugins_url( '/assets/js/jquery.flexslider.min.js', __FILE__ ), array( 'jquery' ) );
				add_action( 'wp_head',array( $this, 'fire_slider' ) );
				wp_enqueue_style( 'slider-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
			}

			// Fire the slider
			function fire_slider() {
				?>
					<script>
						jQuery(window).load(function() {
							jQuery('.product-gallery').flexslider({
								pauseOnHover: true,
								directionNav: false,
								<?php if ( get_option( 'woocommerce_product_gallery_slider_effect' ) == 'slide' ) { echo 'smoothHeight: true,'; } ?>
								<?php if ( get_option( 'woocommerce_product_gallery_slider_navigation_style' ) == 'thumbnails' ) { echo 'controlNav: "thumbnails",'; } ?>
								slideshow: <?php if ( get_option( 'woocommerce_product_gallery_slider_slideshow' ) == 'yes' ) { echo 'true'; } else { echo 'false'; } ?>,
								animation: "<?php echo get_option( 'woocommerce_product_gallery_slider_effect' ); ?>",
								direction: "<?php echo get_option( 'woocommerce_product_gallery_slider_direction' ); ?>"
							});
						});
					</script>
				<?php
			}
		}
		$WC_Product_Gallery_slider = new WC_Product_Gallery_slider();
	}
}