<?php

/*
 * Working AWS PHP SDK example built using the ZIP installation method
 *
 * This demo was created on the date below using the latest AWS SDK available at the time. By the time you
 * read this there may be a later version. If so, download the ZIP from amazon's download page
 *
 *
 * 08/16/16 Jason Ruddock - created
 */

require 'aws-autoloader.php';

// supply your KEY and SECRET here
//
// This should probably go in some global config file in your project
//
// Better yet, you might want to consider putting these in  the ~/.aws/credentails file instead
//
// Better still, if you will be using this from an EC2 instance then create a Role allowing access to the AWS
// services you use and assign it to the instance -- and then just remove the two lines below. Now you can access
// AWS without any key or secret stored in your code
putenv("AWS_ACCESS_KEY_ID=*******************");
putenv("AWS_SECRET_ACCESS_KEY=*****************************************");


// we're going to using S3 today and uploading a file to one of your buckets
//
// once you can use one service it's relatively simple to use any of the others.
use Aws\S3\S3Client;
$s3Client = S3Client::factory();


// We want to upload a file to S3 --
// supply your bucket name, key name (the s4 objects path that we want to create/upload
//  e.g. /whereever/whatever.jpg), and the local path where the file can be found on this server
$bucket = 'tni_misc';
$keyname = 'test.txt';
$filepath = 'test.txt';


// Upload a file.
$result = $s3Client->putObject(array(
    'Bucket'       => $bucket,
    'Key'          => $keyname,
    'SourceFile'   => $filepath,
    'ContentType'  => 'text/plain',
    'ACL'          => 'public-read',
    'StorageClass' => 'REDUCED_REDUNDANCY',
    'Metadata'     => array(
        'param1' => 'value 1',
        'param2' => 'value 2'
    )
));


// spit out the url
echo $result['ObjectURL'] . "\r\n\r\n";

