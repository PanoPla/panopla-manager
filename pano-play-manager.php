<?php

/*
Plugin Name: PanoPlayManager
Plugin URI: http://wordpress.org/plugins/panoplay/
Description: Embed a pano on your site
Version: 0.1
Author: PanoPlay
Author URI: http://www.panoplay.net
*/



// Shortcodes
add_shortcode("ppm", "ppm_handler");

// Activiation Hook
//register_activation_hook( __FILE__, 'ppm_install' );

// Install functions
define( 'PPM_DB_VERSION', '1.0' );

// Create the table to hold the API keys
function ppm_install () {
    global $wpdb;

    $installed_ver = get_option( "ppm_db_version" );
    $table_name = ppm_get_table_name();

    if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name || $installed_ver != PPM_DB_VERSION ) {

        $sql = 'CREATE TABLE ' .$table_name. ' (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      ppm_api VARCHAR(255) DEFAULT "" NOT NULL,
      google_api VARCHAR(255) DEFAULT "" NOT NULL,
      ppm_link VARCHAR(255) DEFAULT "",
      display_refferal INT(1) DEFAULT "0" NOT NULL,
      UNIQUE KEY id (id)
    );';

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        update_option( "ppm_db_version", PPM_DB_VERSION );
    }
}

// Get the table prefix and return the name
function ppm_get_table_name(){
    global $wpdb;
    return $wpdb->prefix . "ppm";
}

// End of Install functions

//register_uninstall_hook( __FILE__, 'ppm_uninstall' );
// End of Uninstall

// The function that actually handles replacing the short code
// The function that actually handles replacing the short code
function ppm_handler($incomingfrompost) {

    $script_text = "<style>#ppm_viewer{width: 100% !important; height: 100% !important;}</style>";
    $script_text .= "<iframe id='ppm_viewer' src='http://bitspacedevelopment.com/pano/'></iframe>";

//    if ($api == "" || $gapi == ""){
//        $script_text = "<p>You need to save your PanoPlay API key and Google API key in the settings page.";
//    } else {
//        $script_text = build_script_text();
//    }

    $incomingfrompost=shortcode_atts(array(
        "headingstart" => $script_text
    ), $incomingfrompost);

    $demolph_output = script_output($incomingfrompost);
    return $demolph_output;
}

function build_script_text(){


    $script = '';

    return $script;
}

// build the script to replace the short code
function script_output($incomingfromhandler) {
    $demolp_output = wp_specialchars_decode($incomingfromhandler["headingstart"]);
    $demolp_output .= wp_specialchars_decode($incomingfromhandler["liststart"]);

    for ($demolp_count = 1; $demolp_count <= $incomingfromhandler["categorylist"]; $demolp_count++) {
        $demolp_output .= wp_specialchars_decode($incomingfromhandler["itemstart"]);
        $demolp_output .= $demolp_count;
        $demolp_output .= " of ";
        $demolp_output .= wp_specialchars($incomingfromhandler["categorylist"]);
        $demolp_output .= wp_specialchars_decode($incomingfromhandler["itemend"]);
    }

    $demolp_output .= wp_specialchars_decode($incomingfromhandler["listend"]);
    $demolp_output .= wp_specialchars_decode($incomingfromhandler["headingend"]);

    return $demolp_output;
}






