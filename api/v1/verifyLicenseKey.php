<?php

// includes for this script + setting level of the script
include_once "../../include/autoload.php";
IncludeOnPath(2);
include_once "../../data/config.php";
SetLevel(2);

// set content type to JSON
header("Content-Type: application/json; charset=utf-8");

// validating GET parameter 'license_key'
if (isset($_GET['license_key']) && !is_null($_GET['license_key'])) {
    $license_key_string = $_GET['license_key'];
} else {
    $license_key_string = false;
}

// validating GET parameter 'info'
if (isset($_GET['info']) && (is_bool($_GET['info']) || $_GET['info'] == 1 || $_GET['info'] == "true")) {
    $info = true;
} else {
    $info = false;
}

// if license key exists, check its validation
if ($license_key_string) {
    $license_key = new Controller\LicenseKeyCon(null, null, null,$license_key_string);
    $data = $license_key->validateLicenseKey($license_key_string, $info); 
    $return = $data;
} else {
    $return['valid'] = false;
    $return['errors'][]['message'] = 'wrong parameters given'; 
}

// print the json to the user
echo json_encode($return);