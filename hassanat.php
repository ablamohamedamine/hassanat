<?php 
/*
 * Plugin Name:       Hassanat
 * Description:       A plugin that display for users some muslim's Adhkar on small notifications.
 * Version:           1.0.0
 * Requires at least: 5.5
 * Requires PHP:      7.0
 * Author:            Mohamed Amine Abla
 * Author URI:        https://ablamohamedamine.com
 * License:           GPL3
 * License URI:       http://www.gnu.org/licenses/gpl.html
 * Text Domain:       hassanat
 */


function hassanat_load_files() {

    require_once plugin_dir_path( __FILE__ ) ."/includes/class-notification-handler.php";
    require_once plugin_dir_path( __FILE__ ) ."/includes/class-consent-handler.php";
    require_once plugin_dir_path( __FILE__ ) ."/includes/class-admin-settings.php";
}

add_action("plugin_loaded", "hassanat_load_files");

function hassanat_enqueue_scripts()  {
    wp_enqueue_style( 'google-fonts-style', 'https://fonts.googleapis.com/css?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap' );
    wp_enqueue_style("notifications-style", plugin_dir_url( __FILE__ ) ."assets/css/notifications-style.css");
    wp_enqueue_script("main-js", plugin_dir_url( __FILE__ ) ."assets/js/main.js", array("jquery"), '', array('in_footer' => true, 'strategy'  => 'async'));

    wp_localize_script('main-js', 'notificationsData', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('notifications_nonce'),
        'pluginUrl' => plugin_dir_url(__FILE__)
    ]);
}

add_action("wp_enqueue_scripts", "hassanat_enqueue_scripts");

function hassanat_init() {
    new Hassanat_ConsentHandler();
    new Hassanat_NotificationHandler();
}

add_action( "init", "hassanat_init" );