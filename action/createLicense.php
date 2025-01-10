<?php

include_once "../include/autoload.php";
include_once "../data/config.php";
include_once "../lib/stripe-php-master/init.php";


SetLevel(1);
$user = new Controller\UserCon();
\Stripe\Stripe::setApiKey(General\Config::$stripe['secret_key']);
$stripe_client = new \Stripe\StripeClient(General\Config::$stripe['secret_key']);

if (isset($_GET['session_id']) && !is_null($_GET['session_id'])) {
    $stripe_session = $_GET['session_id'];
} else {
    $stripe_session = false;
}


if ($user->isLoggedIn()) {
    if ($stripe_session) {
        if (isset($_GET['license_type_id']) && is_numeric($_GET['license_type_id']) && $_GET['license_type_id'] > 0) {
            $license_type_id = $_GET['license_type_id'];
        } else {
            $license_type_id = null;
        }
        
        if (isset($_GET['month_num']) && is_numeric($_GET['month_num']) && $_GET['month_num'] > 0) {
            $month_num = $_GET['month_num'];
        } else {
            $month_num = null;
        }
    
        if ($license_type_id && $month_num) {
            $license = new Controller\LicenseCon();
            $license->createLicense($_SESSION['user']['id'], $license_type_id, $month_num);
        } else {
            General\Error::Add('Fail to create license, invalid data were given');
        }
    } else {
        General\Error::add('You must pay for the license to be created');
    }
    
} else {
    General\Error::add('You must be logged in to create license');
}

header('location: '.General\App::leveledPath("index.php"));

?>