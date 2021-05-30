<?php

namespace Jovana\SendInBlue;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class NewsletterForm
{
    public function __construct()
    {
        add_shortcode('sendinblue-shortcode', array($this, 'create_form'));

        add_action( 'wp_ajax_save_subscriber', array($this, 'save_subscriber') );
        add_action( 'wp_ajax_nopriv_save_subscriber', array($this, 'save_subscriber') );

    }

    public function create_form()
    {
        $form = '<form id="test-blue" method="post">
                    <label for="fname">Name</label>
                    <input type="text" name="fname" id="fname">
                    <label for="lname">Surname</label>
                    <input type="text" name="lname" id="lname">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email">
                    <a id="submit">Submit</a>
                 </form>';

        echo $form;
    }

    public function save_subscriber() {

        global $wpdb;
        $newsletterTableName = $wpdb->prefix . 'sendinblue_newsletter';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $name = isset($_POST['fname']) ? $_POST['fname'] : '';
        $lname = isset($_POST['lname']) ? $_POST['lname'] : '';

        if( ! empty($email) && !empty($name) && ! empty($lname) ) {

            $jov_request = new PostRequest($email, $name, $lname);
            $res = $jov_request->response();

            if ( ! empty( $res ) ) {
                $id = $res->id;

                $error = $wpdb->insert($newsletterTableName, array('id' => $id, 'first_name' => $name, 'last_name' => $lname, 'email' => $email));

                if( $error === false ) {
                    wp_send_json_success('Nothing inserted in database. Check for errors');
                }

                wp_send_json_success('success');
            } else {
                wp_send_json_success($res);
            }
        } else {
            wp_send_json_success('Nothing updated');
        }

        wp_die(); // this is required to terminate immediately and return a proper response

    }
}