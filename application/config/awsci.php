<?php

/*
 *
 * Config file for AWSCI library
 *
 * Put your key and secret here
 *
 */

// note that in this app we actually don't see our key/secret here, this will be run on an EC2 instance with
// a Role set up to acces AWS without a key

$config = array(
    'aws_key' => '',
    'aws_secret'     => ''
);