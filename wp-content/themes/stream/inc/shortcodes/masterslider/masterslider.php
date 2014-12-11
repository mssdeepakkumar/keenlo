function efs_get_slider(){

//We'll fill this in later. 

}
/**add the shortcode for the slider- for use in editor**/

function efs_insert_slider($atts, $content=null){

$slider= efs_get_slider();

return $slider;

}
add_shortcode('ef_slider', 'efs_insert_slider');
/**add template tag- for use in themes**/

function efs_slider(){

	print efs_get_slider();
}
