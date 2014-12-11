<?php

/* * *********************************************************
 * BUTTONS
 * ********************************************************* */

function osc_theme_slidetastic($params, $content = 'Label') {
    extract(shortcode_atts(array(
                'src' => '',
                'class' => '',
                'shape' => ''
                    ), $params));
    $out = '';


    //$out = '<img src="' . $src . '" class="' . $class .' '. $shape . '">';

    $out = '
    <div class="ipadFrameOuter">
        <div class="home-button"><div class="pad-top"></div></div>
        <div class="ipadFrame">
            <div class="master-slider " id="mastersliderIpad">
                <div class="ms-slide">
                    <!-- slide background -->
                    <img src='.get_template_directory_uri() .'/ico/blank.gif" data-src="http://stream.fdthemes.com/wp-content/uploads/2014/02/001.jpg" alt="lorem ipsum dolor sit"/>     
                    <!-- slide text layer -->
                    <div class="ms-layer ms-caption" style="bottom:90px; left:20px;">
                    </div>
                </div>
                <div class="ms-slide">
                    <!-- slide background -->
                    <img src='.get_template_directory_uri() .'/ico/blank.gif" data-src="http://stream.fdthemes.com/wp-content/uploads/2014/02/008.jpg" alt="lorem ipsum dolor sit"/>     
                    <!-- slide text layer -->
                    <div class="ms-layer ms-caption" style="bottom:90px; left:20px;">
                    </div>
                </div>                

                <div class="ms-slide">
                    <!-- slide background -->
                    <img src='.get_template_directory_uri() .'/ico/blank.gif" data-src="http://stream.fdthemes.com/wp-content/uploads/2014/02/002.jpg" alt="lorem ipsum dolor sit"/>     
                    <!-- slide text layer -->
                    <div class="ms-layer ms-caption" style="bottom:90px; left:20px;">
                    </div>
                </div>  
                <div class="ms-slide">
                    <!-- slide background -->
                    <img src='.get_template_directory_uri() .'/ico/blank.gif" data-src="http://stream.fdthemes.com/wp-content/uploads/2014/02/003.jpg" alt="lorem ipsum dolor sit"/>     
                    <!-- slide text layer -->
                    <div class="ms-layer ms-caption" style="bottom:90px; left:20px;">
                    </div>
                </div>
                <div class="ms-slide">
                    <!-- slide background -->
                    <img src='.get_template_directory_uri() .'/ico/blank.gif" data-src="http://stream.fdthemes.com/wp-content/uploads/2014/02/004.jpg" alt="lorem ipsum dolor sit"/>     
                    <!-- slide text layer -->
                    <div class="ms-layer ms-caption" style="bottom:90px; left:20px;">
                    </div>
                </div>                
                <div class="ms-slide">
                    <!-- slide background -->
                    <img src='.get_template_directory_uri() .'/ico/blank.gif" data-src="http://stream.fdthemes.com/wp-content/uploads/2014/02/005.jpg" alt="lorem ipsum dolor sit"/>     
                    <!-- slide text layer -->
                    <div class="ms-layer ms-caption" style="bottom:90px; left:20px;">
                    </div>
                </div>
                <div class="ms-slide">
                    <!-- slide background -->
                    <img src='.get_template_directory_uri() .'/ico/blank.gif" data-src="http://stream.fdthemes.com/wp-content/uploads/2014/02/006.jpg" alt="lorem ipsum dolor sit"/>     
                    <!-- slide text layer -->
                    <div class="ms-layer ms-caption" style="bottom:90px; left:20px;">
                    </div>
                </div>    
                <div class="ms-slide">
                    <!-- slide background -->
                    <img src='.get_template_directory_uri() .'/ico/blank.gif" data-src="http://stream.fdthemes.com/wp-content/uploads/2014/02/007.jpg" alt="lorem ipsum dolor sit"/>     
                    <!-- slide text layer -->
                    <div class="ms-layer ms-caption" style="bottom:90px; left:20px;">
                    </div>
                </div>                            
            </div>
        </div>
    </div>    
	';
wp_enqueue_script( 'masterslider-settings-recent-js', get_template_directory_uri().'/js/masterslider-ipad.settings.js',array(),'20131031',true);  
    return $out;


 

}

     
add_shortcode('slidetastic', 'osc_theme_slidetastic');

    