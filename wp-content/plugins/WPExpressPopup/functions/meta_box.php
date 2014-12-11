<?php 
	
		// Add the Meta Box
	function add_custom_meta_box() {
	    add_meta_box(
			'custom_meta_box', // $id
			'popup options', // $title 
			'show_custom_meta_box', // $callback
			'popup', // $page
			'normal', // $context
			'high'); // $priority
	}
	add_action('add_meta_boxes', 'add_custom_meta_box');

	// Field Array
	$prefix = 'wpep_';

	$custom_meta_fields = array(
		array(
			'label'	=> 'Type',
			'desc'	=> '',
			'id'	=> $prefix.'type',
			'type'	=> 'radio',
			'options' => array (
				'signin' => array (
					'label' => 'login',
					'value'	=> 'signin'
				),
				'video' => array(
					'label' => 'youtube video',
					'value' => 'video'
				),
				'image' => array(
					'label' => 'image',
					'value' => 'image'
				),
				'facebook' => array(
					'label' => 'facebook like box',
					'value' => 'facebook'
				),
				'iframe' => array(
					'label' => 'iframe',
					'value' => 'iframe'
				),
				'custom' => array(
					'label' => 'custom',
					'value' => 'custom'
				)
			)
		),
		array(
			'label'	=> 'content',
			'desc'	=> '',
			'id'	=> $prefix.'custom_content',
			'type'	=> 'textarea',
			'parent'=> $prefix.'type', 
			'parent_value'=> 'custom' 
		),
		array(
			'label'	=> 'video ID',
			'desc'	=> 'example : pyV57QlGUGI',
			'id'	=> $prefix.'video_id',
			'type'	=> 'text',
			'parent'=> $prefix.'type', 
			'parent_value'=> 'video' 
		),
		array(
			'label'	=> 'video width',
			'desc'	=> 'example : 500px',
			'id'	=> $prefix.'video_width',
			'type'	=> 'text',
			'parent'=> $prefix.'type',
			'parent_value'=> 'video', 
		),
		array(
			'label'	=> 'video height',
			'desc'	=> 'example : 400px',
			'id'	=> $prefix.'video_height',
			'type'	=> 'text',
			'parent'=> $prefix.'type',
			'parent_value'=> 'video' 
		),
		array(
			'label'	=> 'Image',
			'desc'	=> 'upload your image',
			'id'	=> $prefix.'image',
			'type'	=> 'image',
			'parent'=> $prefix.'type',
			'parent_value'=> 'image' 
		),
/*		array(
			'label'	=> 'image width',
			'desc'	=> 'example : 500px',
			'id'	=> $prefix.'image_width',
			'type'	=> 'text',
			'parent'=> $prefix.'type',
			'parent_value'=> 'image' 
		),
		array(
			'label'	=> 'image height',
			'desc'	=> 'example : 400px',
			'id'	=> $prefix.'image_height',
			'type'	=> 'text',
			'parent'=> $prefix.'type',
			'parent_value'=> 'image' 
		),*/
		array(
			'label'	=> 'facebook page link',
			'desc'	=> '',
			'id'	=> $prefix.'fb_link',
			'type'	=> 'text',
			'parent'=> $prefix.'type',
			'parent_value'=> 'facebook' 
		),
/*		array(
			'label'	=> 'facebook widget width',
			'desc'	=> 'example : 500',
			'id'	=> $prefix.'fb_width',
			'type'	=> 'text',
			'parent'=> $prefix.'type',
			'parent_value'=> 'facebook' 
		),*/
		array(
			'label'	=> 'facebook widget height',
			'desc'	=> 'example : 400',
			'id'	=> $prefix.'fb_height',
			'type'	=> 'text',
			'parent'=> $prefix.'type',
			'parent_value'=> 'facebook' 
		),
		array(
			'label'	=> 'iframe url',
			'desc'	=> 'example : www.google.com',
			'id'	=> $prefix.'iframe_url',
			'type'	=> 'text',
			'parent'=> $prefix.'type',
			'parent_value'=> 'iframe' 
		),
		array(
			'label'	=> 'iframe height',
			'desc'	=> 'example : 400px',
			'id'	=> $prefix.'iframe_height',
			'type'	=> 'text',
			'parent'=> $prefix.'type',
			'parent_value'=> 'iframe' 
		),
		array(
			'label'	=> 'popup width',
			'desc'	=> 'examples : 550px , 80% <br>default : 70%',
			'id'	=> $prefix.'width',
			'type'	=> 'text'
		),
		array(
			'label'	=> 'Show',
			'desc'	=> '',
			'id'	=> $prefix.'show_on',
			'type'	=> 'radio',
			'options' => array(
				'onload1' => array(
					'label' => 'always onload',
					'value' => 'onload1'
				),
				'onload2' => array(
					'label' => 'onload (with number of time)',
					'value' => 'onload2'
				),
				'onclick' => array(
					'label' => 'onclick',
					'value' => 'onclick'
				)
			)
		),
		array(
			'label'	=> 'show time',
			'desc'	=> '',
			'id'	=> $prefix.'show_time',
			'type'	=> 'slider',
			'min'	=> '1',
			'max'	=> '100',
			'step'	=> '1',
			'parent'=> $prefix.'show_on',
			'parent_value'=> 'onload2' 
		),
		array(
			'label'	=> 'onclick on',
			'desc'	=> ' #id , .classname or tagname',
			'id'	=> $prefix.'click_on',
			'type'	=> 'text',
			'parent'=> $prefix.'show_on',
			'parent_value'=> 'onclick' 
		),
		array(
			'label'	=> 'hide header',
			'desc'	=> '',
			'id'	=>  $prefix.'hide_header',
			'type'	=> 'checkbox_group',
			'options' => array (
				'yes' => array (
					'label' => '',
					'value'	=> 'yes'
				)
			)
		),
		array(
			'label'	=> 'hide footer',
			'desc'	=> '',
			'id'	=>  $prefix.'hide_footer',
			'type'	=> 'checkbox_group',
			'options' => array (
				'yes' => array (
					'label' => '',
					'value'	=> 'yes'
				)
			)
		),
		array(
			'label'	=> 'hide close button',
			'desc'	=> '',
			'id'	=>  $prefix.'hide_close',
			'type'	=> 'checkbox_group',
			'options' => array (
				'yes' => array (
					'label' => '',
					'value'	=> 'yes'
				)
			)
		),
		array(
			'label'	=> 'close icon',
			'desc'	=> 'upload your icon',
			'id'	=> $prefix.'close_icon',
			'type'	=> 'image'
		),
		array(
			'label'	=> 'close icon width',
			'desc'	=> 'example : 30px',
			'id'	=> $prefix.'close_icon_width',
			'type'	=> 'text'
		),
		array(
			'label'	=> 'close icon height',
			'desc'	=> 'example : 30px',
			'id'	=> $prefix.'close_icon_height',
			'type'	=> 'text'
		),
		array(
			'label'	=> 'Open Effect',
			'desc'	=> '',
			'id'	=> $prefix.'open_effect',
			'type'	=> 'select',
			'options' => array (
				'bounceIn' => array (
					'label' => 'bounceIn',
					'value'	=> 'bounceIn'
				),
				'bounceInDown' => array (
					'label' => 'bounceInDown',
					'value'	=> 'bounceInDown'
				),
				'bounceInLeft' => array (
					'label' => 'bounceInLeft',
					'value'	=> 'bounceInLeft'
				),
				'bounceInRight' => array (
					'label' => 'bounceInRight',
					'value'	=> 'bounceInRight'
				),
				'bounceInUp' => array (
					'label' => 'bounceInUp',
					'value'	=> 'bounceInUp'
				),
				'fadeIn' => array (
					'label' => 'fadeIn',
					'value'	=> 'fadeIn'
				),
				'fadeInDown' => array (
					'label' => 'fadeInDown',
					'value'	=> 'fadeInDown'
				),
				'fadeInDownBig' => array (
					'label' => 'fadeInDownBig',
					'value'	=> 'fadeInDownBig'
				),
				'fadeInLeft' => array (
					'label' => 'fadeInLeft',
					'value'	=> 'fadeInLeft'
				),
				'fadeInLeftBig' => array (
					'label' => 'fadeInLeftBig',
					'value'	=> 'fadeInLeftBig'
				),
				'fadeInRight' => array (
					'label' => 'fadeInRight',
					'value'	=> 'fadeInRight'
				),
				'fadeInRightBig' => array (
					'label' => 'fadeInRightBig',
					'value'	=> 'fadeInRightBig'
				),
				'fadeInUp' => array (
					'label' => 'fadeInUp',
					'value'	=> 'fadeInUp'
				),
				'fadeInUpBig' => array (
					'label' => 'fadeInUpBig',
					'value'	=> 'fadeInUpBig'
				),
				'rotateIn' => array (
					'label' => 'rotateIn',
					'value'	=> 'rotateIn'
				),
				'rotateInDownLeft' => array (
					'label' => 'rotateInDownLeft',
					'value'	=> 'rotateInDownLeft'
				),
				'rotateInDownRight' => array (
					'label' => 'rotateInDownRight',
					'value'	=> 'rotateInDownRight'
				),
				'rotateInUpLeft' => array (
					'label' => 'rotateInUpLeft',
					'value'	=> 'rotateInUpLeft'
				),
				'rotateInUpRight' => array (
					'label' => 'rotateInUpRight',
					'value'	=> 'rotateInUpRight'
				)
			)
		),
		array(
			'label'	=> 'Close Effect',
			'desc'	=> '',
			'id'	=> $prefix.'close_effect',
			'type'	=> 'select',
			'options' => array (
				'bounceOut' => array (
					'label' => 'bounceOut',
					'value'	=> 'bounceOut'
				),
				'bounceOutDown' => array (
					'label' => 'bounceOutDown',
					'value'	=> 'bounceOutDown'
				),
				'bounceOutLeft' => array (
					'label' => 'bounceOutLeft',
					'value'	=> 'bounceOutLeft'
				),
				'bounceOutRight' => array (
					'label' => 'bounceOutRight',
					'value'	=> 'bounceOutRight'
				),
				'bounceOutUp' => array (
					'label' => 'bounceOutUp',
					'value'	=> 'bounceOutUp'
				),
				'fadeOut' => array (
					'label' => 'fadeOut',
					'value'	=> 'fadeOut'
				),
				'fadeOutDown' => array (
					'label' => 'fadeOutDown',
					'value'	=> 'fadeOutDown'
				),
				'fadeOutDownBig' => array (
					'label' => 'fadeOutDownBig',
					'value'	=> 'fadeOutDownBig'
				),
				'fadeOutLeft' => array (
					'label' => 'fadeOutLeft',
					'value'	=> 'fadeOutLeft'
				),
				'fadeOutLeftBig' => array (
					'label' => 'fadeOutLeftBig',
					'value'	=> 'fadeOutLeftBig'
				),
				'fadeOutRight' => array (
					'label' => 'fadeOutRight',
					'value'	=> 'fadeOutRight'
				),
				'fadeOutRightBig' => array (
					'label' => 'fadeOutRightBig',
					'value'	=> 'fadeOutRightBig'
				),
				'fadeOutUp' => array (
					'label' => 'fadeOutUp',
					'value'	=> 'fadeOutUp'
				),
				'fadeOutUpBig' => array (
					'label' => 'fadeOutUpBig',
					'value'	=> 'fadeOutUpBig'
				),
				'rotateOut' => array (
					'label' => 'rotateOut',
					'value'	=> 'rotateOut'
				),
				'rotateOutDownLeft' => array (
					'label' => 'rotateOutDownLeft',
					'value'	=> 'rotateOutDownLeft'
				),
				'rotateOutDownRight' => array (
					'label' => 'rotateOutDownRight',
					'value'	=> 'rotateOutDownRight'
				),
				'rotateOutUpLeft' => array (
					'label' => 'rotateOutUpLeft',
					'value'	=> 'rotateOutUpLeft'
				),
				'rotateOutUpRight' => array (
					'label' => 'rotateOutUpRight',
					'value'	=> 'rotateOutUpRight'
				)
			)
		),	
/*
		array(
			'label'	=> 'show delay',
			'desc'	=> '',
			'id'	=> $prefix.'show_delay',
			'type'	=> 'slider',
			'min'	=> '0',
			'max'	=> '100',
			'step'	=> '1'
		),
*/
		array(
			'label'	=> 'auto hide',
			'desc'	=> '',
			'id'	=>  $prefix.'auto_hide',
			'type'	=> 'checkbox_group',
			'options' => array (
				'yes' => array (
					'label' => '',
					'value'	=> 'yes'
				)
			)
		),
		array(
			'label'	=> 'hide delay',
			'desc'	=> '',
			'id'	=> $prefix.'hide_delay',
			'type'	=> 'slider',
			'min'	=> '1',
			'max'	=> '100',
			'step'	=> '1'
		),
		array(
			'label'	=> 'Show in',
			'desc'	=> '',
			'id'	=>  $prefix.'show_in',
			'type'	=> 'checkbox_group',
			'options' => array (
				'all' => array (
					'label' => 'all pages',
					'value'	=> 'all'
				),
				'home' => array (
					'label' => 'home page',
					'value'	=> 'home'
				),
				'front' => array (
					'label' => 'front page',
					'value'	=> 'front'
				),
				'page' => array (
					'label' => 'page',
					'value'	=> 'page'
				),
				'single' => array (
					'label' => 'single',
					'value' => 'single'
				)
			)

		),
		array(
			'label'	=> 'custom css',
			'desc'	=> '',
			'id'	=> $prefix.'custom_css',
			'type'	=> 'textarea',
			'parent_value'=> 'custom' 
		),
	);


