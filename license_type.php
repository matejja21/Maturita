<?php

include_once "include/autoload.php";
include_once "data/config.php";

$user = new View\UserView();

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $licenseType = new View\LicenseTypeView($_GET['id']);
} else {
    $licenseType = new View\LicenseTypeView($_GET['id']);
}




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
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
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

    <br>
    
    <div class="container">
        <?php $licenseType->showLicenseTypeInfo(); ?>
    </div>
    

    <?php
        /* 
        if ($user->isLoggedIn()) {
            echo '<h2>Your licenses</h2>';
            $licenses = new View\LicenseView();
            $licenses->showAllUserLicenses($_SESSION['user']['id']);
        }*/
    ?> 

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php General\Error::show(); ?>