<?php 

class Hassanat_NotificationHandler {
    
    function __construct() {

        add_action("wp_footer", array( $this,"hassanat_check_notification") );
        add_action('wp_ajax_hassanat_display_notification', array( $this,'hassanat_display_notification') );
        add_action('wp_ajax_nopriv_hassanat_display_notification', array( $this,'hassanat_display_notification') );
        add_action('wp_ajax_hassanat_change_dhikr', array( $this,'hassanat_change_dhikr') );
        add_action('wp_ajax_nopriv_hassanat_change_dhikr', array( $this,'hassanat_change_dhikr') );
    }

    public function hassanat_display_notification() {

        check_ajax_referer('notifications_nonce', 'security');

        if (isset($_POST['consent'])) {
            $consent = sanitize_text_field($_POST['consent']);
    
            if ($consent === 'yes') {
                ob_start();
                include(plugin_dir_path( dirname( __FILE__ ) )  . "/templates/notification-popup.php");
                $template_content = ob_get_clean();
                setcookie('hassanat', 'yes', time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
                wp_send_json_success([
                        'hassanat' => $consent,
                        'html' => $template_content
                    ]
                );
            } else {
                wp_send_json_error([
                    'hassanat' => $consent,
                ]);
            }
        } else {
            wp_send_json_error(['message' => 'Consent not provided']);
        }
    }

    public function hassanat_change_dhikr() {
        check_ajax_referer('notifications_nonce', 'security');

        if (isset($_POST['dhikr'])) {
            $dhikr = sanitize_text_field($_POST['dhikr']);
            wp_send_json_success([
                    'text' => $dhikr
                ]
            );
        } else {
            wp_send_json_error(['message' => 'Consent not provided']);
        }
    }

    public function hassanat_check_notification() {
        echo "<div id='notification-popup'>";
        if($this->hassanat_user_has_consented_notification()) {
            include(plugin_dir_path( dirname( __FILE__ ) )  . "/templates/notification-popup.php");
        }
        echo "</div>";
    }

    private function hassanat_user_has_consented_notification() {
        return isset($_COOKIE['hassanat']) && $_COOKIE['hassanat'] === 'yes';
    }
}
