<?php

// The function that actually handles replacing the short code
function ppm_handler($atts) {

    $pano = "<style>#ppm_viewer{width: 100% !important; height: 100% !important;}</style>";
    $pano .= "<iframe id='ppm_viewer' src='http://panopla.com/pano/" . $atts->pano;
    $pano .= "'></iframe>";

    return $pano;
}
