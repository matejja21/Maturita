<?php

// includes for this script + setting level of the script
include_once "../../include/autoload.php";
IncludeOnPath(2);
include_once "../../data/config.php";
SetLevel(2);

// create user object
$user = new Controller\UserCon();

// if user is admin, create new license with data validating below
if ($user->isLoggedIn() && $user->isAdmin()) {

    // validating POST parameter 'name'
    if (isset($_POST['name']) && !is_null($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $name = null;
    }

    // validating POST parameter 'description'
    if (isset($_POST['description']) && !is_null($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        $description = null;
    }

    // validating POST parameter 'doc_url'
    if (isset($_POST['doc_url']) && !is_null($_POST['doc_url'])) {
        $doc_url = $_POST['doc_url'];
    } else {
        $doc_url = null;
    }
    
    // validating POST parameter 'month_price'
    if (isset($_POST['month_price']) && is_numeric($_POST['month_price']) && $_POST['month_price'] > 0) {
        $month_price = $_POST['month_price'];
    } else {
        $month_price = null;
    }

    // validating POST parameter 'currency'
    if (isset($_POST['currency']) && is_string($_POST['currency']) && strlen($_POST['currency']) == 3) {
        $currency = strtolower($_POST['currency']);
    } else {
        $currency = null;
    }

    // if all data are valid, create license
    if ($name && $description && $doc_url && $month_price && $currency) {
        $license = new Controller\LicenseCon();
        $license->createLicense($name, $description, $doc_url, $month_price, $currency);
    } else {
        General\Error::Add('Fail to create license, invalid data were given');
    }
} else {
    General\Error::add('You must be logged in to create license');
}

// redirect admin to admin homepage
header('location: '.General\App::leveledPath("admin/index.php"));