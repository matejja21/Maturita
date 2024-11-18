<?php


include_once "../include/autoload.php";
include_once "../data/config.php";

SetLevel(1);
//echo "it is this page";
if (isset($_GET['license_id']) && is_numeric($_GET['license_id']) && $_GET['license_id'] > 0) {
    $license_id = $_GET['license_id'];
} else {
    $license_id = false;
}

echo $license_id;

if ($license_id) {
    $user = new Controller\UserCon();
    if ($user->isLoggedIn()) {
        $license = new Controller\Licensecon($license_id);
        $license->activateLicense($user->id);
    } else {
        General\Error::add('You must be logged in to change license');
    }
} else {
    General\Error::add('Invalid data');
}

header('location: '.General\App::leveledPath("index.php"));


?>