function admin_enq(){
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('custom-js', plugins_url( '../js/custom-js.js' , __FILE__ ));
	wp_enqueue_style('jquery-ui-custom',plugins_url( '../css/jquery-ui-custom.css' , __FILE__ ));
}

// enqueue scripts and styles, but only if is_admin

	add_action('admin_init', 'admin_enq');


// add some custom js to the head of the page
add_action('admin_head','add_custom_scripts');
function add_custom_scripts() {
	global $custom_meta_fields, $post;

	if(!is_object($post)){
		return;
	}
	
	$output = '<script type="text/javascript">
				jQuery(function() {';
	
	foreach ($custom_meta_fields as $field) { // loop through the fields looking for certain types

		// slider
		if ($field['type'] == 'slider') {
			if(isset($field['id']))
			$value = get_post_meta($post->ID, $field['id'], true);
			if ($value == '') $value = $field['min'];
			$output .= '
					jQuery( "#'.$field['id'].'-slider" ).slider({
						value: '.$value.',
						min: '.$field['min'].',
						max: '.$field['max'].',
						step: '.$field['step'].',
						slide: function( event, ui ) {
							jQuery( "#'.$field['id'].'" ).val( ui.value );
						}
					});';
		}
	}
	
	$output .= '});
		</script>';
	if(isset($_GET['post_type']) && $_GET['post_type']=='popup'){
		echo $output;
	}	
	
}



// The Callback
function show_custom_meta_box() {
	global $custom_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
	
	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($custom_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		if(isset($field['parent'])){
			$meta_parent = get_post_meta($post->ID, $field['parent'], true);
		}else{
			$meta_parent = '';
		}
		// begin a table row with
		
		
			if(isset($field['parent']) && $field['parent']!='' && $field['parent_value'] != $meta_parent ){
				echo '<tr style="display:none" class="'.$field['parent_value'].' '.$field['parent'].'">';
			}elseif(isset($field['parent'])){
				echo '<tr class="'.$field['parent_value'].' '.$field['parent'].'">';			
			}else{
				echo "<tr>";
			}
		
		
		echo '
				<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
				<td>';
				switch($field['type']) {
					// text
					case 'text':
						echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// textarea
					case 'textarea':
						if($field['id']=='wpep_custom_content'){
							wp_editor( $meta, $field['id'] );
						}else{
							echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
								<br /><span class="description">'.$field['desc'].'</span>';
						}
					break;
					// checkbox
					case 'checkbox':
						echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
								<label for="'.$field['id'].'">'.$field['desc'].'</label>';
					break;
					// select
					case 'select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
						foreach ($field['options'] as $option) {
							echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
						}
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// radio
					case 'radio':
						foreach ( $field['options'] as $option ) {
							echo '<input type="radio" name="'.$field['id'].'" id="'.$option['value'].'" value="'.$option['value'].'" ',$meta == $option['value'] ? ' checked="checked"' : '',' />
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
					break;
					// checkbox_group
					case 'checkbox_group':
						foreach ($field['options'] as $option) {
							echo '<input type="checkbox" value="'.$option['value'].'" name="'.$field['id'].'[]" id="'.$option['value'].'"',$meta && in_array($option['value'], $meta) ? ' checked="checked"' : '',' /> 
									<label for="'.$option['value'].'">'.$option['label'].'</label><br />';
						}
						echo '<span class="description">'.$field['desc'].'</span>';
						if($field['id']=='wpep_show_in' && isset($_GET['post'])){
							echo 'for specific post or page use this shortcode : [wpep id="'.$_GET['post'].'"]';
						}
					break;
					// tax_select
					case 'tax_select':
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
						$terms = get_terms($field['id'], 'get=all');
						$selected = wp_get_object_terms($post->ID, $field['id']);
						foreach ($terms as $term) {
							if (!empty($selected) && !strcmp($term->slug, $selected[0]->slug)) 
								echo '<option value="'.$term->slug.'" selected="selected">'.$term->name.'</option>'; 
							else
								echo '<option value="'.$term->slug.'">'.$term->name.'</option>'; 
						}
						$taxonomy = get_taxonomy($field['id']);
						echo '</select><br /><span class="description"><a href="'.get_bloginfo('home').'/wp-admin/edit-tags.php?taxonomy='.$field['id'].'">Manage '.$taxonomy->label.'</a></span>';
					break;
					// post_list
					case 'post_list':
					$items = get_posts( array (
						'post_type'	=> $field['post_type'],
						'posts_per_page' => -1
					));
						echo '<select name="'.$field['id'].'" id="'.$field['id'].'">
								<option value="">Select One</option>'; // Select One
							foreach($items as $item) {
								echo '<option value="'.$item->ID.'"',$meta == $item->ID ? ' selected="selected"' : '','>'.$item->post_type.': '.$item->post_title.'</option>';
							} // end foreach
						echo '</select><br /><span class="description">'.$field['desc'].'</span>';
					break;
					// date
					case 'date':
						echo '<input type="text" class="datepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// slider
					case 'slider':
					$value = $meta != '' ? $meta : '1';
						echo '<div id="'.$field['id'].'-slider"></div>
								<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$value.'" size="5" /> s
								<br /><span class="description">'.$field['desc'].'</span>';
					break;
					// image
					case 'image':
						if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');	$image = $image[0]; }	
						else{ $image=""; }			
						echo	'<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
									<img src="'.$image.'" class="custom_preview_image" alt="" /><br />
										<input class="custom_upload_image_button button" type="button" value="Choose Image" />
										<small>&nbsp;<a href="#" class="custom_clear_image_button">Remove Image</a></small>
										<br clear="all" /><span class="description">'.$field['desc'].'</span>';
					break;
					// repeatable
					case 'repeatable':
						echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span>
											<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="'.$row.'" size="30" />
											<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
							echo '<li><span class="sort hndle">|||</span>
										<input type="text" name="'.$field['id'].'['.$i.']" id="'.$field['id'].'" value="" size="30" />
										<a class="repeatable-remove button" href="#">-</a></li>';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
					break;
				} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

function remove_taxonomy_boxes() {
	remove_meta_box('categorydiv', 'post', 'side');
}
add_action( 'admin_menu' , 'remove_taxonomy_boxes' );

// Save the Data
function save_custom_meta($post_id) {
    global $custom_meta_fields;


	if(!isset($_POST['custom_meta_box_nonce'])){
		return;
	}
	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
	}
	
	// loop through fields and save the data
	foreach ($custom_meta_fields as $field) {
		if($field['type'] == 'tax_select') continue;
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // enf foreach
	
	// save taxonomies
	$post = get_post($post_id);
	$category = $_POST['category'];
	wp_set_object_terms( $post_id, $category, 'category' );
}
add_action('save_post', 'save_custom_meta');
?>