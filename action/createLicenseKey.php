<?php

// includes for this script + setting level of the script
include_once "../include/autoload.php";
IncludeOnPath(1);
include_once "../data/config.php";
include_once "../lib/stripe-php-master/init.php";
SetLevel(1);

// setting up Stripe client + user object
$user = new Controller\UserCon();
\Stripe\Stripe::setApiKey(General\Config::$stripe['secret_key']);
$stripe_client = new \Stripe\StripeClient(General\Config::$stripe['secret_key']);

// validating GET parameter 'session_id'
if (isset($_GET['session_id']) && !is_null($_GET['session_id'])) {
    $stripe_session = $_GET['session_id'];
} else {
    $stripe_session = false;
}

// if user is logged in, validate other data and create new license key
if ($user->isLoggedIn()) {
    if ($stripe_session) {
        
        // validating GET parameter 'license_id'
        if (isset($_GET['license_id']) && is_numeric($_GET['license_id']) && $_GET['license_id'] > 0) {
            $license_id = $_GET['license_id'];
        } else {
            $license_id = null;
        }
        
        // validating GET parameter 'month_num'
        if (isset($_GET['month_num']) && is_numeric($_GET['month_num']) && $_GET['month_num'] > 0) {
            $month_num = $_GET['month_num'];
        } else {
            $month_num = null;
        }
        
        // if license and number of months exist, create new license key for the user
        if ($license_id && $month_num) {
            $license_key = new Controller\LicenseKeyCon();
            $license_key->createLicenseKey($_SESSION['user']['id'], $license_id, $month_num);
        } else {
            General\Error::Add('Fail to create license key, invalid data were given');
        }
    } else {
        General\Error::add('You must pay for the license key to be created');
    }
    
} else {
    General\Error::add('You must be logged in to create license key');
}

// redirect user to dashboard
header('location: '.General\App::leveledPath("dashboard.php"));

?>