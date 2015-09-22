<?php

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
