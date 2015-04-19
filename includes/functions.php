<?php

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
