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

        
            <h1>Administration page</h1>

            <h2>Create new license type</h2>
            <div class="container">
                <form method="POST" action="action/createLicenseType.php">
                    <div class="form-group">
                        <lable for="create_name">Name: </lable>
                        <input type="text" id="create_name" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <lable for="create_description">Description: </lable>
                        <textarea id="create_description" name="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <lable for="create_doc_url">Documentation URL: </lable>
                        <input type="text" id="create_doc_url" name="doc_url" class="form-control">
                    </div>  

                    <div class="form-group">
                        <lable for="create_monthly_price">Monthley price: </lable>
                        <input type="number" min="0" max="100" id="create_name" name="month_price" class="form-control">
                    </div>

                    <div class="form-group">
                        <lable for="create_currency">Currency: </lable>
                        <select id="create_currency" name="currency" class="form-control">
                            <option value="eur">EUR</option>
                            <option value="czk">CZK</option>
                            <option value="usd">USD</oprion>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary mt-2">
                </form>
            </div>

            <h2>License Types</h2>
            <?=$licenseType->showAllLicenseTypesAdmin()?>
        </div>
    </div>
</body>
</html>