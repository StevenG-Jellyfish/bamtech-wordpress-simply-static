<?php

class WPCF7_FORM_SOAP
{
    public function get_proxy() {
        $proxy_ini_file = "/etc/jellyfish/proxy.ini";
        if (! file_exists($proxy_ini_file)) {
            return false;
        }

        $proxy_ini_array = parse_ini_file($proxy_ini_file, true);
        if (! is_array($proxy_ini_array)) {
            return false;
        }

        define("PROXY_URL", $proxy_ini_array["proxy"]["PROXY_URL"]);
        define("PROXY_PORT", $proxy_ini_array["proxy"]["PROXY_PORT"]);
        return true;
    }

    public function init_client() {
        if ($this->get_proxy()) {
            $this->client = new nusoap_client(
                $this->service_url,
                true,
                PROXY_URL,
                PROXY_PORT
           );
        } else {
            $this->client = new nusoap_client(
                $this->service_url,
                true
           );
        }

        $this->client->soap_defencoding = 'UTF-8';
        $this->authenticate();
    }

    private function authenticate() {
        $this->client->setCredentials(
             $this->username,
             $this->password
       );
    }

    // Where is this sending the data, what does it want to do with it why do we need to json_encode it.
    public function send_request($request = null) {
        if (! $request) {
            return null;
        }

        $registerResponse = $this->client->call('Register', $request);
        $error = $this->client->getError();

         if ($error) {
             var_dump($error);
             die();
         }

        return json_encode($registerResponse);
    }


    private function get_field($fieldname, $fields) {
         return isset($fields[$fieldname]) ? $fields[$fieldname] : '';
    }

    public function create_request($submission = [], $ip) {
        // $submission variable pulls information stored in the database after a user has a submitted a form.
        $first_name = $this->get_field('first-name', $submission);
        $email = $this->get_field('email', $submission);
        // ... other fields

        // create a SOAP string
        // $request = <<<SOAP
        // SOAP;
        $request = '';
        
        return $request;
    }
}
