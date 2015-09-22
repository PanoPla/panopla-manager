<?php

/*
Plugin Name: PanoPlaManager
Plugin URI: http://wordpress.org/plugins/panoplay/
Description: Embed a pano on your site
Version: 0.1
Author: PanoPla
Author URI: http://www.panoplay.net
*/

require_once("install.php");
require_once("pano.php");

// Shortcodes
add_shortcode("ppm", "ppm_handler");

// Activiation Hook
register_activation_hook( __FILE__, 'ppm_install' );
