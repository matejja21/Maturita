<?php

include_once "../../include/autoload.php";
include_once "../../data/config.php";

SetLevel(2);
header("Content-Type: application/json; charset=utf-8");

if (isset($_GET['license_key']) && !is_null($_GET['license_key'])) {
    $license_key_string = $_GET['license_key'];
} else {
    $license_key_string = false;
}

if (isset($_GET['info']) && (is_bool($_GET['info']) || $_GET['info'] == 1 || $_GET['info'] == "true")) {
    $info = true;
} else {
    $info = false;
}

//var_dump($info);

if ($license_key_string) {
    $license_key = new Controller\LicenseKeyCon(null, null, null,$license_key_string);
    $data = $license->validateLicenseKey($license_key_string, $info); 
    $return = $data;
} else {
    $return['valid'] = false;
    $return['errors'][]['message'] = 'wrong parameters given'; 
}

echo json_encode($return);