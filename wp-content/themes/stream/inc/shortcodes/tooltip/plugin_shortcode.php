<?php

/* * *********************************************************
 * Tooltip
 * ********************************************************* */

function osc_theme_tooltip($params, $content = 'Tooltip') {
    extract(shortcode_atts(array(
                'type' => '',
                'link' => '',
                'tooltip' => '',
                'style' => '',
                'class' => ''
                    ), $params));
    $out = '';
    if ($type == 'link') {
        $out = '<a  href="' . $link . '" data-placement="' . $style . '" title="' . do_shortcode($tooltip) . '"  class="osc_tooltip ' . $class . '">' . do_shortcode($content) . '</a>
';
    } elseif ($type == 'button') {
        $out = '<button type="button"  data-toggle="tooltip" data-placement="' . $style . '" title="' . $tooltip . '" class="btn osc_tooltip ' . $class . '">' . do_shortcode($content) . '</button>';
    }


    $out .= "
    <script>
        jQuery(document).ready(function() {
            jQuery('.osc_tooltip').tooltip();
        });
    </script>
    ";

    return $out;
}

add_shortcode('tooltip', 'osc_theme_tooltip');

