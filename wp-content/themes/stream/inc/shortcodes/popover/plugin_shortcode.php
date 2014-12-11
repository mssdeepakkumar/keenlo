<?php

function osc_theme_popover($params, $content = 'Popover') {
    extract(shortcode_atts(array(
                'trigger' => '',
                'title' => '',
                'pop_content' => '',
                'style' => '',
                'size' => '',
                'type' => '',
                'class' => ''
                    ), $params));
    $out = '';
    $out = '<button class="osc_popover btn ' . $size . ' ' . $type . ' ' . $class . '" data-content="' . $pop_content . '" data-placement="' . $style . '" data-toggle="popover" data-trigger="' . $trigger . '" data-container="body" type="button" data-title="' . $title . '"> ' . do_shortcode($content) . ' </button>';


    $out .= "
    <script>
       jQuery(document).ready(function(){
        jQuery('.osc_popover').popover();
        });
    </script>
    ";

    return $out;
}

add_shortcode('popover', 'osc_theme_popover');