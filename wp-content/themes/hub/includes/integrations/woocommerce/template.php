<?php
/**
 * Template functions
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Products
/* Functions affecting WooCommerce products
/*-----------------------------------------------------------------------------------*/

/**
 * Upsells
 * Replace the default upsell function with our own which displays the correct number product columns
 */
if ( ! function_exists( 'woo_wc_upsell_display' ) ) {
	function woo_wc_upsell_display() {
	    woocommerce_upsell_display( -1, 3 );
	}
}


/**
 * Related Products
 * Replace the default related products function with our own which displays the correct number of product columns
 * @return array indicates number of products to display and in how many columns
 */
function woo_wc_related_products() {
	$args = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);
	return $args;
}


if ( ! function_exists( 'woo_wc_placeholder_img_src' ) ) {
	/**
	 * Custom Placeholder
	 * Checks the theme option. If a custom placeholder is specified display it, otherwise display our Woo themed placeholder.
	 * @param  string $src Placeholder URL
	 * @return string      Sanitized placeholder URL
	 */
	function woo_wc_placeholder_img_src( $src ) {
		global $woo_options;
		if ( isset( $woo_options['woo_placeholder_url'] ) && '' != $woo_options['woo_placeholder_url'] ) {
			$src = $woo_options['woo_placeholder_url'];
		}
		else {
			$src = get_template_directory_uri() . '/images/wc-placeholder.gif';
		}
		return esc_url( $src );
	} // End woo_wc_placeholder_img_src()
}

if ( ! function_exists( 'woo_wc_loop_columns' ) ) {
	/**
	 * Product Columns
	 * Set product columns to 3
	 * @return integer The number of columns products in archives are arranged into
	 */
	function woo_wc_loop_columns() {
		return 3;
	}
}


/*-----------------------------------------------------------------------------------*/
/* Layout
/* Functions affecting the WooCommerce layout
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_before_content' ) ) {
	/**
	 * Woo Wrapper Open
	 * Wraps WooCommerce pages in WooTheme Markup
	 */
	function woo_wc_before_content() {
		global $woo_options;
		$uri = $_SERVER["REQUEST_URI"];
		$ex_plode =explode("/",$uri);
		
		if($ex_plode[1] == "product-category"){?>
		<style>
		#wrapper #breadcrumbs {
    		margin-bottom: 0;
		}

		#inner-wrapper > div {
		    margin: 0;
		}
		.page-title {
		position: absolute !important;
		background:rgba(255,255,255,0.65);		
		top: 320px !important;
		}
		</style>
		<div class="res-trck-ft" style=" height: 300px; overflow: hidden;">
		<img src="<?php echo get_template_directory_uri(); ?>/images/categories-header.jpg" alt="timeline" width="100%">
		</div>		
		<?php }
		if($ex_plode[1] == "store"){
		$u_name = $ex_plode[2];
	
		global $wpdb;
		$results2 = $wpdb->get_results( 'SELECT name FROM wp_terms WHERE slug = "'.$u_name.'"');
		$v_name = $results2[0]->name;
		$results = $wpdb->get_results( 'SELECT term_id FROM wp_terms WHERE slug = "'.$u_name.'"');
		$v_id = $results[0]->term_id;
		
		$results3 = $wpdb->get_results( 'SELECT personal_name FROM wp_vendor_name WHERE user_id = "'.$v_id.'"');
		$p_name =$results3[0]->personal_name;
		$upload_dir = wp_upload_dir(); 
		$i_url = $upload_dir['baseurl']; 
		$tt = get_queried_object()->term_id;
		?>
		<style>

		#inner-wrapper > div {
		    margin: 0;
		}
		.product-vendor #breadcrumbs {
    		margin-bottom: 0;
		}
		.page_title{
		padding : 10px 15px;		
		}
		.p_name {
		    margin-top: 10px;
		}
		.page_title{
			*margin-top: 70px;
		}

		</style>
		<div id="content" class="col-full">
		<?php if(!empty($tt)){?>
		<div class="res-trck-ft" style=" height: 300px; overflow: hidden;">
		<img src="<?php echo $i_url;?>/vendore_images/<?php echo $tt;?>/timeline.jpg" alt="timeline" width="100%">
		</div>		
			
		</div>
		
  		<div class="wrapper rltv-pro">
			<div class = "img_prof" style="overflow: hidden;">
		    <div class="img-view-strk">
		    <img src="<?php echo $i_url;?>/vendore_images/<?php echo $tt;?>/profileimage.jpg" alt="profileimage" width="10%">
		    </div>
		    <div class="ut-nm-pro">
			<div class="page_title"><?php echo $v_name;?></div><br>
			<div class="page_title p_name"><?php echo $p_name;?></div>
		    </div>
		    </div>
		<?php }
		}?>
	        <!-- #main Starts -->
	        <?php woo_main_before(); ?>
		<?php if($ex_plode[1] == "product-category"){?><div class="wrapper"><?php }?><div id="main" class="col-left">

	    <?php
	} // End woo_wc_before_content()
}

