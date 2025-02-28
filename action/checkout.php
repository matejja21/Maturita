<?php

// includes for this script + setting level of the script
include_once "../include/autoload.php";
IncludeOnPath(1);
include_once "../data/config.php";
include_once "../lib/stripe-php-master/init.php";
SetLevel(1);

// setting up Stripe client
$user = new Controller\UserCon();
\Stripe\Stripe::setApiKey(General\Config::$stripe['secret_key']);

// if user is logged in, continue in this script
if ($user->isLoggedIn()) {

    // validating GET parameter 'action_type'
    if (isset($_GET['action_type']) && !is_null($_GET['action_type']) && ($_GET['action_type'] == 'new' || $_GET['action_type'] == 'extend')) {
        $action_type = $_GET['action_type'];
    } else {
        $action_type = null;
    }

    // if action type is 'new', create new license key
    if ($action_type == 'new') {

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

        // if license and number of months exist, redirect user to the Stripe paygate for creating new license key
        if ($license_id && $month_num) {
            $license = new Controller\LicenseCon($license_id);
            $license_data = $license->getLicense();
            if ($license_data) {
                $stripe_checkout = \Stripe\Checkout\Session::create([
                    "mode" => 'payment',
                    "success_url" => General\Config::$general['app_root_url']."/action/createLicenseKey.php?license_id=".$license_id."&month_num=".$month_num."&session_id={CHECKOUT_SESSION_ID}",
                    "line_items" => [
                        [
                            "quantity" => $month_num,
                            "price_data" => [
                                "currency" => $license_data['currency'],
                                "unit_amount" => $license_data['monthly_price'] * 100,
                                "product_data" => [
                                    "name" => $license_data['name'],
                                    "description" => $license_data['description']
                                ]
                            ],
                        ]
                    ]
                ]);
                header('location: '.$stripe_checkout->url);
            } else {
                header('location: '.General\App::leveledPath('index.php'));
            }
            
        } else {
            General\Error::Add('Fail to create license, invalid data were given');
        }
    } else if ($action_type == 'extend') { // if action type is 'extend', extend existed license key
       
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
        
        // if license key and number of months exist, redirect user to the Stripe paygate for extend existed license key
        if ($license_key_id && $month_num) {
            $license_key = new Controller\LicenseKeycon($license_key_id);
            if ($license_key->validateLicenseKeyOwner($user->id)) {

                $license = new Controller\LicenseCon();
                $license_data = $license->getLicenseByLicenseKey($license_key_id);

                if ($license_data) {
                    $stripe_checkout = \Stripe\Checkout\Session::create([
                        "mode" => 'payment',
                        "success_url" => General\Config::$general['app_root_url']."/action/changeLicenseKeyExpirationDate.php?license_key_id=".$license_key_id."&month_num=".$month_num."&session_id={CHECKOUT_SESSION_ID}",
                        "line_items" => [
                            [
                                "quantity" => $month_num,
                                "price_data" => [
                                    "currency" => $license_data['currency'],
                                    "unit_amount" => $license_data['monthly_price'] * 100,
                                    "product_data" => [
                                        "name" => "Extend: ".$license_data['name'],
                                        "description" => $license_data['description']
                                    ]
                                ],
                            ]
                        ]
                    ]);
                    header('location: '.$stripe_checkout->url);
                }
            } else {
                General\Error::add('You can nat change other users expiration dates');
                header('location: '.General\App::leveledPath('index.php'));

            }
        } else {
            General\Error::add('Invalid data');
            header('location: '.General\App::leveledPath('index.php'));
        }
    } else {
        General\Error::add('Invalid action type');
        header('location: '.General\App::leveledPath('index.php'));
    }

} else {
    General\Error::add('You must be logged in to create license');
    header('location: '.General\App::leveledPath('index.php'));
}

?>