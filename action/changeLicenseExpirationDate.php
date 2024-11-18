<?php


include_once "../include/autoload.php";
include_once "../data/config.php";

SetLevel(1);
//echo "it is this page";
if (isset($_POST['license_id']) && is_numeric($_POST['license_id']) && $_POST['license_id'] > 0) {
    $license_id = $_POST['license_id'];
} else {
    $license_id = false;
}

if (isset($_POST['month_num']) && is_numeric($_POST['month_num']) && $_POST['month_num'] > 0 && $_POST['month_num'] <= 36) {
    $month_num = $_POST['month_num'];
} else {
    $month_num = false;
}

echo $license_id;
echo $month_num;

if ($license_id && $month_num) {
    $user = new Controller\UserCon();
    if ($user->isLoggedIn()) {
        $license = new Controller\Licensecon($license_id);
        $license->changeExpirationDate($user->id, $month_num);
    } else {
        General\Error::add('You must be logged in to change license expiration date');
    }
} else {
    General\Error::add('Invalid data');
}

header('location: '.General\App::leveledPath("index.php"));


?>