if ( ! function_exists( 'woo_wc_after_content' ) ) {
	/**
	 * Woo Wrapper Close
	 * Wraps WooCommerce pages in WooTheme Markup
	 */
	function woo_wc_after_content() {
		?>
<?php if($ex_plode[1] == "product-category"){?></div><?php }?>
			</div><!-- /#main -->
	        <?php woo_main_after(); ?>
		<?php get_sidebar(); ?>
		<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>
		<ul id="sidebar">
		<?php dynamic_sidebar( 'left-sidebar' ); ?>
		</ul>
		<?php endif; ?>
		<ul id="sidebar">
		<?php dynamic_sidebar( 'right-sidebar' ); ?>
		</ul>
	        <?php do_action( 'woocommerce_sidebar' ); ?>

            </div><!-- /.wrapper -->

	    </div><!-- /#content -->

	    <?php
	} // End woo_wc_after_content()
}

if ( ! function_exists( 'woo_wc_layout_body_class' ) ) {
	/**
	 * Woo Body Class
	 * Add a class to the body if full width shop archives are specified
	 * @param  array $wc_classes Classes to be applied to the body
	 * @return string            Classes to be applied to the body
	 */
	function woo_wc_layout_body_class( $wc_classes ) {
		global $woo_options, $post;
		$single_layout = get_post_meta( $post->ID, '_layout', true );

		$layout = '';

		// Add layout-full class to product archives if necessary
		if ( isset( $woo_options['woocommerce_archives_fullwidth'] ) && 'true' == $woo_options['woocommerce_archives_fullwidth'] && ( is_shop() || is_product_category() ) ) {
			$layout = 'layout-full';
		}
		// Add layout-full class to single product pages if necessary
		if ( isset( $woo_options[ 'woocommerce_products_fullwidth' ] ) && ( $woo_options[ 'woocommerce_products_fullwidth' ] == "true" && is_product() ) && ( $single_layout != 'layout-left-content' && $single_layout != 'layout-right-content' ) ) {
			$layout = 'layout-full';
		}

		// Add classes to body_class() output
		$wc_classes[] = $layout;
		return $wc_classes;
	} // End woocommerce_layout_body_class()
}

if ( ! function_exists( 'woo_wc_before_shop_loop_item' ) ) {
	function woo_wc_before_shop_loop_item() {
		?>

			<div class="product-inner">

		<?php
	}
}

if ( ! function_exists( 'woo_wc_after_shop_loop_item' ) ) {
	function woo_wc_after_shop_loop_item() {
		?>

			</div><!-- /.product-inner -->

		<?php
	}
}

/*-----------------------------------------------------------------------------------*/
/* Sidebar
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_get_sidebar' ) ) {
	/**
	 * Woo Get Sidebar
	 * Replaces the WooCommerce sidebar with one which checks whether the full-width theme option is enabled.
	 */
	function woo_wc_get_sidebar() {
		global $woo_options, $post;

		// Display the sidebar if full width option is disabled on archives
		if ( ! is_product() ) {
			if ( isset( $woo_options['woocommerce_archives_fullwidth'] ) && 'false' == $woo_options['woocommerce_archives_fullwidth'] ) {
				get_sidebar('shop');
			}
		} else {
			$single_layout = get_post_meta( $post->ID, '_layout', true );
			if ( $woo_options[ 'woocommerce_products_fullwidth' ] == 'false' ) {
				if ( $single_layout == "layout-full" || $single_layout == "layout-default" ) {
					return;
				}
				get_sidebar('shop');
			}
		}

	} // End woo_wc_get_sidebar()
}


/*-----------------------------------------------------------------------------------*/
/* Pagination / Search */
/* Functions affecting WooCommerce / WooFramework pagination & search */
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_pagination' ) ) {
	/**
	 * WooCommerce Pagination
	 * Replaces WooCommerce pagination with the function in the WooFramework
	 * @uses  woo_wc_add_search_fragment()
	 * @uses  woo_wc_pagination_defaults()
	 * @uses  woo_pagination()
	 */
	function woo_wc_pagination() {
		if ( is_search() && is_post_type_archive() ) {
			add_filter( 'woo_pagination_args', 			'woo_wc_add_search_fragment', 10 );
			add_filter( 'woo_pagination_args_defaults', 'woo_wc_pagination_defaults', 10 );
		}
		woo_pagination();
	} // End woo_wc_pagination()
}

if ( ! function_exists( 'woo_wc_add_search_fragment' ) ) {
	/**
	 * Search Fragment
	 * @param  array $settings Fragments
	 * @return array           Fragments
	 */
	function woo_wc_add_search_fragment ( $settings ) {
		$settings['add_fragment'] = '&post_type=product';
		return $settings;
	} // End woo_wc_add_search_fragment()
}

if ( ! function_exists( 'woo_wc_pagination_defaults' ) ) {
	function woo_wc_pagination_defaults ( $settings ) {
		/**
		 * Pagination Defaults
		 * @param  array $settings Settings
	 	 * @return array           Settings
		 */
		$settings['use_search_permastruct'] = false;
		return $settings;
	} // End woo_wc_pagination_defaults()
}

/*-----------------------------------------------------------------------------------*/
/* Cart Link
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woo_wc_cart_link' ) ) {
	/**
	 * Cart link
	 */
	function woo_wc_cart_link() {
		global $woocommerce;
		?>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo $woocommerce->cart->get_cart_total(); ?> <span class="count"><?php echo sprintf( _n('%d item', '%d items', $woocommerce->cart->get_cart_contents_count(), 'woothemes' ), $woocommerce->cart->get_cart_contents_count() );?></span></a>
		<?php
	}
}
