<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Wrapper for AWS PHP SDK used to access it from CodeIgnitor
 */
class AwsCI {

    protected  $ci;
    protected  $aws_key;
    protected  $aws_secret;

    public function __construct() {
        
        $this->ci =& get_instance();
        $this->ci->config->load('awsci');


        // pull key and secret from config file (/application/config/awscli.php) if provided
        //
        // (if possible don't do this -- use EC2 roles so that the key/secret never appears in the
        //  source code anywhere..)

        // load up the aws SDK
        require_once('Aws/aws-autoloader.php');

        if (strlen($this->ci->config->item('aws_key'))) {
            // set env variables for KEY and SECRET
            $this->aws_key = $this->ci->config->item('aws_key');
            $this->aws_secret = $this->ci->config->item('aws_secret');
            putenv("AWS_ACCESS_KEY_ID=" . $this->aws_key);
            putenv("AWS_SECRET_ACCESS_KEY=" . $this->aws_secret);
        }
        
        

    }

}