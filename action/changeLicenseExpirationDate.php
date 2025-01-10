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
if (isset($_GET['license_id']) && is_numeric($_GET['license_id']) && $_GET['license_id'] > 0) {
    $license_id = $_GET['license_id'];
} else {
    $license_id = false;
}

if (isset($_GET['month_num']) && is_numeric($_GET['month_num']) && $_GET['month_num'] > 0 && $_GET['month_num'] <= 36) {
    $month_num = $_GET['month_num'];
} else {
    $month_num = false;
}

echo $license_id;
echo $month_num;

if ($license_id && $month_num) {
    $user = new Controller\UserCon();
    if ($user->isLoggedIn()) {
        if ($stripe_session) {
            $license = new Controller\Licensecon($license_id);
            $license->changeExpirationDate($user->id, $month_num);
        } else {
            General\Error::add('You must pay for license extension');
        }

    } else {
        General\Error::add('You must be logged in to change license expiration date');
    }
} else {
    General\Error::add('Invalid data');
}

header('location: '.General\App::leveledPath("index.php"));


?>