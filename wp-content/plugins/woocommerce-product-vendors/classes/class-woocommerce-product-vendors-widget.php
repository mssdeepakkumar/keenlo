<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WooCommerce_Product_Vendors_Widget extends WP_Widget {
	private $widget_cssclass;
	private $widget_description;
	private $widget_idbase;
	private $widget_title;

	/**
	 * Constructor function.
	 * @since  1.0.0
	 * @return  void
	 */
	public function __construct() {
		// Widget variable settings
		$this->widget_cssclass = 'widget_product_vendors';
		$this->widget_description = __( 'Display selected or current product vendor info.', 'wc_product_vendors' );
		$this->widget_idbase = 'product_vendors';
		$this->widget_title = __( 'WooCommerce Product Vendors', 'wc_product_vendors' );

		// Widget settings
		$widget_ops = array( 'classname' => $this->widget_cssclass, 'description' => $this->widget_description );

		// Widget control settings
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => $this->widget_idbase );

		// Create the widget
		$this->WP_Widget( $this->widget_idbase, $this->widget_title, $widget_ops, $control_ops );
	} // End __construct()

	/**
	 * Display the widget on the frontend
	 * @since  1.0.0
	 * @param  array $args     Widget arguments.
	 * @param  array $instance Widget settings for this instance.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$vendor_id = false;
		$vendors = false;

		// Only show current vendor widget when showing a vendor's product(s)
		$show_widget = true;
		if( $instance['vendor'] == 'current' ) {
			if( is_singular( 'product' ) ) {
				global $post;
				$vendors = get_product_vendors( $post->ID );
				if( ! $vendors ) {
					$show_widget = false;
				}
			}
			if( is_archive() && ! is_tax( 'shop_vendor' ) ) {
				$show_widget = false;
			}
		} else {
			$vendors = array(
				get_vendor( $instance['vendor'] )
			);
		}

		if( $show_widget ) {

			if( is_tax( 'shop_vendor' ) ) {
				$vendor_id = get_queried_object()->term_id;
				if( $vendor_id ) {
					$vendors = array(
						get_vendor( $vendor_id )
					);
				}
			}

			if( $vendors ) {

				// Set up widget title
				if( $instance['title'] ) {
					$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
				} else {
					$title = false;
				}

				// Before widget (defined by themes)
				echo $before_widget;

				// Display the widget title if one was input (before and after defined by themes).
				if ( $title ) { echo $before_title . $title . $after_title; }

				// Widget content
				$html = '';

				foreach( $vendors as $vendor ) {
					$html .= '<h4>' . $vendor->title . '</h4>';
					$html .= '<p>' . $vendor->description . '</p>';
					$html .= '<p><a href="' . esc_attr( $vendor->url ) . '" title"' . sprintf( __( 'More products from %1$s', 'wc_product_vendors' ), $vendor->title ) . '">' . sprintf( __( 'More products from %1$s', 'wc_product_vendors' ), $vendor->title ) . '</a></p>';
				}

				// Action for plugins/themes to hook onto
				do_action( $this->widget_cssclass . '_top' );

				echo $html;

				// Action for plugins/themes to hook onto
				do_action( $this->widget_cssclass . '_bottom' );

				// After widget (defined by themes).
				echo $after_widget;
			}
		}
	} // End widget()

	/**
	 * Method to update the settings from the form() method
	 * @since  1.0.0
	 * @param  array $new_instance New settings.
	 * @param  array $old_instance Previous settings.
	 * @return array               Updated settings.
	 */
	public function update ( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// Sanitise inputs
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['vendor'] = esc_attr( $new_instance['vendor'] );

		return $instance;
	} // End update()

	/**
	 * The form on the widget control in the widget administration area
	 * @since  1.0.0
	 * @param  array $instance The settings for this instance.
	 * @return void
	 */
    public function form( $instance ) {

		// Set up the default widget settings
		$defaults = array(
						'title' => '',
						'vendor' => 'current'
					);

		$instance = wp_parse_args( (array) $instance, $defaults );

		// Set up vendor options
		$vendors = get_vendors();
		$vendor_options = '<option value="current" ' . selected( $instance['vendor'], 'current', false ) . '>' . __( 'Current vendor(s)', 'wc_product_vendors' ) . '</option>';
		foreach( $vendors as $vendor ) {
			$vendor_options .= '<option value="' . esc_attr( $vendor->ID ) . '" ' . selected( $instance['vendor'], $vendor->ID, false ) . '>' . esc_html( $vendor->title ) . '</option>';
		}
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title (optional):', 'wc_product_vendors' ); ?></label>
			<input type="text" name="<?php echo $this->get_field_name( 'title' ); ?>"  value="<?php echo $instance['title']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'vendor' ); ?>"><?php _e( 'Vendor:', 'wc_product_vendors' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'vendor' ); ?>" class="widefat" id="<?php echo $this->get_field_id( 'vendor' ); ?>">
				<?php echo $vendor_options; ?>
			</select><br/><br/>
			<span class="description"><?php _e( '\'Current vendor(s)\' will display the details of the vendors whose product(s) are being viewed at the time. It will not show on other pages.', 'wc_product_vendors' ); ?></span>
		</p>
<?php
	} // End form()
} // End Class

// Register the widget
add_action( 'widgets_init', create_function( '', 'return register_widget("WooCommerce_Product_Vendors_Widget");' ), 1 );