<?php

namespace Jovana\SendInBlue;

class NewsletterInit
{
    public function __construct()
    {
        register_activation_hook(
            SENDINBLUE_NEWSLETTER_PATH,
            array(
                __CLASS__,
                'activation'
            )
        );

        register_deactivation_hook(
            SENDINBLUE_NEWSLETTER_PATH,
            array(
                __CLASS__,
                'uninstall'
            )
        );

        add_action(
            'wp_enqueue_scripts',
            array(
                $this,
                'enqueue_scripts'
            )
        );
    }

    public static function activation()
    {
        global $wpdb;

        $newsletterTableName = $wpdb->prefix . 'sendinblue_newsletter';
        $charset_collate = $wpdb->get_charset_collate();

        $sqlNewsletter = "CREATE TABLE IF NOT EXISTS $newsletterTableName (
                          id mediumint(9) NOT NULL AUTO_INCREMENT,
                          first_name varchar(255) NOT NULL,
                          last_name varchar(255) NOT NULL,
                          email varchar(255) NOT NULL,
                          PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sqlNewsletter);

        add_option('newsletter_db_version', '1.0');
    }

    public static function uninstall()
    {
        global $wpdb;

        $newsletterTableName = $wpdb->prefix . "sendinblue_newsletter";
        $sqlNewsletter = "DROP TABLE IF EXISTS $newsletterTableName";

        $wpdb->query($sqlNewsletter);

        delete_option('newsletter_db_version');
    }

    public function enqueue_scripts()
    {
        $ajax_info = [
            'ajaxurl'        => admin_url( 'admin-ajax.php' )
        ];

        wp_register_script('news-js', SENDINBLUE_NEWSLETTER_URL . '/JS/triggerNewsletterForm.js', ['jquery'], '1.0.0', true);
        wp_localize_script( 'news-js', 'ajax_info', $ajax_info );
        wp_enqueue_script('news-js');
    }

}