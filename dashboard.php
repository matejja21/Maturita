<?php
// includes for this script
include_once "include/autoload.php";
IncludeOnPath(0);
include_once "data/config.php";

// create important objects
$user = new View\UserView();
$licenses = new View\LicenseView();
$license_key = new View\LicenseKeyView();

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <div class="container-flow">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom bg-primary shadow">
            <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
                <span class="fs-4 text-light">License key store</span>
            </a>
            
            <ul class="nav nav-pills">
                <?php $user->userButton(); // show user button for login or logout ?>
            </ul>
        </header>

        <br>
    
        <div class="container">
            <h1>Dashboard</h1>
            <h2>Active licenses</h2>
            <?php $license_key->showAllUserLicenseKeysActivate($user->id); // show table with active license keys ?>
            <h2>Inactive licenses</h2>
            <?php $license_key->showAllUserLicenseKeysDeactivate($user->id); // show table with inactive license keys ?>
        </div>
    

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php General\Error::show(); // show errors ?>