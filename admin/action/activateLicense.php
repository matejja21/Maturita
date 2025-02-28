<?php

// includes for this script + setting level of the script
include_once "../../include/autoload.php";
IncludeOnPath(2);
include_once "../../data/config.php";
SetLevel(2);

// create user object
$user = new Controller\UserCon();

// if user is admin, change license (given below) activation to true
if ($user->isAdmin()) {

    // validating GET parameter 'license_key_id'
    if (isset($_GET['license_id']) && is_numeric($_GET['license_id']) && $_GET['license_id'] > 0) {
        $license_id = $_GET['license_id'];
    } else {
        $license_id = false;
    }

    // if license exists, change its activation to true
    if ($license_id) {
        if ($user->isLoggedIn()) {
            $license = new Controller\LicenseCon($license_id);
            $license->activateLicense();
        } else {
            General\Error::add('You must be logged in to change license');
        }
    } else {
        General\Error::add('Invalid data');
    }
    
    // redirect admin to admin homepage
    header('location: '.General\App::leveledPath("admin/index.php"));
} else {
    // redirect user to homepage
    General\Error::add('You are not an admin');
    header('location: '.General\App::leveledPath("index.php"));
}

?>