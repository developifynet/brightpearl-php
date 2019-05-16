<?php

require_once './vendor/autoload.php';

use \Developifynet\Brightpearl\BrightpearlClient;
use \Developifynet\Brightpearl\BrightpearlException;

$client = new BrightpearlClient();
$client->settings([
    'app_reference' => 'your-api-reference',
    'account_code'  => 'your-account',
    'account_token' => 'your-app-token',
    'api_domain'    => 'ws-eu1.brightpearl.com', // Change as per your need
]);

try {
    $bp = new BrightpearlClient();
    echo '<pre>';
    print_r($bp->settings(array(
//        'app_reference' => 'asdfsadf',
//        'account_token' => 'asdfsadf',
//        'account_code' => 'asdfsadf',
    )));
} catch (BrightpearlException $e) {
    echo $e->getMessage();
}
