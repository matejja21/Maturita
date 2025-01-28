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
    <script src="https://accounts.google.com/gsi/client" async></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>License key store</title>
</head>
<body>
    <div class="container-flow">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom bg-primary">
        <a href="../index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4 text-light">License key store</span>
        </a>
        
        <ul class="nav nav-pills">
            <?php $user->userButton();?>
            <!--<li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Features</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Pricing</a></li>
            <li class="nav-item"><a href="#" class="nav-link">FAQs</a></li>
            <li class="nav-item"><a href="#" class="nav-link">About</a></li>-->
        </ul>
        </header>
        <div class="container">
            <h1>Administration page <a class="btn btn-primary" href="index.php">Back</a></h1>

            <h2>Update license type - ID: <?=$license_type_id?></h2>
            <?php $licenseType->licenseTypeUpdateForm(); ?>
        </div>
    </div>
</body>
</html>