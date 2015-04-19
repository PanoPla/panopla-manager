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
    $table_name = get_table_name();

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
        create_first_row();
    }
}

// Get the table prefix and return the name
function get_table_name(){
    global $wpdb;
    return $wpdb->prefix . "ppm";
}

// End of Install functions

//register_uninstall_hook( __FILE__, 'ppm_uninstall' );
// End of Uninstall

// The function that actually handles replacing the short code
// The function that actually handles replacing the short code
function ppm_handler($incomingfrompost) {

    $api = get_ppm_api();
    $gapi = get_google_api();
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

    $api = get_ppm_api();
    $gapi = get_google_api();
    $ppm_link = get_ppm_refferal_url();
    $display_ref = get_display_ref();

    $script = '';

    // If the user has selected display ref link, add it.
    if ($display_ref == "1"){
        $script .= $ppm_link;
    }

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

// Create the row to store the keys
function create_first_row(){
    global $wpdb;
    $table_name = get_table_name();
    $wpdb->insert( $table_name, array('ppm_api' => '', 'google_api' => '', 'display_refferal' => '0'), array());
}

// Save the ppm API key
function save_ppm_api($api){
    global $wpdb;

    $table_id = 1;
    $table_name = get_table_name();
    $wpdb->query($wpdb->prepare("UPDATE ".$table_name." SET ppm_api='$api' WHERE id = %d", $table_id));
}

// Save the refferal link to ppm
function save_ppm_link($link){
    global $wpdb;

    $table_id = 1;
    $table_name = get_table_name();
    $wpdb->query($wpdb->prepare("UPDATE ".$table_name." SET ppm_link='$link' WHERE id = %d", $table_id));
}

// Save the Google API key
function save_google_api($gapi){
    global $wpdb;

    $table_id = 1;
    $table_name = get_table_name();
    $wpdb->query($wpdb->prepare("UPDATE ".$table_name." SET google_api='$gapi' WHERE id = %d", $table_id));
}

function save_display_ref($ref){
    global $wpdb;

    $table_id = 1;
    $table_name = get_table_name();
    $wpdb->query($wpdb->prepare("UPDATE ".$table_name." SET display_refferal='$ref' WHERE id = %d", $table_id));
}

// Get the ppm api from the db
function get_ppm_api(){
    global $wpdb;

    $table_id = 1;
    $table_name = get_table_name();
    $api = $wpdb->get_row( $wpdb->prepare( "SELECT ppm_api FROM " .$table_name. " WHERE ID = %d", $table_id));
    return $api->ppm_api;
}

// Get the google API from the db
function get_google_api(){
    global $wpdb;

    $table_id = 1;
    $table_name = get_table_name();
    $gapi = $wpdb->get_row( $wpdb->prepare( "SELECT google_api FROM " .$table_name. " WHERE ID = %d", $table_id));
    return $gapi->google_api;
}

function get_display_ref(){
    global $wpdb;

    $table_id = 1;
    $table_name = get_table_name();
    $gapi = $wpdb->get_row( $wpdb->prepare( "SELECT display_refferal FROM " .$table_name. " WHERE ID = %d", $table_id));
    return $gapi->display_refferal;
}

// Get the refferal link from the database
function get_ppm_refferal_url(){
    global $wpdb;

    $table_id = 1;
    $table_name = get_table_name();
    $href = $wpdb->get_row( $wpdb->prepare( "SELECT ppm_link FROM " .$table_name. " WHERE ID = %d", $table_id));
    return $href->ppm_link;
}

// Process the form data
function process_ppm_keys(){
    if ($_POST){

        // Check for the google api key
        if (isset($_POST['google_api_key'])){
            save_google_api(sanitize_text_field($_POST['google_api_key']));
        }

        // Check for the apply api key
        if (isset($_POST['ppm_api_key'])){
            save_ppm_api(sanitize_text_field($_POST['ppm_api_key']));
        }

        // Check if the ppm link was posted
        if (isset($_POST['ppm_link'])){
            save_ppm_link($_POST['ppm_link']);
        }

        if (isset($_POST['display_ref'])){
            save_display_ref(1);
        } else {
            save_display_ref(0);
        }

        // redirect
        wp_redirect(admin_url( 'admin.php?page=pano-play-manager/pano-play-manager.php&settings-saved'));
        exit;
    }
}

