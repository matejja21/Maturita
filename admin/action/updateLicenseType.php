<?php

include_once "../../include/autoload.php";
include_once "../../data/config.php";

SetLevel(2);
$user = new Controller\UserCon();

if ($user->isLoggedIn() && $user->isAdmin()) {
    if (isset($_POST['license_type_id']) && is_numeric($_POST['license_type_id']) && $_POST['license_type_id'] > 0) {
        $license_type_id = $_POST['license_type_id'];
    } else {
        $license_type_id = null;
    }

    if (isset($_POST['name']) && !is_null($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $name = null;
    }

    if (isset($_POST['description']) && !is_null($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        $description = null;
    }

    if (isset($_POST['doc_url']) && !is_null($_POST['doc_url'])) {
        $doc_url = $_POST['doc_url'];
    } else {
        $doc_url = null;
    }
    
    if (isset($_POST['month_price']) && is_numeric($_POST['month_price']) && $_POST['month_price'] > 0) {
        $month_price = $_POST['month_price'];
    } else {
        $month_price = null;
    }

    if (isset($_POST['currency']) && is_string($_POST['currency']) && strlen($_POST['currency']) == 3) {
        $currency = strtolower($_POST['currency']);
    } else {
        $currency = null;
    }

    if ($license_type_id && $name && $description && $doc_url && $month_price && $currency) {
        $license_type = new Controller\LicenseTypeCon($license_type_id);
        $license_type->changeLicenseType($name, $description, $doc_url, $month_price, $currency);
    } else {
        General\Error::add('Fail to update license type, invalid data were given');
    }
} else {
    General\Error::add('You must be logged in to update license');
}

//var_dump($_POST);
header('location: '.General\App::leveledPath("admin/update.php"));