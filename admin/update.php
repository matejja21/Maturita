<?php

// includes for this script + setting level of the script
include_once "../include/autoload.php";
IncludeOnPath(1);
include_once "../data/config.php";
SetLevel(1);

// verify if user is Admin
$user = new View\UserView();
$user->verifyAdmin();

// validating GET parameter 'license_id'
if (isset($_GET['license_id']) && is_numeric($_GET['license_id']) && $_GET['license_id'] > 0) {
    $license_id = $_GET['license_id'];
} else {
    $license_id = null;
}

// if license existed, admin will be able to update it
if ($license_id) {
    $license = new View\LicenseView($license_id);
    if (!$license->selectLicense()) {
        General\Error::Add('Given license doeas not exist');
        header('location: index.php');
    }
} else {
    General\Error::Add('You need to specify the license to be able to update it');
    header('location: index.php');
}

// show errors
General\Error::Show();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://accounts.google.com/gsi/client" async></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="data/media/icon.svg">
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
            <?php $user->userButton(); // show user button for login or logout ?>
        </ul>
        </header>
        <div class="container">
            <h1>Administration page <a class="btn btn-primary" href="index.php">Back</a></h1>

            <h2>Update license - ID: <?=$license_id?></h2>
            <?php $license->licenseUpdateForm(); // show update form for the license ?>
        </div>
    </div>
</body>
</html>