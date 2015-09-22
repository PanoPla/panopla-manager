<?php

// The function that actually handles replacing the short code
function ppm_handler($atts = array(), $out = FALSE) {

    static $args = array(
      'pano' => '1'
    );

    if ( $out ) return $args;
    $args = shortcode_atts( $args, $atts, 'ppm' );

    $pano = "<style>#ppm_viewer{width: 100% !important; height: 100% !important;}</style>";
    $pano .= "<iframe id='ppm_viewer' src='http://panopla.com/pano/" . $args['pano'];
    $pano .= "'></iframe>";

    return $pano;
}
