<?php


include_once "../include/autoload.php";
include_once "../data/config.php";
include_once "../lib/stripe-php-master/init.php";


\Stripe\Stripe::setApiKey(General\Config::$stripe['secret_key']);
$stripe_client = new \Stripe\StripeClient(General\Config::$stripe['secret_key']);

if (isset($_GET['session_id']) && !is_null($_GET['session_id'])) {
    $stripe_session = $_GET['session_id'];
} else {
    $stripe_session = false;
}

SetLevel(1);
//echo "it is this page";
if (isset($_GET['license_key_id']) && is_numeric($_GET['license_key_id']) && $_GET['license_key_id'] > 0) {
    $license_key_id = $_GET['license_key_id'];
} else {
    $license_key_id = false;
}

if (isset($_GET['month_num']) && is_numeric($_GET['month_num']) && $_GET['month_num'] > 0 && $_GET['month_num'] <= 36) {
    $month_num = $_GET['month_num'];
} else {
    $month_num = false;
}

echo $license_key_id;
echo $month_num;

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

header('location: '.General\App::leveledPath("dashboard.php"));


?>