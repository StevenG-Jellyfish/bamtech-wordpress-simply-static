<?php
/**
 * Plugin Name: Varnish purge
 * Plugin URI: http://jellyfish.co.uk
 * Description: This plugin enables / purges Varnish content
 * Version: 1.0.0
 * Author: Mauricio Masias
 * Author URI: http://jellyfish.co.uk/our-people/mauricio-masias
 * License: GPL2
 */

add_action( 'admin_menu', 'exec_varnish' , 10, 3);


function exec_varnish(){
	
	/*
	*  Add Submenu to settings main manu 
	*/
	add_submenu_page( 'options-general.php', 'Varnish purge', 'Varnish purge', 'manage_options', 'varnish-purge','varnish_purge_callback');

}

function varnish_purge_callback(){

    $status_flag = false;
    $error_flag = false;
    $active =  (isset($_POST['varnish_hidden']))? $_POST['varnish_hidden'] : false;

    /*
    *  ENV VARS
    *  ==================
    *  SITE_URL
    *  VARNISH_PATH
    *  VARNISH_ENABLED
    *  VARNISH_TOKEN
    *  VARNISH_AWS
    *  VARNISH_AWS_LB
    *  VARNISH_AWS_REGION
    */

    $varnish_vars = array(

        
        'VARNISH_ENABLED'   => (isset($_POST['varnish_enabled']))? $_POST['varnish_enabled'] : false,
        'VARNISH_AWS'       => (isset($_POST['varnish_aws']))? $_POST['varnish_aws'] : false,

        'SITE_URL'          => (isset($_POST['varnish_url']))? $_POST['varnish_url'] : false,
        'VARNISH_PATH'      => (isset($_POST['varnish_path']))? $_POST['varnish_path'] : false,
        
        'VARNISH_TOKEN'     => (isset($_POST['varnish_token']))? $_POST['varnish_token'] : false,
        
        'VARNISH_AWS_LB'    => (isset($_POST['varnish_aws_lb']))? $_POST['varnish_aws_lb'] : 'prod-lb-896982088.us-east-1.elb.amazonaws.com',
        'VARNISH_AWS_REGION'=> (isset($_POST['varnish_aws_region']))? $_POST['varnish_aws_region'] : 'us-east1'

    );
    


    /*
    $varnish_url =  (isset($_POST['varnish_url']))? $_POST['varnish_url'] : false;
    $varnish_path =  (isset($_POST['varnish_path']))? $_POST['varnish_path'] : false;
    $varnish_token =  (isset($_POST['varnish_token']))? $_POST['varnish_token'] : false;
    $varnish_aws =  (isset($_POST['varnish_aws']))? $_POST['varnish_aws'] : false;
    $varnish_aws_lb =  (isset($_POST['varnish_aws_lb']))? $_POST['varnish_aws_lb'] : false;
    $varnish_aws_region =  (isset($_POST['varnish_aws_region']))? $_POST['varnish_aws_region'] : false;
    $varnish_enabled =  (isset($_POST['varnish_enabled']))? $_POST['varnish_enabled'] : false;
    */



    if($active == 'Y' && $varnish_vars['VARNISH_ENABLED']!= false && $varnish_vars['VARNISH_AWS']!= false) {
        
        //Purge Varnish cache
        $varnish = new Varnish($varnish_vars);
        //$varnish->purge();

        $status_flag = true;

    
    }else{ $status_flag = false;
    }


    include('varnish-form.php');
}



/**
 * Class Varnish.
 */
class Varnish{

    /**
     * @var string
     */
    protected $path;
    protected $varnish_vars;

    /**
     * Constructor.
     */
    public function __construct($varnish_vars){

        $this->varnish_vars = $varnish_vars;
        $this->path = $varnish_vars['SITE_URL'].'.*';

        if ($varnish_vars['VARNISH_PATH']) {
            $this->path = $varnish_vars['VARNISH_PATH'];
        }

        $enabled = $varnish_vars['VARNISH_ENABLED'] === 'true' ? true : false;

        if ($enabled) {
            //$this->setHooks();
        }
    }

    /**
     *  Attach purge WordPress events.
     */
    protected function setHooks(){

        add_action('save_post', [$this, 'purge']);
        add_action('deleted_post', [$this, 'purge']);
        add_action('trashed_post', [$this, 'purge']);
        add_action('edit_post', [$this, 'purge']);
        add_action('delete_attachment', [$this, 'purge']);
        add_action('switch_theme', [$this, 'purge']);

    }

    /**
     * Fire a remote request to clear varnish cache.
     */
    public function purge(){

        $headers = [];
        $responses = [];

        if($this->varnish_vars['VARNISH_TOKEN']){

            $headers['X-Purge-Token'] = $this->varnish_vars['VARNISH_TOKEN'];
        }

        if($this->varnish_vars['VARNISH_AWS']){

            $lb = $this->varnish_vars['VARNISH_AWS_LB'];
            $region = $this->varnish_vars['VARNISH_AWS_REGION'];

            $output = shell_exec("aws elb describe-load-balancers --load-balancer-name {$lb} --region {$region}");

            $instances = [];

            if(!empty($output)){

                $output = json_decode($output);
                foreach($output->LoadBalancerDescriptions[0]->Instances as $instance){

                    $instances[] = $instance->InstanceId;
                }
            }

            if(!empty($instances)){

                $output = shell_exec("aws ec2 describe-instances --instance-ids " . implode(' ', $instances) . " --region {$region}");
                if(!empty($output)){

                    $output = json_decode($output);
                    foreach($output->Reservations as $reservation){

                        foreach($reservation->Instances as $instance) {
                            $host = preg_replace('#^https?://#', '', $this->varnish_vars['SITE_URL']);
                            $headers['X-Purge-Url'] = '.*';
                            $headers['X-Purge-Host'] = $host;
                            $headers['X-Purge-Method'] = 'direct';

                            $responses[] = wp_remote_request('http://' . $instance->PublicDnsName, [
                                'method' => 'PURGE',
                                'headers' => $headers,
                            ]);
                        }
                    }
                }
            }

        }else{

            $headers['X-Purge-Method'] = 'regex';
            $responses[] = wp_remote_request($this->path, [
                'method' => 'PURGE',
                'headers' => $headers,
            ]);
        }
    }
}
?>