<?php


include_once "../../include/autoload.php";
include_once "../../data/config.php";

SetLevel(2);
//echo "it is this page";
$user = new Controller\UserCon();

if ($user->isAdmin()) {
    if (isset($_GET['license_type_id']) && is_numeric($_GET['license_type_id']) && $_GET['license_type_id'] > 0) {
        $license_type_id = $_GET['license_type_id'];
    } else {
        $license_type_id = false;
    }
    
    echo $license_type_id;
    
    if ($license_type_id) {
        if ($user->isLoggedIn()) {
            $license_type = new Controller\LicenseTypeCon($license_type_id);
            $license_type->deactivateLicenseType();
        } else {
            General\Error::add('You must be logged in to change license type');
        }
    } else {
        General\Error::add('Invalid data');
    }
    
    header('location: '.General\App::leveledPath("admin/index.php"));
} else {
    General\Error::add('You are not an admin');
    header('location: '.General\App::leveledPath("index.php"));
}


?>