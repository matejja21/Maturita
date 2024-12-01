<?php

include_once "../include/autoload.php";
include_once "../data/config.php";

SetLevel(1);

$user = new View\UserView();
$user->verifyAdmin();

if (isset($_GET['license_type_id']) && is_numeric($_GET['license_type_id']) && $_GET['license_type_id'] > 0) {
    $license_type_id = $_GET['license_type_id'];
} else {
    $license_type_id = null;
}

if ($license_type_id) {
    $licenseType = new View\LicenseTypeView($license_type_id);
    if (!$licenseType->selectLicenseType()) {
        General\Error::Add('Given license type doeas not exist');
        header('location: index.php');
    }
} else {
    General\Error::Add('You need to specify the license type to be able to update it');
    header('location: index.php');
}

General\Error::Show();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>License Key Store - Admin</title>
</head>
<body>
    <h1>Administration page</h1>

    <h2>Update license type - ID: <?=$license_type_id?></h2>
    <?php $licenseType->licenseTypeUpdateForm(); ?>
</body>
</html>