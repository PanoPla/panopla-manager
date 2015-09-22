<?php

// The function that actually handles replacing the short code
function ppm_handler($atts = array(), $out = FALSE) {

    static $args = array(
      'pano' => '1',
      'height' => '400',
      'width' => '600'
    );

    if ( $out ) return $args;
    $args = shortcode_atts( $args, $atts, 'ppm' );

    $pano .= "<iframe id='ppm_viewer' height='" . $args['height'] .
             "' wight='" . $args['width'] . "' src='http://panopla.com/pano/"
             . $args['pano'] . "'></iframe>";

    return $pano;
}
