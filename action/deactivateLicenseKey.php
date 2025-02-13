<?php


include_once "../include/autoload.php";
include_once "../data/config.php";

SetLevel(1);
//echo "it is this page";
if (isset($_GET['license_key_id']) && is_numeric($_GET['license_key_id']) && $_GET['license_key_id'] > 0) {
    $license_key_id = $_GET['license_key_id'];
} else {
    $license_key_id = false;
}

//echo $license_key_id;

if ($license_key_id) {
    $user = new Controller\UserCon();
    if ($user->isLoggedIn()) {
        $license_key = new Controller\LicenseKeyCon($license_key_id);
        $license_key->deactivateLicenseKey($user->id);
    } else {
        General\Error::add('You must be logged in to change license key');
    }
} else {
    General\Error::add('Invalid data');
}

header('location: '.General\App::leveledPath("dashboard.php"));


?>