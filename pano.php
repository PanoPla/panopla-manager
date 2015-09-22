<?php

// The function that actually handles replacing the short code
function ppm_handler($atts) {

    print_r($atts);
    die();

    $pano = "<style>#ppm_viewer{width: 100% !important; height: 100% !important;}</style>";
    $pano .= "<iframe id='ppm_viewer' src='http://panopla.com/pano/" $atts;
    $pano .= "'></iframe>";

    return $pano;
}
