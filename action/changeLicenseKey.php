<?php

// includes for this script + setting level of the script
include_once "../include/autoload.php";
IncludeOnPath(1);
include_once "../data/config.php";
SetLevel(1);

// validating GET parameter 'license_key_id'
if (isset($_GET['license_key_id']) && is_numeric($_GET['license_key_id']) && $_GET['license_key_id'] > 0) {
    $license_key_id = $_GET['license_key_id'];
} else {
    $license_key_id = false;
}

// if license key exists, change its license key to new license key
if ($license_key_id) {
    $user = new Controller\UserCon();
    if ($user->isLoggedIn()) {
        $license_key = new Controller\LicenseKeycon($license_key_id);
        $license_key->changeLicenseKey($user->id);
    } else {
        General\Error::add('You must be logged in to change license key');
    }
} else {
    General\Error::add('Invalid data');
}

// redirect user to dashboard
header('location: '.General\App::leveledPath("dashboard.php"));


?>