<?php 

class Hassanat_ConsentHandler {
    public function __construct() {

        add_action("wp_footer", array( $this,"hassanat_consent_notification"));
        add_action("init", array( $this,"hassanat_register_consent"));
    }

    public function hassanat_consent_notification() {

        if(!isset( $_COOKIE["hassanat"] )) {
            include( plugin_dir_path( dirname( __FILE__ ) ) ."templates/consent-popup.php");
        }
    }
}
