<?php

class WPCF7_FORM_SUBMISSION
{
    public $values = [];

    public function set(WPCF7_ContactForm $contact_form = null) {

        if (null == $contact_form) {
            return null;
        }

        $submission = WPCF7_Submission::get_instance();
        $form_fields = $contact_form->form_scan_shortcode();

        foreach ($form_fields as $field) {
            if (isset($field['name']) && $field['name'] != '') {
                $field_name = $field['name'];

                if ($field['basetype'] == 'checkbox') {
                    $checkbox_submission = $submission->get_posted_data($field_name);

                    $this->values[ $field_name ] = $this->api_checkbox_value(
                        $checkbox_submission[0]
                    );
                } else {
                    $this->values[ $field_name ] = $submission->get_posted_data($field_name);
                }
            }
        }
    }

    public function api_checkbox_value($submitted_value = '') {
         return $submitted_value == '' ? 'O' : 'I';
    }

    public function get_client_ip() {
        if (getenv('HTTP_CLIENT_IP')) {
            return getenv('HTTP_CLIENT_IP');
        }

        if (getenv('HTTP_X_FORWARDED_FOR')) {
            return getenv('HTTP_X_FORWARDED_FOR');
        }

        if (getenv('HTTP_X_FORWARDED')) {
            return getenv('HTTP_X_FORWARDED');
        }

        if (getenv('HTTP_FORWARDED_FOR')) {
            return getenv('HTTP_FORWARDED_FOR');
        }

        if (getenv('HTTP_FORWARDED')) {
            return getenv('HTTP_FORWARDED');
        }

        if (getenv('REMOTE_ADDR')) {
            return getenv('REMOTE_ADDR');
        }

        return 'UNKNOWN';
    }
}
