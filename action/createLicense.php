<?php

include_once "../include/autoload.php";
include_once "../data/config.php";

SetLevel(1);
$user = new Controller\UserCon();

if ($user->isLoggedIn()) {
    if (isset($_POST['license_type_id']) && is_numeric($_POST['license_type_id']) && $_POST['license_type_id'] > 0) {
        $license_type_id = $_POST['license_type_id'];
    } else {
        $license_type_id = null;
    }
    
    if (isset($_POST['month_num']) && is_numeric($_POST['month_num']) && $_POST['month_num'] > 0) {
        $month_num = $_POST['month_num'];
    } else {
        $month_num = null;
    }

    if ($license_type_id && $month_num) {
        $license = new Controller\LicenseCon();
        $license->createLicense($_SESSION['user']['id'], $license_type_id, $month_num);
    } else {
        General\Error::Add('Fail to create license, invalid data were given');
    }
} else {
    General\Error::add('You must be logged in to create license');
}

header('location: '.General\App::leveledPath("index.php"));

?>