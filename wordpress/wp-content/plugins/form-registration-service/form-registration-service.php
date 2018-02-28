<?php
/**
 * Plugin Name: Form Registration Service
 * Description: Form processing for CF7 Web Service.
 * Version: 1.0.00
 * Author: Matt Nottage
 * Author URI: http://jellyfish.co.uk
 * Text Domain: form-registration-service
 */
session_start();

require_once dirname(__FILE__) . '/lib/nusoap_patched.php';
require_once dirname(__FILE__) . '/soap.php';
require_once dirname(__FILE__) . '/submission.php';
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

if (class_exists('WPCF7_Service')) {
    class WPCF7_FORM_REGISTRATION extends WPCF7_Service
    {

        private static $ipaddress;
        private static $instance;
        private $form_id;

        public static function get_instance() {
            if (empty(self::$instance)) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        private function __construct() {
            $this->soap = new WPCF7_SHIRE_SOAP;
            $this->submission = new WPCF7_FORM_SUBMISSION;
            $this->form_id = '';
        }

        public function get_title() {
            return __('Form registration', 'form-registration-service');
        }

        public function is_active() {
            return true;
        }

        public function get_categories() {
            return ['webservice', 'contact-form-7'];
        }

        public function icon() {
            return 'wp-content/uploads/2016/06/logo_shire.png';
        }

        public function link() {
            echo sprintf(
                '<a href="%1$s">%2$s</a>',
                'https://www.shire.com',
                'shire.com'
            );
        }

        public function load($action = '') {

        }

        public function display($action = '') {
        }

        public function admin_notice($message = '') {
        }

        public function set_submission ($contact_form) {
            $registration_service->submission->fetch($contact_form);
        }

        // Instantiate connection to an API and send request if needed.
        public function send_submission() {
            $ip = $this->submission->get_client_ip();
            $this->soap->init_client();
            $request = $this->soap->create_request($this->submission->values, $ip);
            $response = $this->soap->send_request($request);
            return $response;
        }
    }

    // Wordpress: Add actions and filters
    if (function_exists("add_filter")) {
        add_filter('wpcf7_posted_data', 'form_registration_validate_form_values');
        add_filter('wpcf7_skip_mail', 'form_registration_check_errors');
        add_filter('wpcf7_ajax_json_echo', 'form_registration_form_validation_messages');
    }

    if (function_exists("add_action")) {
        add_action('wpcf7_init', 'form_registration_service_register_service');
        add_action('wpcf7_before_send_mail', 'form_registration_service_submission');
    }

    // Stop email notification to user and database entry if there are form submission errors.
    function form_registration_check_errors ()
    {
        $service = WPCF7_FORM_REGISTRATION::get_instance();
        $form_values = &$service->submission->values;
        return ! empty($service->formErrors);
    }

    function form_registration_service_register_service() {
         $integration = WPCF7_Integration::get_instance();
         $service = WPCF7_FORM_REGISTRATION::get_instance();

         $integration->add_service('form-registration-service', $service);
    }

    // If any errors exist set the parameters, kill the process and display error message via an ajax call.
    function form_registration_form_validation_messages($output)
    {
        $service = WPCF7_FORM_REGISTRATION::get_instance();

        $service->formErrors;
        $invalids = [];
        // Set paramters for ouputting validation errors.
        foreach ($service->formErrors as $key => $message) {
            $invalids[] = [
                "into"      => 'span.wpcf7-form-control-wrap.'. $key,
                "message"   => $message,
                "idref"     => null
            ];
        }

        // Display form errors, if any
        if(! empty($invalids)) {
             $output["mailSent"] = false;
             $output["message"]  = "One or more fields have an error. Please check and try again.";
             $output["invalids"] = $invalids;
        }

        echo json_encode($output);
        die;
    }

    function form_registration_service_submission(WPCF7_ContactForm $contact_form = null) {
        $registration_service = WPCF7_FORM_REGISTRATION::get_instance();
        $registration_service->submission->set($contact_form);
        $form_values = &$registration_service->submission->values;
    }


    // Check form submission fields for any any errors. Return appropriate message is any errors exist.
    function form_registration_validate_form_values($form_values)
    {
        $registration_service = WPCF7_FORM_REGISTRATION::get_instance();
        $registration_service->formErrors = [];
        $errors = [];

        // If multiple forms are used on the site use the form ID to validate the form fields in each form
        $form_id = $form_values['_wpcf7'];

        // Validation on form fields that all contact forms have in common.
        if (empty($form_values['full_name'])) {
            $errors['full_name'] = 'Please enter your name';
        }
        // Allows zero or more unicode characters. We use unicode because names may contain symbols above some letters in name.
        elseif (preg_match('/^[\p{L}-. ]*$/u', $form_values['full_name']) == 0) {
            $errors['full_name'] = 'Invalid input for name';
        }

        if (empty($form_values['email'])) {
            $errors['email'] = 'Please enter your email address';
        }
        // Checks if its a valid email address
        elseif (false === filter_var($form_values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email address';
        }

        $registration_service->formErrors = $errors;

        // Perform some action if there are no form errors.
        if (empty($registration_service->formErrors)) {
            // calls to custom functions (store_db())
        }

        return $form_values;
    }
}
