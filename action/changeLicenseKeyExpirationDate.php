<?php

// includes for this script + setting level of the script
include_once "../include/autoload.php";
IncludeOnPath(1);
include_once "../data/config.php";
SetLevel(1);
include_once "../lib/stripe-php-master/init.php";

// setting up Stripe client
\Stripe\Stripe::setApiKey(General\Config::$stripe['secret_key']);
$stripe_client = new \Stripe\StripeClient(General\Config::$stripe['secret_key']);

// validating GET parameter 'session_id'
if (isset($_GET['session_id']) && !is_null($_GET['session_id'])) {
    $stripe_session = $_GET['session_id'];
} else {
    $stripe_session = false;
}

// validating GET parameter 'license_key_id'
if (isset($_GET['license_key_id']) && is_numeric($_GET['license_key_id']) && $_GET['license_key_id'] > 0) {
    $license_key_id = $_GET['license_key_id'];
} else {
    $license_key_id = false;
}

// validating GET parameter 'month_num'
if (isset($_GET['month_num']) && is_numeric($_GET['month_num']) && $_GET['month_num'] > 0 && $_GET['month_num'] <= 36) {
    $month_num = $_GET['month_num'];
} else {
    $month_num = false;
}

// if license key and number of months exist, change license keys expiration date
if ($license_key_id && $month_num) {
    $user = new Controller\UserCon();
    if ($user->isLoggedIn()) {
        if ($stripe_session) {
            $license_key = new Controller\LicenseKeycon($license_key_id);
            $license_key->changeExpirationDate($user->id, $month_num);
        } else {
            General\Error::add('You must pay for license key extension');
        }

    } else {
        General\Error::add('You must be logged in to change license key expiration date');
    }
} else {
    General\Error::add('Invalid data');
}

// redirect user to dashboard
header('location: '.General\App::leveledPath("dashboard.php"));


?>