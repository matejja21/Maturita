<?php

include_once "../../include/autoload.php";
include_once "../../data/config.php";

SetLevel(2);
header("Content-Type: application/json; charset=utf-8");

if (isset($_GET['license']) && !is_null($_GET['license'])) {
    $license_string = $_GET['license'];
} else {
    $license_string = false;
}

if (isset($_GET['info']) && (is_bool($_GET['info']) || $_GET['info'] == 1 || $_GET['info'] == "true")) {
    $info = true;
} else {
    $info = false;
}

//var_dump($info);

if ($license_string) {
    $license = new Controller\LicenseCon(null, null, null,$license_string);
    $data = $license->validateLicense($license_string, $info); 
    $return = $data;
} else {
    $return['valid'] = false;
    $return['errors'][]['message'] = 'wrong parameters given'; 
}

echo json_encode($return);