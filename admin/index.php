<?php

include_once "../include/autoload.php";
include_once "../data/config.php";

SetLevel(1);

$user = new View\UserView();
$user->verifyAdmin();

$licenseType = new View\LicenseTypeView();

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

    <h2>Create new license type</h2>
    <form method="POST" action="action/createLicenseType.php">
        <lable for="create_name">Name: </lable>
        <input type="text" id="create_name" name="name">

        <lable for="create_description">Description: </lable>
        <textarea id="create_description" name="description"></textarea>

        <lable for="create_doc_url">Documentation URL: </lable>
        <input type="text" id="create_doc_url" name="doc_url">

        <lable for="create_monthly_price">Monthley price: </lable>
        <input type="number" min="0" max="100" id="create_name" name="month_price">

        <lable for="create_currency">Currency: </lable>
        <select id="create_currency" name="currency">
            <option value="eur">EUR</option>
            <option value="czk">CZK</option>
            <option value="usd">USD</oprion>
        </select>
        <input type="submit">
    </form>

    <h2>License Types</h2>
    <?=$licenseType->showAllLicenseTypesAdmin()?>
</body>
</html>