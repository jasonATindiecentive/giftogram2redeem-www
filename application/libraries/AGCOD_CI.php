<?php

defined('BASEPATH') OR exit('No direct script access allowed');

include dirname(__FILE__)  . "/amazongcod/Amazon_GCOD.php";

/**
 *
 * Wrapper for AWS AGCOD
 * 
 * Probably not necessary to wrap, but the real code is in "amazongcod" and other libraries in this project
 * do it this way, so...
 * 
 */
class AwsCI extends Amazon_GCOD {

    public function __construct($awsAccessKeyId = NULL, $awsSecretAccessKey = NULL, $partnerId = NULL, $sandbox = false, $displayRequest = false) {
        parent::__construct($awsAccessKeyId, $awsSecretAccessKey, $partnerId, $sandbox, $displayRequest);
    }
    

}